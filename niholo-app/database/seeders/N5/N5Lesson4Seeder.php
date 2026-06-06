<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson4Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 4],
            [
                'title' => 'N5.lesson4.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson4.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '今', 'back' => 'いま', 'key' => 'ima', 'example_japanese' => '今は何時ですか', 'example_blocks_json' => ["今","は","何時","ですか"]],
            ['front' => '～時', 'back' => '～じ', 'key' => 'ji', 'example_japanese' => '今、何時ですか', 'example_blocks_json' => ["今","、","何","時","ですか"]],
            ['front' => '～分', 'back' => '～ふん / ぷん', 'key' => 'fun', 'example_japanese' => '五分待ちます', 'example_blocks_json' => ["五","分","待ちます"]],
            ['front' => '半', 'back' => 'はん', 'key' => 'han', 'example_japanese' => '九時半です', 'example_blocks_json' => ["九時","半","です"]],
            ['front' => '何時', 'back' => 'なんじ', 'key' => 'nanji', 'example_japanese' => '会議は何時ですか', 'example_blocks_json' => ["会議","は","何時","ですか"]],
            ['front' => '何分', 'back' => 'なんぷん', 'key' => 'nanpun', 'example_japanese' => '何分かかりますか', 'example_blocks_json' => ["何分","かかりますか"]],
            ['front' => '午前', 'back' => 'ごぜん', 'key' => 'gozen', 'example_japanese' => '午前九時に起きます', 'example_blocks_json' => ["午前","九時","に","起きます"]],
            ['front' => '午後', 'back' => 'ごご', 'key' => 'gogo', 'example_japanese' => '午後から働きます', 'example_blocks_json' => ["午後","から","働きます"]],
            ['front' => '朝', 'back' => 'あさ', 'key' => 'asa', 'example_japanese' => '朝ごはんを食べます', 'example_blocks_json' => ["朝","ごはん","を","食べます"]],
            ['front' => '昼', 'back' => 'ひる', 'key' => 'hiru', 'example_japanese' => '昼に休みます', 'example_blocks_json' => ["昼","に","休みます"]],
            ['front' => '晩 / 夜', 'back' => 'ばん / よる', 'key' => 'ban_yoru', 'example_japanese' => '夜、勉強します', 'example_blocks_json' => ["夜","、","勉強します"]],
            ['front' => '一昨日', 'back' => 'おととい', 'key' => 'ototoi', 'example_japanese' => '一昨日、友達に会いました', 'example_blocks_json' => ["一昨日","、","友達","に","会いました"]],
            ['front' => '昨日', 'back' => 'きのう', 'key' => 'kinou', 'example_japanese' => '昨日は休みでした', 'example_blocks_json' => ["昨日","は","休みでした"]],
            ['front' => '今日', 'back' => 'きょう', 'key' => 'kyou', 'example_japanese' => '今日は月曜日です', 'example_blocks_json' => ["今日","は","月曜日","です"]],
            ['front' => '明日', 'back' => 'あした', 'key' => 'ashita', 'example_japanese' => '明日、学校へ行きます', 'example_blocks_json' => ["明日","、","学校","へ","行きます"]],
            ['front' => '明後日', 'back' => 'あさって', 'key' => 'asatte', 'example_japanese' => '明後日、働きます', 'example_blocks_json' => ["明後日","、","働きます"]],
            ['front' => '今朝', 'back' => 'けさ', 'key' => 'kesa', 'example_japanese' => '今朝、新聞を読みました', 'example_blocks_json' => ["今朝","、","新聞","を","読みました"]],
            ['front' => '今晩', 'back' => 'こんばん', 'key' => 'konban', 'example_japanese' => '今晩、テレビを見ます', 'example_blocks_json' => ["今晩","、","テレビ","を","見ます"]],
            ['front' => '月曜日', 'back' => 'げつようび', 'key' => 'getsuyoubi', 'example_japanese' => '月曜日は忙しいです', 'example_blocks_json' => ["月曜日","は","忙しい","です"]],
            ['front' => '火曜日', 'back' => 'かようび', 'key' => 'kayoubi', 'example_japanese' => '火曜日にテストがあります', 'example_blocks_json' => ["火曜日","に","テスト","が","あります"]],
            ['front' => '水曜日', 'back' => 'すいようび', 'key' => 'suiyoubi', 'example_japanese' => '水曜日は休みです', 'example_blocks_json' => ["水曜日","は","休み","です"]],
            ['front' => '木曜日', 'back' => 'もくようび', 'key' => 'mokuyoubi', 'example_japanese' => '木曜日に映画を見ます', 'example_blocks_json' => ["木曜日","に","映画","を","見ます"]],
            ['front' => '金曜日', 'back' => 'きんようび', 'key' => 'kinyoubi', 'example_japanese' => '金曜日の夜', 'example_blocks_json' => ["金曜日","の","夜"]],
            ['front' => '土曜日', 'back' => 'どようび', 'key' => 'doyoubi', 'example_japanese' => '土曜日に遊びます', 'example_blocks_json' => ["土曜日","に","遊びます"]],
            ['front' => '日曜日', 'back' => 'にちようび', 'key' => 'nichiyoubi', 'example_japanese' => '日曜日は働きません', 'example_blocks_json' => ["日曜日","は","働きません"]],
            ['front' => '何曜日', 'back' => 'なんようび', 'key' => 'nanyoubi', 'example_japanese' => '今日は何曜日ですか', 'example_blocks_json' => ["今日","は","何曜日","ですか"]],
            ['front' => '起きます', 'back' => 'おきます', 'key' => 'okimasu', 'example_japanese' => '毎朝６時に起きます', 'example_blocks_json' => ["毎朝","６時","に","起きます"]],
            ['front' => '寝ます', 'back' => 'ねます', 'key' => 'nemasu', 'example_japanese' => '１１時に寝ます', 'example_blocks_json' => ["１１時","に","寝ます"]],
            ['front' => '働きます', 'back' => 'はたらきます', 'key' => 'hatarakimasu', 'example_japanese' => '毎日働きます', 'example_blocks_json' => ["毎日","働きます"]],
            ['front' => '休みます', 'back' => 'やすみます', 'key' => 'yasumimasu', 'example_japanese' => '部屋で休みます', 'example_blocks_json' => ["部屋","で","休みます"]],
            ['front' => '勉強します', 'back' => 'べんきょうします', 'key' => 'benkyoushimasu', 'example_japanese' => '日本語を勉強します', 'example_blocks_json' => ["日本語","を","勉強します"]],
            ['front' => '終わります', 'back' => 'おわります', 'key' => 'owarimasu', 'example_japanese' => '仕事が終わります', 'example_blocks_json' => ["仕事","が","終わります"]],
            ['front' => '休み', 'back' => 'やすみ', 'key' => 'yasumi', 'example_japanese' => '明日は休みです', 'example_blocks_json' => ["明日","は","休み","です"]],
            ['front' => '試験', 'back' => 'しけん', 'key' => 'shiken', 'example_japanese' => '明日試験があります', 'example_blocks_json' => ["明日","試験","が","あります"]],
            ['front' => '毎～', 'back' => 'まい～', 'key' => 'mai_', 'example_japanese' => '毎日', 'example_blocks_json' => ["毎日"]],
            ['front' => '～から', 'back' => '～から', 'key' => '_kara', 'example_japanese' => '９時から働きます', 'example_blocks_json' => ["９時","から","働きます"]],
            ['front' => '～まで', 'back' => '～まで', 'key' => '_made', 'example_japanese' => '５時まで働きます', 'example_blocks_json' => ["５時","まで","働きます"]],
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
                    'back_text' => "N5.lesson4.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson4.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}