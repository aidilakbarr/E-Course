<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $instructors = User::where('role', 'INSTRUCTOR')->get();
    //     $categoryIds = \App\Models\Category::pluck('id')->toArray();

    //     foreach ($instructors as $instructor) {
    //         foreach (range(1, 3) as $i) {
    //             $course = Course::create([
    //                 'title' => "Course $i by {$instructor->name}",
    //                 'description' => 'Deskripsi kursus otomatis',
    //                 'thumbnail' => 'default.jpg',
    //                 'status' => 'AKTIF',
    //                 'instructor_id' => $instructor->id,
    //             ]);

    //             $course->categories()->attach(array_rand(array_flip($categoryIds), 2));

    //             foreach (range(1, 3) as $j) {
    //                 Lesson::create([
    //                     'course_id' => $course->id,
    //                     'title' => "Lesson $j",
    //                     'video_url' => 'https://example.com/video.mp4',
    //                     'content' => "Konten dari Lesson $j",
    //                     'order' => $j,
    //                 ]);
    //             }
    //         }
    //     }
    // }
}
