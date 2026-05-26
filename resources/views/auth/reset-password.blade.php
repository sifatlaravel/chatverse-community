@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-md rounded-3xl border border-white/10 bg-white/5 p-8">
  <h1 class="text-2xl font-bold mb-6">Reset password</h1>
  
<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <input type="hidden" name="email" value="{{ $email }}">
  <div>
    <label class="text-sm text-slate-300">New password</label>
    <input type="password" name="password" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
    @error('password')<div class="mt-1 text-xs text-rose-300">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="text-sm text-slate-300">Confirm password</label>
    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
  </div>
  <button class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950">Reset password</button>
</form>

</div>
@endsection
