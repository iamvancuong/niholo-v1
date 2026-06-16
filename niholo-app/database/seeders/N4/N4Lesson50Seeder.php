<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson50Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 50],
            [
                'title' => 'N4.lesson50.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson50.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語50A', 'back' => 'たんご50A', 'key' => 'word_50_1', 'example_japanese' => '例文50Aです', 'example_blocks_json' => ["例文50A","です"]],
            ['front' => '単語50B', 'back' => 'たんご50B', 'key' => 'word_50_2', 'example_japanese' => '例文50Bです', 'example_blocks_json' => ["例文50B","です"]],
            ['front' => '単語50C', 'back' => 'たんご50C', 'key' => 'word_50_3', 'example_japanese' => '例文50Cです', 'example_blocks_json' => ["例文50C","です"]],
            ['front' => '単語50D', 'back' => 'たんご50D', 'key' => 'word_50_4', 'example_japanese' => '例文50Dです', 'example_blocks_json' => ["例文50D","です"]],
            ['front' => '単語50E', 'back' => 'たんご50E', 'key' => 'word_50_5', 'example_japanese' => '例文50Eです', 'example_blocks_json' => ["例文50E","です"]],
            ['front' => '単語50F', 'back' => 'たんご50F', 'key' => 'word_50_6', 'example_japanese' => '例文50Fです', 'example_blocks_json' => ["例文50F","です"]],
            ['front' => '単語50G', 'back' => 'たんご50G', 'key' => 'word_50_7', 'example_japanese' => '例文50Gです', 'example_blocks_json' => ["例文50G","です"]],
            ['front' => '単語50H', 'back' => 'たんご50H', 'key' => 'word_50_8', 'example_japanese' => '例文50Hです', 'example_blocks_json' => ["例文50H","です"]],
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
                    'back_text' => "N4.lesson50.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson50.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
