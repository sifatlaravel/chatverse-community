<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Chatverse' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 selection:bg-fuchsia-400/30">
  <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-cyan-400/25 blur-3xl"></div>
    <div class="absolute top-56 -left-32 h-96 w-96 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
    <div class="absolute -bottom-40 right-0 h-[28rem] w-[28rem] rounded-full bg-indigo-500/20 blur-3xl"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(34,193,238,.10),transparent_40%),radial-gradient(circle_at_70%_60%,rgba(168,85,247,.10),transparent_42%)]"></div>
  </div>

    <header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/70 backdrop-blur">
      <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        
        <a href="{{ route('home') }}" class="flex items-center">
          <img 
              src="{{ asset('assets/chatverse-logo-256.webp') }}" 
              alt="Chatverse" 
              class="h-14 md:h-16 w-auto object-contain"
          >
        </a>

      <nav class="hidden items-center gap-6 text-sm text-slate-200 md:flex">
        <a class="hover:text-white" href="{{ route('features') }}">Features</a>
        <a class="hover:text-white" href="{{ route('pricing') }}">Pricing</a>
        <a class="hover:text-white" href="{{ route('demo') }}">Demo</a>
        <a class="hover:text-white" href="{{ route('docs') }}">Docs</a>
        <a class="hover:text-white" href="{{ route('contact') }}">Contact</a>
      </nav>

      <div class="flex items-center gap-2">
        @auth
          <a href="{{ route('dashboard') }}" class="rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/15">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-xl bg-white/5 px-4 py-2 text-sm font-semibold hover:bg-white/10">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="rounded-xl bg-white/5 px-4 py-2 text-sm font-semibold hover:bg-white/10">Login</a>
          <a href="{{ route('register') }}" class="rounded-xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:opacity-95">Get Started</a>
        @endauth
      </div>
    </div>
  </header>

  <main class="mx-auto max-w-6xl px-4 py-10">
    @if (session('status'))
      <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
        {{ session('status') }}
      </div>
    @endif
    @if (session('error'))
      <div class="mb-6 rounded-2xl border border-rose-400/20 bg-rose-400/10 px-4 py-3 text-sm text-rose-200">
        {{ session('error') }}
      </div>
    @endif
    @yield('content')
  </main>

  <footer class="border-t border-white/10 bg-slate-950/40">
    <div class="mx-auto max-w-6xl px-4 py-10 text-sm text-slate-300">
      <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-3">
          <img src="{{ asset('assets/chatverse-logo-256.webp') }}" alt="Chatverse" class="h-9 w-auto opacity-95">
          <div class="text-slate-400">AI chatbots that capture leads — fast.</div>
        </div>
        <div class="flex flex-wrap gap-x-6 gap-y-2">
          <a class="hover:text-white" href="{{ route('terms') }}">Terms</a>
          <a class="hover:text-white" href="{{ route('privacy') }}">Privacy</a>
          <a class="hover:text-white" href="{{ route('contact') }}">Support</a>
        </div>
      </div>
      <div class="mt-6 text-slate-500">© {{ date('Y') }} Chatverse.</div>
    </div>
  </footer>
</body>
</html>
