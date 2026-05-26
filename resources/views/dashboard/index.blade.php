@extends('layouts.app')
@section('content')
<div class="flex flex-col gap-8">
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <div class="text-xs text-slate-400">Welcome</div>
        <div class="text-2xl font-bold">{{ $user->name }}</div>
        <div class="mt-1 text-sm text-slate-300">{{ $user->email }}</div>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('billing.plans') }}" class="rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-sm font-semibold hover:bg-white/10">Billing</a>
        <a href="{{ route('profile.edit') }}" class="rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-sm font-semibold hover:bg-white/10">Profile</a>
      </div>
    </div>
  </div>

  <div class="grid gap-6 md:grid-cols-3">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 md:col-span-2">
      <div class="flex items-center justify-between">
        <div class="text-lg font-semibold">Your bots</div>
        <a href="{{ route('bots.create') }}" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-2 text-sm font-semibold text-slate-950">New bot</a>
      </div>

      <div class="mt-4 space-y-3">
        @forelse($bots as $bot)
          <div class="rounded-2xl border border-white/10 bg-black/20 p-4 flex items-center justify-between gap-4">
            <div>
              <div class="font-semibold">{{ $bot->bot_name }}</div>
              <div class="text-xs text-slate-400">Key: {{ $bot->public_key }}</div>
            </div>
            <a href="{{ route('bots.edit', $bot) }}" class="rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-sm font-semibold hover:bg-white/10">Edit</a>
          </div>
        @empty
          <div class="rounded-2xl border border-white/10 bg-black/20 p-4 text-sm text-slate-300">
            No bots yet. Create your first bot.
          </div>
        @endforelse
      </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
      <div class="text-lg font-semibold">Subscription</div>
      <div class="mt-3 text-sm text-slate-300">
        Status: <span class="font-semibold text-white">{{ $sub?->status ?? 'inactive' }}</span>
      </div>
      <div class="mt-2 text-sm text-slate-300">
        Plan: <span class="font-semibold text-white">{{ $sub?->plan?->name ?? 'None' }}</span>
      </div>
      <div class="mt-4">
        <a href="{{ route('billing.plans') }}" class="block rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-center text-sm font-semibold hover:bg-white/10">Manage</a>
      </div>
    </div>
  </div>
</div>
@endsection
