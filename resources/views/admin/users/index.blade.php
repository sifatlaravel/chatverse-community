@extends('layouts.admin')

@php $pageTitle = 'Users'; @endphp

@section('content')
<div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
  <div>
    <h1 class="text-3xl font-extrabold">Users</h1>
    <p class="mt-2 text-sm text-slate-300">Promote admins, suspend abusers, and review plan status.</p>
  </div>
  <form method="GET" class="mt-2 flex items-center gap-2 md:mt-0">
    <input name="q" value="{{ request('q') }}" placeholder="Search email…" class="w-64 rounded-2xl border border-white/10 bg-black/30 px-4 py-2 text-sm placeholder:text-slate-500" />
    <button class="rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/15">Search</button>
  </form>
</div>

<div class="mt-6 overflow-hidden rounded-3xl border border-white/10 bg-white/5">
  <table class="w-full text-sm">
    <thead class="bg-black/20 text-slate-300">
      <tr>
        <th class="px-5 py-3 text-left">User</th>
        <th class="px-5 py-3 text-left">Company</th>
        <th class="px-5 py-3 text-left">Verified</th>
        <th class="px-5 py-3 text-left">Plan</th>
        <th class="px-5 py-3 text-left">Status</th>
        <th class="px-5 py-3 text-right">Actions</th>
      </tr>
    </thead>
    <tbody class="text-slate-200">
      @forelse($users as $u)
        <tr class="border-t border-white/10">
          <td class="px-5 py-4">
            <div class="font-semibold">{{ $u->email }}</div>
            <div class="text-xs text-slate-400">#{{ $u->id }} • {{ $u->name }}</div>
          </td>
          <td class="px-5 py-4 text-slate-300">{{ $u->company ?? '—' }}</td>
          <td class="px-5 py-4">
            @if($u->email_verified_at)
              <span class="rounded-full bg-emerald-500/15 px-2 py-1 text-xs font-semibold text-emerald-200">Yes</span>
            @else
              <span class="rounded-full bg-white/10 px-2 py-1 text-xs font-semibold text-slate-200">No</span>
            @endif
          </td>
          <td class="px-5 py-4 text-slate-300">
            {{ optional(optional($u->subscription)->plan)->name ?? '—' }}
          </td>
          <td class="px-5 py-4">
            @if($u->is_admin)
              <span class="rounded-full bg-cyan-500/15 px-2 py-1 text-xs font-semibold text-cyan-200">Admin</span>
            @endif
            @if($u->is_suspended)
              <span class="ml-2 rounded-full bg-rose-500/15 px-2 py-1 text-xs font-semibold text-rose-200">Suspended</span>
            @else
              <span class="ml-2 rounded-full bg-emerald-500/10 px-2 py-1 text-xs font-semibold text-emerald-200">Active</span>
            @endif
          </td>
          <td class="px-5 py-4 text-right">
            <div class="flex flex-wrap justify-end gap-2">
              <form method="POST" action="{{ route('admin.users.toggle_admin', $u) }}">
                @csrf
                <button class="rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold hover:bg-white/10">{{ $u->is_admin ? 'Remove admin' : 'Make admin' }}</button>
              </form>
              <form method="POST" action="{{ route('admin.users.toggle_suspend', $u) }}">
                @csrf
                <button class="rounded-xl border {{ $u->is_suspended ? 'border-emerald-400/20 bg-emerald-500/15 text-emerald-100' : 'border-rose-400/20 bg-rose-500/15 text-rose-100' }} px-3 py-2 text-xs font-semibold hover:opacity-95">
                  {{ $u->is_suspended ? 'Unsuspend' : 'Suspend' }}
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="px-5 py-6 text-sm text-slate-300">No users found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6">{{ $users->links() }}</div>
@endsection
