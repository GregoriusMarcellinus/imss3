<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GudangAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role != 4 && auth()->user()->role != 0) {
            return redirect()->route('unauthorized');
        }
        return $next($request);
    }
}
