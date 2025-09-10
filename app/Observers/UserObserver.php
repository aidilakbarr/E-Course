<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function created(User $user)
    {
        Cache::put("user:{$user->id}", $user->only(['id', 'name', 'email', 'profile', 'role']), now()->addMinutes(30));
    }

    public function updated(User $user)
    {
        Cache::put("user:{$user->id}", $user->only(['id', 'name', 'email', 'profile', 'role']), now()->addMinutes(30));
    }

    public function deleted(User $user)
    {
        Cache::forget("user:{$user->id}");
    }
}
