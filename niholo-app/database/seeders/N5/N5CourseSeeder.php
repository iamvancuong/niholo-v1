<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Course;

/**
 * Seeder tổng cho khóa học N5.
 * Để thêm bài mới: tạo N5LessonXSeeder.php trong thư mục N5/
 * rồi thêm vào mảng $lessons bên dưới.
 */
class N5CourseSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::firstOrCreate(
            ['level' => 'N5'],
            [
                'name' => 'N5.course.title',
                'description' => 'N5.course.description',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1528164344705-47542687000d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_published' => true,
            ]
        );

        // Thêm bài mới vào đây
        $lessons = [
            N5Lesson1Seeder::class,
            N5Lesson2Seeder::class,
            N5Lesson3Seeder::class,
            N5Lesson4Seeder::class,
            N5Lesson5Seeder::class,
            N5Lesson6Seeder::class,
            N5Lesson7Seeder::class,
            N5Lesson8Seeder::class,
            N5Lesson9Seeder::class,
            N5Lesson10Seeder::class,
            N5Lesson11Seeder::class,
            N5Lesson12Seeder::class,
            N5Lesson13Seeder::class,
            N5Lesson14Seeder::class,
            N5Lesson15Seeder::class,
            N5Lesson16Seeder::class,
            N5Lesson17Seeder::class,
            N5Lesson18Seeder::class,
            N5Lesson19Seeder::class,
            N5Lesson20Seeder::class,
            N5Lesson21Seeder::class,
            N5Lesson22Seeder::class,
            N5Lesson23Seeder::class,
            N5Lesson24Seeder::class,
            N5Lesson25Seeder::class,
        ];

        foreach ($lessons as $seederClass) {
            (new $seederClass())->run($course->id);
        }
    }
}
