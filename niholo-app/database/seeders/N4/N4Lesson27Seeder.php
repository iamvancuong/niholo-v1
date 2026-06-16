<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson27Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 27],
            [
                'title' => 'N4.lesson27.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson27.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '飼います', 'back' => 'かいます', 'key' => 'kaimasu', 'example_japanese' => '犬を飼います', 'example_blocks_json' => ['犬', 'を', '飼います']],
            ['front' => '建てます', 'back' => 'たてます', 'key' => 'tatemasu', 'example_japanese' => '家を建てます', 'example_blocks_json' => ['家', 'を', '建てます']],
            ['front' => '走ります', 'back' => 'はしります', 'key' => 'hashirimasu', 'example_japanese' => '道を走ります', 'example_blocks_json' => ['道', 'を', '走ります']],
            ['front' => '取ります', 'back' => 'とります', 'key' => 'torimasu', 'example_japanese' => '休みを取ります', 'example_blocks_json' => ['休み', 'を', '取ります']],
            ['front' => '見えます', 'back' => 'みえます', 'key' => 'miemasu', 'example_japanese' => '山が見えます', 'example_blocks_json' => ['山', 'が', '見えます']],
            ['front' => '聞こえます', 'back' => 'きこえます', 'key' => 'kikoemasu', 'example_japanese' => '音が聞こえます', 'example_blocks_json' => ['音', 'が', '聞こえます']],
            ['front' => 'できます', 'back' => 'できます', 'key' => 'dekimasu', 'example_japanese' => '空港ができます', 'example_blocks_json' => ['空港', 'が', 'できます']],
            ['front' => '開きます', 'back' => 'ひらきます', 'key' => 'hirakimasu', 'example_japanese' => '教室を開きます', 'example_blocks_json' => ['教室', 'を', '開きます']],
            ['front' => 'ペット', 'back' => 'ペット', 'key' => 'petto', 'example_japanese' => 'ペットを飼います', 'example_blocks_json' => ['ペット', 'を', '飼います']],
            ['front' => '鳥', 'back' => 'とり', 'key' => 'tori', 'example_japanese' => '鳥がいます', 'example_blocks_json' => ['鳥', 'が', 'います']],
            ['front' => '声', 'back' => 'こえ', 'key' => 'koe', 'example_japanese' => '大きい声です', 'example_blocks_json' => ['大きい', '声', 'です']],
            ['front' => '波', 'back' => 'なみ', 'key' => 'nami', 'example_japanese' => '波が高いです', 'example_blocks_json' => ['波', 'が', '高い', 'です']],
            ['front' => '花火', 'back' => 'はなび', 'key' => 'hanabi', 'example_japanese' => '花火を見ます', 'example_blocks_json' => ['花火', 'を', '見ます']],
            ['front' => '景色', 'back' => 'けしき', 'key' => 'keshiki', 'example_japanese' => '景色がいいです', 'example_blocks_json' => ['景色', 'が', 'いい', 'です']],
            ['front' => '昼間', 'back' => 'ひるま', 'key' => 'hiruma', 'example_japanese' => '昼間は暑いです', 'example_blocks_json' => ['昼間', 'は', '暑い', 'です']],
            ['front' => '昔', 'back' => 'むかし', 'key' => 'mukashi', 'example_japanese' => '昔の友達', 'example_blocks_json' => ['昔', 'の', '友達']],
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
                    'back_text' => "N4.lesson27.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson27.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
