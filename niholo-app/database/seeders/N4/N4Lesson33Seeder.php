<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson33Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 33],
            [
                'title' => 'N4.lesson33.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson33.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '逃げます', 'back' => 'にげます', 'key' => 'nigemasu', 'example_japanese' => '泥棒が逃げます', 'example_blocks_json' => ["泥棒","が","逃げます"]],
            ['front' => '騒ぎます', 'back' => 'さわぎます', 'key' => 'sawagimasu', 'example_japanese' => '教室で騒ぎます', 'example_blocks_json' => ["教室","で","騒ぎます"]],
            ['front' => '諦めます', 'back' => 'あきらめます', 'key' => 'akiramemasu', 'example_japanese' => '夢を諦めます', 'example_blocks_json' => ["夢","を","諦めます"]],
            ['front' => '投げます', 'back' => 'なげます', 'key' => 'nagemasu', 'example_japanese' => 'ボールを投げます', 'example_blocks_json' => ["ボール","を","投げます"]],
            ['front' => '守ります', 'back' => 'まもります', 'key' => 'mamarimasu', 'example_japanese' => '約束を守ります', 'example_blocks_json' => ["約束","を","守ります"]],
            ['front' => '上げます', 'back' => 'あげます', 'key' => 'agemasu_up', 'example_japanese' => '手を上げます', 'example_blocks_json' => ["手","を","上げます"]],
            ['front' => '下げます', 'back' => 'さげます', 'key' => 'sagemasu', 'example_japanese' => '熱を下げます', 'example_blocks_json' => ["熱","を","下げます"]],
            ['front' => '伝えます', 'back' => 'つたえます', 'key' => 'tsutaemasu', 'example_japanese' => 'メッセージを伝えます', 'example_blocks_json' => ["メッセージ","を","伝えます"]],
            ['front' => '注意します', 'back' => 'ちゅういします', 'key' => 'chuui', 'example_japanese' => '車に注意します', 'example_blocks_json' => ["車","に","注意します"]],
            ['front' => '外します', 'back' => 'はずします', 'key' => 'hazushimasu', 'example_japanese' => '席を外します', 'example_blocks_json' => ["席","を","外します"]],
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
                    'back_text' => "N4.lesson33.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson33.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
