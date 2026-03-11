<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_approved) {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors(['account' => 'Your account is pending admin approval.']);
        }

        return $next($request);
    }
}