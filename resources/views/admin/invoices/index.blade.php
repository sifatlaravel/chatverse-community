@extends('layouts.admin')

@php $pageTitle = 'Invoices'; @endphp

@section('content')
<div class="flex items-end justify-between gap-4">
  <div>
    <h1 class="text-3xl font-extrabold">Invoices</h1>
    <p class="mt-2 text-sm text-slate-300">Approve payments to activate subscriptions. Proof files open in a new tab.</p>
  </div>
</div>

<div class="mt-6 space-y-3">
  @foreach($invoices as $inv)
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
      <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
          <div class="font-semibold">#{{ $inv->id }} • {{ $inv->user->email }}</div>
          <div class="text-sm text-slate-300">{{ $inv->plan->name }} • {{ $inv->payment_method }}</div>
          <div class="mt-1 text-xs text-slate-400">Status: {{ $inv->status }} • Ref: {{ $inv->reference }}</div>
          @if($inv->proof_path)
            <div class="mt-2 text-xs"><a class="underline" href="{{ asset('storage/'.$inv->proof_path) }}" target="_blank">View proof</a></div>
          @endif
        </div>

        <div class="flex gap-2">
          <form method="POST" action="{{ route('admin.invoices.approve', $inv) }}" class="flex items-center gap-2">
            @csrf
            <input name="admin_note" placeholder="Note (optional)" class="hidden md:block rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-xs">
            <button class="rounded-xl bg-emerald-500/20 border border-emerald-400/20 px-3 py-2 text-sm font-semibold text-emerald-100">Approve</button>
          </form>
          <form method="POST" action="{{ route('admin.invoices.reject', $inv) }}" class="flex items-center gap-2">
            @csrf
            <input name="admin_note" placeholder="Reason (optional)" class="hidden md:block rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-xs">
            <button class="rounded-xl bg-rose-500/20 border border-rose-400/20 px-3 py-2 text-sm font-semibold text-rose-100">Reject</button>
          </form>
        </div>
      </div>
    </div>
  @endforeach

  <div class="mt-6">
    {{ $invoices->links() }}
  </div>
</div>
@endsection
