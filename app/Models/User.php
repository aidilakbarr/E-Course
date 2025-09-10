<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'profile',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => RoleEnum::class,
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN;
    }

    public function getProfileUrlAttribute()
    {
        return $this->profile
            ? asset('storage/'.$this->profile)
            : default_profile_image();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
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
        return $query->when(
            filled($filters['role'] ?? null) && RoleEnum::tryFrom($filters['role']),
            fn ($q) => $q->where('role', RoleEnum::from($filters['role']))
        );
    }

    public function scopeSearch($query, $keyword)
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhereHas('mahasiswa', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                })
                ->orWhereHas('dosen', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%{$keyword}%");
                });
        });
    }
}
