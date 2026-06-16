<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson29Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 29],
            [
                'title' => 'N4.lesson29.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson29.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '開きます', 'back' => 'あきます', 'key' => 'akimasu', 'example_japanese' => 'ドアが開きます', 'example_blocks_json' => ["ドア","が","開きます"]],
            ['front' => '閉まります', 'back' => 'しまります', 'key' => 'shimarimasu', 'example_japanese' => 'ドアが閉まります', 'example_blocks_json' => ["ドア","が","閉まります"]],
            ['front' => 'つきます', 'back' => 'つきます', 'key' => 'tsukimasu', 'example_japanese' => '電気がつきます', 'example_blocks_json' => ["電気","が","つきます"]],
            ['front' => '消えます', 'back' => 'きえます', 'key' => 'kiemasu', 'example_japanese' => '電気が消えます', 'example_blocks_json' => ["電気","が","消えます"]],
            ['front' => '壊れます', 'back' => 'こわれます', 'key' => 'kowaremasu', 'example_japanese' => 'いすが壊れます', 'example_blocks_json' => ["いす","が","壊れます"]],
            ['front' => '割れます', 'back' => 'われます', 'key' => 'waremasu', 'example_japanese' => 'コップが割れます', 'example_blocks_json' => ["コップ","が","割れます"]],
            ['front' => '折れます', 'back' => 'おれます', 'key' => 'oremasu', 'example_japanese' => '木が折れます', 'example_blocks_json' => ["木","が","折れます"]],
            ['front' => '破れます', 'back' => 'やぶれます', 'key' => 'yaburemasu', 'example_japanese' => '紙が破れます', 'example_blocks_json' => ["紙","が","破れます"]],
            ['front' => '汚れます', 'back' => 'よごれます', 'key' => 'yogoremasu', 'example_japanese' => '服が汚れます', 'example_blocks_json' => ["服","が","汚れます"]],
            ['front' => '付きます', 'back' => 'つきます', 'key' => 'tsukimasu_p', 'example_japanese' => 'ポケットが付きます', 'example_blocks_json' => ["ポケット","が","付きます"]],
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
                    'back_text' => "N4.lesson29.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson29.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
