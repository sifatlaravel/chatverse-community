@extends('layouts.app')

@section('content')
@php
  // Safe defaults to avoid "Trying to access array offset on null"
  $bank  = config('chatverse.billing.bank', []);
  $bkash = config('chatverse.billing.bkash', []);

  $bankEnabled  = (bool)($bank['enabled'] ?? false);
  $bkashEnabled = (bool)($bkash['enabled'] ?? false);

  $method = $invoice->payment_method; // 'bank_transfer' or 'bkash'
  $isPending = ($invoice->status === 'pending');

  $showBank  = ($method === 'bank_transfer') && $bankEnabled;
  $showBkash = ($method === 'bkash') && $bkashEnabled;
@endphp

<h1 class="text-3xl font-extrabold">Invoice #{{ $invoice->id }}</h1>

<div class="mt-6 grid gap-6 md:grid-cols-2">
  {{-- LEFT: Invoice + Instructions --}}
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-sm text-slate-400">Plan</div>
    <div class="text-xl font-bold">{{ $invoice->plan->name }}</div>

    <div class="mt-3 text-sm text-slate-300">
      Amount:
      <span class="text-white font-semibold">
        {{ $invoice->currency }} {{ number_format($invoice->amount_cents / 100, 2) }}
      </span>
    </div>

    <div class="mt-2 text-sm text-slate-300">
      Method:
      <span class="text-white font-semibold">
        {{ $method === 'bkash' ? 'bKash' : 'Bank transfer' }}
      </span>
    </div>

    <div class="mt-2 text-sm text-slate-300">
      Status:
      <span class="text-white font-semibold">{{ ucfirst($invoice->status) }}</span>
    </div>

    <div class="mt-6 rounded-2xl border border-white/10 bg-black/20 p-4 text-sm text-slate-300">
      <div class="font-semibold text-white">Payment instructions</div>
      <div class="mt-2 text-slate-200">
        Please send payment first, then submit your
        <span class="font-semibold text-white">Transaction ID</span> and/or screenshot.
      </div>

      <div class="mt-4 grid gap-4 md:grid-cols-2">
        {{-- Bank --}}
        @if($showBank)
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="font-semibold text-white">Bank Transfer</div>

            @if(!empty($bank['name']))
              <div class="mt-2">Bank: <span class="text-white font-semibold">{{ $bank['name'] }}</span></div>
            @endif
            @if(!empty($bank['account_name']))
              <div>Account Name: <span class="text-white font-semibold">{{ $bank['account_name'] }}</span></div>
            @endif
            @if(!empty($bank['account_number']))
              <div>Account No: <span class="text-white font-semibold">{{ $bank['account_number'] }}</span></div>
            @endif
            @if(!empty($bank['routing']))
              <div>Routing: <span class="text-white font-semibold">{{ $bank['routing'] }}</span></div>
            @endif
            @if(!empty($bank['swift']))
              <div>SWIFT: <span class="text-white font-semibold">{{ $bank['swift'] }}</span></div>
            @endif
            @if(!empty($bank['branch']))
              <div>Branch: <span class="text-white font-semibold">{{ $bank['branch'] }}</span></div>
            @endif

            <div class="mt-3 rounded-xl border border-white/10 bg-black/30 p-3">
              <div class="text-xs text-slate-400">Reference</div>
              <div class="text-white font-semibold">Invoice #{{ $invoice->id }}</div>
            </div>

            @if(!empty($bank['note']))
              <div class="mt-2 text-xs text-slate-400">{{ $bank['note'] }}</div>
            @endif
          </div>
        @endif

        {{-- bKash --}}
        @if($showBkash)
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <div class="font-semibold text-white">bKash</div>

            @if(!empty($bkash['number']))
              <div class="mt-2">Number: <span class="text-white font-semibold">{{ $bkash['number'] }}</span></div>
            @endif
            @if(!empty($bkash['type']))
              <div>Type: <span class="text-white font-semibold">{{ $bkash['type'] }}</span></div>
            @endif

            <div class="mt-3 rounded-xl border border-white/10 bg-black/30 p-3">
              <div class="text-xs text-slate-400">Reference</div>
              <div class="text-white font-semibold">Invoice #{{ $invoice->id }}</div>
            </div>

            @if(!empty($bkash['note']))
              <div class="mt-2 text-xs text-slate-400">{{ $bkash['note'] }}</div>
            @endif
          </div>
        @endif

        {{-- Fallback if method selected but disabled/misconfigured --}}
        @if(!$showBank && !$showBkash)
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4 md:col-span-2">
            <div class="font-semibold text-white">Payment method unavailable</div>
            <div class="mt-2 text-slate-200">
              The selected payment method is currently disabled or not configured.
              Please go back and choose another method, or contact support.
            </div>
          </div>
        @endif
      </div>

      <div class="mt-4 text-xs text-slate-400">Admin will approve after confirming funds.</div>
    </div>
  </div>

  {{-- RIGHT: Submit proof --}}
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">Submit proof</div>

    {{-- Flash success/status --}}
    @if(session('status'))
      <div class="mt-3 rounded-2xl border border-white/10 bg-black/20 p-3 text-sm text-slate-200">
        {{ session('status') }}
      </div>
    @endif

    @if(!$isPending)
      <div class="mt-4 rounded-2xl border border-white/10 bg-black/20 p-4 text-sm text-slate-200">
        This invoice is already <span class="font-semibold text-white">{{ $invoice->status }}</span>.
        Proof submission is disabled.
      </div>
    @else
      <form
        method="POST"
        action="{{ route('billing.invoice.proof', $invoice) }}"
        enctype="multipart/form-data"
        class="mt-4 space-y-4"
      >
        @csrf

        <div>
          <label class="text-sm text-slate-300">Transaction / Reference ID (optional)</label>
          <input
            name="reference"
            value="{{ old('reference', $invoice->reference) }}"
            class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-slate-100"
          >
          @error('reference')
            <div class="mt-1 text-xs text-red-300">{{ $message }}</div>
          @enderror
        </div>

        <div>
          <label class="text-sm text-slate-300">Upload screenshot (optional)</label>
          <input
            type="file"
            name="proof"
            accept="image/png,image/jpeg,image/webp"
            class="mt-2 w-full text-sm text-slate-200"
          >
          <div class="mt-1 text-xs text-slate-400">PNG/JPG/WebP recommended.</div>
          @error('proof')
            <div class="mt-1 text-xs text-red-300">{{ $message }}</div>
          @enderror
        </div>

        <button
          type="submit"
          class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950"
        >
          Submit
        </button>
      </form>
    @endif
  </div>
</div>
@endsection
