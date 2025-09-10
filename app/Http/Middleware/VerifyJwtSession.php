<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJwtSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('jwt_token');

        if (! $token) {
            return redirect('/auth/login');
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();
            if (! $user) {
                session()->forget('jwt_token');

                return redirect('/login');
            }

            auth()->setUser($user);
        } catch (\Exception $e) {
            session()->forget('jwt_token');

            return redirect('/auth/login');
        }

        return $next($request);
    }
}
