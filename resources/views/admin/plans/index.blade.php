@extends('layouts.admin')

@php $pageTitle = 'Plans'; @endphp

@section('content')
<h1 class="text-3xl font-extrabold">Plans</h1>
<p class="mt-2 text-sm text-slate-300">For v1, plans are seeded. You can adjust pricing/limits in the database.</p>

<div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-6">
  <table class="w-full text-sm">
    <thead class="text-slate-300">
      <tr>
        <th class="text-left py-2">ID</th>
        <th class="text-left py-2">Code</th>
        <th class="text-left py-2">Name</th>
        <th class="text-left py-2">Bots</th>
        <th class="text-left py-2">Price</th>
        <th class="text-left py-2">Active</th>
      </tr>
    </thead>
    <tbody class="text-slate-200">
      @foreach($plans as $p)
        <tr class="border-t border-white/10">
          <td class="py-2">{{ $p->id }}</td>
          <td class="py-2">{{ $p->code }}</td>
          <td class="py-2">{{ $p->name }}</td>
          <td class="py-2">{{ $p->bot_limit }}</td>
          <td class="py-2">{{ $p->currency }} {{ number_format($p->monthly_price_cents/100,0) }}</td>
          <td class="py-2">{{ $p->is_active ? 'Yes' : 'No' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
