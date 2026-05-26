@extends('layouts.admin')

@php $pageTitle = 'Leads'; @endphp

@section('content')
<div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
  <div>
    <h1 class="text-3xl font-extrabold">Leads</h1>
    <p class="mt-2 text-sm text-slate-300">All captured leads across Chatverse.</p>
  </div>
</div>

<div class="mt-6 overflow-hidden rounded-3xl border border-white/10 bg-white/5">
  <table class="w-full text-sm">
    <thead class="bg-black/20 text-slate-300">
      <tr>
        <th class="px-5 py-3 text-left">Lead</th>
        <th class="px-5 py-3 text-left">Contact</th>
        <th class="px-5 py-3 text-left">Bot</th>
        <th class="px-5 py-3 text-left">Captured</th>
      </tr>
    </thead>
    <tbody class="text-slate-200">
      @forelse($leads as $l)
        <tr class="border-t border-white/10">
          <td class="px-5 py-4">
            <div class="font-semibold">{{ $l->name ?? '—' }}</div>
            @if($l->message)
              <div class="mt-1 line-clamp-2 text-xs text-slate-400">{{ $l->message }}</div>
            @endif
          </td>
          <td class="px-5 py-4 text-slate-300">
            <div>{{ $l->email ?? '—' }}</div>
            <div class="text-xs text-slate-400">{{ $l->phone ?? '' }}</div>
          </td>
          <td class="px-5 py-4 text-slate-300">
            <div class="font-semibold">{{ optional($l->bot)->bot_name ?? '—' }}</div>
            <div class="text-xs text-slate-400">{{ optional(optional($l->bot)->user)->email ?? '' }}</div>
          </td>
          <td class="px-5 py-4 text-slate-300">{{ $l->created_at?->diffForHumans() }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-5 py-6 text-sm text-slate-300">No leads yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6">{{ $leads->links() }}</div>
@endsection
