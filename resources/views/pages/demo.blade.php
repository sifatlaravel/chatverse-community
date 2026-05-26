@extends('layouts.app')
@section('content')
<h1 class="text-4xl font-extrabold">Live Demo</h1>
<p class="mt-3 text-slate-300">This is the demo bot (“Buddy by Chatverse”). Copy the embed code to test on any website.</p>

<div class="mt-8 grid gap-6 md:grid-cols-2">
  <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
    <div class="text-lg font-semibold">Demo Embed Code</div>
    <p class="mt-2 text-sm text-slate-300">Paste these 2 lines inside your site’s <code>&lt;body&gt;</code> before the closing tag.</p>

    @php
      $k = $demoBot?->public_key ?? 'demo-buddy';
      $css = url('/chatverse/widget/chatverse-widget.css');
      $js = url('/chatverse/widget/chatverse-widget.js');
    @endphp

    <pre class="mt-4 overflow-auto rounded-2xl border border-white/10 bg-black/40 p-4 text-xs text-slate-200"><code>&lt;link rel=&quot;stylesheet&quot; href=&quot;{{ $css }}&quot;&gt;
&lt;script src=&quot;{{ $js }}&quot; data-bot=&quot;{{ $k }}&quot; defer&gt;&lt;/script&gt;</code></pre>

    <div class="mt-4 text-xs text-slate-400">Tip: For local testing, use your current APP_URL domain/port.</div>
  </div>

  <div class="relative rounded-3xl border border-white/10 bg-black/30 p-6">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-xs text-slate-400">Buddy by Chatverse</div>
        <div class="text-lg font-semibold">Demo chat is active on this page</div>
      </div>
      <img src="{{ asset('assets/buddy/buddy_right.webp') }}" class="h-20 w-auto opacity-90" alt="Buddy">
    </div>
    <p class="mt-4 text-sm text-slate-300">Open the chat button (bottom-right). Ask:</p>
    <ul class="mt-2 space-y-1 text-sm text-slate-300">
      <li>• “What are you?”</li>
      <li>• “How do you capture leads?”</li>
      <li>• “Can I install you on WordPress?”</li>
    </ul>

    <link rel="stylesheet" href="{{ url('/chatverse/widget/chatverse-widget.css') }}">
    <script src="{{ url('/chatverse/widget/chatverse-widget.js') }}" data-bot="{{ $k }}" defer></script>
  </div>
</div>
@endsection
