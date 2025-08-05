<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

        protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'angkatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa')->withPivot('nilai', 'status');
    }

    public function kelasMahasiswa()
    {
        return $this->hasMany(KelasMahasiswa::class);
    }

}
