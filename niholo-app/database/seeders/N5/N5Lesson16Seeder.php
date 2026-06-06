<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson16Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 16],
            [
                'title' => 'N5.lesson16.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson16.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '乗ります', 'back' => 'のります', 'key' => 'norimasu', 'example_japanese' => '電車に乗ります', 'example_blocks_json' => ['電車', 'に', '乗ります']],
            ['front' => '降ります', 'back' => 'おります', 'key' => 'orimasu', 'example_japanese' => '電車を降ります', 'example_blocks_json' => ['電車', 'を', '降ります']],
            ['front' => '乗り換えます', 'back' => 'のりかえます', 'key' => 'norikaemasu', 'example_japanese' => '地下鉄に乗り換えます', 'example_blocks_json' => ['地下鉄', 'に', '乗り換えます']],
            ['front' => '浴びます', 'back' => 'あびます', 'key' => 'abimasu', 'example_japanese' => 'シャワーを浴びます', 'example_blocks_json' => ['シャワー', 'を', '浴びます']],
            ['front' => '入れます', 'back' => 'いれます', 'key' => 'iremasu', 'example_japanese' => 'かばんに本を入れます', 'example_blocks_json' => ['かばん', 'に', '本', 'を', '入れます']],
            ['front' => '出します', 'back' => 'だします', 'key' => 'dashimasu', 'example_japanese' => 'お金を出します', 'example_blocks_json' => ['お金', 'を', '出します']],
            ['front' => '入ります（大学に～）', 'back' => 'はいります', 'key' => 'hairimasu_daigaku', 'example_japanese' => '大学に入ります', 'example_blocks_json' => ['大学', 'に', '入ります']],
            ['front' => '出ます（大学を～）', 'back' => 'でます', 'key' => 'demasu_daigaku', 'example_japanese' => '大学を出ます', 'example_blocks_json' => ['大学', 'を', '出ます']],
            ['front' => 'やめます（会社を～）', 'back' => 'やめます', 'key' => 'yamemasu_kaisha', 'example_japanese' => '会社をやめます', 'example_blocks_json' => ['会社', 'を', 'やめます']],
            ['front' => '押します', 'back' => 'おします', 'key' => 'oshimasu', 'example_japanese' => 'ボタンを押します', 'example_blocks_json' => ['ボタン', 'を', '押します']],
            ['front' => '若い', 'back' => 'わかい', 'key' => 'wakai', 'example_japanese' => '若い人', 'example_blocks_json' => ['若い', '人']],
            ['front' => '長い', 'back' => 'ながい', 'key' => 'nagai', 'example_japanese' => '髪が長いです', 'example_blocks_json' => ['髪', 'が', '長い', 'です']],
            ['front' => '短い', 'back' => 'みじかい', 'key' => 'mijikai', 'example_japanese' => '短い時間', 'example_blocks_json' => ['短い', '時間']],
            ['front' => '明るい', 'back' => 'あかるい', 'key' => 'akarui', 'example_japanese' => '明るい部屋', 'example_blocks_json' => ['明るい', '部屋']],
            ['front' => '暗い', 'back' => 'くらい', 'key' => 'kurai', 'example_japanese' => '外は暗いです', 'example_blocks_json' => ['外', 'は', '暗い', 'です']],
            ['front' => '背が高い', 'back' => 'せがたかい', 'key' => 'segatakai', 'example_japanese' => '彼は背が高いです', 'example_blocks_json' => ['彼', 'は', '背', 'が', '高い', 'です']],
            ['front' => '頭がいい', 'back' => 'あたまがいい', 'key' => 'atamagaii', 'example_japanese' => '彼女は頭がいいです', 'example_blocks_json' => ['彼女', 'は', '頭', 'が', 'いい', 'です']],
            ['front' => '体', 'back' => 'からだ', 'key' => 'karada', 'example_japanese' => '体にいいです', 'example_blocks_json' => ['体', 'に', 'いい', 'です']],
            ['front' => '頭', 'back' => 'あたま', 'key' => 'atama', 'example_japanese' => '頭が痛いです', 'example_blocks_json' => ['頭', 'が', '痛い', 'です']],
            ['front' => '髪', 'back' => 'かみ', 'key' => 'kami', 'example_japanese' => '髪を切ります', 'example_blocks_json' => ['髪', 'を', '切ります']],
            ['front' => '顔', 'back' => 'かお', 'key' => 'kao', 'example_japanese' => '顔を洗います', 'example_blocks_json' => ['顔', 'を', '洗います']],
            ['front' => '目', 'back' => 'め', 'key' => 'me', 'example_japanese' => '目がきれいです', 'example_blocks_json' => ['目', 'が', 'きれい', 'です']],
            ['front' => '耳', 'back' => 'みみ', 'key' => 'mimi', 'example_japanese' => '耳が大きいです', 'example_blocks_json' => ['耳', 'が', '大きい', 'です']],
            ['front' => '口', 'back' => 'くち', 'key' => 'kuchi', 'example_japanese' => '口を開けます', 'example_blocks_json' => ['口', 'を', '開けます']],
            ['front' => '歯', 'back' => 'は', 'key' => 'ha', 'example_japanese' => '歯を磨きます', 'example_blocks_json' => ['歯', 'を', '磨きます']],
            ['front' => 'お腹', 'back' => 'おなか', 'key' => 'onaka', 'example_japanese' => 'お腹が痛いです', 'example_blocks_json' => ['お腹', 'が', '痛い', 'です']],
            ['front' => '足', 'back' => 'あし', 'key' => 'ashi', 'example_japanese' => '足が長いです', 'example_blocks_json' => ['足', 'が', '長い', 'です']],
            ['front' => 'サービス', 'back' => 'サービス', 'key' => 'saabisu', 'example_japanese' => 'サービスがいいです', 'example_blocks_json' => ['サービス', 'が', 'いい', 'です']],
            ['front' => 'ジョギング', 'back' => 'ジョギング', 'key' => 'jogingu', 'example_japanese' => 'ジョギングをします', 'example_blocks_json' => ['ジョギング', 'を', 'します']],
            ['front' => 'シャワー', 'back' => 'シャワー', 'key' => 'shawaa', 'example_japanese' => 'シャワーを浴びます', 'example_blocks_json' => ['シャワー', 'を', '浴びます']],
            ['front' => '緑', 'back' => 'みどり', 'key' => 'midori', 'example_japanese' => '緑が多い町', 'example_blocks_json' => ['緑', 'が', '多い', '町']],
            ['front' => 'お寺', 'back' => 'おてら', 'key' => 'otera', 'example_japanese' => '有名なお寺', 'example_blocks_json' => ['有名', 'な', 'お寺']],
            ['front' => '神社', 'back' => 'じんじゃ', 'key' => 'jinja', 'example_japanese' => '神社へ行きます', 'example_blocks_json' => ['神社', 'へ', '行きます']],
            ['front' => '留学生', 'back' => 'りゅうがくせい', 'key' => 'ryuugakusei_16', 'example_japanese' => '留学生と話します', 'example_blocks_json' => ['留学生', 'と', '話します']],
            ['front' => '～番', 'back' => '～ばん', 'key' => 'ban', 'example_japanese' => '１番の電車', 'example_blocks_json' => ['１番', 'の', '電車']],
            ['front' => 'どうやって', 'back' => 'どうやって', 'key' => 'douyatte', 'example_japanese' => 'どうやって行きますか', 'example_blocks_json' => ['どうやって', '行きます', 'か']],
            ['front' => 'どの～', 'back' => 'どの～', 'key' => 'dono', 'example_japanese' => 'どの人ですか', 'example_blocks_json' => ['どの', '人', 'ですか']],
            ['front' => 'いいえ、まだまだです', 'back' => 'いいえ、まだまだです', 'key' => 'iie_madamadadesu', 'example_japanese' => 'いいえ、まだまだです', 'example_blocks_json' => ['いいえ', '、', 'まだまだ', 'です']],
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
                    'back_text' => "N5.lesson16.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson16.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
