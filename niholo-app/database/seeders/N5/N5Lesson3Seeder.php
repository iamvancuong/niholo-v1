<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson3Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 3],
            [
                'title' => 'N5.lesson3.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson3.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'ここ', 'back' => 'ここ', 'key' => 'koko', 'example_japanese' => 'ここは食堂です', 'example_blocks_json' => ["ここ","は","食堂","です"]],
            ['front' => 'そこ', 'back' => 'そこ', 'key' => 'soko', 'example_japanese' => 'トイレはそこです', 'example_blocks_json' => ["トイレ","は","そこ","です"]],
            ['front' => 'あそこ', 'back' => 'あそこ', 'key' => 'asoko', 'example_japanese' => 'あそこは教室です', 'example_blocks_json' => ["あそこ","は","教室","です"]],
            ['front' => 'どこ', 'back' => 'どこ', 'key' => 'doko', 'example_japanese' => '事務所はどこですか', 'example_blocks_json' => ["事務所","は","どこ","ですか"]],
            ['front' => 'こちら', 'back' => 'こちら', 'key' => 'kochira', 'example_japanese' => 'こちらは受付です', 'example_blocks_json' => ["こちら","は","受付","です"]],
            ['front' => 'そちら', 'back' => 'そちら', 'key' => 'sochira', 'example_japanese' => 'そちらは会議室です', 'example_blocks_json' => ["そちら","は","会議室","です"]],
            ['front' => 'あちら', 'back' => 'あちら', 'key' => 'achira', 'example_japanese' => 'あちらはロビーです', 'example_blocks_json' => ["あちら","は","ロビー","です"]],
            ['front' => 'どちら', 'back' => 'どちら', 'key' => 'dochira', 'example_japanese' => 'エレベーターはどちらですか', 'example_blocks_json' => ["エレベーター","は","どちら","ですか"]],
            ['front' => '教室', 'back' => 'きょうしつ', 'key' => 'kyoushitsu', 'example_japanese' => '教室に学生がいます', 'example_blocks_json' => ["教室","に","学生","が","います"]],
            ['front' => '食堂', 'back' => 'しょくどう', 'key' => 'shokudou', 'example_japanese' => '食堂で食べます', 'example_blocks_json' => ["食堂","で","食べます"]],
            ['front' => '事務所', 'back' => 'じむしょ', 'key' => 'jimusho', 'example_japanese' => '事務所に電話します', 'example_blocks_json' => ["事務所","に","電話します"]],
            ['front' => '会議室', 'back' => 'かいぎしつ', 'key' => 'kaigishitsu', 'example_japanese' => '会議室は２階です', 'example_blocks_json' => ["会議室","は","２階","です"]],
            ['front' => '受付', 'back' => 'うけつけ', 'key' => 'uketsuke', 'example_japanese' => '受付は１階です', 'example_blocks_json' => ["受付","は","１階","です"]],
            ['front' => 'ロビー', 'back' => 'ロビー', 'key' => 'robii', 'example_japanese' => 'ロビーで待ちます', 'example_blocks_json' => ["ロビー","で","待ちます"]],
            ['front' => '部屋', 'back' => 'へや', 'key' => 'heya', 'example_japanese' => '私の部屋です', 'example_blocks_json' => ["私","の","部屋","です"]],
            ['front' => 'トイレ / お手洗い', 'back' => 'トイレ / おてあらい', 'key' => 'toire', 'example_japanese' => 'トイレはどこですか', 'example_blocks_json' => ["トイレ","は","どこ","ですか"]],
            ['front' => '階段', 'back' => 'かいだん', 'key' => 'kaidan', 'example_japanese' => 'あそこは階段です', 'example_blocks_json' => ["あそこ","は","階段","です"]],
            ['front' => 'エレベーター', 'back' => 'エレベーター', 'key' => 'erebeetaa', 'example_japanese' => 'エレベーターに乗ります', 'example_blocks_json' => ["エレベーター","に","乗ります"]],
            ['front' => 'エスカレーター', 'back' => 'エスカレーター', 'key' => 'esukareetaa', 'example_japanese' => 'エスカレーターはあそこです', 'example_blocks_json' => ["エスカレーター","は","あそこ","です"]],
            ['front' => '売り場', 'back' => 'うりば', 'key' => 'uriba', 'example_japanese' => '靴の売り場はどこですか', 'example_blocks_json' => ["靴","の","売り場","は","どこ","ですか"]],
            ['front' => '国', 'back' => 'くに', 'key' => 'kuni', 'example_japanese' => 'お国はどちらですか', 'example_blocks_json' => ["お国","は","どちら","ですか"]],
            ['front' => '会社', 'back' => 'かいしゃ', 'key' => 'kaisha', 'example_japanese' => '会社はどこですか', 'example_blocks_json' => ["会社","は","どこ","ですか"]],
            ['front' => 'うち', 'back' => 'うち', 'key' => 'uchi', 'example_japanese' => 'うちへ帰ります', 'example_blocks_json' => ["うち","へ","帰ります"]],
            ['front' => '電話', 'back' => 'でんわ', 'key' => 'denwa', 'example_japanese' => '電話はどこですか', 'example_blocks_json' => ["電話","は","どこ","ですか"]],
            ['front' => '靴', 'back' => 'くつ', 'key' => 'kutsu', 'example_japanese' => 'イタリアの靴です', 'example_blocks_json' => ["イタリア","の","靴","です"]],
            ['front' => 'ネクタイ', 'back' => 'ネクタイ', 'key' => 'nekutai', 'example_japanese' => 'フランスのネクタイです', 'example_blocks_json' => ["フランス","の","ネクタイ","です"]],
            ['front' => 'ワイン', 'back' => 'ワイン', 'key' => 'wain', 'example_japanese' => 'ワインを飲みます', 'example_blocks_json' => ["ワイン","を","飲みます"]],
            ['front' => 'たばこ', 'back' => 'たばこ', 'key' => 'tabako', 'example_japanese' => 'たばこを買います', 'example_blocks_json' => ["たばこ","を","買います"]],
            ['front' => '地下', 'back' => 'ちか', 'key' => 'chika', 'example_japanese' => '食堂は地下です', 'example_blocks_json' => ["食堂","は","地下","です"]],
            ['front' => '～階', 'back' => '～かい / がい', 'key' => 'kai', 'example_japanese' => '３階です', 'example_blocks_json' => ["３階","です"]],
            ['front' => '何階', 'back' => 'なんがい', 'key' => 'nankai', 'example_japanese' => 'トイレは何階ですか', 'example_blocks_json' => ["トイレ","は","何階","ですか"]],
            ['front' => '～円', 'back' => '～えん', 'key' => 'en', 'example_japanese' => '千円です', 'example_blocks_json' => ["千円","です"]],
            ['front' => 'いくら', 'back' => 'いくら', 'key' => 'ikura', 'example_japanese' => 'この時計はいくらですか', 'example_blocks_json' => ["この","時計","は","いくら","ですか"]],
            ['front' => '百', 'back' => 'ひゃく', 'key' => 'hyaku', 'example_japanese' => '三百円です', 'example_blocks_json' => ["三百円","です"]],
            ['front' => '千', 'back' => 'せん', 'key' => 'sen', 'example_japanese' => '三千円です', 'example_blocks_json' => ["三千円","です"]],
            ['front' => '万', 'back' => 'まん', 'key' => 'man', 'example_japanese' => '一万円です', 'example_blocks_json' => ["一万円","です"]],
            ['front' => 'すみません', 'back' => 'すみません', 'key' => 'sumimasen', 'example_japanese' => 'すみません', 'example_blocks_json' => ["すみません"]],
            ['front' => '見せてください', 'back' => 'みせてください', 'key' => 'misetekudasai', 'example_japanese' => 'その靴を見せてください', 'example_blocks_json' => ["その","靴","を","見せてください"]],
            ['front' => 'じゃ', 'back' => 'じゃ', 'key' => 'ja', 'example_japanese' => 'じゃ、これをください', 'example_blocks_json' => ["じゃ","、","これ","を","ください"]],
            ['front' => '～をください', 'back' => '～をください', 'key' => 'okudasai', 'example_japanese' => 'これをください', 'example_blocks_json' => ["これ","を","ください"]],
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
                    'back_text' => "N5.lesson3.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson3.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}