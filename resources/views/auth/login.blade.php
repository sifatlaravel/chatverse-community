@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-md rounded-3xl border border-white/10 bg-white/5 p-8">
  <h1 class="text-2xl font-bold mb-6">Login</h1>
  
<form method="POST" action="{{ route('login.store') }}" class="space-y-4">
  @csrf
  <div>
    <label class="text-sm text-slate-300">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
    @error('email')<div class="mt-1 text-xs text-rose-300">{{ $message }}</div>@enderror
  </div>
  <div>
    <label class="text-sm text-slate-300">Password</label>
    <input type="password" name="password" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
    @error('password')<div class="mt-1 text-xs text-rose-300">{{ $message }}</div>@enderror
  </div>
  <div class="flex items-center justify-between">
    <label class="text-sm text-slate-300 flex items-center gap-2">
      <input type="checkbox" name="remember" class="rounded border-white/20 bg-black/30">
      Remember me
    </label>
    <a class="text-sm text-slate-200 underline" href="{{ route('password.request') }}">Forgot?</a>
  </div>

  <button class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950">Login</button>
  <div class="text-sm text-slate-400">No account? <a class="text-white underline" href="{{ route('register') }}">Register</a></div>
</form>

</div>
@endsection
