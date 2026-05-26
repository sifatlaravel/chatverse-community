@extends('layouts.admin')

@php $pageTitle = 'Bots'; @endphp

@section('content')
<div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
  <div>
    <h1 class="text-3xl font-extrabold">Bots</h1>
    <p class="mt-2 text-sm text-slate-300">Monitor bots across the platform and disable abusive keys.</p>
  </div>
  <form method="GET" class="mt-2 flex items-center gap-2 md:mt-0">
    <input name="q" value="{{ request('q') }}" placeholder="Search bot name / key…" class="w-64 rounded-2xl border border-white/10 bg-black/30 px-4 py-2 text-sm placeholder:text-slate-500" />
    <button class="rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/15">Search</button>
  </form>
</div>

<div class="mt-6 overflow-hidden rounded-3xl border border-white/10 bg-white/5">
  <table class="w-full text-sm">
    <thead class="bg-black/20 text-slate-300">
      <tr>
        <th class="px-5 py-3 text-left">Bot</th>
        <th class="px-5 py-3 text-left">Owner</th>
        <th class="px-5 py-3 text-left">Key</th>
        <th class="px-5 py-3 text-left">Domain</th>
        <th class="px-5 py-3 text-left">Status</th>
        <th class="px-5 py-3 text-right">Action</th>
      </tr>
    </thead>
    <tbody class="text-slate-200">
      @forelse($bots as $b)
        <tr class="border-t border-white/10">
          <td class="px-5 py-4">
            <div class="font-semibold">{{ $b->bot_name }}</div>
            <div class="text-xs text-slate-400">{{ $b->company_name ?? '—' }} {{ $b->is_demo ? '• Demo' : '' }}</div>
          </td>
          <td class="px-5 py-4 text-slate-300">{{ optional($b->user)->email ?? '—' }}</td>
          <td class="px-5 py-4"><code class="rounded-lg bg-black/30 px-2 py-1 text-xs">{{ $b->public_key }}</code></td>
          <td class="px-5 py-4 text-slate-300">{{ $b->allowed_domain ?? '—' }}</td>
          <td class="px-5 py-4">
            @if($b->is_active)
              <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-xs font-semibold text-emerald-200">Active</span>
            @else
              <span class="rounded-full bg-rose-500/15 px-2 py-1 text-xs font-semibold text-rose-200">Disabled</span>
            @endif
          </td>
          <td class="px-5 py-4 text-right">
            <form method="POST" action="{{ route('admin.bots.toggle_active', $b) }}">
              @csrf
              <button class="rounded-xl border {{ $b->is_active ? 'border-rose-400/20 bg-rose-500/15 text-rose-100' : 'border-emerald-400/20 bg-emerald-500/15 text-emerald-100' }} px-3 py-2 text-xs font-semibold hover:opacity-95">
                {{ $b->is_active ? 'Disable' : 'Enable' }}
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="px-5 py-6 text-sm text-slate-300">No bots found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6">{{ $bots->links() }}</div>
@endsection
