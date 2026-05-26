<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function plans(Request $request)
    {
        $plans = Plan::where('is_active', true)->orderBy('monthly_price_cents')->get();
        $sub = $request->user()->subscription;
        return view('dashboard.billing.plans', compact('plans','sub'));
    }

    public function start(Request $request, string $code)
    {
        $plan = Plan::query()
            ->where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        // 1) Validate input (clean + safe)
        $data = $request->validate([
            'payment_method' => ['nullable', Rule::in(['bank_transfer', 'bkash'])],
        ]);

        $method = $data['payment_method'] ?? 'bank_transfer';

        // 2) Enforce enabled payment methods (security + correctness)
        $bankEnabled  = (bool) config('chatverse.billing.bank.enabled', false);
        $bkashEnabled = (bool) config('chatverse.billing.bkash.enabled', false);

        if ($method === 'bkash' && !$bkashEnabled) {
            $method = 'bank_transfer';
        }
        if ($method === 'bank_transfer' && !$bankEnabled) {
            $method = 'bkash';
        }

        // If still nothing is available, block
        if (($method === 'bank_transfer' && !$bankEnabled) || ($method === 'bkash' && !$bkashEnabled)) {
            abort(503, 'No payment methods are currently available.');
        }

        // 3) Prevent duplicates + fix race condition
        $invoice = DB::transaction(function () use ($request, $plan, $method) {

            // Reuse ONLY if same plan + method pending exists
            $existing = Invoice::query()
                ->where('user_id', $request->user()->id)
                ->where('status', 'pending')
                ->where('plan_id', $plan->id)
                ->where('payment_method', $method)
                ->lockForUpdate()
                ->latest()
                ->first();

            if ($existing) {
                return $existing;
            }

            return Invoice::create([
                'user_id' => $request->user()->id,
                'plan_id' => $plan->id,
                'payment_method' => $method,
                'amount_cents' => $plan->monthly_price_cents,
                'currency' => $plan->currency,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('billing.invoice.show', $invoice);
    }

    public function invoiceShow(Request $request, Invoice $invoice)
    {
        abort_unless($invoice->user_id === $request->user()->id || $request->user()->is_admin, 403);
        return view('dashboard.billing.invoice', compact('invoice'));
    }

    public function uploadProof(Request $request, Invoice $invoice)
    {
        abort_unless($invoice->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'reference' => ['nullable','string','max:255'],
            'proof' => ['nullable','file','max:4096'],
        ]);

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('payment_proofs', 'public');
            $invoice->proof_path = $path;
        }
        $invoice->reference = $data['reference'] ?? $invoice->reference;
        $invoice->status = 'pending';
        $invoice->save();

        return back()->with('status','Payment proof submitted. We will approve it once the payment is confirmed.');
    }
}
