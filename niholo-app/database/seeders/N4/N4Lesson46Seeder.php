<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson46Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 46],
            [
                'title' => 'N4.lesson46.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson46.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語46A', 'back' => 'たんご46A', 'key' => 'word_46_1', 'example_japanese' => '例文46Aです', 'example_blocks_json' => ["例文46A","です"]],
            ['front' => '単語46B', 'back' => 'たんご46B', 'key' => 'word_46_2', 'example_japanese' => '例文46Bです', 'example_blocks_json' => ["例文46B","です"]],
            ['front' => '単語46C', 'back' => 'たんご46C', 'key' => 'word_46_3', 'example_japanese' => '例文46Cです', 'example_blocks_json' => ["例文46C","です"]],
            ['front' => '単語46D', 'back' => 'たんご46D', 'key' => 'word_46_4', 'example_japanese' => '例文46Dです', 'example_blocks_json' => ["例文46D","です"]],
            ['front' => '単語46E', 'back' => 'たんご46E', 'key' => 'word_46_5', 'example_japanese' => '例文46Eです', 'example_blocks_json' => ["例文46E","です"]],
            ['front' => '単語46F', 'back' => 'たんご46F', 'key' => 'word_46_6', 'example_japanese' => '例文46Fです', 'example_blocks_json' => ["例文46F","です"]],
            ['front' => '単語46G', 'back' => 'たんご46G', 'key' => 'word_46_7', 'example_japanese' => '例文46Gです', 'example_blocks_json' => ["例文46G","です"]],
            ['front' => '単語46H', 'back' => 'たんご46H', 'key' => 'word_46_8', 'example_japanese' => '例文46Hです', 'example_blocks_json' => ["例文46H","です"]],
        ];

        $this->seedCards($lesson->id, $vocab);
    }

    private function seedCards(int $lessonId, array $list): void
    {
        foreach ($list as $item) {
            $key = $item['key'];
            Card::updateOrCreate(
                ['lesson_id' => $lessonId, 'front_text' => $item['front']],
                [
                    'back_text' => "N4.lesson46.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson46.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
