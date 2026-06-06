<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson5Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 5],
            [
                'title' => 'N5.lesson5.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson5.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '行きます', 'back' => 'いきます', 'key' => 'ikimasu', 'example_japanese' => '明日、学校へ行きます', 'example_blocks_json' => ["明日","、","学校","へ","行きます"]],
            ['front' => '来ます', 'back' => 'きます', 'key' => 'kimasu', 'example_japanese' => '日本へ来ました', 'example_blocks_json' => ["日本","へ","来ました"]],
            ['front' => '帰ります', 'back' => 'かえります', 'key' => 'kaerimasu', 'example_japanese' => 'うちへ帰ります', 'example_blocks_json' => ["うち","へ","帰ります"]],
            ['front' => '飛行機', 'back' => 'ひこうき', 'key' => 'hikouki', 'example_japanese' => '飛行機で行きます', 'example_blocks_json' => ["飛行機","で","行きます"]],
            ['front' => '船', 'back' => 'ふね', 'key' => 'fune', 'example_japanese' => '船で来ました', 'example_blocks_json' => ["船","で","来ました"]],
            ['front' => '電車', 'back' => 'でんしゃ', 'key' => 'densha', 'example_japanese' => '電車で帰ります', 'example_blocks_json' => ["電車","で","帰ります"]],
            ['front' => '地下鉄', 'back' => 'ちかてつ', 'key' => 'chikatetsu', 'example_japanese' => '地下鉄で行きます', 'example_blocks_json' => ["地下鉄","で","行きます"]],
            ['front' => '新幹線', 'back' => 'しんかんせん', 'key' => 'shinkansen', 'example_japanese' => '新幹線は速いです', 'example_blocks_json' => ["新幹線","は","速い","です"]],
            ['front' => 'バス', 'back' => 'バス', 'key' => 'basu', 'example_japanese' => 'バスで学校へ行きます', 'example_blocks_json' => ["バス","で","学校","へ","行きます"]],
            ['front' => 'タクシー', 'back' => 'タクシー', 'key' => 'takushii', 'example_japanese' => 'タクシーで帰ります', 'example_blocks_json' => ["タクシー","で","帰ります"]],
            ['front' => '自転車', 'back' => 'じてんしゃ', 'key' => 'jitensha', 'example_japanese' => '自転車で行きます', 'example_blocks_json' => ["自転車","で","行きます"]],
            ['front' => '歩いて', 'back' => 'あるいて', 'key' => 'aruite', 'example_japanese' => '歩いて家へ帰ります', 'example_blocks_json' => ["歩いて","家","へ","帰ります"]],
            ['front' => '学校', 'back' => 'がっこう', 'key' => 'gakkou', 'example_japanese' => '学校へ行きます', 'example_blocks_json' => ["学校","へ","行きます"]],
            ['front' => 'スーパー', 'back' => 'スーパー', 'key' => 'suupaa', 'example_japanese' => 'スーパーへ行きます', 'example_blocks_json' => ["スーパー","へ","行きます"]],
            ['front' => '駅', 'back' => 'えき', 'key' => 'eki', 'example_japanese' => '駅で友達に会います', 'example_blocks_json' => ["駅","で","友達","に","会います"]],
            ['front' => '友達', 'back' => 'ともだち', 'key' => 'tomodachi', 'example_japanese' => '友達と行きます', 'example_blocks_json' => ["友達","と","行きます"]],
            ['front' => '家族', 'back' => 'かぞく', 'key' => 'kazoku', 'example_japanese' => '家族と来ました', 'example_blocks_json' => ["家族","と","来ました"]],
            ['front' => '一人で', 'back' => 'ひとりで', 'key' => 'hitoride', 'example_japanese' => '一人で帰ります', 'example_blocks_json' => ["一人で","帰ります"]],
            ['front' => '先週', 'back' => 'せんしゅう', 'key' => 'senshuu', 'example_japanese' => '先週日本へ来ました', 'example_blocks_json' => ["先週","日本","へ","来ました"]],
            ['front' => '今週', 'back' => 'こんしゅう', 'key' => 'konshuu', 'example_japanese' => '今週は忙しいです', 'example_blocks_json' => ["今週","は","忙しい","です"]],
            ['front' => '来週', 'back' => 'らいしゅう', 'key' => 'raishuu', 'example_japanese' => '来週国へ帰ります', 'example_blocks_json' => ["来週","国","へ","帰ります"]],
            ['front' => '先月', 'back' => 'せんげつ', 'key' => 'sengetsu', 'example_japanese' => '先月日本へ来ました', 'example_blocks_json' => ["先月","日本","へ","来ました"]],
            ['front' => '今月', 'back' => 'こんげつ', 'key' => 'kongetsu', 'example_japanese' => '今月は休みが多いです', 'example_blocks_json' => ["今月","は","休み","が","多い","です"]],
            ['front' => '来月', 'back' => 'らいげつ', 'key' => 'raigetsu', 'example_japanese' => '来月試験があります', 'example_blocks_json' => ["来月","試験","が","あります"]],
            ['front' => '去年', 'back' => 'きょねん', 'key' => 'kyonen', 'example_japanese' => '去年日本へ来ました', 'example_blocks_json' => ["去年","日本","へ","来ました"]],
            ['front' => '今年', 'back' => 'ことし', 'key' => 'kotoshi', 'example_japanese' => '今年は暑いです', 'example_blocks_json' => ["今年","は","暑い","です"]],
            ['front' => '来年', 'back' => 'らいねん', 'key' => 'rainen', 'example_japanese' => '来年国へ帰ります', 'example_blocks_json' => ["来年","国","へ","帰ります"]],
            ['front' => '何月', 'back' => 'なんがつ', 'key' => 'nangatsu', 'example_japanese' => '今何月ですか', 'example_blocks_json' => ["今","何月","ですか"]],
            ['front' => '何日', 'back' => 'なんにち', 'key' => 'nannichi', 'example_japanese' => '何日かかりますか', 'example_blocks_json' => ["何日","かかりますか"]],
            ['front' => 'いつ', 'back' => 'いつ', 'key' => 'itsu', 'example_japanese' => 'いつ日本へ来ましたか', 'example_blocks_json' => ["いつ","日本","へ","来ました","か"]],
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
                    'back_text' => "N5.lesson5.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson5.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}