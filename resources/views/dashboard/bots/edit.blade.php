@extends('layouts.app')
@section('content')
<h1 class="text-3xl font-extrabold">Edit bot</h1>

<div class="mt-4 rounded-3xl border border-white/10 bg-white/5 p-6">
  <div class="text-sm text-slate-300">Embed code</div>
  @php
    $css = url('/chatverse/widget/chatverse-widget.css');
    $js = url('/chatverse/widget/chatverse-widget.js');
  @endphp
  <pre class="mt-3 overflow-auto rounded-2xl border border-white/10 bg-black/40 p-4 text-xs text-slate-200"><code>&lt;link rel=&quot;stylesheet&quot; href=&quot;{{ $css }}&quot;&gt;
&lt;script src=&quot;{{ $js }}&quot; data-bot=&quot;{{ $bot->public_key }}&quot; defer&gt;&lt;/script&gt;</code></pre>
</div>

<form method="POST" action="{{ route('bots.update', $bot) }}" class="mt-6 grid gap-6 md:grid-cols-2">
  @csrf
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6 space-y-4">
    <div>
      <label class="text-sm text-slate-300">Bot name</label>
      <input name="bot_name" value="{{ old('bot_name', $bot->bot_name) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3" required>
    </div>
    <div>
      <label class="text-sm text-slate-300">Company/Website name</label>
      <input name="company_name" value="{{ old('company_name', $bot->company_name) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
    </div>
    <div>
      <label class="text-sm text-slate-300">Allowed domain (optional)</label>
      <input name="allowed_domain" value="{{ old('allowed_domain', $bot->allowed_domain) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
    </div>
    <div>
      <label class="text-sm text-slate-300">Welcome message</label>
      <textarea name="welcome_message" rows="3" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">{{ old('welcome_message', $bot->welcome_message) }}</textarea>
    </div>
    <label class="flex items-center gap-2 text-sm text-slate-300">
      <input type="checkbox" name="is_active" value="1" class="rounded border-white/20 bg-black/30" {{ $bot->is_active ? 'checked' : '' }}>
      Active
    </label>
  </div>

  <div class="rounded-3xl border border-white/10 bg-white/5 p-6 space-y-4">
    <div class="grid grid-cols-3 gap-3">
      <div>
        <label class="text-sm text-slate-300">Primary</label>
        <input name="theme_primary" value="{{ old('theme_primary', $bot->theme_primary) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-300">Accent</label>
        <input name="theme_accent" value="{{ old('theme_accent', $bot->theme_accent) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-300">Background</label>
        <input name="theme_bg" value="{{ old('theme_bg', $bot->theme_bg) }}" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
      </div>
    </div>

    <div>
      <label class="text-sm text-slate-300">Knowledge Base</label>
      <textarea name="knowledge_base" rows="12" class="mt-1 w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3">{{ old('knowledge_base', $bot->knowledge_base) }}</textarea>
    </div>

    <button class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-3 font-semibold text-slate-950">Save</button>
  </div>
</form>
@endsection
