<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        session(['jwt_token' => $request->input('token')]);

        return redirect('/dashboard');
    }
}
