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
    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'instructor_id',
        'status'
    ];

    protected $casts =[
        'status' => StatusCourseEnum::class
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

    function getThumbnailUrlAttribute(){
        return asset('storage/'. $this->thumbnail);
    }

public function scopeSearch($query, ?string $search)
{
    if ($search) {
        $query->where('title', 'like', '%' . $search . '%');
    }

    return $query;
}

public function scopeByRole($query)
{
    $user = auth()->user();

    return $user->isAdmin()
        ? $query
        : $query->where('instructor_id', $user->id);
}

}
