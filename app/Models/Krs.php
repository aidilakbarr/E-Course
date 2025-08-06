<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Model Krs.php
    public function matakuliahs()
    {
        return $this->belongsToMany(Matakuliah::class, 'krs_mata_kuliah');
    }

}
