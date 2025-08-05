<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'semester',
        'sks',
        'dosen_id',
        'kelas',
        'kapasitas',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function scopeSearch($query, $keyword)
    {
        if (!$keyword)
            return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('kode', 'like', "%{$keyword}%")
                ->orWhere('nama', 'like', "%{$keyword}%")
                ->orWhereHas('dosen.user', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                });
        });
    }
}
