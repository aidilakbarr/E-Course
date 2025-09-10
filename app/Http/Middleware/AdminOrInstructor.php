<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrInstructor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();
        dd($user);

        if ($user && ($user->role === RoleEnum::ADMIN || $user->role === RoleEnum::INSTRUCTOR)) {
            return $next($request);
        }

        return redirect()->route('user.home.index')->with('error', 'Akses khusus admin/instructor.');
    }
}
