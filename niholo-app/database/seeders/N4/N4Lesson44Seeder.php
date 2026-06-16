<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson44Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 44],
            [
                'title' => 'N4.lesson44.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson44.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語44A', 'back' => 'たんご44A', 'key' => 'word_44_1', 'example_japanese' => '例文44Aです', 'example_blocks_json' => ["例文44A","です"]],
            ['front' => '単語44B', 'back' => 'たんご44B', 'key' => 'word_44_2', 'example_japanese' => '例文44Bです', 'example_blocks_json' => ["例文44B","です"]],
            ['front' => '単語44C', 'back' => 'たんご44C', 'key' => 'word_44_3', 'example_japanese' => '例文44Cです', 'example_blocks_json' => ["例文44C","です"]],
            ['front' => '単語44D', 'back' => 'たんご44D', 'key' => 'word_44_4', 'example_japanese' => '例文44Dです', 'example_blocks_json' => ["例文44D","です"]],
            ['front' => '単語44E', 'back' => 'たんご44E', 'key' => 'word_44_5', 'example_japanese' => '例文44Eです', 'example_blocks_json' => ["例文44E","です"]],
            ['front' => '単語44F', 'back' => 'たんご44F', 'key' => 'word_44_6', 'example_japanese' => '例文44Fです', 'example_blocks_json' => ["例文44F","です"]],
            ['front' => '単語44G', 'back' => 'たんご44G', 'key' => 'word_44_7', 'example_japanese' => '例文44Gです', 'example_blocks_json' => ["例文44G","です"]],
            ['front' => '単語44H', 'back' => 'たんご44H', 'key' => 'word_44_8', 'example_japanese' => '例文44Hです', 'example_blocks_json' => ["例文44H","です"]],
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
                    'back_text' => "N4.lesson44.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson44.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
