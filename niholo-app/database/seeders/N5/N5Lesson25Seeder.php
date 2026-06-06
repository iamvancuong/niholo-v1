<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson25Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 25],
            [
                'title' => 'N5.lesson25.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson25.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '考えます', 'back' => 'かんがえます', 'key' => 'kangaemasu', 'example_japanese' => '問題について考えます', 'example_blocks_json' => ['問題', 'について', '考えます']],
            ['front' => '着きます', 'back' => 'つきます', 'key' => 'tsukimasu_eki', 'example_japanese' => '駅に着きます', 'example_blocks_json' => ['駅', 'に', '着きます']],
            ['front' => '留学します', 'back' => 'りゅうがくします', 'key' => 'ryuugakushimasu', 'example_japanese' => '日本へ留学します', 'example_blocks_json' => ['日本', 'へ', '留学します']],
            ['front' => '取ります', 'back' => 'とります', 'key' => 'torimasu_toshi', 'example_japanese' => '年を取ります', 'example_blocks_json' => ['年', 'を', '取ります']],
            ['front' => '田舎', 'back' => 'いなか', 'key' => 'inaka', 'example_japanese' => '田舎は静かです', 'example_blocks_json' => ['田舎', 'は', '静か', 'です']],
            ['front' => '大使館', 'back' => 'たいしかん', 'key' => 'taishikan', 'example_japanese' => '大使館へ行きます', 'example_blocks_json' => ['大使館', 'へ', '行きます']],
            ['front' => 'チャンス', 'back' => 'チャンス', 'key' => 'chansu', 'example_japanese' => 'いいチャンスですね', 'example_blocks_json' => ['いい', 'チャンス', 'ですね']],
            ['front' => '億', 'back' => 'おく', 'key' => 'oku', 'example_japanese' => '１億円あります', 'example_blocks_json' => ['１億', '円', 'あります']],
            ['front' => 'もし', 'back' => 'もし', 'key' => 'moshi', 'example_japanese' => 'もしお金があったら、家を買います', 'example_blocks_json' => ['もし', 'お金', 'が', 'あったら、', '家', 'を', '買います']],
            ['front' => 'いくら', 'back' => 'いくら', 'key' => 'ikura', 'example_japanese' => 'いくら高くても、買います', 'example_blocks_json' => ['いくら', '高くても、', '買います']],
            ['front' => '転勤', 'back' => 'てんきん', 'key' => 'tenkin', 'example_japanese' => '東京へ転勤します', 'example_blocks_json' => ['東京', 'へ', '転勤します']],
            ['front' => 'こと', 'back' => 'こと', 'key' => 'koto', 'example_japanese' => '色々なことがあります', 'example_blocks_json' => ['色々', 'な', 'こと', 'が', 'あります']],
            ['front' => '頑張ります', 'back' => 'がんばります', 'key' => 'ganbarimasu', 'example_japanese' => 'これからも頑張ります', 'example_blocks_json' => ['これから', 'も', '頑張ります']],
            ['front' => 'どうぞお元気で', 'back' => 'どうぞおげんきで', 'key' => 'douzoogenkide', 'example_japanese' => 'どうぞお元気で', 'example_blocks_json' => ['どうぞお元気で']],
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
                    'back_text' => "N5.lesson25.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson25.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
