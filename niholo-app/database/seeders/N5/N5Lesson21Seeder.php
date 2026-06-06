<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson21Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 21],
            [
                'title' => 'N5.lesson21.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson21.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '思います', 'back' => 'おもいます', 'key' => 'omoimasu', 'example_japanese' => '明日雨が降ると思います', 'example_blocks_json' => ['明日', '雨', 'が', '降る', 'と', '思います']],
            ['front' => '言います', 'back' => 'いいます', 'key' => 'iimasu', 'example_japanese' => '寝る前に「おやすみなさい」と言います', 'example_blocks_json' => ['寝る', '前', 'に', '「おやすみなさい」', 'と', '言います']],
            ['front' => '足ります', 'back' => 'たります', 'key' => 'tarimasu', 'example_japanese' => 'お金が足ります', 'example_blocks_json' => ['お金', 'が', '足ります']],
            ['front' => '勝ちます', 'back' => 'かちます', 'key' => 'kachimasu', 'example_japanese' => '試合に勝ちます', 'example_blocks_json' => ['試合', 'に', '勝ちます']],
            ['front' => '負けます', 'back' => 'まけます', 'key' => 'makemasu', 'example_japanese' => '試合に負けました', 'example_blocks_json' => ['試合', 'に', '負けました']],
            ['front' => 'あります（お祭りが～）', 'back' => 'あります', 'key' => 'arimasu_matsuri', 'example_japanese' => '明日お祭りがあります', 'example_blocks_json' => ['明日', 'お祭り', 'が', 'あります']],
            ['front' => '役に立ちます', 'back' => 'やくにたちます', 'key' => 'yakunitachimasu', 'example_japanese' => 'この本は役に立ちます', 'example_blocks_json' => ['この', '本', 'は', '役に立ちます']],
            ['front' => '無駄（な）', 'back' => 'むだ（な）', 'key' => 'muda', 'example_japanese' => '無駄なコピー', 'example_blocks_json' => ['無駄', 'な', 'コピー']],
            ['front' => '不便（な）', 'back' => 'ふべん（な）', 'key' => 'fuben', 'example_japanese' => 'ここは交通が不便です', 'example_blocks_json' => ['ここ', 'は', '交通', 'が', '不便', 'です']],
            ['front' => '同じ', 'back' => 'おなじ', 'key' => 'onaji', 'example_japanese' => '私と同じ意見です', 'example_blocks_json' => ['私', 'と', '同じ', '意見', 'です']],
            ['front' => 'すごい', 'back' => 'すごい', 'key' => 'sugoi', 'example_japanese' => 'すごいですね', 'example_blocks_json' => ['すごい', 'ですね']],
            ['front' => '首相', 'back' => 'しゅしょう', 'key' => 'shushou', 'example_japanese' => '日本の首相', 'example_blocks_json' => ['日本', 'の', '首相']],
            ['front' => '大統領', 'back' => 'だいとうりょう', 'key' => 'daitouryou', 'example_japanese' => 'アメリカの大統領', 'example_blocks_json' => ['アメリカ', 'の', '大統領']],
            ['front' => '政治', 'back' => 'せいじ', 'key' => 'seiji', 'example_japanese' => '政治について話します', 'example_blocks_json' => ['政治', 'について', '話します']],
            ['front' => 'ニュース', 'back' => 'ニュース', 'key' => 'nyuusu', 'example_japanese' => 'ニュースを見ます', 'example_blocks_json' => ['ニュース', 'を', '見ます']],
            ['front' => 'スピーチ', 'back' => 'スピーチ', 'key' => 'supiichi', 'example_japanese' => 'スピーチをします', 'example_blocks_json' => ['スピーチ', 'を', 'します']],
            ['front' => '試合', 'back' => 'しあい', 'key' => 'shiai', 'example_japanese' => 'サッカーの試合', 'example_blocks_json' => ['サッカー', 'の', '試合']],
            ['front' => 'アルバイト', 'back' => 'アルバイト', 'key' => 'arubaito', 'example_japanese' => 'アルバイトをします', 'example_blocks_json' => ['アルバイト', 'を', 'します']],
            ['front' => '意見', 'back' => 'いけん', 'key' => 'iken', 'example_japanese' => '意見を言います', 'example_blocks_json' => ['意見', 'を', '言います']],
            ['front' => 'お話', 'back' => 'おはなし', 'key' => 'ohanashi', 'example_japanese' => '面白いお話', 'example_blocks_json' => ['面白い', 'お話']],
            ['front' => 'ユーモア', 'back' => 'ユーモア', 'key' => 'yuumoa', 'example_japanese' => 'ユーモアがあります', 'example_blocks_json' => ['ユーモア', 'が', 'あります']],
            ['front' => 'デザイン', 'back' => 'デザイン', 'key' => 'dezain', 'example_japanese' => 'デザインがいいです', 'example_blocks_json' => ['デザイン', 'が', 'いい', 'です']],
            ['front' => '交通', 'back' => 'こうつう', 'key' => 'koutsuu', 'example_japanese' => '交通が便利です', 'example_blocks_json' => ['交通', 'が', '便利', 'です']],
            ['front' => 'ラッシュ', 'back' => 'ラッシュ', 'key' => 'rasshu', 'example_japanese' => 'ラッシュの時間', 'example_blocks_json' => ['ラッシュ', 'の', '時間']],
            ['front' => '最近', 'back' => 'さいきん', 'key' => 'saikin', 'example_japanese' => '最近忙しいです', 'example_blocks_json' => ['最近', '忙しい', 'です']],
            ['front' => 'たぶん', 'back' => 'たぶん', 'key' => 'tabun', 'example_japanese' => 'たぶん雨が降ります', 'example_blocks_json' => ['たぶん', '雨', 'が', '降ります']],
            ['front' => 'きっと', 'back' => 'きっと', 'key' => 'kitto', 'example_japanese' => 'きっと来ます', 'example_blocks_json' => ['きっと', '来ます']],
            ['front' => 'ほんとうに', 'back' => 'ほんとうに', 'key' => 'hontouni', 'example_japanese' => 'ほんとうにおいしいです', 'example_blocks_json' => ['ほんとうに', 'おいしい', 'です']],
            ['front' => 'そんなに', 'back' => 'そんなに', 'key' => 'sonnani', 'example_japanese' => 'そんなに難しくないです', 'example_blocks_json' => ['そんなに', '難しくない', 'です']],
            ['front' => '～について', 'back' => '～について', 'key' => 'nitsuite', 'example_japanese' => '日本についてどう思いますか', 'example_blocks_json' => ['日本', 'について', 'どう', '思います', 'か']],
            ['front' => 'しかたがありません', 'back' => 'しかたがありません', 'key' => 'shikatagaarimasen', 'example_japanese' => 'しかたがありません', 'example_blocks_json' => ['しかたがありません']],
            ['front' => 'しばらくですね', 'back' => 'しばらくですね', 'key' => 'shibarakudesune', 'example_japanese' => 'しばらくですね', 'example_blocks_json' => ['しばらくですね']],
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
                    'back_text' => "N5.lesson21.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson21.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
