@extends('layouts.admin')

@php $pageTitle = 'Conversations'; @endphp

@section('content')
<div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
  <div>
    <h1 class="text-3xl font-extrabold">Conversations</h1>
    <p class="mt-2 text-sm text-slate-300">Recent chat sessions across all bots.</p>
  </div>
</div>

<div class="mt-6 overflow-hidden rounded-3xl border border-white/10 bg-white/5">
  <table class="w-full text-sm">
    <thead class="bg-black/20 text-slate-300">
      <tr>
        <th class="px-5 py-3 text-left">Session</th>
        <th class="px-5 py-3 text-left">Bot</th>
        <th class="px-5 py-3 text-left">Messages</th>
        <th class="px-5 py-3 text-left">Started</th>
      </tr>
    </thead>
    <tbody class="text-slate-200">
      @forelse($conversations as $c)
        <tr class="border-t border-white/10">
          <td class="px-5 py-4">
            <div class="font-semibold">{{ $c->public_id }}</div>
            <div class="text-xs text-slate-400">Visitor: {{ $c->visitor_id }}</div>
          </td>
          <td class="px-5 py-4 text-slate-300">
            <div class="font-semibold">{{ optional($c->bot)->bot_name ?? '—' }}</div>
            <div class="text-xs text-slate-400">{{ optional(optional($c->bot)->user)->email ?? '' }}</div>
          </td>
          <td class="px-5 py-4">
            <span class="rounded-full bg-white/10 px-2 py-1 text-xs font-semibold">{{ $c->messages_count ?? 0 }}</span>
          </td>
          <td class="px-5 py-4 text-slate-300">{{ $c->created_at?->diffForHumans() }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-5 py-6 text-sm text-slate-300">No conversations yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6">{{ $conversations->links() }}</div>
@endsection
