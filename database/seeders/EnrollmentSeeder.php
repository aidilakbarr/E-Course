<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $students = User::where('role', 'STUDENT')->get();
    //     $courses = Course::all();

    //     foreach ($students as $student) {
    //         $randomCourses = $courses->random(2);

    //         foreach ($randomCourses as $course) {
    //             Enrollment::create([
    //                 'student_id' => $student->id,
    //                 'course_id' => $course->id,
    //                 'status' => 'ENROLLED',
    //             ]);
    //         }
    //     }
    // }
}
