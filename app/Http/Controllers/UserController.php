<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return view('user.home.index');
    }
    public function showAbout(){
        return view('user.about.index');
    }
    public function showCourse(){
        return view('user.course.index');
    }
    public function showContact(){
        return view('user.contact.index');
    }
    public function showDetailCourse(){
        return view('user.detail-course.index');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
    $user = Auth::user();
    $data = $request->validated();

    // dd($request->all());
    logger('Data untuk update: ', $data);
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }
    if ($request->hasFile('profile')) {
        $path = $request->file('profile')->store('profiles', 'public');
        $data['profile'] = $path;
    } else {
        unset($data['profile']);
    }

    $user->update($data);
    logger('Data untuk update: ', $data);

    return back()->with('success', 'Profile berhasil diperbarui');
}


}
