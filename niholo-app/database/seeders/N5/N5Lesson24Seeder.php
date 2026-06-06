<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson24Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 24],
            [
                'title' => 'N5.lesson24.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson24.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'くれます', 'back' => 'くれます', 'key' => 'kuremasu', 'example_japanese' => '友達が花をくれました', 'example_blocks_json' => ['友達', 'が', '花', 'を', 'くれました']],
            ['front' => '直します', 'back' => 'なおします', 'key' => 'naoshimasu', 'example_japanese' => '自転車を直します', 'example_blocks_json' => ['自転車', 'を', '直します']],
            ['front' => '連れて行きます', 'back' => 'つれていきます', 'key' => 'tsureteikimasu', 'example_japanese' => '子供を連れて行きます', 'example_blocks_json' => ['子供', 'を', '連れて行きます']],
            ['front' => '連れて来ます', 'back' => 'つれてきます', 'key' => 'tsuretekimasu', 'example_japanese' => '友達を連れて来ます', 'example_blocks_json' => ['友達', 'を', '連れて来ます']],
            ['front' => '送ります', 'back' => 'おくります', 'key' => 'okurimasu_hito', 'example_japanese' => '駅まで人を送ります', 'example_blocks_json' => ['駅', 'まで', '人', 'を', '送ります']],
            ['front' => '紹介します', 'back' => 'しょうかいします', 'key' => 'shoukaishimasu', 'example_japanese' => '友達を紹介します', 'example_blocks_json' => ['友達', 'を', '紹介します']],
            ['front' => '案内します', 'back' => 'あんないします', 'key' => 'annaishimasu', 'example_japanese' => '会社を案内します', 'example_blocks_json' => ['会社', 'を', '案内します']],
            ['front' => '説明します', 'back' => 'せつめいします', 'key' => 'setsumeishimasu', 'example_japanese' => '文法を説明します', 'example_blocks_json' => ['文法', 'を', '説明します']],
            ['front' => '準備します', 'back' => 'じゅんびします', 'key' => 'junbishimasu', 'example_japanese' => '料理を準備します', 'example_blocks_json' => ['料理', 'を', '準備します']],
            ['front' => 'おじいさん', 'back' => 'おじいさん', 'key' => 'ojiisan', 'example_japanese' => 'おじいさんは元気です', 'example_blocks_json' => ['おじいさん', 'は', '元気', 'です']],
            ['front' => 'おばあさん', 'back' => 'おばあさん', 'key' => 'obaasan', 'example_japanese' => 'おばあさんは８０歳です', 'example_blocks_json' => ['おばあさん', 'は', '８０歳', 'です']],
            ['front' => 'おじさん', 'back' => 'おじさん', 'key' => 'ojisan', 'example_japanese' => 'おじさんは医者です', 'example_blocks_json' => ['おじさん', 'は', '医者', 'です']],
            ['front' => 'おばさん', 'back' => 'おばさん', 'key' => 'obasan', 'example_japanese' => 'おばさんは先生です', 'example_blocks_json' => ['おばさん', 'は', '先生', 'です']],
            ['front' => 'お菓子', 'back' => 'おかし', 'key' => 'okashi', 'example_japanese' => 'お菓子を買います', 'example_blocks_json' => ['お菓子', 'を', '買います']],
            ['front' => '全部', 'back' => 'ぜんぶ', 'key' => 'zenbu', 'example_japanese' => '全部食べました', 'example_blocks_json' => ['全部', '食べました']],
            ['front' => '自分で', 'back' => 'じぶんで', 'key' => 'jibunde', 'example_japanese' => '自分でします', 'example_blocks_json' => ['自分で', 'します']],
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
                    'back_text' => "N5.lesson24.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson24.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
