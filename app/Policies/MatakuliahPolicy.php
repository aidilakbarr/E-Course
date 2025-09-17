<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\matakuliah;
use Illuminate\Auth\Access\Response;

class MatakuliahPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, matakuliah $matakuliah): bool
    {
        return true;
    }
    public function create(User $user): bool
    {
        return $user->role === RoleEnum::ADMIN || $user->role === RoleEnum::KAPRODI;
    }
    public function update(User $user, matakuliah $matakuliah): bool
    {
        return $user->role === RoleEnum::ADMIN || $user->role === RoleEnum::KAPRODI;
    }
    public function delete(User $user, matakuliah $matakuliah): bool
    {
        return $user->role === RoleEnum::ADMIN || $user->role === RoleEnum::KAPRODI;
    }
    public function restore(User $user, matakuliah $matakuliah): bool
    {
        return $user->role === RoleEnum::ADMIN || $user->role === RoleEnum::KAPRODI;
    }
    public function forceDelete(User $user, matakuliah $matakuliah): bool
    {
        return $user->role === RoleEnum::ADMIN || $user->role === RoleEnum::KAPRODI;
    }
}
