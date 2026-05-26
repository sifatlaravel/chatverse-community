<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Chatverse Admin' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 selection:bg-fuchsia-400/30">
  <!-- Background glow (same vibe as public) -->
  <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-cyan-400/25 blur-3xl"></div>
    <div class="absolute top-56 -left-32 h-96 w-96 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
    <div class="absolute -bottom-40 right-0 h-[28rem] w-[28rem] rounded-full bg-indigo-500/20 blur-3xl"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(34,193,238,.10),transparent_40%),radial-gradient(circle_at_70%_60%,rgba(168,85,247,.10),transparent_42%)]"></div>
  </div>

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-white/10 bg-slate-950/80 p-4 backdrop-blur transition-transform md:static md:translate-x-0">
      <div class="flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
          <img src="{{ asset('assets/chatverse-logo-256.webp') }}" alt="Chatverse" class="h-9 w-auto">
          <span class="rounded-full bg-white/10 px-2 py-1 text-xs font-semibold">Admin</span>
        </a>
        <button type="button" class="rounded-xl bg-white/5 p-2 hover:bg-white/10 md:hidden" onclick="toggleAdminSidebar(false)">
          <span class="sr-only">Close sidebar</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
            <path d="M18 6 6 18M6 6l12 12" />
          </svg>
        </button>
      </div>

      <nav class="mt-6 space-y-2 text-sm">
        @php
          $items = [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2 4 4 8-8 4 4v8H3z'],
            ['route' => 'admin.invoices', 'label' => 'Invoices', 'icon' => 'M7 7h10M7 11h10M7 15h6'],
            ['route' => 'admin.plans', 'label' => 'Plans', 'icon' => 'M4 6h16M4 12h16M4 18h16'],
            ['route' => 'admin.users', 'label' => 'Users', 'icon' => 'M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'],
            ['route' => 'admin.bots', 'label' => 'Bots', 'icon' => 'M12 2a2 2 0 0 0-2 2v2H8a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2h-2V4a2 2 0 0 0-2-2Z'],
            ['route' => 'admin.leads', 'label' => 'Leads', 'icon' => 'M21 15a4 4 0 0 1-4 4H7l-4 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z'],
            ['route' => 'admin.conversations', 'label' => 'Conversations', 'icon' => 'M7 8h10M7 12h6M7 16h8'],
          ];
        @endphp

        @foreach ($items as $it)
          @php $active = request()->routeIs($it['route'].'*'); @endphp
          <a href="{{ route($it['route']) }}" class="group flex items-center gap-3 rounded-2xl px-3 py-2 font-semibold transition {{ $active ? 'bg-white/12 text-white' : 'bg-white/5 text-slate-200 hover:bg-white/10 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 opacity-90">
              <path d="{{ $it['icon'] }}" />
            </svg>
            <span>{{ $it['label'] }}</span>
          </a>
        @endforeach
      </nav>

      <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-4">
        <div class="text-xs font-semibold text-slate-300">Signed in as</div>
        <div class="mt-1 text-sm font-semibold">{{ auth()->user()->email ?? '' }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
          @csrf
          <button class="w-full rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold hover:bg-white/15">Logout</button>
        </form>
      </div>
    </aside>

    <!-- Mobile overlay -->
    <div id="adminOverlay" class="fixed inset-0 z-40 hidden bg-black/60 md:hidden" onclick="toggleAdminSidebar(false)"></div>

    <!-- Main -->
    <div class="flex-1 md:ml-0">
      <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/70 backdrop-blur">
        <div class="flex items-center justify-between px-4 py-3 md:px-8">
          <button type="button" class="rounded-xl bg-white/5 p-2 hover:bg-white/10 md:hidden" onclick="toggleAdminSidebar(true)">
            <span class="sr-only">Open sidebar</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
              <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <div class="flex items-center gap-3">
            <div class="text-sm font-semibold text-slate-200">{{ $pageTitle ?? 'Admin' }}</div>
          </div>

          <a href="{{ route('home') }}" class="rounded-xl bg-white/5 px-4 py-2 text-sm font-semibold hover:bg-white/10">View site</a>
        </div>
      </header>

      <main class="px-4 py-8 md:px-8">
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
    </div>
  </div>

  <script>
    function toggleAdminSidebar(open) {
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('adminOverlay');
      if (!sidebar || !overlay) return;
      if (open) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
      }
    }
  </script>
</body>
</html>
