<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    private function tokenTTL()
    {
        return auth()->factory()->getTTL() * 60;
    }
    public function register(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            $accessToken = JWTAuth::fromUser($user);

            SendWelcomeEmail::dispatch($user);

            return successResponse('Registrasi berhasil', [
                'user' => new UserResource($user),
                'access_token' => $accessToken,
                'token_type' => 'bearer',
                'expires_in' => $this->tokenTTL()
            ], 201);
        } catch (ValidationException $e) {
            return errorResponse("Validasi gagal", [
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            report($th);
            return errorResponse("Terjadi kesalahan saat registrasi", [
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

            return successResponse('Login berhasil', [
                'user' => new UserResource($user),
                'access_token' => $accessToken,
                'token_type' => 'bearer',
                'expires_in' => $this->tokenTTL()
            ]);
        } catch (JWTException $e) {
            report($e);
            return errorResponse('Gagal Membuat token', [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function me()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return errorResponse('Tidak terauthentikasi');
            }

            return successResponse('Data user ditemukan', [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile' => $user->profile ?? null,
                    'role' => $user->role ?? null,
                ],
            ], 200);
        } catch (TokenExpiredException $e) {
            return errorResponse('Token kadaluarsa. Silakan login ulang', [
                'error' => $e->getMessage(),
            ], 401);
        } catch (TokenInvalidException $e) {
            return errorResponse('Token tidak valid. Silakan login ulang', [
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $th) {
            report($th);
            return errorResponse('Terjadi kesalahan saat mengambil data user', [
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return successResponse('Berhasil logout');
        } catch (\Throwable $th) {
            report($th);
            return errorResponse('Gagal logout', [
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

            return successResponse('Token berhasil diperbarui', [
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
                'token_type' => 'bearer',
                'expires_in' => $this->tokenTTL()
            ]);
        } catch (TokenExpiredException $e) {
            return errorResponse('Sesi berakhir. Refresh token kadaluarsa. Silakan login ulang', [
                'error' => $e->getMessage(),
            ], 401);
        } catch (TokenInvalidException $e) {
            return errorResponse('Refresh token tidak valid. Silakan login ulang', [
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $th) {
            report($th);
            return errorResponse('Gagal memperbarui token', [
                'error' => $th->getMessage(),
            ], 401);
        }
    }
}