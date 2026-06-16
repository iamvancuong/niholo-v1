<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson36Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 36],
            [
                'title' => 'N4.lesson36.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson36.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語36A', 'back' => 'たんご36A', 'key' => 'word_36_1', 'example_japanese' => '例文36Aです', 'example_blocks_json' => ["例文36A","です"]],
            ['front' => '単語36B', 'back' => 'たんご36B', 'key' => 'word_36_2', 'example_japanese' => '例文36Bです', 'example_blocks_json' => ["例文36B","です"]],
            ['front' => '単語36C', 'back' => 'たんご36C', 'key' => 'word_36_3', 'example_japanese' => '例文36Cです', 'example_blocks_json' => ["例文36C","です"]],
            ['front' => '単語36D', 'back' => 'たんご36D', 'key' => 'word_36_4', 'example_japanese' => '例文36Dです', 'example_blocks_json' => ["例文36D","です"]],
            ['front' => '単語36E', 'back' => 'たんご36E', 'key' => 'word_36_5', 'example_japanese' => '例文36Eです', 'example_blocks_json' => ["例文36E","です"]],
            ['front' => '単語36F', 'back' => 'たんご36F', 'key' => 'word_36_6', 'example_japanese' => '例文36Fです', 'example_blocks_json' => ["例文36F","です"]],
            ['front' => '単語36G', 'back' => 'たんご36G', 'key' => 'word_36_7', 'example_japanese' => '例文36Gです', 'example_blocks_json' => ["例文36G","です"]],
            ['front' => '単語36H', 'back' => 'たんご36H', 'key' => 'word_36_8', 'example_japanese' => '例文36Hです', 'example_blocks_json' => ["例文36H","です"]],
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
                    'back_text' => "N4.lesson36.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson36.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
