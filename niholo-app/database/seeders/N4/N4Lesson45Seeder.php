<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson45Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 45],
            [
                'title' => 'N4.lesson45.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson45.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語45A', 'back' => 'たんご45A', 'key' => 'word_45_1', 'example_japanese' => '例文45Aです', 'example_blocks_json' => ["例文45A","です"]],
            ['front' => '単語45B', 'back' => 'たんご45B', 'key' => 'word_45_2', 'example_japanese' => '例文45Bです', 'example_blocks_json' => ["例文45B","です"]],
            ['front' => '単語45C', 'back' => 'たんご45C', 'key' => 'word_45_3', 'example_japanese' => '例文45Cです', 'example_blocks_json' => ["例文45C","です"]],
            ['front' => '単語45D', 'back' => 'たんご45D', 'key' => 'word_45_4', 'example_japanese' => '例文45Dです', 'example_blocks_json' => ["例文45D","です"]],
            ['front' => '単語45E', 'back' => 'たんご45E', 'key' => 'word_45_5', 'example_japanese' => '例文45Eです', 'example_blocks_json' => ["例文45E","です"]],
            ['front' => '単語45F', 'back' => 'たんご45F', 'key' => 'word_45_6', 'example_japanese' => '例文45Fです', 'example_blocks_json' => ["例文45F","です"]],
            ['front' => '単語45G', 'back' => 'たんご45G', 'key' => 'word_45_7', 'example_japanese' => '例文45Gです', 'example_blocks_json' => ["例文45G","です"]],
            ['front' => '単語45H', 'back' => 'たんご45H', 'key' => 'word_45_8', 'example_japanese' => '例文45Hです', 'example_blocks_json' => ["例文45H","です"]],
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
                    'back_text' => "N4.lesson45.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson45.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
