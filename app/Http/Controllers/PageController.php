<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Bot;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function features()
    {
        return view('pages.features');
    }

    public function pricing()
    {
        $plans = Plan::where('is_active', true)->orderBy('monthly_price_cents')->get();
        return view('pages.pricing', compact('plans'));
    }

    public function demo()
    {
        $demoBot = Bot::where('is_demo', true)->first();
        return view('pages.demo', compact('demoBot'));
    }

    public function docs()
    {
        return view('pages.docs');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
