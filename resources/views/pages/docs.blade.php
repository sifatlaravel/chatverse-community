@extends('layouts.app')
@section('content')
<h1 class="text-4xl font-extrabold">Docs</h1>
<div class="mt-6 grid gap-6 md:grid-cols-2">
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">1) Create your bot</div>
    <p class="mt-2 text-sm text-slate-300">After you have an active plan, create a bot and set your knowledge base (FAQ + services).</p>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">2) Copy embed code</div>
    <p class="mt-2 text-sm text-slate-300">Use the JS embed from your bot edit page. Paste into any site.</p>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">3) Add domain allowlist (optional)</div>
    <p class="mt-2 text-sm text-slate-300">For security, set your website domain to block other sites from using your bot key.</p>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">4) Leads & conversations</div>
    <p class="mt-2 text-sm text-slate-300">Leads are stored on your dashboard. You can extend with email notifications later.</p>
  </div>
</div>
@endsection
