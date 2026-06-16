<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson43Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 43],
            [
                'title' => 'N4.lesson43.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson43.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '単語43A', 'back' => 'たんご43A', 'key' => 'word_43_1', 'example_japanese' => '例文43Aです', 'example_blocks_json' => ["例文43A","です"]],
            ['front' => '単語43B', 'back' => 'たんご43B', 'key' => 'word_43_2', 'example_japanese' => '例文43Bです', 'example_blocks_json' => ["例文43B","です"]],
            ['front' => '単語43C', 'back' => 'たんご43C', 'key' => 'word_43_3', 'example_japanese' => '例文43Cです', 'example_blocks_json' => ["例文43C","です"]],
            ['front' => '単語43D', 'back' => 'たんご43D', 'key' => 'word_43_4', 'example_japanese' => '例文43Dです', 'example_blocks_json' => ["例文43D","です"]],
            ['front' => '単語43E', 'back' => 'たんご43E', 'key' => 'word_43_5', 'example_japanese' => '例文43Eです', 'example_blocks_json' => ["例文43E","です"]],
            ['front' => '単語43F', 'back' => 'たんご43F', 'key' => 'word_43_6', 'example_japanese' => '例文43Fです', 'example_blocks_json' => ["例文43F","です"]],
            ['front' => '単語43G', 'back' => 'たんご43G', 'key' => 'word_43_7', 'example_japanese' => '例文43Gです', 'example_blocks_json' => ["例文43G","です"]],
            ['front' => '単語43H', 'back' => 'たんご43H', 'key' => 'word_43_8', 'example_japanese' => '例文43Hです', 'example_blocks_json' => ["例文43H","です"]],
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
                    'back_text' => "N4.lesson43.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson43.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
