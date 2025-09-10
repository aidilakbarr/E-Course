<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function searchAndPaginate($search, $perPage = 5)
    {
        return User::search($search)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findWithMahasiswaAndDosen(int $id): ?User
    {
        return User::with(['mahasiswa', 'dosen'])->findOrFail($id);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
