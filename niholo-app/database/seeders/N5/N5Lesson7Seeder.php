<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson7Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 7],
            [
                'title' => 'N5.lesson7.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson7.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '切ります', 'back' => 'きります', 'key' => 'kirimasu', 'example_japanese' => 'はさみで紙を切ります', 'example_blocks_json' => ['はさみ', 'で', '紙', 'を', '切ります']],
            ['front' => '送ります', 'back' => 'おくります', 'key' => 'okurimasu', 'example_japanese' => 'メールを送ります', 'example_blocks_json' => ['メール', 'を', '送ります']],
            ['front' => 'あげます', 'back' => 'あげます', 'key' => 'agemasu', 'example_japanese' => '友達にプレゼントをあげます', 'example_blocks_json' => ['友達', 'に', 'プレゼント', 'を', 'あげます']],
            ['front' => 'もらいます', 'back' => 'もらいます', 'key' => 'moraimasu', 'example_japanese' => '父から時計をもらいました', 'example_blocks_json' => ['父', 'から', '時計', 'を', 'もらいました']],
            ['front' => '貸します', 'back' => 'かします', 'key' => 'kashimasu', 'example_japanese' => '本を貸します', 'example_blocks_json' => ['本', 'を', '貸します']],
            ['front' => '借ります', 'back' => 'かります', 'key' => 'karimasu', 'example_japanese' => '図書館で本を借ります', 'example_blocks_json' => ['図書館', 'で', '本', 'を', '借ります']],
            ['front' => '教えます', 'back' => 'おしえます', 'key' => 'oshiemasu', 'example_japanese' => '日本語を教えます', 'example_blocks_json' => ['日本語', 'を', '教えます']],
            ['front' => '習います', 'back' => 'ならいます', 'key' => 'naraimasu', 'example_japanese' => '英語を習います', 'example_blocks_json' => ['英語', 'を', '習います']],
            ['front' => 'かけます', 'back' => 'かけます', 'key' => 'kakemasu', 'example_japanese' => '電話をかけます', 'example_blocks_json' => ['電話', 'を', 'かけます']],
            ['front' => '手', 'back' => 'て', 'key' => 'te', 'example_japanese' => '手で食べます', 'example_blocks_json' => ['手', 'で', '食べます']],
            ['front' => 'はし', 'back' => 'はし', 'key' => 'hashi', 'example_japanese' => 'はしで食べます', 'example_blocks_json' => ['はし', 'で', '食べます']],
            ['front' => 'スプーン', 'back' => 'スプーン', 'key' => 'supuun', 'example_japanese' => 'スプーンで食べます', 'example_blocks_json' => ['スプーン', 'で', '食べます']],
            ['front' => 'ナイフ', 'back' => 'ナイフ', 'key' => 'naifu', 'example_japanese' => 'ナイフで切ります', 'example_blocks_json' => ['ナイフ', 'で', '切ります']],
            ['front' => 'フォーク', 'back' => 'フォーク', 'key' => 'fooku', 'example_japanese' => 'フォークで食べます', 'example_blocks_json' => ['フォーク', 'で', '食べます']],
            ['front' => 'はさみ', 'back' => 'はさみ', 'key' => 'hasami', 'example_japanese' => 'はさみで切ります', 'example_blocks_json' => ['はさみ', 'で', '切ります']],
            ['front' => 'パソコン', 'back' => 'パソコン', 'key' => 'pasokon', 'example_japanese' => 'パソコンで映画を見ます', 'example_blocks_json' => ['パソコン', 'で', '映画', 'を', '見ます']],
            ['front' => '紙', 'back' => 'かみ', 'key' => 'kami', 'example_japanese' => '紙を切ります', 'example_blocks_json' => ['紙', 'を', '切ります']],
            ['front' => '花', 'back' => 'はな', 'key' => 'hana', 'example_japanese' => '花をあげます', 'example_blocks_json' => ['花', 'を', 'あげます']],
            ['front' => 'プレゼント', 'back' => 'プレゼント', 'key' => 'purezento', 'example_japanese' => 'プレゼントをもらいました', 'example_blocks_json' => ['プレゼント', 'を', 'もらいました']],
            ['front' => '荷物', 'back' => 'にもつ', 'key' => 'nimotsu', 'example_japanese' => '荷物を送ります', 'example_blocks_json' => ['荷物', 'を', '送ります']],
            ['front' => 'お金', 'back' => 'おかね', 'key' => 'okane', 'example_japanese' => 'お金を貸します', 'example_blocks_json' => ['お金', 'を', '貸します']],
            ['front' => '切符', 'back' => 'きっぷ', 'key' => 'kippu', 'example_japanese' => '切符を買います', 'example_blocks_json' => ['切符', 'を', '買います']],
            ['front' => '父', 'back' => 'ちち', 'key' => 'chichi', 'example_japanese' => '父にシャツをあげます', 'example_blocks_json' => ['父', 'に', 'シャツ', 'を', 'あげます']],
            ['front' => '母', 'back' => 'はは', 'key' => 'haha', 'example_japanese' => '母から花をもらいました', 'example_blocks_json' => ['母', 'から', '花', 'を', 'もらいました']],
            ['front' => 'もう', 'back' => 'もう', 'key' => 'mou', 'example_japanese' => 'もう昼ごはんを食べました', 'example_blocks_json' => ['もう', '昼ごはん', 'を', '食べました']],
            ['front' => 'まだ', 'back' => 'まだ', 'key' => 'mada', 'example_japanese' => 'いいえ、まだです', 'example_blocks_json' => ['いいえ', '、', 'まだ', 'です']],
            ['front' => 'これから', 'back' => 'これから', 'key' => 'korekara', 'example_japanese' => 'これから食べます', 'example_blocks_json' => ['これから', '食べます']],
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
                    'back_text' => "N5.lesson7.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson7.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
