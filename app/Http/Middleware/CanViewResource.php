<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanViewResource
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();
        dd($user);

        if (! in_array($user->role, ['ADMIN', 'USER'])) {
            return response()->json([
                'message' => 'Unauthorized to view this resource.',
            ], 403);
        }

        return $next($request);
    }
}
