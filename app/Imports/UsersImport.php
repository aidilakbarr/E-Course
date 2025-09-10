<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                \Log::info('Import row:', $row->toArray());

                $user = User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                    'role' => $row['role'],
                ]);

                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $row['nim'],
                    'prodi' => $row['prodi'],
                    'angkatan' => $row['angkatan'],
                ]);
            } catch (\Throwable $e) {
                \Log::error('Gagal import row: '.json_encode($row).' - Error: '.$e->getMessage());
            }
        }
    }
}
