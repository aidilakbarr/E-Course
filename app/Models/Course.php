<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Enums\StatusCourseEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'instructor_id',
        'status',
    ];

    protected $casts = [
        'status' => StatusCourseEnum::class,
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return asset('storage/'.$this->thumbnail);
    }

    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }

    public function scopeByRole($query)
    {
        $user = auth()->user();

        return $user->isAdmin()
            ? $query
            : $query->where('instructor_id', $user->id);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['instructor_id'] ?? null, fn ($q, $id) => $q->where('instructor_id', $id))
            ->when(
                filled($filters['status'] ?? null) && StatusCourseEnum::tryFrom($filters['status']),
                fn ($q) => $q->where('status', StatusCourseEnum::from($filters['status']))
            )
            ->when(
                filled($filters['role'] ?? null) && RoleEnum::tryFrom($filters['role']),
                fn ($q) => $q->whereHas('instructor', fn ($q2) => $q2->where('role', RoleEnum::from($filters['role'])))
            );

    }

    public function scopeFilterByUser($query, $user)
    {
        return $user->isAdmin()
            ? $query
            : $query->where('instructor_id', $user->id);
    }

    public function scopeSearch($query, $keyword)
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orWhereHas('instructor', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                });
        });
    }
}
