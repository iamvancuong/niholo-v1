<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson48Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 48],
            [
                'title' => 'N4.lesson48.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson48.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語48A', 'back' => 'たんご48A', 'key' => 'word_48_1', 'example_japanese' => '例文48Aです', 'example_blocks_json' => ["例文48A","です"]],
            ['front' => '単語48B', 'back' => 'たんご48B', 'key' => 'word_48_2', 'example_japanese' => '例文48Bです', 'example_blocks_json' => ["例文48B","です"]],
            ['front' => '単語48C', 'back' => 'たんご48C', 'key' => 'word_48_3', 'example_japanese' => '例文48Cです', 'example_blocks_json' => ["例文48C","です"]],
            ['front' => '単語48D', 'back' => 'たんご48D', 'key' => 'word_48_4', 'example_japanese' => '例文48Dです', 'example_blocks_json' => ["例文48D","です"]],
            ['front' => '単語48E', 'back' => 'たんご48E', 'key' => 'word_48_5', 'example_japanese' => '例文48Eです', 'example_blocks_json' => ["例文48E","です"]],
            ['front' => '単語48F', 'back' => 'たんご48F', 'key' => 'word_48_6', 'example_japanese' => '例文48Fです', 'example_blocks_json' => ["例文48F","です"]],
            ['front' => '単語48G', 'back' => 'たんご48G', 'key' => 'word_48_7', 'example_japanese' => '例文48Gです', 'example_blocks_json' => ["例文48G","です"]],
            ['front' => '単語48H', 'back' => 'たんご48H', 'key' => 'word_48_8', 'example_japanese' => '例文48Hです', 'example_blocks_json' => ["例文48H","です"]],
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
                    'back_text' => "N4.lesson48.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson48.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
