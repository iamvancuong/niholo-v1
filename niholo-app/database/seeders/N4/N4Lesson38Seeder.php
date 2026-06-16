<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson38Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 38],
            [
                'title' => 'N4.lesson38.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson38.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語38A', 'back' => 'たんご38A', 'key' => 'word_38_1', 'example_japanese' => '例文38Aです', 'example_blocks_json' => ["例文38A","です"]],
            ['front' => '単語38B', 'back' => 'たんご38B', 'key' => 'word_38_2', 'example_japanese' => '例文38Bです', 'example_blocks_json' => ["例文38B","です"]],
            ['front' => '単語38C', 'back' => 'たんご38C', 'key' => 'word_38_3', 'example_japanese' => '例文38Cです', 'example_blocks_json' => ["例文38C","です"]],
            ['front' => '単語38D', 'back' => 'たんご38D', 'key' => 'word_38_4', 'example_japanese' => '例文38Dです', 'example_blocks_json' => ["例文38D","です"]],
            ['front' => '単語38E', 'back' => 'たんご38E', 'key' => 'word_38_5', 'example_japanese' => '例文38Eです', 'example_blocks_json' => ["例文38E","です"]],
            ['front' => '単語38F', 'back' => 'たんご38F', 'key' => 'word_38_6', 'example_japanese' => '例文38Fです', 'example_blocks_json' => ["例文38F","です"]],
            ['front' => '単語38G', 'back' => 'たんご38G', 'key' => 'word_38_7', 'example_japanese' => '例文38Gです', 'example_blocks_json' => ["例文38G","です"]],
            ['front' => '単語38H', 'back' => 'たんご38H', 'key' => 'word_38_8', 'example_japanese' => '例文38Hです', 'example_blocks_json' => ["例文38H","です"]],
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
                    'back_text' => "N4.lesson38.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson38.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
