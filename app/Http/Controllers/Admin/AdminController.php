<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Conversation;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingInvoices = Invoice::where('status','pending')->latest()->take(10)->get();
        return view('admin.dashboard', compact('pendingInvoices'));
    }

    public function invoices()
    {
        $invoices = Invoice::latest()->paginate(25);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function approve(Request $request, Invoice $invoice)
    {
        $invoice->status = 'approved';
        $invoice->approved_at = now();
        $invoice->admin_note = $request->input('admin_note');
        $invoice->save();

        $sub = Subscription::firstOrCreate(['user_id' => $invoice->user_id], [
            'plan_id' => $invoice->plan_id,
        ]);

        $sub->plan_id = $invoice->plan_id;
        $sub->status = 'active';
        $sub->starts_at = now();
        $sub->ends_at = now()->addMonth();
        $sub->save();

        return back()->with('status','Invoice approved and subscription activated.');
    }

    public function reject(Request $request, Invoice $invoice)
    {
        $invoice->status = 'rejected';
        $invoice->admin_note = $request->input('admin_note');
        $invoice->save();

        return back()->with('status','Invoice rejected.');
    }

    public function plans()
    {
        $plans = Plan::orderBy('id')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function users(Request $request)
    {
        $q = trim((string) $request->get('q',''));

        $users = User::query()
            ->with(['subscription.plan'])
            ->when($q !== '', fn($qr) => $qr->where('email', 'like', "%{$q}%"))
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        // Don't allow removing admin from self to avoid lockout.
        if (auth()->id() === $user->id && $user->is_admin) {
            return back()->with('error', 'You cannot remove your own admin access.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return back()->with('status', $user->is_admin ? 'User promoted to admin.' : 'Admin access removed.');
    }

    public function toggleSuspend(User $user)
    {
        // Don't allow suspending self.
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->is_suspended = !$user->is_suspended;
        $user->save();

        return back()->with('status', $user->is_suspended ? 'User suspended.' : 'User unsuspended.');
    }

    public function bots(Request $request)
    {
        $q = trim((string) $request->get('q',''));

        $bots = Bot::query()
            ->with('user')
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where('bot_name', 'like', "%{$q}%")
                   ->orWhere('public_key', 'like', "%{$q}%");
            })
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.bots.index', compact('bots'));
    }

    public function toggleBotActive(Bot $bot)
    {
        // Never disable the demo bot in v1 (it powers public demo)
        if ($bot->is_demo) {
            return back()->with('error', 'Demo bot cannot be disabled.');
        }

        $bot->is_active = !$bot->is_active;
        $bot->save();

        return back()->with('status', $bot->is_active ? 'Bot enabled.' : 'Bot disabled.');
    }

    public function leads()
    {
        $leads = Lead::query()
            ->with(['bot.user'])
            ->orderByDesc('id')
            ->paginate(25);

        return view('admin.leads.index', compact('leads'));
    }

    public function conversations()
    {
        $conversations = Conversation::query()
            ->with(['bot.user'])
            ->withCount('messages')
            ->orderByDesc('id')
            ->paginate(25);

        return view('admin.conversations.index', compact('conversations'));
    }
}
