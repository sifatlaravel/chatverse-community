@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-md rounded-3xl border border-white/10 bg-white/5 p-8">
  <h1 class="text-2xl font-bold mb-6">Forgot password</h1>
  
<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
  @csrf
  <div>
    <label class="text-sm text-slate-300">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
    @error('email')<div class="mt-1 text-xs text-rose-300">{{ $message }}</div>@enderror
  </div>
  <button class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950">Send reset link</button>
  <div class="text-sm text-slate-400"><a class="text-white underline" href="{{ route('login') }}">Back to login</a></div>
</form>

</div>
@endsection
