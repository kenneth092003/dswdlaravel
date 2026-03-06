<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && ! auth()->user()->is_approved) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is pending approval by an administrator.']);
        }

        return $next($request);
    }
}