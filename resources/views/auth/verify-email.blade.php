@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-md rounded-3xl border border-white/10 bg-white/5 p-8">
  <h1 class="text-2xl font-bold mb-6">Verify your email</h1>
  
<p class="text-sm text-slate-300">We sent a verification link to your email. Please verify to unlock the dashboard.</p>
@if (session('status'))
  <div class="mt-4 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('status') }}</div>
@endif
<form method="POST" action="{{ route('verification.send') }}" class="mt-6">
  @csrf
  <button class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 font-semibold hover:bg-white/10">Resend verification email</button>
</form>

</div>
@endsection
