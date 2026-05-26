@extends('layouts.app')

@section('content')
@php
  // Safe defaults so array-access never crashes if config is missing/null
  $bank  = config('chatverse.billing.bank', []);
  $bkash = config('chatverse.billing.bkash', []);

  $bankEnabled  = (bool)($bank['enabled'] ?? false);
  $bkashEnabled = (bool)($bkash['enabled'] ?? false);
  $hasAnyMethod = $bankEnabled || $bkashEnabled;
@endphp

<h1 class="text-3xl font-extrabold">Billing</h1>
<p class="mt-2 text-sm text-slate-300">
  Choose a plan and submit payment proof. Admin approval activates your subscription.
</p>

<div class="mt-6 grid gap-6 md:grid-cols-3">
  @foreach($plans as $plan)
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
      <div class="text-sm text-slate-400">{{ $plan->code }}</div>
      <div class="mt-1 text-2xl font-bold">{{ $plan->name }}</div>

      <div class="mt-4 text-3xl font-extrabold">
        {{ $plan->currency }}
        {{ number_format($plan->monthly_price_cents / 100, 2) }}
        <span class="text-sm text-slate-400 font-semibold">/mo</span>
      </div>

      <ul class="mt-4 space-y-2 text-sm text-slate-300">
        <li>• Bot limit: <span class="text-white font-semibold">{{ $plan->bot_limit }}</span></li>
        <li>• Lead capture + KB</li>
      </ul>

      <div class="mt-6 space-y-2">
        @if(!$hasAnyMethod)
          <div class="rounded-2xl border border-white/10 bg-black/20 p-4 text-sm text-slate-300">
            <div class="font-semibold text-white">No payment methods available</div>
            <div class="mt-2 text-slate-200">
              Please contact support or try again later.
            </div>
          </div>
        @else
          <form method="POST" action="{{ route('billing.start', $plan->code) }}" class="space-y-3">
            @csrf

            <label class="block text-sm text-slate-300">Payment method</label>

            <select
              name="payment_method"
              class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-slate-100"
              required
            >
              @if($bankEnabled)
                <option value="bank_transfer">Bank transfer (Global + BD)</option>
              @endif

              @if($bkashEnabled)
                <option value="bkash">bKash (Bangladesh)</option>
              @endif
            </select>

            <p class="text-xs text-slate-400">
              You’ll see the exact bank/bKash account details on the invoice page after selecting a method.
            </p>

            <button
              type="submit"
              class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950"
            >
              Start with Invoice
            </button>
          </form>
        @endif
      </div>
    </div>
  @endforeach
</div>
@endsection
