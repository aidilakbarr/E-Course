<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            $accessToken = JWTAuth::fromUser($user);

            SendWelcomeEmail::dispatch($user);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'access_token' => $accessToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat registrasi',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!$accessToken = auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah',
                ], 401);
            }
            $user = auth()->user();
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ?? null,
                    'profile' => $user->profile ?? null,
                ],
                'access_token' => $accessToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]);
        } catch (JWTException $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function me()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak terautentikasi',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data user ditemukan',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile' => $user->profile ?? null,
                    'role' => $user->role ?? null,
                ],
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token kadaluarsa. Silakan login ulang.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid. Silakan login ulang.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data user',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil logout',
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->input('refresh_token');

            if (!$refreshToken) {
                $refreshToken = $request->bearerToken();
                if (!$refreshToken) {
                    throw new \Exception("Refresh token tidak ditemukan di request body atau Authorization header.");
                }
            }
            $newAccessToken = auth()->setToken($refreshToken)->refresh();
            $user = auth()->user();
            $newRefreshToken = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addMinutes(config('jwt.refresh_ttl', 10080))->timestamp]);

            return response()->json([
                'success' => true,
                'message' => 'Token berhasil diperbarui',
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi berakhir. Refresh token kadaluarsa. Silakan login ulang.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token tidak valid. Silakan login ulang.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui token',
                'error' => $th->getMessage(),
            ], 401);
        }
    }
}