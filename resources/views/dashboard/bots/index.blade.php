@extends('layouts.app')
@section('content')
<div class="flex items-center justify-between">
  <h1 class="text-3xl font-extrabold">Bots</h1>
  <a href="{{ route('bots.create') }}" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-fuchsia-500 px-4 py-2 font-semibold text-slate-950">Create</a>
</div>

<div class="mt-6 space-y-3">
  @foreach($bots as $bot)
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <div class="text-lg font-semibold">{{ $bot->bot_name }}</div>
        <div class="text-sm text-slate-300">{{ $bot->company_name }}</div>
        <div class="mt-2 text-xs text-slate-400">Public key: {{ $bot->public_key }}</div>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('bots.edit', $bot) }}" class="rounded-2xl border border-white/15 bg-white/5 px-4 py-2 font-semibold hover:bg-white/10">Edit</a>
      </div>
    </div>
  @endforeach
</div>
@endsection
