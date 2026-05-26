@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-extrabold">Profile</h1>

<div class="mt-6 grid gap-6 md:grid-cols-2">
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">Account</div>
    <form method="POST" action="{{ route('profile.update') }}" class="mt-4 space-y-4">
      @csrf
      <div>
        <label class="text-sm text-slate-300">Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
      </div>
      <div>
        <label class="text-sm text-slate-300">Company</label>
        <input name="company" value="{{ old('company', $user->company) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-300">Timezone</label>
        <input name="timezone" value="{{ old('timezone', $user->timezone) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-300">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
        <div class="mt-1 text-xs text-slate-400">Changing email requires verification again.</div>
      </div>
      <button class="w-full rounded-2xl bg-white/10 px-4 py-3 font-semibold hover:bg-white/15">Save</button>
    </form>
  </div>

  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">Password</div>
    <form method="POST" action="{{ route('profile.password') }}" class="mt-4 space-y-4">
      @csrf
      <div>
        <label class="text-sm text-slate-300">Current password</label>
        <input type="password" name="current_password" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
      </div>
      <div>
        <label class="text-sm text-slate-300">New password</label>
        <input type="password" name="password" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
      </div>
      <div>
        <label class="text-sm text-slate-300">Confirm new password</label>
        <input type="password" name="password_confirmation" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
      </div>
      <button class="w-full rounded-2xl bg-white/10 px-4 py-3 font-semibold hover:bg-white/15">Update password</button>
    </form>
  </div>
</div>
@endsection
