<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $bots = $user->bots()->latest()->get();
        $sub = $user->subscription?->load('plan');
        return view('dashboard.index', compact('user','bots','sub'));
    }
}
