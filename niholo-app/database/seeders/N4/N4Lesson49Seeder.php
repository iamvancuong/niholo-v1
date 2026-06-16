<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson49Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 49],
            [
                'title' => 'N4.lesson49.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson49.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語49A', 'back' => 'たんご49A', 'key' => 'word_49_1', 'example_japanese' => '例文49Aです', 'example_blocks_json' => ["例文49A","です"]],
            ['front' => '単語49B', 'back' => 'たんご49B', 'key' => 'word_49_2', 'example_japanese' => '例文49Bです', 'example_blocks_json' => ["例文49B","です"]],
            ['front' => '単語49C', 'back' => 'たんご49C', 'key' => 'word_49_3', 'example_japanese' => '例文49Cです', 'example_blocks_json' => ["例文49C","です"]],
            ['front' => '単語49D', 'back' => 'たんご49D', 'key' => 'word_49_4', 'example_japanese' => '例文49Dです', 'example_blocks_json' => ["例文49D","です"]],
            ['front' => '単語49E', 'back' => 'たんご49E', 'key' => 'word_49_5', 'example_japanese' => '例文49Eです', 'example_blocks_json' => ["例文49E","です"]],
            ['front' => '単語49F', 'back' => 'たんご49F', 'key' => 'word_49_6', 'example_japanese' => '例文49Fです', 'example_blocks_json' => ["例文49F","です"]],
            ['front' => '単語49G', 'back' => 'たんご49G', 'key' => 'word_49_7', 'example_japanese' => '例文49Gです', 'example_blocks_json' => ["例文49G","です"]],
            ['front' => '単語49H', 'back' => 'たんご49H', 'key' => 'word_49_8', 'example_japanese' => '例文49Hです', 'example_blocks_json' => ["例文49H","です"]],
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
                    'back_text' => "N4.lesson49.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson49.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
