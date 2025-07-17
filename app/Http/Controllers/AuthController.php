<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(LoginUserRequest $request){
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === RoleEnum::ADMIN || $user->role === RoleEnum::INSTRUCTOR) {
                return redirect()->intended(route('admin.dashboard.index'));
            } else {
                return redirect()->intended(route('user.home.index'));
            }
        }

        return back()->withErrors([
            'Email' => 'Email atau password salah'
        ])->onlyInput('email');
    }

    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request) {
        $user = User::create($request->validated());
        Auth::login($user);
        return redirect(route('user.home.index') );
    }

    public function logout(request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('auth.login'));
    }
}
