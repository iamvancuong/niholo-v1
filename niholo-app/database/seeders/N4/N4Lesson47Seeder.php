<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson47Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 47],
            [
                'title' => 'N4.lesson47.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson47.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語47A', 'back' => 'たんご47A', 'key' => 'word_47_1', 'example_japanese' => '例文47Aです', 'example_blocks_json' => ["例文47A","です"]],
            ['front' => '単語47B', 'back' => 'たんご47B', 'key' => 'word_47_2', 'example_japanese' => '例文47Bです', 'example_blocks_json' => ["例文47B","です"]],
            ['front' => '単語47C', 'back' => 'たんご47C', 'key' => 'word_47_3', 'example_japanese' => '例文47Cです', 'example_blocks_json' => ["例文47C","です"]],
            ['front' => '単語47D', 'back' => 'たんご47D', 'key' => 'word_47_4', 'example_japanese' => '例文47Dです', 'example_blocks_json' => ["例文47D","です"]],
            ['front' => '単語47E', 'back' => 'たんご47E', 'key' => 'word_47_5', 'example_japanese' => '例文47Eです', 'example_blocks_json' => ["例文47E","です"]],
            ['front' => '単語47F', 'back' => 'たんご47F', 'key' => 'word_47_6', 'example_japanese' => '例文47Fです', 'example_blocks_json' => ["例文47F","です"]],
            ['front' => '単語47G', 'back' => 'たんご47G', 'key' => 'word_47_7', 'example_japanese' => '例文47Gです', 'example_blocks_json' => ["例文47G","です"]],
            ['front' => '単語47H', 'back' => 'たんご47H', 'key' => 'word_47_8', 'example_japanese' => '例文47Hです', 'example_blocks_json' => ["例文47H","です"]],
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
                    'back_text' => "N4.lesson47.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson47.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
