<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson41Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 41],
            [
                'title' => 'N4.lesson41.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson41.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語41A', 'back' => 'たんご41A', 'key' => 'word_41_1', 'example_japanese' => '例文41Aです', 'example_blocks_json' => ["例文41A","です"]],
            ['front' => '単語41B', 'back' => 'たんご41B', 'key' => 'word_41_2', 'example_japanese' => '例文41Bです', 'example_blocks_json' => ["例文41B","です"]],
            ['front' => '単語41C', 'back' => 'たんご41C', 'key' => 'word_41_3', 'example_japanese' => '例文41Cです', 'example_blocks_json' => ["例文41C","です"]],
            ['front' => '単語41D', 'back' => 'たんご41D', 'key' => 'word_41_4', 'example_japanese' => '例文41Dです', 'example_blocks_json' => ["例文41D","です"]],
            ['front' => '単語41E', 'back' => 'たんご41E', 'key' => 'word_41_5', 'example_japanese' => '例文41Eです', 'example_blocks_json' => ["例文41E","です"]],
            ['front' => '単語41F', 'back' => 'たんご41F', 'key' => 'word_41_6', 'example_japanese' => '例文41Fです', 'example_blocks_json' => ["例文41F","です"]],
            ['front' => '単語41G', 'back' => 'たんご41G', 'key' => 'word_41_7', 'example_japanese' => '例文41Gです', 'example_blocks_json' => ["例文41G","です"]],
            ['front' => '単語41H', 'back' => 'たんご41H', 'key' => 'word_41_8', 'example_japanese' => '例文41Hです', 'example_blocks_json' => ["例文41H","です"]],
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
                    'back_text' => "N4.lesson41.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson41.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
