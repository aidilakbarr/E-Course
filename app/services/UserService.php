<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $userRepository;

    protected FileUploadService $fileUploadService;

    public function __construct(UserRepository $userRepository, FileUploadService $fileUploadService)
    {
        $this->userRepository = $userRepository;
        $this->fileUploadService = $fileUploadService;
    }

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['profile'])) {
                $data['profile'] = $this->fileUploadService::uploadProfile($data['profile']);
            }

            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'profile' => $data['profile'] ?? null,
                'password' => Hash::make($data['password']),
            ]);

            $this->attachRoleData($user, $data);

            return $user;
        });
    }

    public function updateUser(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if (isset($data['profile'])) {
                $data['profile'] = $this->fileUploadService::uploadProfile($data['profile']);
            }

            $this->userRepository->update($user, [
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'profile' => $data['profile'] ?? $user->profile,
                'password' => isset($data['password']) && $data['password']
                    ? Hash::make($data['password'])
                    : $user->password,
            ]);

            $this->attachRoleData($user, $data);

            return $user->fresh();
        });
    }

    protected function attachRoleData(User $user, array $data): void
    {
        if ($data['role'] === RoleEnum::MAHASISWA->value) {
            $user->mahasiswa()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $data['nim'],
                    'angkatan' => $data['angkatan'],
                    'prodi' => $data['prodi_mahasiswa'],
                ]
            );
        } elseif ($data['role'] === RoleEnum::DOSEN->value) {
            $user->dosen()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nidn' => $data['nidn'],
                    'prodi' => $data['prodi'],
                ]
            );
        }
    }
}
