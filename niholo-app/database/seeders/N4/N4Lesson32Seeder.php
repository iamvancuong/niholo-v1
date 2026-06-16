<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson32Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 32],
            [
                'title' => 'N4.lesson32.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson32.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '運動します', 'back' => 'うんどうします', 'key' => 'undoushimasu', 'example_japanese' => '毎日運動します', 'example_blocks_json' => ["毎日","運動します"]],
            ['front' => '成功します', 'back' => 'せいこうします', 'key' => 'seikoushimasu', 'example_japanese' => '仕事に成功します', 'example_blocks_json' => ["仕事","に","成功します"]],
            ['front' => '失敗します', 'back' => 'しっぱいします', 'key' => 'shippaishimasu', 'example_japanese' => '試験に失敗します', 'example_blocks_json' => ["試験","に","失敗します"]],
            ['front' => '合格します', 'back' => 'ごうかくします', 'key' => 'goukaku', 'example_japanese' => '試験に合格します', 'example_blocks_json' => ["試験","に","合格します"]],
            ['front' => 'やみます', 'back' => 'やみます', 'key' => 'yamimasu', 'example_japanese' => '雨がやみます', 'example_blocks_json' => ["雨","が","やみます"]],
            ['front' => '晴れます', 'back' => 'はれます', 'key' => 'haremasu', 'example_japanese' => '空が晴れます', 'example_blocks_json' => ["空","が","晴れます"]],
            ['front' => '曇ります', 'back' => 'くもります', 'key' => 'kumorimasu', 'example_japanese' => '空が曇ります', 'example_blocks_json' => ["空","が","曇ります"]],
            ['front' => '続きます', 'back' => 'つづきます', 'key' => 'tsuzukimasu', 'example_japanese' => '熱が続きます', 'example_blocks_json' => ["熱","が","続きます"]],
            ['front' => 'ひきます', 'back' => 'ひきます', 'key' => 'hikimasu', 'example_japanese' => '風邪をひきます', 'example_blocks_json' => ["風邪","を","ひきます"]],
            ['front' => '冷やします', 'back' => 'ひやします', 'key' => 'hiyashimasu', 'example_japanese' => 'ビールを冷やします', 'example_blocks_json' => ["ビール","を","冷やします"]],
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
                    'back_text' => "N4.lesson32.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson32.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
