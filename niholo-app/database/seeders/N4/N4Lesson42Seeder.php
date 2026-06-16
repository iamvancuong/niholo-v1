<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson42Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 42],
            [
                'title' => 'N4.lesson42.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson42.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語42A', 'back' => 'たんご42A', 'key' => 'word_42_1', 'example_japanese' => '例文42Aです', 'example_blocks_json' => ["例文42A","です"]],
            ['front' => '単語42B', 'back' => 'たんご42B', 'key' => 'word_42_2', 'example_japanese' => '例文42Bです', 'example_blocks_json' => ["例文42B","です"]],
            ['front' => '単語42C', 'back' => 'たんご42C', 'key' => 'word_42_3', 'example_japanese' => '例文42Cです', 'example_blocks_json' => ["例文42C","です"]],
            ['front' => '単語42D', 'back' => 'たんご42D', 'key' => 'word_42_4', 'example_japanese' => '例文42Dです', 'example_blocks_json' => ["例文42D","です"]],
            ['front' => '単語42E', 'back' => 'たんご42E', 'key' => 'word_42_5', 'example_japanese' => '例文42Eです', 'example_blocks_json' => ["例文42E","です"]],
            ['front' => '単語42F', 'back' => 'たんご42F', 'key' => 'word_42_6', 'example_japanese' => '例文42Fです', 'example_blocks_json' => ["例文42F","です"]],
            ['front' => '単語42G', 'back' => 'たんご42G', 'key' => 'word_42_7', 'example_japanese' => '例文42Gです', 'example_blocks_json' => ["例文42G","です"]],
            ['front' => '単語42H', 'back' => 'たんご42H', 'key' => 'word_42_8', 'example_japanese' => '例文42Hです', 'example_blocks_json' => ["例文42H","です"]],
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
                    'back_text' => "N4.lesson42.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson42.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
