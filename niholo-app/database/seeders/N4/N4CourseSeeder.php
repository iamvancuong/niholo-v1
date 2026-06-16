<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Course;

class N4CourseSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::firstOrCreate(
            ['level' => 'N4'],
            [
                'name' => 'N4.course.title',
                'description' => 'N4.course.description',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1545569341-9eb8b30979d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
            ]
        );

        $lessons = [
            N4Lesson26Seeder::class,
            N4Lesson27Seeder::class,
            N4Lesson28Seeder::class,
            N4Lesson29Seeder::class,
            N4Lesson30Seeder::class,
            N4Lesson31Seeder::class,
            N4Lesson32Seeder::class,
            N4Lesson33Seeder::class,
            N4Lesson34Seeder::class,
            N4Lesson35Seeder::class,
            N4Lesson36Seeder::class,
            N4Lesson37Seeder::class,
            N4Lesson38Seeder::class,
            N4Lesson39Seeder::class,
            N4Lesson40Seeder::class,
            N4Lesson41Seeder::class,
            N4Lesson42Seeder::class,
            N4Lesson43Seeder::class,
            N4Lesson44Seeder::class,
            N4Lesson45Seeder::class,
            N4Lesson46Seeder::class,
            N4Lesson47Seeder::class,
            N4Lesson48Seeder::class,
            N4Lesson49Seeder::class,
            N4Lesson50Seeder::class,
        ];

        foreach ($lessons as $seederClass) {
            (new $seederClass())->run($course->id);
        }
    }
}
