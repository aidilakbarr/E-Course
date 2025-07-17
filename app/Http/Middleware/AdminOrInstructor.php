<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrInstructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    if (auth()->check() && (auth()->user()->role === RoleEnum::ADMIN  || auth()->user()->role === RoleEnum::INSTRUCTOR)) {
        return $next($request);
    }


        return redirect(route('user.home.index'))->with('error', 'Akses khusus admin.');
    }
}
