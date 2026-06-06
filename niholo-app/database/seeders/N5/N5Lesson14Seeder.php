<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson14Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 14],
            [
                'title' => 'N5.lesson14.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson14.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'つけます', 'back' => 'つけます', 'key' => 'tsukemasu', 'example_japanese' => '電気をつけます', 'example_blocks_json' => ['電気', 'を', 'つけます']],
            ['front' => '消します', 'back' => 'けします', 'key' => 'keshimasu', 'example_japanese' => '電気を消します', 'example_blocks_json' => ['電気', 'を', '消します']],
            ['front' => '開けます', 'back' => 'あけます', 'key' => 'akemasu', 'example_japanese' => 'ドアを開けます', 'example_blocks_json' => ['ドア', 'を', '開けます']],
            ['front' => '閉めます', 'back' => 'しめます', 'key' => 'shimemasu', 'example_japanese' => '窓を閉めます', 'example_blocks_json' => ['窓', 'を', '閉めます']],
            ['front' => '急ぎます', 'back' => 'いそぎます', 'key' => 'isogimasu', 'example_japanese' => '急ぎますから、タクシーで行きます', 'example_blocks_json' => ['急ぎます', 'から', '、', 'タクシー', 'で', '行きます']],
            ['front' => '待ちます', 'back' => 'まちます', 'key' => 'machimasu', 'example_japanese' => '少し待ってください', 'example_blocks_json' => ['少し', '待って', 'ください']],
            ['front' => '持ちます', 'back' => 'もちます', 'key' => 'mochimasu', 'example_japanese' => '荷物を持ちましょうか', 'example_blocks_json' => ['荷物', 'を', '持ちましょう', 'か']],
            ['front' => '取ります', 'back' => 'とります', 'key' => 'torimasu', 'example_japanese' => '塩を取ってください', 'example_blocks_json' => ['塩', 'を', '取って', 'ください']],
            ['front' => '手伝います', 'back' => 'てつだいます', 'key' => 'tetsudaimasu', 'example_japanese' => '仕事を手伝います', 'example_blocks_json' => ['仕事', 'を', '手伝います']],
            ['front' => '呼びます', 'back' => 'よびます', 'key' => 'yobimasu', 'example_japanese' => 'タクシーを呼びます', 'example_blocks_json' => ['タクシー', 'を', '呼びます']],
            ['front' => '話します', 'back' => 'はなします', 'key' => 'hanashimasu', 'example_japanese' => 'ゆっくり話してください', 'example_blocks_json' => ['ゆっくり', '話して', 'ください']],
            ['front' => '使います', 'back' => 'つかいます', 'key' => 'tsukaimasu', 'example_japanese' => 'パソコンを使います', 'example_blocks_json' => ['パソコン', 'を', '使います']],
            ['front' => '止めます', 'back' => 'とめます', 'key' => 'tomemasu', 'example_japanese' => '車を止めます', 'example_blocks_json' => ['車', 'を', '止めます']],
            ['front' => '見せます', 'back' => 'みせます', 'key' => 'misemasu', 'example_japanese' => 'パスポートを見せてください', 'example_blocks_json' => ['パスポート', 'を', '見せて', 'ください']],
            ['front' => '教えます', 'back' => 'おしえます', 'key' => 'oshiemasu', 'example_japanese' => '住所を教えてください', 'example_blocks_json' => ['住所', 'を', '教えて', 'ください']],
            ['front' => '座ります', 'back' => 'すわります', 'key' => 'suwarimasu', 'example_japanese' => 'ここに座ってください', 'example_blocks_json' => ['ここ', 'に', '座って', 'ください']],
            ['front' => '立ちます', 'back' => 'たちます', 'key' => 'tachimasu', 'example_japanese' => '立ってください', 'example_blocks_json' => ['立って', 'ください']],
            ['front' => '入ります', 'back' => 'はいります', 'key' => 'hairimasu', 'example_japanese' => '喫茶店に入ります', 'example_blocks_json' => ['喫茶店', 'に', '入ります']],
            ['front' => '出ます', 'back' => 'でます', 'key' => 'demasu', 'example_japanese' => '部屋を出ます', 'example_blocks_json' => ['部屋', 'を', '出ます']],
            ['front' => '降ります', 'back' => 'ふります', 'key' => 'furimasu', 'example_japanese' => '雨が降っています', 'example_blocks_json' => ['雨', 'が', '降っています']],
            ['front' => 'コピーします', 'back' => 'コピーします', 'key' => 'kopiishimasu', 'example_japanese' => 'レポートをコピーします', 'example_blocks_json' => ['レポート', 'を', 'コピーします']],
            ['front' => 'エアコン', 'back' => 'エアコン', 'key' => 'eakon', 'example_japanese' => 'エアコンをつけます', 'example_blocks_json' => ['エアコン', 'を', 'つけます']],
            ['front' => 'パスポート', 'back' => 'パスポート', 'key' => 'pasupooto', 'example_japanese' => 'パスポートを見せます', 'example_blocks_json' => ['パスポート', 'を', '見せます']],
            ['front' => '名前', 'back' => 'なまえ', 'key' => 'namae', 'example_japanese' => '名前を書きます', 'example_blocks_json' => ['名前', 'を', '書きます']],
            ['front' => '住所', 'back' => 'じゅうしょ', 'key' => 'juusho', 'example_japanese' => '住所を教えます', 'example_blocks_json' => ['住所', 'を', '教えます']],
            ['front' => '地図', 'back' => 'ちず', 'key' => 'chizu', 'example_japanese' => '地図を描きます', 'example_blocks_json' => ['地図', 'を', '描きます']],
            ['front' => '塩', 'back' => 'しお', 'key' => 'shio', 'example_japanese' => '塩を取ります', 'example_blocks_json' => ['塩', 'を', '取ります']],
            ['front' => '砂糖', 'back' => 'さとう', 'key' => 'satou', 'example_japanese' => '砂糖を入れます', 'example_blocks_json' => ['砂糖', 'を', '入れます']],
            ['front' => '問題', 'back' => 'もんだい', 'key' => 'mondai', 'example_japanese' => '難しい問題', 'example_blocks_json' => ['難しい', '問題']],
            ['front' => '答え', 'back' => 'こたえ', 'key' => 'kotae', 'example_japanese' => '答えを書きます', 'example_blocks_json' => ['答え', 'を', '書きます']],
            ['front' => '読み方', 'back' => 'よみかた', 'key' => 'yomikata', 'example_japanese' => '漢字の読み方', 'example_blocks_json' => ['漢字', 'の', '読み方']],
            ['front' => '～方', 'back' => '～かた', 'key' => 'kata', 'example_japanese' => '作り方を教えます', 'example_blocks_json' => ['作り方', 'を', '教えます']],
            ['front' => 'まっすぐ', 'back' => 'まっすぐ', 'key' => 'massugu', 'example_japanese' => 'まっすぐ行きます', 'example_blocks_json' => ['まっすぐ', '行きます']],
            ['front' => 'ゆっくり', 'back' => 'ゆっくり', 'key' => 'yukkuri', 'example_japanese' => 'ゆっくり話します', 'example_blocks_json' => ['ゆっくり', '話します']],
            ['front' => 'すぐ', 'back' => 'すぐ', 'key' => 'sugu', 'example_japanese' => 'すぐ行きます', 'example_blocks_json' => ['すぐ', '行きます']],
            ['front' => 'また', 'back' => 'また', 'key' => 'mata', 'example_japanese' => 'また来ます', 'example_blocks_json' => ['また', '来ます']],
            ['front' => 'あとで', 'back' => 'あとで', 'key' => 'atode', 'example_japanese' => 'あとで電話します', 'example_blocks_json' => ['あとで', '電話します']],
            ['front' => 'もう少し', 'back' => 'もうすこし', 'key' => 'mousukoshi', 'example_japanese' => 'もう少し待ってください', 'example_blocks_json' => ['もう', '少し', '待って', 'ください']],
            ['front' => 'もう～', 'back' => 'もう～', 'key' => 'mou_more', 'example_japanese' => 'もう一杯いかがですか', 'example_blocks_json' => ['もう', '一杯', 'いかがですか']],
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
                    'back_text' => "N5.lesson14.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson14.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
