<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\N5\N5CourseSeeder;

use Database\Seeders\N4\N4CourseSeeder;

/**
 * DataVocabularySeeder - Điều phối tất cả các khóa học.
 *
 * Để thêm khóa học mới (N4, N3, ...):
 * 1. Tạo thư mục: database/seeders/N4/
 * 2. Tạo: N4CourseSeeder.php + N4Lesson1Seeder.php, ...
 * 3. Thêm N4CourseSeeder::class vào mảng $courses bên dưới
 */
class DataVocabularySeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            N5CourseSeeder::class,
            N4CourseSeeder::class,
            // N3CourseSeeder::class,
        ];

        foreach ($courses as $seederClass) {
            $this->call($seederClass);
        }
    }
}