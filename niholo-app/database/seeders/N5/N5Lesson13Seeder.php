<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson13Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 13],
            [
                'title' => 'N5.lesson13.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson13.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '遊びます', 'back' => 'あそびます', 'key' => 'asobimasu', 'example_japanese' => '公園で遊びます', 'example_blocks_json' => ['公園', 'で', '遊びます']],
            ['front' => '泳ぎます', 'back' => 'およぎます', 'key' => 'oyogimasu', 'example_japanese' => 'プールで泳ぎます', 'example_blocks_json' => ['プール', 'で', '泳ぎます']],
            ['front' => '迎えます', 'back' => 'むかえます', 'key' => 'mukaemasu', 'example_japanese' => '友達を迎えます', 'example_blocks_json' => ['友達', 'を', '迎えます']],
            ['front' => '疲れます', 'back' => 'つかれます', 'key' => 'tsukaremasu', 'example_japanese' => '仕事で疲れました', 'example_blocks_json' => ['仕事', 'で', '疲れました']],
            ['front' => '出します', 'back' => 'だします', 'key' => 'dashimasu', 'example_japanese' => '手紙を出します', 'example_blocks_json' => ['手紙', 'を', '出します']],
            ['front' => '入ります', 'back' => 'はいります', 'key' => 'hairimasu', 'example_japanese' => '喫茶店に入ります', 'example_blocks_json' => ['喫茶店', 'に', '入ります']],
            ['front' => '出ます', 'back' => 'でます', 'key' => 'demasu', 'example_japanese' => '喫茶店を出ます', 'example_blocks_json' => ['喫茶店', 'を', '出ます']],
            ['front' => '結婚します', 'back' => 'けっこんします', 'key' => 'kekkonshimasu', 'example_japanese' => '来年結婚します', 'example_blocks_json' => ['来年', '結婚します']],
            ['front' => '買い物します', 'back' => 'かいものします', 'key' => 'kaimonoshimasu', 'example_japanese' => 'デパートで買い物します', 'example_blocks_json' => ['デパート', 'で', '買い物します']],
            ['front' => '食事します', 'back' => 'しょくじします', 'key' => 'shokujishimasu', 'example_japanese' => 'レストランで食事します', 'example_blocks_json' => ['レストラン', 'で', '食事します']],
            ['front' => '散歩します', 'back' => 'さんぽします', 'key' => 'sanposhimasu', 'example_japanese' => '公園を散歩します', 'example_blocks_json' => ['公園', 'を', '散歩します']],
            ['front' => '大変（な）', 'back' => 'たいへん（な）', 'key' => 'taihen', 'example_japanese' => '大変な仕事', 'example_blocks_json' => ['大変', 'な', '仕事']],
            ['front' => '欲しい', 'back' => 'ほしい', 'key' => 'hoshii', 'example_japanese' => '車が欲しいです', 'example_blocks_json' => ['車', 'が', '欲しい', 'です']],
            ['front' => '寂しい', 'back' => 'さびしい', 'key' => 'sabishii', 'example_japanese' => '一人で寂しいです', 'example_blocks_json' => ['一人', 'で', '寂しい', 'です']],
            ['front' => '広い', 'back' => 'ひろい', 'key' => 'hiroi', 'example_japanese' => '広い部屋', 'example_blocks_json' => ['広い', '部屋']],
            ['front' => '狭い', 'back' => 'せまい', 'key' => 'semai', 'example_japanese' => '狭い道', 'example_blocks_json' => ['狭い', '道']],
            ['front' => '市役所', 'back' => 'しやくしょ', 'key' => 'shiyakusho', 'example_japanese' => '市役所へ行きます', 'example_blocks_json' => ['市役所', 'へ', '行きます']],
            ['front' => 'プール', 'back' => 'プール', 'key' => 'puuru', 'example_japanese' => 'プールで泳ぎます', 'example_blocks_json' => ['プール', 'で', '泳ぎます']],
            ['front' => '川', 'back' => 'かわ', 'key' => 'kawa', 'example_japanese' => 'きれいな川', 'example_blocks_json' => ['きれい', 'な', '川']],
            ['front' => '経済', 'back' => 'けいざい', 'key' => 'keizai', 'example_japanese' => '日本の経済', 'example_blocks_json' => ['日本', 'の', '経済']],
            ['front' => '美術', 'back' => 'びじゅつ', 'key' => 'bijutsu', 'example_japanese' => '美術を勉強します', 'example_blocks_json' => ['美術', 'を', '勉強します']],
            ['front' => '釣り', 'back' => 'つり', 'key' => 'tsuri', 'example_japanese' => '釣りをします', 'example_blocks_json' => ['釣り', 'を', 'します']],
            ['front' => 'スキー', 'back' => 'スキー', 'key' => 'sukii', 'example_japanese' => 'スキーに行きます', 'example_blocks_json' => ['スキー', 'に', '行きます']],
            ['front' => '会議', 'back' => 'かいぎ', 'key' => 'kaigi', 'example_japanese' => '会議をします', 'example_blocks_json' => ['会議', 'を', 'します']],
            ['front' => '登録', 'back' => 'とうろく', 'key' => 'touroku', 'example_japanese' => '外国人登録', 'example_blocks_json' => ['外国人', '登録']],
            ['front' => '週末', 'back' => 'しゅうまつ', 'key' => 'shuumatsu', 'example_japanese' => '週末は休みです', 'example_blocks_json' => ['週末', 'は', '休み', 'です']],
            ['front' => 'ごろ', 'back' => 'ごろ', 'key' => 'goro', 'example_japanese' => '１２時ごろ帰ります', 'example_blocks_json' => ['１２時', 'ごろ', '帰ります']],
            ['front' => '何か', 'back' => 'なにか', 'key' => 'nanika', 'example_japanese' => '何か食べますか', 'example_blocks_json' => ['何か', '食べます', 'か']],
            ['front' => 'どこか', 'back' => 'どこか', 'key' => 'dokoka', 'example_japanese' => '週末どこかへ行きますか', 'example_blocks_json' => ['週末', 'どこか', 'へ', '行きます', 'か']],
            ['front' => 'お腹がすきました', 'back' => 'おなかがすきました', 'key' => 'onakagasukimashita', 'example_japanese' => 'お腹がすきましたから、食べましょう', 'example_blocks_json' => ['お腹', 'が', 'すきました', 'から', '、', '食べましょう']],
            ['front' => 'お腹がいっぱいです', 'back' => 'おなかがいっぱいです', 'key' => 'onakagaippaidesu', 'example_japanese' => 'もうお腹がいっぱいです', 'example_blocks_json' => ['もう', 'お腹', 'が', 'いっぱい', 'です']],
            ['front' => 'のどがかわきました', 'back' => 'のどがかわきました', 'key' => 'nodogakawakimashita', 'example_japanese' => 'のどがかわきましたね', 'example_blocks_json' => ['のど', 'が', 'かわきました', 'ね']],
            ['front' => 'そうですね', 'back' => 'そうですね', 'key' => 'soudesune', 'example_japanese' => 'そうですね。行きましょう', 'example_blocks_json' => ['そうですね', '。', '行きましょう']],
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
                    'back_text' => "N5.lesson13.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson13.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
