<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson37Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 37],
            [
                'title' => 'N4.lesson37.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson37.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語37A', 'back' => 'たんご37A', 'key' => 'word_37_1', 'example_japanese' => '例文37Aです', 'example_blocks_json' => ["例文37A","です"]],
            ['front' => '単語37B', 'back' => 'たんご37B', 'key' => 'word_37_2', 'example_japanese' => '例文37Bです', 'example_blocks_json' => ["例文37B","です"]],
            ['front' => '単語37C', 'back' => 'たんご37C', 'key' => 'word_37_3', 'example_japanese' => '例文37Cです', 'example_blocks_json' => ["例文37C","です"]],
            ['front' => '単語37D', 'back' => 'たんご37D', 'key' => 'word_37_4', 'example_japanese' => '例文37Dです', 'example_blocks_json' => ["例文37D","です"]],
            ['front' => '単語37E', 'back' => 'たんご37E', 'key' => 'word_37_5', 'example_japanese' => '例文37Eです', 'example_blocks_json' => ["例文37E","です"]],
            ['front' => '単語37F', 'back' => 'たんご37F', 'key' => 'word_37_6', 'example_japanese' => '例文37Fです', 'example_blocks_json' => ["例文37F","です"]],
            ['front' => '単語37G', 'back' => 'たんご37G', 'key' => 'word_37_7', 'example_japanese' => '例文37Gです', 'example_blocks_json' => ["例文37G","です"]],
            ['front' => '単語37H', 'back' => 'たんご37H', 'key' => 'word_37_8', 'example_japanese' => '例文37Hです', 'example_blocks_json' => ["例文37H","です"]],
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
                    'back_text' => "N4.lesson37.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson37.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
