<?php

namespace App\Models;

use App\Enums\StatusCourseEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

      protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'teacher',
        'start_on',
        'ends_on',
        'kuota',
        'status'
    ];

    protected $casts =[
        'status' => StatusCourseEnum::class
    ];
}
