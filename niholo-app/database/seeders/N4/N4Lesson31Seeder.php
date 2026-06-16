<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson31Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 31],
            [
                'title' => 'N4.lesson31.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson31.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '始まります', 'back' => 'はじまります', 'key' => 'hajimarimasu', 'example_japanese' => '式が始まります', 'example_blocks_json' => ["式","が","始まります"]],
            ['front' => '続けます', 'back' => 'つづけます', 'key' => 'tsuzukemasu', 'example_japanese' => '仕事を続けます', 'example_blocks_json' => ["仕事","を","続けます"]],
            ['front' => '見つけます', 'back' => 'みつけます', 'key' => 'mitsukemasu', 'example_japanese' => '仕事を見つけます', 'example_blocks_json' => ["仕事","を","見つけます"]],
            ['front' => '受けます', 'back' => 'うけます', 'key' => 'ukemasu', 'example_japanese' => '試験を受けます', 'example_blocks_json' => ["試験","を","受けます"]],
            ['front' => '入学します', 'back' => 'にゅうがくします', 'key' => 'nyuugakushimasu', 'example_japanese' => '大学に入学します', 'example_blocks_json' => ["大学","に","入学します"]],
            ['front' => '卒業します', 'back' => 'そつぎょうします', 'key' => 'sotsugyoushimasu', 'example_japanese' => '大学を卒業します', 'example_blocks_json' => ["大学","を","卒業します"]],
            ['front' => '出席します', 'back' => 'しゅっせきします', 'key' => 'shussekishimasu', 'example_japanese' => '会議に出席します', 'example_blocks_json' => ["会議","に","出席します"]],
            ['front' => '休憩します', 'back' => 'きゅうけいします', 'key' => 'kyuukeishimasu', 'example_japanese' => '少し休憩します', 'example_blocks_json' => ["少し","休憩します"]],
            ['front' => '連休', 'back' => 'れんきゅう', 'key' => 'renkyuu', 'example_japanese' => '連休は旅行します', 'example_blocks_json' => ["連休","は","旅行します"]],
            ['front' => '作文', 'back' => 'さくぶん', 'key' => 'sakubun', 'example_japanese' => '作文を書きます', 'example_blocks_json' => ["作文","を","書きます"]],
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
                    'back_text' => "N4.lesson31.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson31.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
