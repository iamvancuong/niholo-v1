<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson35Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 35],
            [
                'title' => 'N4.lesson35.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson35.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '咲きます', 'back' => 'さきます', 'key' => 'sakimasu', 'example_japanese' => '花が咲きます', 'example_blocks_json' => ["花","が","咲きます"]],
            ['front' => '変わります', 'back' => 'かわります', 'key' => 'kawarimasu', 'example_japanese' => '色が変わります', 'example_blocks_json' => ["色","が","変わります"]],
            ['front' => '困ります', 'back' => 'こまります', 'key' => 'komarimasu', 'example_japanese' => 'お金がなくて困ります', 'example_blocks_json' => ["お金","が","なくて","困ります"]],
            ['front' => '付けます', 'back' => 'つけます', 'key' => 'tsukemasu_b', 'example_japanese' => '丸を付けます', 'example_blocks_json' => ["丸","を","付けます"]],
            ['front' => '拾います', 'back' => 'ひろいます', 'key' => 'hiroimasu', 'example_japanese' => 'ごみを拾います', 'example_blocks_json' => ["ごみ","を","拾います"]],
            ['front' => 'かかります', 'back' => 'かかります', 'key' => 'kakarimasu_p', 'example_japanese' => '電話がかかります', 'example_blocks_json' => ["電話","が","かかります"]],
            ['front' => '楽', 'back' => 'らく', 'key' => 'raku', 'example_japanese' => '楽な生活', 'example_blocks_json' => ["楽な","生活"]],
            ['front' => '正しい', 'back' => 'ただしい', 'key' => 'tadashii', 'example_japanese' => '正しい答え', 'example_blocks_json' => ["正しい","答え"]],
            ['front' => '珍しい', 'back' => 'めずらしい', 'key' => 'mezurashii', 'example_japanese' => '珍しい鳥', 'example_blocks_json' => ["珍しい","鳥"]],
            ['front' => '方', 'back' => 'かた', 'key' => 'kata', 'example_japanese' => 'あの方', 'example_blocks_json' => ["あの","方"]],
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
                    'back_text' => "N4.lesson35.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson35.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
