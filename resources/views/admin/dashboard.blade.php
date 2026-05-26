@extends('layouts.admin')

@php
  $pageTitle = 'Admin Dashboard';
@endphp

@section('content')
<div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
  <div>
    <h1 class="text-3xl font-extrabold">Dashboard</h1>
    <p class="mt-2 text-sm text-slate-300">Approve invoices to activate subscriptions. Use the sidebar to manage the platform.</p>
  </div>
  <div class="flex flex-wrap gap-2">
    <a href="{{ route('admin.invoices') }}" class="rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/15">Open Invoices</a>
    <a href="{{ route('admin.users') }}" class="rounded-2xl border border-white/15 bg-white/5 px-4 py-2 text-sm font-semibold hover:bg-white/10">Manage Users</a>
  </div>
</div>

<div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-6">
  <div class="text-lg font-semibold">Pending invoices</div>
  <div class="mt-4 space-y-3">
    @forelse($pendingInvoices as $inv)
      <div class="rounded-2xl border border-white/10 bg-black/20 p-4 flex items-center justify-between gap-4">
        <div>
          <div class="font-semibold">#{{ $inv->id }} • {{ $inv->user->email }}</div>
          <div class="text-xs text-slate-400">{{ $inv->plan->name }} • {{ $inv->payment_method }} • {{ $inv->currency }} {{ number_format($inv->amount_cents/100,2) }}</div>
        </div>
        <div class="flex gap-2">
          <form method="POST" action="{{ route('admin.invoices.approve', $inv) }}">@csrf
            <button class="rounded-xl bg-emerald-500/20 border border-emerald-400/20 px-3 py-2 text-sm font-semibold text-emerald-100">Approve</button>
          </form>
          <form method="POST" action="{{ route('admin.invoices.reject', $inv) }}">@csrf
            <button class="rounded-xl bg-rose-500/20 border border-rose-400/20 px-3 py-2 text-sm font-semibold text-rose-100">Reject</button>
          </form>
        </div>
      </div>
    @empty
      <div class="text-sm text-slate-300">No pending invoices.</div>
    @endforelse
  </div>
</div>
@endsection
