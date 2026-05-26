@extends('layouts.app')
@section('content')
<div class="grid gap-8 md:grid-cols-2 md:items-center">
  <div>
    <h1 class="text-4xl font-extrabold">Features built for fast revenue</h1>
    <p class="mt-4 text-slate-300">Chatverse is a micro-SaaS focused on one thing: a chatbot that looks premium, answers intelligently, and captures leads.</p>

    <div class="mt-8 grid gap-4">
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-lg font-semibold">AI answers from your Knowledge Base</div>
        <p class="mt-2 text-sm text-slate-300">Add FAQs, services, pricing rules, and brand tone. Buddy uses it in every reply.</p>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-lg font-semibold">Lead capture inside chat</div>
        <p class="mt-2 text-sm text-slate-300">When the visitor shows interest (pricing, contact, booking), Buddy asks for email/phone.</p>
      </div>
      <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
        <div class="text-lg font-semibold">Embed in 2 lines</div>
        <p class="mt-2 text-sm text-slate-300">Copy & paste the script tag into any website. Works on mobile.</p>
      </div>
    </div>
  </div>

  <div class="relative">
    <div class="absolute -inset-6 rounded-3xl bg-gradient-to-br from-cyan-400/15 to-fuchsia-500/15 blur-2xl"></div>
    <div class="relative rounded-3xl border border-white/10 bg-black/30 p-6">
      <img src="{{ asset('assets/buddy/buddy_left.webp') }}" class="mx-auto w-[320px] opacity-95" alt="Buddy">
      <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
          <div class="font-semibold">Device-ready</div>
          <div class="mt-1 text-slate-400 text-xs">iOS / Android / Desktop</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
          <div class="font-semibold">Brand themes</div>
          <div class="mt-1 text-slate-400 text-xs">Pick colors per bot</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mt-12 rounded-3xl border border-white/10 bg-white/5 p-8">
  <h2 class="text-2xl font-bold">Security for a clean v1 launch</h2>
  <div class="mt-4 grid gap-4 md:grid-cols-3 text-sm text-slate-300">
    <div class="rounded-2xl border border-white/10 bg-black/20 p-4">Email verification required</div>
    <div class="rounded-2xl border border-white/10 bg-black/20 p-4">Optional domain allowlist per bot</div>
    <div class="rounded-2xl border border-white/10 bg-black/20 p-4">Admin approves payments before activation</div>
  </div>
</div>
@endsection
