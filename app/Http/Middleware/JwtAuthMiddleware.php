<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {

            $token = $request->bearerToken();


            if (!$token || trim($token) === '') {
                throw new Exception('Token tidak ditemukan di Authorization header.');
            }

            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                throw new Exception('User tidak valid');
            }

            $request->merge(['auth_user' => $user]);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => 'Token expired',
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => 'Token invalid',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => 'Token not found or malformed',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => $e->getMessage(),
            ], 401);
        }

        return $next($request);
    }
}
