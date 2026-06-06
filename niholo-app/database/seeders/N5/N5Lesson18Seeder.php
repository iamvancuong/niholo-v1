<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson18Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 18],
            [
                'title' => 'N5.lesson18.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson18.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'できます', 'back' => 'できます', 'key' => 'dekimasu', 'example_japanese' => '日本語ができます', 'example_blocks_json' => ['日本語', 'が', 'できます']],
            ['front' => '洗います', 'back' => 'あらいます', 'key' => 'araimasu', 'example_japanese' => '手を洗います', 'example_blocks_json' => ['手', 'を', '洗います']],
            ['front' => '弾きます', 'back' => 'ひきます', 'key' => 'hikimasu', 'example_japanese' => 'ピアノを弾きます', 'example_blocks_json' => ['ピアノ', 'を', '弾きます']],
            ['front' => '歌います', 'back' => 'うたいます', 'key' => 'utaimasu', 'example_japanese' => '歌を歌います', 'example_blocks_json' => ['歌', 'を', '歌います']],
            ['front' => '集めます', 'back' => 'あつめます', 'key' => 'atsumemasu', 'example_japanese' => '切手を集めます', 'example_blocks_json' => ['切手', 'を', '集めます']],
            ['front' => '捨てます', 'back' => 'すてます', 'key' => 'sutemasu', 'example_japanese' => 'ごみを捨てます', 'example_blocks_json' => ['ごみ', 'を', '捨てます']],
            ['front' => '換えます', 'back' => 'かえます', 'key' => 'kaemasu', 'example_japanese' => 'お金を換えます', 'example_blocks_json' => ['お金', 'を', '換えます']],
            ['front' => '運転します', 'back' => 'うんてんします', 'key' => 'untenshimasu', 'example_japanese' => '車を運転します', 'example_blocks_json' => ['車', 'を', '運転します']],
            ['front' => '予約します', 'back' => 'よやくします', 'key' => 'yoyakushimasu', 'example_japanese' => 'ホテルを予約します', 'example_blocks_json' => ['ホテル', 'を', '予約します']],
            ['front' => 'ピアノ', 'back' => 'ピアノ', 'key' => 'piano', 'example_japanese' => 'ピアノを弾くことができます', 'example_blocks_json' => ['ピアノ', 'を', '弾く', 'こと', 'が', 'できます']],
            ['front' => 'メートル', 'back' => 'メートル', 'key' => 'meetoru', 'example_japanese' => '５０メートル泳げます', 'example_blocks_json' => ['５０メートル', '泳げます']],
            ['front' => '現金', 'back' => 'げんきん', 'key' => 'genkin', 'example_japanese' => '現金で払います', 'example_blocks_json' => ['現金', 'で', '払います']],
            ['front' => '趣味', 'back' => 'しゅみ', 'key' => 'shumi', 'example_japanese' => '趣味は読書です', 'example_blocks_json' => ['趣味', 'は', '読書', 'です']],
            ['front' => '日記', 'back' => 'にっき', 'key' => 'nikki', 'example_japanese' => '毎日日記を書きます', 'example_blocks_json' => ['毎日', '日記', 'を', '書きます']],
            ['front' => 'お祈り', 'back' => 'おい祈り', 'key' => 'oinori', 'example_japanese' => 'お祈りをします', 'example_blocks_json' => ['お祈り', 'を', 'します']],
            ['front' => '課長', 'back' => 'かちょう', 'key' => 'kachou', 'example_japanese' => '課長に聞きます', 'example_blocks_json' => ['課長', 'に', '聞きます']],
            ['front' => '部長', 'back' => 'ぶちょう', 'key' => 'buchou', 'example_japanese' => '部長はいますか', 'example_blocks_json' => ['部長', 'は', 'います', 'か']],
            ['front' => '社長', 'back' => 'しゃちょう', 'key' => 'shachou', 'example_japanese' => '社長の部屋', 'example_blocks_json' => ['社長', 'の', '部屋']],
            ['front' => '動物', 'back' => 'どうぶつ', 'key' => 'doubutsu', 'example_japanese' => '動物が好きです', 'example_blocks_json' => ['動物', 'が', '好き', 'です']],
            ['front' => '馬', 'back' => 'うま', 'key' => 'uma', 'example_japanese' => '馬に乗ります', 'example_blocks_json' => ['馬', 'に', '乗ります']],
            ['front' => 'へえ', 'back' => 'へえ', 'key' => 'hee', 'example_japanese' => 'へえ、すごいですね', 'example_blocks_json' => ['へえ', '、', 'すごい', 'ですね']],
            ['front' => 'それは面白いですね', 'back' => 'それはおもしろいですね', 'key' => 'sorehaomoshiroidesune', 'example_japanese' => 'それは面白いですね', 'example_blocks_json' => ['それ', 'は', '面白い', 'ですね']],
            ['front' => 'なかなか', 'back' => 'なかなか', 'key' => 'nakanaka', 'example_japanese' => 'なかなかできません', 'example_blocks_json' => ['なかなか', 'できません']],
            ['front' => 'ぜひ', 'back' => 'ぜひ', 'key' => 'zehi', 'example_japanese' => 'ぜひ来てください', 'example_blocks_json' => ['ぜひ', '来て', 'ください']],
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
                    'back_text' => "N5.lesson18.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson18.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
