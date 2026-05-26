@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-extrabold">Create bot</h1>
<p class="mt-2 text-sm text-slate-300">Choose colors, paste your knowledge base, and go live.</p>

<form method="POST" action="{{ route('bots.store') }}" class="mt-6 grid gap-6 md:grid-cols-2">
  @csrf
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6 space-y-4">
    <div>
      <label class="text-sm text-slate-300">Bot name</label>
      <input name="bot_name" value="{{ old('bot_name') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
      @error('bot_name')<div class="mt-1 text-xs text-rose-300">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="text-sm text-slate-300">Company/Website name</label>
      <input name="company_name" value="{{ old('company_name') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
    </div>
    <div>
      <label class="text-sm text-slate-300">Allowed domain (optional)</label>
      <input name="allowed_domain" value="{{ old('allowed_domain') }}" placeholder="innfoverse.com" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
      <div class="mt-1 text-xs text-slate-400">If set, widget blocks other domains.</div>
    </div>
    <div>
      <label class="text-sm text-slate-300">Welcome message</label>
      <textarea name="welcome_message" rows="3" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">{{ old('welcome_message', 'Hi! How can I help?') }}</textarea>
    </div>
  </div>

  <div class="rounded-3xl border border-white/10 bg-white/5 p-6 space-y-4">
    <div class="grid grid-cols-3 gap-3">
      <div>
        <label class="text-sm text-slate-300">Primary</label>
        <input name="theme_primary" value="{{ old('theme_primary', '#22c1ee') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-300">Accent</label>
        <input name="theme_accent" value="{{ old('theme_accent', '#a855f7') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-300">Background</label>
        <input name="theme_bg" value="{{ old('theme_bg', '#0b1020') }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
      </div>
    </div>

    <div>
      <label class="text-sm text-slate-300">Knowledge Base</label>
      <textarea name="knowledge_base" rows="12" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" placeholder="Add FAQs, services, hours, location, pricing rules...">{{ old('knowledge_base') }}</textarea>
      <div class="mt-1 text-xs text-slate-400">Tip: Use bullet points and short paragraphs.</div>
    </div>

    <button class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950">Create bot</button>
  </div>
</form>
@endsection
