<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function showRegisterForm()
    {
        return Inertia::render('Auth/Register');
    }

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
            // SendWelcomeEmail::dispatch($user);

            return redirect()->route('auth.login');
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

            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return back()->withErrors([
                    'email' => 'Email tidak ditemukan'
                ])->withInput();
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return back()->withErrors([
                    'password' => 'Password salah'
                ])->withInput();
            }

            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat login'
            ]);
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

    public function logout(Request $request)
    {
        try {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            // return back()->with('success', 'Berhasil logout!');
            return redirect()->route('auth.login')->with('success', 'Berhasil logout!');
            // return redirect()->route('auth.login');
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
