<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSenimanRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role === 'seniman') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda harus menjadi seniman untuk mengakses halaman ini.');
    }
}
