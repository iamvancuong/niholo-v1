<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson34Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 34],
            [
                'title' => 'N4.lesson34.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson34.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '磨きます', 'back' => 'みがきます', 'key' => 'migakimasu', 'example_japanese' => '歯を磨きます', 'example_blocks_json' => ["歯","を","磨きます"]],
            ['front' => '組み立てます', 'back' => 'くみたてます', 'key' => 'kumitatemasu', 'example_japanese' => '本棚を組み立てます', 'example_blocks_json' => ["本棚","を","組み立てます"]],
            ['front' => '折ります', 'back' => 'おります', 'key' => 'orimasu', 'example_japanese' => '紙を折ります', 'example_blocks_json' => ["紙","を","折ります"]],
            ['front' => '気がつきます', 'back' => 'きがつきます', 'key' => 'ki_ni_gatsu', 'example_japanese' => '忘れ物に気がつきます', 'example_blocks_json' => ["忘れ物","に","気がつきます"]],
            ['front' => 'つけます', 'back' => 'つけます', 'key' => 'tsukemasu', 'example_japanese' => 'しょうゆをつけます', 'example_blocks_json' => ["しょうゆ","を","つけます"]],
            ['front' => '見つかります', 'back' => 'みつかります', 'key' => 'mitsukarimasu', 'example_japanese' => 'かぎが見つかります', 'example_blocks_json' => ["かぎ","が","見つかります"]],
            ['front' => '質問します', 'back' => 'しつもんします', 'key' => 'shitsumon', 'example_japanese' => '先生に質問します', 'example_blocks_json' => ["先生","に","質問します"]],
            ['front' => 'さします', 'back' => 'さします', 'key' => 'sasimasu', 'example_japanese' => '傘をさします', 'example_blocks_json' => ["傘","を","さします"]],
            ['front' => 'スポーツクラブ', 'back' => 'スポーツクラブ', 'key' => 'supootsu_k', 'example_japanese' => 'スポーツクラブに行きます', 'example_blocks_json' => ["スポーツクラブ","に","行きます"]],
            ['front' => 'お城', 'back' => 'おしろ', 'key' => 'oshiro', 'example_japanese' => 'お城を見ます', 'example_blocks_json' => ["お城","を","見ます"]],
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
                    'back_text' => "N4.lesson34.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson34.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
