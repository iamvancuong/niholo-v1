<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson12Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 12],
            [
                'title' => 'N5.lesson12.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson12.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '簡単（な）', 'back' => 'かんたん（な）', 'key' => 'kantan', 'example_japanese' => '簡単なテスト', 'example_blocks_json' => ['簡単', 'な', 'テスト']],
            ['front' => '近い', 'back' => 'ちかい', 'key' => 'chikai', 'example_japanese' => '駅から近いです', 'example_blocks_json' => ['駅', 'から', '近い', 'です']],
            ['front' => '遠い', 'back' => 'とおい', 'key' => 'tooi', 'example_japanese' => '遠い国', 'example_blocks_json' => ['遠い', '国']],
            ['front' => '速い / 早い', 'back' => 'はやい', 'key' => 'hayai', 'example_japanese' => '新幹線は速いです', 'example_blocks_json' => ['新幹線', 'は', '速い', 'です']],
            ['front' => '遅い', 'back' => 'おそい', 'key' => 'osoi', 'example_japanese' => '歩くのが遅いです', 'example_blocks_json' => ['歩く', 'の', 'が', '遅い', 'です']],
            ['front' => '多い', 'back' => 'おおい', 'key' => 'ooi', 'example_japanese' => '人が多いです', 'example_blocks_json' => ['人', 'が', '多い', 'です']],
            ['front' => '少ない', 'back' => 'すくない', 'key' => 'sukunai', 'example_japanese' => '人が少ないです', 'example_blocks_json' => ['人', 'が', '少ない', 'です']],
            ['front' => '暖かい / 温かい', 'back' => 'あたたかい', 'key' => 'atatakai', 'example_japanese' => '暖かい天気', 'example_blocks_json' => ['暖かい', '天気']],
            ['front' => '涼しい', 'back' => 'すずしい', 'key' => 'suzushii', 'example_japanese' => '秋は涼しいです', 'example_blocks_json' => ['秋', 'は', '涼しい', 'です']],
            ['front' => '甘い', 'back' => 'あまい', 'key' => 'amai', 'example_japanese' => '甘いケーキ', 'example_blocks_json' => ['甘い', 'ケーキ']],
            ['front' => '辛い', 'back' => 'からい', 'key' => 'karai', 'example_japanese' => '辛い料理', 'example_blocks_json' => ['辛い', '料理']],
            ['front' => '重い', 'back' => 'おもい', 'key' => 'omoi', 'example_japanese' => '重い荷物', 'example_blocks_json' => ['重い', '荷物']],
            ['front' => '軽い', 'back' => 'かるい', 'key' => 'karui', 'example_japanese' => '軽いかばん', 'example_blocks_json' => ['軽い', 'かばん']],
            ['front' => 'コーヒー', 'back' => 'コーヒー', 'key' => 'koohii', 'example_japanese' => 'コーヒーを飲みます', 'example_blocks_json' => ['コーヒー', 'を', '飲みます']],
            ['front' => '紅茶', 'back' => 'こうちゃ', 'key' => 'koucha', 'example_japanese' => '紅茶が好きです', 'example_blocks_json' => ['紅茶', 'が', '好き', 'です']],
            ['front' => 'お茶', 'back' => 'おちゃ', 'key' => 'ocha', 'example_japanese' => 'お茶を飲みます', 'example_blocks_json' => ['お茶', 'を', '飲みます']],
            ['front' => '季節', 'back' => 'きせつ', 'key' => 'kisetsu', 'example_japanese' => '好きな季節', 'example_blocks_json' => ['好き', 'な', '季節']],
            ['front' => '春', 'back' => 'はる', 'key' => 'haru', 'example_japanese' => '春は暖かいです', 'example_blocks_json' => ['春', 'は', '暖かい', 'です']],
            ['front' => '夏', 'back' => 'なつ', 'key' => 'natsu', 'example_japanese' => '夏休み', 'example_blocks_json' => ['夏休み']],
            ['front' => '秋', 'back' => 'あき', 'key' => 'aki', 'example_japanese' => '秋は涼しいです', 'example_blocks_json' => ['秋', 'は', '涼しい', 'です']],
            ['front' => '冬', 'back' => 'ふゆ', 'key' => 'fuyu', 'example_japanese' => '冬は寒いです', 'example_blocks_json' => ['冬', 'は', '寒い', 'です']],
            ['front' => '天気', 'back' => 'てんき', 'key' => 'tenki', 'example_japanese' => 'いい天気ですね', 'example_blocks_json' => ['いい', '天気', 'ですね']],
            ['front' => '雨', 'back' => 'あめ', 'key' => 'ame', 'example_japanese' => '雨が降ります', 'example_blocks_json' => ['雨', 'が', '降ります']],
            ['front' => '雪', 'back' => 'ゆき', 'key' => 'yuki', 'example_japanese' => '雪が降ります', 'example_blocks_json' => ['雪', 'が', '降ります']],
            ['front' => '曇り', 'back' => 'くもり', 'key' => 'kumori', 'example_japanese' => '今日は曇りです', 'example_blocks_json' => ['今日', 'は', '曇り', 'です']],
            ['front' => 'ホテル', 'back' => 'ホテル', 'key' => 'hoteru', 'example_japanese' => '有名なホテル', 'example_blocks_json' => ['有名', 'な', 'ホテル']],
            ['front' => '空港', 'back' => 'くうこう', 'key' => 'kuukou', 'example_japanese' => '空港へ行きます', 'example_blocks_json' => ['空港', 'へ', '行きます']],
            ['front' => '海', 'back' => 'うみ', 'key' => 'umi', 'example_japanese' => '海で泳ぎます', 'example_blocks_json' => ['海', 'で', '泳ぎます']],
            ['front' => '世界', 'back' => 'せかい', 'key' => 'sekai', 'example_japanese' => '世界で一番', 'example_blocks_json' => ['世界', 'で', '一番']],
            ['front' => 'パーティー', 'back' => 'パーティー', 'key' => 'paatii', 'example_japanese' => 'パーティーをします', 'example_blocks_json' => ['パーティー', 'を', 'します']],
            ['front' => 'お祭り', 'back' => 'おまつり', 'key' => 'omatsuri', 'example_japanese' => 'お祭りはにぎやかです', 'example_blocks_json' => ['お祭り', 'は', 'にぎやか', 'です']],
            ['front' => 'すき焼き', 'back' => 'すきやき', 'key' => 'sukiyaki', 'example_japanese' => 'すき焼きを食べます', 'example_blocks_json' => ['すき焼き', 'を', '食べます']],
            ['front' => '刺身', 'back' => 'さしみ', 'key' => 'sashimi', 'example_japanese' => '刺身はおいしいです', 'example_blocks_json' => ['刺身', 'は', 'おいしい', 'です']],
            ['front' => 'お寿司', 'back' => 'おすし', 'key' => 'osushi', 'example_japanese' => 'お寿司が好きです', 'example_blocks_json' => ['お寿司', 'が', '好き', 'です']],
            ['front' => '天ぷら', 'back' => 'てんぷら', 'key' => 'tenpura', 'example_japanese' => '天ぷらを作ります', 'example_blocks_json' => ['天ぷら', 'を', '作ります']],
            ['front' => '豚肉', 'back' => 'ぶたにく', 'key' => 'butaniku', 'example_japanese' => '豚肉を買います', 'example_blocks_json' => ['豚肉', 'を', '買います']],
            ['front' => '鶏肉', 'back' => 'とりにく', 'key' => 'toriniku', 'example_japanese' => '鶏肉が好きです', 'example_blocks_json' => ['鶏肉', 'が', '好き', 'です']],
            ['front' => '牛肉', 'back' => 'ぎゅうにく', 'key' => 'gyuuniku', 'example_japanese' => '牛肉を食べます', 'example_blocks_json' => ['牛肉', 'を', '食べます']],
            ['front' => 'どちら', 'back' => 'どちら', 'key' => 'dochira', 'example_japanese' => 'どちらが好きですか', 'example_blocks_json' => ['どちら', 'が', '好き', 'ですか']],
            ['front' => 'どちらも', 'back' => 'どちらも', 'key' => 'dochiramo', 'example_japanese' => 'どちらも好きです', 'example_blocks_json' => ['どちらも', '好き', 'です']],
            ['front' => 'ずっと', 'back' => 'ずっと', 'key' => 'zutto', 'example_japanese' => '日本の方がずっと大きいです', 'example_blocks_json' => ['日本', 'の', '方', 'が', 'ずっと', '大きい', 'です']],
            ['front' => '初めて', 'back' => 'はじめて', 'key' => 'hajimete', 'example_japanese' => '初めて食べました', 'example_blocks_json' => ['初めて', '食べました']],
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
                    'back_text' => "N5.lesson12.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson12.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
