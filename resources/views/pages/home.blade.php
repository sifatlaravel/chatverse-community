@extends('layouts.app')

@section('content')
<section class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-8 md:p-12">
  <div class="grid gap-10 md:grid-cols-2 md:items-center">
    <div>
      <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-slate-200">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
        Demo available • Install in minutes
      </p>
      <h1 class="mt-6 text-4xl font-extrabold leading-tight md:text-5xl">
        Turn website chats into <span class="bg-gradient-to-r from-cyan-300 to-fuchsia-400 bg-clip-text text-transparent">real leads</span>.
      </h1>
      <p class="mt-5 text-lg text-slate-300">
        Chatverse gives you a premium AI chatbot (“Buddy”) that answers visitors, captures contact details, and helps you close faster — on desktop and mobile.
      </p>

      <div class="mt-7 flex flex-col gap-3 sm:flex-row">
        <a href="{{ route('demo') }}" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-6 py-3 text-center font-semibold text-slate-950 hover:opacity-95">
          Try the live demo
        </a>
        <a href="{{ route('pricing') }}" class="rounded-2xl border border-white/15 bg-white/5 px-6 py-3 text-center font-semibold hover:bg-white/10">
          View pricing
        </a>
      </div>

      <div class="mt-8 grid grid-cols-3 gap-3 text-xs text-slate-300">
        <div class="rounded-2xl border border-white/10 bg-black/20 p-3">
          <div class="text-white font-semibold">Lead capture</div>
          <div class="mt-1 text-slate-400">Name + email inside chat</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-black/20 p-3">
          <div class="text-white font-semibold">AI answers</div>
          <div class="mt-1 text-slate-400">From your knowledge base</div>
        </div>
        <div class="rounded-2xl border border-white/10 bg-black/20 p-3">
          <div class="text-white font-semibold">Mobile-first</div>
          <div class="mt-1 text-slate-400">Smooth on iOS/Android</div>
        </div>
      </div>
    </div>

    <div class="relative">
      <div class="absolute -inset-6 rounded-3xl bg-gradient-to-br from-cyan-400/20 to-fuchsia-500/15 blur-2xl"></div>
      <div class="relative rounded-3xl border border-white/10 bg-black/30 p-6">
        <div class="flex items-center gap-3">
          <img src="{{ asset('assets/buddy/buddy_closeup.webp') }}" class="h-14 w-14 rounded-2xl border border-white/10 bg-white/5 object-cover" alt="Buddy">
          <div>
            <div class="text-xs text-slate-400">Buddy by Chatverse</div>
            <div class="text-lg font-semibold">A premium AI chatbot vibe</div>
          </div>
        </div>

        <div class="mt-6 space-y-3 text-sm">
          <div class="max-w-[85%] rounded-2xl border border-white/10 bg-white/5 p-3 text-slate-200">Hi! I’m Buddy. Want to capture more leads from your website?</div>
          <div class="ml-auto max-w-[85%] rounded-2xl border border-white/10 bg-white/5 p-3 text-slate-200">Yes. Can you work on mobile too?</div>
          <div class="max-w-[85%] rounded-2xl border border-white/10 bg-cyan-400/10 p-3 text-slate-200">Absolutely. Chatverse is built mobile-first and installs in minutes.</div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3 text-xs">
          <div class="rounded-2xl border border-white/10 bg-black/20 p-3">
            <div class="font-semibold text-white">2-line embed</div>
            <div class="mt-1 text-slate-400">Copy & paste</div>
          </div>
          <div class="rounded-2xl border border-white/10 bg-black/20 p-3">
            <div class="font-semibold text-white">Fast launch</div>
            <div class="mt-1 text-slate-400">Start earning quickly</div>
          </div>
        </div>
      </div>

      <img src="{{ asset('assets/buddy/buddy_full.webp') }}" alt="Buddy" class="pointer-events-none absolute -bottom-14 -right-8 hidden w-[360px] opacity-90 md:block">
    </div>
  </div>
</section>

<section class="mt-12 grid gap-6 md:grid-cols-3">
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">How it works</div>
    <ol class="mt-4 space-y-3 text-sm text-slate-300">
      <li><span class="text-white font-semibold">1.</span> Create an account & verify email</li>
      <li><span class="text-white font-semibold">2.</span> Choose a plan and pay via bank/bKash</li>
      <li><span class="text-white font-semibold">3.</span> Create your bot, copy embed code, go live</li>
    </ol>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">Built for conversion</div>
    <p class="mt-3 text-sm text-slate-300">Buddy answers common questions and asks for contact details when the visitor shows buying intent.</p>
    <div class="mt-4 text-xs text-slate-400">Works best for agencies, local businesses, SaaS, services.</div>
  </div>
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">Safe & reliable</div>
    <p class="mt-3 text-sm text-slate-300">Email-verified accounts, rate-limited API, domain allowlist option, and admin approvals for payments.</p>
    <div class="mt-4 text-xs text-slate-400">Perfect for a fast v1 launch.</div>
  </div>
</section>

<section class="mt-12 rounded-3xl border border-white/10 bg-gradient-to-r from-cyan-400/15 to-fuchsia-500/10 p-8 md:p-10">
  <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
    <div>
      <div class="text-2xl font-bold">Ready to test Buddy on your site?</div>
      <div class="mt-2 text-slate-300">Try the demo, then upgrade to deploy your own bot.</div>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('demo') }}" class="rounded-2xl bg-white px-6 py-3 font-semibold text-slate-950">Open demo</a>
      <a href="{{ route('register') }}" class="rounded-2xl border border-white/15 bg-white/5 px-6 py-3 font-semibold hover:bg-white/10">Create account</a>
    </div>
  </div>
</section>
@endsection
