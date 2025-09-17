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

    public function register(RegisterUserRequest $request)
    {
        try {
            User::create($request->validated());
            // SendWelcomeEmail::dispatch($user);
            return redirect()->route('auth.login');
        } catch (\Throwable $th) {
            return handleError($th);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $credentials = $request->validated();
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                return back()->withErrors([
                    'email' => 'Email tidak ditemukan',
                ])->withInput();
            }
            if (!Hash::check($credentials['password'], $user->password)) {
                return back()->withErrors([
                    'password' => 'Password salah',
                ])->withInput();
            }
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        } catch (\Throwable $th) {
            return handleError($th);
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
        } catch (\Throwable $th) {
            report($th);
            return handleError($th);
        }
    }

    public function logout(Request $request)
    {
        try {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login')->with('success', 'Berhasil logout!');
        } catch (\Throwable $th) {
            report($th);
            return handleError($th);
        }
    }
}
