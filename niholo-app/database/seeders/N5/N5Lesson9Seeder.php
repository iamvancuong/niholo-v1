<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson9Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 9],
            [
                'title' => 'N5.lesson9.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson9.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'わかります', 'back' => 'わかります', 'key' => 'wakarimasu', 'example_japanese' => '日本語がわかります', 'example_blocks_json' => ['日本語', 'が', 'わかります']],
            ['front' => 'あります', 'back' => 'あります', 'key' => 'arimasu', 'example_japanese' => '車があります', 'example_blocks_json' => ['車', 'が', 'あります']],
            ['front' => '好き（な）', 'back' => 'すき（な）', 'key' => 'suki', 'example_japanese' => 'スポーツが好きです', 'example_blocks_json' => ['スポーツ', 'が', '好き', 'です']],
            ['front' => '嫌い（な）', 'back' => 'きらい（な）', 'key' => 'kirai', 'example_japanese' => '魚が嫌いです', 'example_blocks_json' => ['魚', 'が', '嫌い', 'です']],
            ['front' => '上手（な）', 'back' => 'じょうず（な）', 'key' => 'jouzu', 'example_japanese' => '歌が上手です', 'example_blocks_json' => ['歌', 'が', '上手', 'です']],
            ['front' => '下手（な）', 'back' => 'へた（な）', 'key' => 'heta', 'example_japanese' => '絵が下手です', 'example_blocks_json' => ['絵', 'が', '下手', 'です']],
            ['front' => '料理', 'back' => 'りょうり', 'key' => 'ryouri', 'example_japanese' => '料理を作ります', 'example_blocks_json' => ['料理', 'を', '作ります']],
            ['front' => '飲み物', 'back' => 'のみもの', 'key' => 'nomimono', 'example_japanese' => '飲み物は何がいいですか', 'example_blocks_json' => ['飲み物', 'は', '何', 'が', 'いい', 'ですか']],
            ['front' => 'スポーツ', 'back' => 'スポーツ', 'key' => 'supootsu', 'example_japanese' => 'どんなスポーツが好きですか', 'example_blocks_json' => ['どんな', 'スポーツ', 'が', '好き', 'ですか']],
            ['front' => '野球', 'back' => 'やきゅう', 'key' => 'yakyuu', 'example_japanese' => '野球をします', 'example_blocks_json' => ['野球', 'を', 'します']],
            ['front' => '音楽', 'back' => 'おんがく', 'key' => 'ongaku', 'example_japanese' => '音楽を聞きます', 'example_blocks_json' => ['音楽', 'を', '聞きます']],
            ['front' => '歌', 'back' => 'うた', 'key' => 'uta', 'example_japanese' => '歌を歌います', 'example_blocks_json' => ['歌', 'を', '歌います']],
            ['front' => '絵', 'back' => 'え', 'key' => 'e', 'example_japanese' => '絵を描きます', 'example_blocks_json' => ['絵', 'を', '描きます']],
            ['front' => '字', 'back' => 'じ', 'key' => 'ji', 'example_japanese' => 'きれいな字ですね', 'example_blocks_json' => ['きれい', 'な', '字', 'ですね']],
            ['front' => '漢字', 'back' => 'かんじ', 'key' => 'kanji', 'example_japanese' => '漢字が少しわかります', 'example_blocks_json' => ['漢字', 'が', '少し', 'わかります']],
            ['front' => 'ひらがな', 'back' => 'ひらがな', 'key' => 'hiragana', 'example_japanese' => 'ひらがなで書きます', 'example_blocks_json' => ['ひらがな', 'で', '書きます']],
            ['front' => 'かたかな', 'back' => 'かたかな', 'key' => 'katakana', 'example_japanese' => 'かたかながわかりますか', 'example_blocks_json' => ['かたかな', 'が', 'わかります', 'か']],
            ['front' => 'ローマ字', 'back' => 'ローマじ', 'key' => 'roomaji', 'example_japanese' => 'ローマ字で名前を書きます', 'example_blocks_json' => ['ローマ字', 'で', '名前', 'を', '書きます']],
            ['front' => '細かいお金', 'back' => 'こまかいおかね', 'key' => 'komakai_okane', 'example_japanese' => '細かいお金がありません', 'example_blocks_json' => ['細かい', 'お金', 'が', 'ありません']],
            ['front' => 'チケット', 'back' => 'チケット', 'key' => 'chiketto', 'example_japanese' => '映画のチケット', 'example_blocks_json' => ['映画', 'の', 'チケット']],
            ['front' => '時間', 'back' => 'じかん', 'key' => 'jikan', 'example_japanese' => '時間がありません', 'example_blocks_json' => ['時間', 'が', 'ありません']],
            ['front' => '用事', 'back' => 'ようじ', 'key' => 'youji', 'example_japanese' => '用事があります', 'example_blocks_json' => ['用事', 'が', 'あります']],
            ['front' => '約束', 'back' => 'やくそく', 'key' => 'yakusoku', 'example_japanese' => '友達と約束があります', 'example_blocks_json' => ['友達', 'と', '約束', 'が', 'あります']],
            ['front' => 'ご主人', 'back' => 'ごしゅじん', 'key' => 'goshujin', 'example_japanese' => 'ご主人はお元気ですか', 'example_blocks_json' => ['ご主人', 'は', 'お元気', 'ですか']],
            ['front' => '夫 / 主人', 'back' => 'おっと / しゅじん', 'key' => 'otto', 'example_japanese' => '夫は会社員です', 'example_blocks_json' => ['夫', 'は', '会社員', 'です']],
            ['front' => '奥さん', 'back' => 'おくさん', 'key' => 'okusan', 'example_japanese' => '奥さんは先生です', 'example_blocks_json' => ['奥さん', 'は', '先生', 'です']],
            ['front' => '妻 / 家内', 'back' => 'つま / かない', 'key' => 'tsuma', 'example_japanese' => '妻はスーパーで働いています', 'example_blocks_json' => ['妻', 'は', 'スーパー', 'で', '働いています']],
            ['front' => '子ども', 'back' => 'こども', 'key' => 'kodomo', 'example_japanese' => '子どもがいます', 'example_blocks_json' => ['子ども', 'が', 'います']],
            ['front' => 'よく', 'back' => 'よく', 'key' => 'yoku', 'example_japanese' => '英語がよくわかります', 'example_blocks_json' => ['英語', 'が', 'よく', 'わかります']],
            ['front' => 'だいたい', 'back' => 'だいたい', 'key' => 'daitai', 'example_japanese' => 'だいたいわかります', 'example_blocks_json' => ['だいたい', 'わかります']],
            ['front' => 'たくさん', 'back' => 'たくさん', 'key' => 'takusan', 'example_japanese' => 'お金がたくさんあります', 'example_blocks_json' => ['お金', 'が', 'たくさん', 'あります']],
            ['front' => '少し', 'back' => 'すこし', 'key' => 'sukoshi', 'example_japanese' => '少し疲れています', 'example_blocks_json' => ['少し', '疲れています']],
            ['front' => '全然', 'back' => 'ぜんぜん', 'key' => 'zenzen', 'example_japanese' => 'フランス語が全然わかりません', 'example_blocks_json' => ['フランス語', 'が', '全然', 'わかりません']],
            ['front' => '早く / 速く', 'back' => 'はやく', 'key' => 'hayaku', 'example_japanese' => '早く帰ります', 'example_blocks_json' => ['早く', '帰ります']],
            ['front' => 'から', 'back' => 'から', 'key' => 'kara', 'example_japanese' => '時間がないですから、タクシーで行きます', 'example_blocks_json' => ['時間', 'が', 'ない', 'です', 'から', '、', 'タクシー', 'で', '行きます']],
            ['front' => 'どうして', 'back' => 'どうして', 'key' => 'doushite', 'example_japanese' => 'どうして昨日休みましたか', 'example_blocks_json' => ['どうして', '昨日', '休みました', 'か']],
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
                    'back_text' => "N5.lesson9.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson9.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
