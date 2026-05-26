@extends('layouts.app')
@section('content')
<h1 class="text-4xl font-extrabold">Pricing</h1>
<p class="mt-3 text-slate-300">Start with manual invoices (bank/bKash) to launch fast. Upgrade payment gateways later.</p>

<div class="mt-8 grid gap-6 md:grid-cols-3">
  @foreach($plans as $plan)
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
      <div class="text-sm text-slate-400">{{ $plan->code }}</div>
      <div class="mt-1 text-2xl font-bold">{{ $plan->name }}</div>
      <div class="mt-4 text-3xl font-extrabold">
        {{ $plan->currency }} {{ number_format($plan->monthly_price_cents / 100, 0) }}
        <span class="text-sm text-slate-400 font-semibold">/mo</span>
      </div>

      <ul class="mt-5 space-y-2 text-sm text-slate-300">
        <li>• Up to <span class="text-white font-semibold">{{ $plan->bot_limit }}</span> bots</li>
        <li>• Lead capture included</li>
        <li>• Knowledge base replies</li>
        <li>• Mobile-first widget</li>
      </ul>

      <div class="mt-6">
      @auth
          <a 
              href="{{ auth()->user()->subscription->plan_id == $plan->id ? 'javascript:void(0)' : route('billing.plans') }}"
              class="block rounded-2xl px-4 py-3 text-center font-semibold
              {{ auth()->user()->subscription->plan_id == $plan->id 
                  ? 'bg-slate-700 text-slate-300 cursor-not-allowed' 
                  : 'bg-gradient-to-r from-cyan-400 to-fuchsia-500 text-slate-950' }}"
          >
              @if(auth()->user()->subscription->plan_id == $plan->id)
                  Current Plan
              @else
                  Choose Plan
              @endif
          </a>
      @else
          <a href="{{ route('register') }}" class="block rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 text-center font-semibold text-slate-950">
              Create Account
          </a>
      @endauth
      </div>
    </div>
  @endforeach
</div>

<div class="mt-10 rounded-3xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">
  <div class="font-semibold text-white">Payments (v1)</div>
  <div class="mt-2">• Global: Bank transfer (manual approval)</div>
  <div>• Bangladesh: bKash manual (transaction ID + screenshot)</div>
</div>
@endsection
