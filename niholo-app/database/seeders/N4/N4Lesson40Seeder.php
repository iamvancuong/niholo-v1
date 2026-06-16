<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson40Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 40],
            [
                'title' => 'N4.lesson40.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson40.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語40A', 'back' => 'たんご40A', 'key' => 'word_40_1', 'example_japanese' => '例文40Aです', 'example_blocks_json' => ["例文40A","です"]],
            ['front' => '単語40B', 'back' => 'たんご40B', 'key' => 'word_40_2', 'example_japanese' => '例文40Bです', 'example_blocks_json' => ["例文40B","です"]],
            ['front' => '単語40C', 'back' => 'たんご40C', 'key' => 'word_40_3', 'example_japanese' => '例文40Cです', 'example_blocks_json' => ["例文40C","です"]],
            ['front' => '単語40D', 'back' => 'たんご40D', 'key' => 'word_40_4', 'example_japanese' => '例文40Dです', 'example_blocks_json' => ["例文40D","です"]],
            ['front' => '単語40E', 'back' => 'たんご40E', 'key' => 'word_40_5', 'example_japanese' => '例文40Eです', 'example_blocks_json' => ["例文40E","です"]],
            ['front' => '単語40F', 'back' => 'たんご40F', 'key' => 'word_40_6', 'example_japanese' => '例文40Fです', 'example_blocks_json' => ["例文40F","です"]],
            ['front' => '単語40G', 'back' => 'たんご40G', 'key' => 'word_40_7', 'example_japanese' => '例文40Gです', 'example_blocks_json' => ["例文40G","です"]],
            ['front' => '単語40H', 'back' => 'たんご40H', 'key' => 'word_40_8', 'example_japanese' => '例文40Hです', 'example_blocks_json' => ["例文40H","です"]],
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
                    'back_text' => "N4.lesson40.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson40.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
