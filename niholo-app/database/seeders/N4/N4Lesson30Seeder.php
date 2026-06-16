<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson30Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 30],
            [
                'title' => 'N4.lesson30.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson30.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '貼ります', 'back' => 'はります', 'key' => 'harimasu', 'example_japanese' => 'ポスターを貼ります', 'example_blocks_json' => ["ポスター","を","貼ります"]],
            ['front' => '掛けます', 'back' => 'かけます', 'key' => 'kakemasu', 'example_japanese' => 'カレンダーを掛けます', 'example_blocks_json' => ["カレンダー","を","掛けます"]],
            ['front' => '飾ります', 'back' => 'かざります', 'key' => 'kazarimasu', 'example_japanese' => '花を飾ります', 'example_blocks_json' => ["花","を","飾ります"]],
            ['front' => '並べます', 'back' => 'ならべます', 'key' => 'narabemasu', 'example_japanese' => '机を並べます', 'example_blocks_json' => ["机","を","並べます"]],
            ['front' => '植えます', 'back' => 'うえます', 'key' => 'uemasu', 'example_japanese' => '木を植えます', 'example_blocks_json' => ["木","を","植えます"]],
            ['front' => '戻します', 'back' => 'もどします', 'key' => 'modoshimasu', 'example_japanese' => '本を戻します', 'example_blocks_json' => ["本","を","戻します"]],
            ['front' => 'まとめます', 'back' => 'まとめます', 'key' => 'matomemasu', 'example_japanese' => '荷物をまとめます', 'example_blocks_json' => ["荷物","を","まとめます"]],
            ['front' => 'しまいます', 'back' => 'しまいます', 'key' => 'shimaimasu', 'example_japanese' => '服をしまいます', 'example_blocks_json' => ["服","を","しまいます"]],
            ['front' => '決めます', 'back' => 'きめます', 'key' => 'kimetemasu', 'example_japanese' => '予定を決めます', 'example_blocks_json' => ["予定","を","決めます"]],
            ['front' => '予習します', 'back' => 'よしゅうします', 'key' => 'yoshuushimasu', 'example_japanese' => '授業を予習します', 'example_blocks_json' => ["授業","を","予習します"]],
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
                    'back_text' => "N4.lesson30.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson30.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
