<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepository
{
    public function paginateWithFilters(array $filters, ?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        return Course::with('instructor')
            ->filterByUser(auth()->user())
            ->search($search)
            ->filter($filters)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function store(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course;
    }

    public function destroy(Course $course): bool
    {
        return $course->delete();
    }
}
