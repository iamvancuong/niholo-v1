<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson39Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 39],
            [
                'title' => 'N4.lesson39.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson39.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語39A', 'back' => 'たんご39A', 'key' => 'word_39_1', 'example_japanese' => '例文39Aです', 'example_blocks_json' => ["例文39A","です"]],
            ['front' => '単語39B', 'back' => 'たんご39B', 'key' => 'word_39_2', 'example_japanese' => '例文39Bです', 'example_blocks_json' => ["例文39B","です"]],
            ['front' => '単語39C', 'back' => 'たんご39C', 'key' => 'word_39_3', 'example_japanese' => '例文39Cです', 'example_blocks_json' => ["例文39C","です"]],
            ['front' => '単語39D', 'back' => 'たんご39D', 'key' => 'word_39_4', 'example_japanese' => '例文39Dです', 'example_blocks_json' => ["例文39D","です"]],
            ['front' => '単語39E', 'back' => 'たんご39E', 'key' => 'word_39_5', 'example_japanese' => '例文39Eです', 'example_blocks_json' => ["例文39E","です"]],
            ['front' => '単語39F', 'back' => 'たんご39F', 'key' => 'word_39_6', 'example_japanese' => '例文39Fです', 'example_blocks_json' => ["例文39F","です"]],
            ['front' => '単語39G', 'back' => 'たんご39G', 'key' => 'word_39_7', 'example_japanese' => '例文39Gです', 'example_blocks_json' => ["例文39G","です"]],
            ['front' => '単語39H', 'back' => 'たんご39H', 'key' => 'word_39_8', 'example_japanese' => '例文39Hです', 'example_blocks_json' => ["例文39H","です"]],
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
                    'back_text' => "N4.lesson39.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson39.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
