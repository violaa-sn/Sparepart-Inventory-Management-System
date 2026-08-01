<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            // ambil data terbaru dari database
            Auth::user()->refresh();

            if (Auth::user()->status_user === 'nonaktif') {

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/')
                    ->with('error', 'Akun Anda telah dinonaktifkan.');
            }
        }

        return $next($request);
    }
}
