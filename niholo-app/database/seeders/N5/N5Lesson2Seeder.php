<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson2Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 2],
            [
                'title' => 'N5.lesson2.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson2.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'これ', 'back' => 'これ', 'key' => 'kore', 'example_japanese' => 'これは本です', 'example_blocks_json' => ["これ","は","本","です"]],
            ['front' => 'それ', 'back' => 'それ', 'key' => 'sore', 'example_japanese' => 'それは私の傘です', 'example_blocks_json' => ["それ","は","私","の","傘","です"]],
            ['front' => 'あれ', 'back' => 'あれ', 'key' => 'are', 'example_japanese' => 'あれは車です', 'example_blocks_json' => ["あれ","は","車","です"]],
            ['front' => 'この～', 'back' => 'この～', 'key' => 'kono', 'example_japanese' => 'この本は私のです', 'example_blocks_json' => ["この","本","は","私","の","です"]],
            ['front' => 'その～', 'back' => 'その～', 'key' => 'sono', 'example_japanese' => 'その鍵は誰のですか', 'example_blocks_json' => ["その","鍵","は","誰","の","ですか"]],
            ['front' => 'あの～', 'back' => 'あの～', 'key' => 'ano', 'example_japanese' => 'あの人は先生です', 'example_blocks_json' => ["あの","人","は","先生","です"]],
            ['front' => '本', 'back' => 'ほん', 'key' => 'hon', 'example_japanese' => 'これは本です', 'example_blocks_json' => ["これ","は","本","です"]],
            ['front' => '辞書', 'back' => 'じしょ', 'key' => 'jisho', 'example_japanese' => 'それは英語の辞書です', 'example_blocks_json' => ["それ","は","英語","の","辞書","です"]],
            ['front' => '雑誌', 'back' => 'ざっし', 'key' => 'zasshi', 'example_japanese' => '車の雑誌を読みます', 'example_blocks_json' => ["車","の","雑誌","を","読みます"]],
            ['front' => '新聞', 'back' => 'しんぶん', 'key' => 'shinbun', 'example_japanese' => '毎朝新聞を読みます', 'example_blocks_json' => ["毎朝","新聞","を","読みます"]],
            ['front' => 'ノート', 'back' => 'ノート', 'key' => 'nooto', 'example_japanese' => 'ノートに書きます', 'example_blocks_json' => ["ノート","に","書きます"]],
            ['front' => '手帳', 'back' => 'てちょう', 'key' => 'techou', 'example_japanese' => 'これは私の手帳です', 'example_blocks_json' => ["これ","は","私","の","手帳","です"]],
            ['front' => '名刺', 'back' => 'めいし', 'key' => 'meishi', 'example_japanese' => '名刺をください', 'example_blocks_json' => ["名刺","を","ください"]],
            ['front' => 'カード', 'back' => 'カード', 'key' => 'kaado', 'example_japanese' => 'カードで払います', 'example_blocks_json' => ["カード","で","払います"]],
            ['front' => '鉛筆', 'back' => 'えんぴつ', 'key' => 'enpitsu', 'example_japanese' => '鉛筆で書きます', 'example_blocks_json' => ["鉛筆","で","書きます"]],
            ['front' => 'ボールペン', 'back' => 'ボールペン', 'key' => 'boorupen', 'example_japanese' => 'ボールペンを貸してください', 'example_blocks_json' => ["ボールペン","を","貸してください"]],
            ['front' => 'シャープペンシル', 'back' => 'シャープペンシル', 'key' => 'shaapupenshiru', 'example_japanese' => 'それはシャープペンシルです', 'example_blocks_json' => ["それ","は","シャープペンシル","です"]],
            ['front' => 'かぎ', 'back' => 'かぎ', 'key' => 'kagi', 'example_japanese' => '部屋のかぎです', 'example_blocks_json' => ["部屋","の","かぎ","です"]],
            ['front' => '時計', 'back' => 'とけい', 'key' => 'tokei', 'example_japanese' => 'これは誰の時計ですか', 'example_blocks_json' => ["これ","は","誰","の","時計","ですか"]],
            ['front' => '傘', 'back' => 'かさ', 'key' => 'kasa', 'example_japanese' => '傘を忘れません', 'example_blocks_json' => ["傘","を","忘れません"]],
            ['front' => 'かばん', 'back' => 'かばん', 'key' => 'kaban', 'example_japanese' => '私のかばんです', 'example_blocks_json' => ["私","の","かばん","です"]],
            ['front' => 'テレビ', 'back' => 'テレビ', 'key' => 'terebi', 'example_japanese' => 'テレビを見ます', 'example_blocks_json' => ["テレビ","を","見ます"]],
            ['front' => 'ラジオ', 'back' => 'ラジオ', 'key' => 'rajio', 'example_japanese' => 'ラジオを聞きます', 'example_blocks_json' => ["ラジオ","を","聞きます"]],
            ['front' => 'カメラ', 'back' => 'カメラ', 'key' => 'kamera', 'example_japanese' => 'カメラを買いました', 'example_blocks_json' => ["カメラ","を","買いました"]],
            ['front' => 'コンピューター', 'back' => 'コンピューター', 'key' => 'konpyuutaa', 'example_japanese' => 'これはコンピューターです', 'example_blocks_json' => ["これ","は","コンピューター","です"]],
            ['front' => '車', 'back' => 'くるま', 'key' => 'kuruma', 'example_japanese' => '日本の車です', 'example_blocks_json' => ["日本","の","車","です"]],
            ['front' => '机', 'back' => 'つくえ', 'key' => 'tsukue', 'example_japanese' => '先生の机です', 'example_blocks_json' => ["先生","の","机","です"]],
            ['front' => 'いす', 'back' => 'いす', 'key' => 'isu', 'example_japanese' => 'いすに座ります', 'example_blocks_json' => ["いす","に","座ります"]],
            ['front' => 'チョコレート', 'back' => 'チョコレート', 'key' => 'chokoreeto', 'example_japanese' => 'チョコレートをあげます', 'example_blocks_json' => ["チョコレート","を","あげます"]],
            ['front' => 'コーヒー', 'back' => 'コーヒー', 'key' => 'koohii', 'example_japanese' => 'コーヒーを飲みます', 'example_blocks_json' => ["コーヒー","を","飲みます"]],
            ['front' => 'お土産', 'back' => 'おみやげ', 'key' => 'omiyage', 'example_japanese' => 'これは日本のお土産です', 'example_blocks_json' => ["これ","は","日本","の","お土産","です"]],
            ['front' => 'そうです', 'back' => 'そうです', 'key' => 'soudesu', 'example_japanese' => 'はい、そうです', 'example_blocks_json' => ["はい","、","そう","です"]],
            ['front' => '違います', 'back' => 'ちがいます', 'key' => 'chigaimasu', 'example_japanese' => 'いいえ、違います', 'example_blocks_json' => ["いいえ","、","違います"]],
            ['front' => 'そうですか', 'back' => 'そうですか', 'key' => 'soudesuka', 'example_japanese' => 'あ、そうですか', 'example_blocks_json' => ["あ","、","そうですか"]],
            ['front' => 'どうぞ', 'back' => 'どうぞ', 'key' => 'douzo', 'example_japanese' => 'お茶をどうぞ', 'example_blocks_json' => ["お茶","を","どうぞ"]],
            ['front' => 'どうも', 'back' => 'どうも', 'key' => 'doumo', 'example_japanese' => 'どうもありがとうございます', 'example_blocks_json' => ["どうも","ありがとうございます"]],
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
                    'back_text' => "N5.lesson2.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson2.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}