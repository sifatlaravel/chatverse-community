<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActivePlanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            abort(403);
        }
        $sub = $user->subscription;
        if (!$sub || !$sub->isActive()) {
            return redirect()->route('billing.plans')->with('error', 'You need an active plan to access that feature.');
        }
        return $next($request);
    }
}
