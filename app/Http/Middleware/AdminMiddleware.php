<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses panel admin.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        return $next($request);
    }
}
