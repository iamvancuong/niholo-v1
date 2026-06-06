<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson8Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 8],
            [
                'title' => 'N5.lesson8.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson8.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'ハンサム（な）', 'back' => 'ハンサム（な）', 'key' => 'hansamu', 'example_japanese' => '彼はハンサムです', 'example_blocks_json' => ['彼', 'は', 'ハンサム', 'です']],
            ['front' => 'きれい（な）', 'back' => 'きれい（な）', 'key' => 'kirei', 'example_japanese' => 'きれいな花です', 'example_blocks_json' => ['きれい', 'な', '花', 'です']],
            ['front' => '静か（な）', 'back' => 'しずか（な）', 'key' => 'shizuka', 'example_japanese' => 'ここは静かです', 'example_blocks_json' => ['ここ', 'は', '静か', 'です']],
            ['front' => 'にぎやか（な）', 'back' => 'にぎやか（な）', 'key' => 'nigiyaka', 'example_japanese' => '町はにぎやかです', 'example_blocks_json' => ['町', 'は', 'にぎやか', 'です']],
            ['front' => '有名（な）', 'back' => 'ゆうめい（な）', 'key' => 'yuumei', 'example_japanese' => '有名なレストランです', 'example_blocks_json' => ['有名', 'な', 'レストラン', 'です']],
            ['front' => '親切（な）', 'back' => 'しんせつ（な）', 'key' => 'shinsetsu', 'example_japanese' => '親切な人です', 'example_blocks_json' => ['親切', 'な', '人', 'です']],
            ['front' => '元気（な）', 'back' => 'げんき（な）', 'key' => 'genki', 'example_japanese' => 'お元気ですか', 'example_blocks_json' => ['お元気', 'ですか']],
            ['front' => '暇（な）', 'back' => 'ひま（な）', 'key' => 'hima', 'example_japanese' => '今日は暇です', 'example_blocks_json' => ['今日', 'は', '暇', 'です']],
            ['front' => '便利（な）', 'back' => 'べんり（な）', 'key' => 'benri', 'example_japanese' => '地下鉄は便利です', 'example_blocks_json' => ['地下鉄', 'は', '便利', 'です']],
            ['front' => '大きい', 'back' => 'おおきい', 'key' => 'ookii', 'example_japanese' => '大きいかばんです', 'example_blocks_json' => ['大きい', 'かばん', 'です']],
            ['front' => '小さい', 'back' => 'ちいさい', 'key' => 'chiisai', 'example_japanese' => '小さい会社です', 'example_blocks_json' => ['小さい', '会社', 'です']],
            ['front' => '新しい', 'back' => 'あたらしい', 'key' => 'atarashii', 'example_japanese' => '新しいカメラ', 'example_blocks_json' => ['新しい', 'カメラ']],
            ['front' => '古い', 'back' => 'ふるい', 'key' => 'furui', 'example_japanese' => '古い車', 'example_blocks_json' => ['古い', '車']],
            ['front' => 'いい', 'back' => 'いい', 'key' => 'ii', 'example_japanese' => 'いい天気ですね', 'example_blocks_json' => ['いい', '天気', 'ですね']],
            ['front' => '悪い', 'back' => 'わるい', 'key' => 'warui', 'example_japanese' => '天気が悪いです', 'example_blocks_json' => ['天気', 'が', '悪い', 'です']],
            ['front' => '暑い', 'back' => 'あつい', 'key' => 'atsui', 'example_japanese' => '今日は暑いです', 'example_blocks_json' => ['今日', 'は', '暑い', 'です']],
            ['front' => '寒い', 'back' => 'さむい', 'key' => 'samui', 'example_japanese' => '日本の冬は寒いです', 'example_blocks_json' => ['日本', 'の', '冬', 'は', '寒い', 'です']],
            ['front' => '難しい', 'back' => 'むずかしい', 'key' => 'muzukashii', 'example_japanese' => '日本語は難しいです', 'example_blocks_json' => ['日本語', 'は', '難しい', 'です']],
            ['front' => '易しい', 'back' => 'やさしい', 'key' => 'yasashii', 'example_japanese' => '易しいテスト', 'example_blocks_json' => ['易しい', 'テスト']],
            ['front' => '高い', 'back' => 'たかい', 'key' => 'takai', 'example_japanese' => 'このカメラは高いです', 'example_blocks_json' => ['この', 'カメラ', 'は', '高い', 'です']],
            ['front' => '安い', 'back' => 'やすい', 'key' => 'yasui', 'example_japanese' => '安いくスーパー', 'example_blocks_json' => ['安い', 'スーパー']],
            ['front' => 'おいしい', 'back' => 'おいしい', 'key' => 'oishii', 'example_japanese' => 'おいしい料理', 'example_blocks_json' => ['おいしい', '料理']],
            ['front' => '忙しい', 'back' => 'いそがしい', 'key' => 'isogashii', 'example_japanese' => '今週は忙しいです', 'example_blocks_json' => ['今週', 'は', '忙しい', 'です']],
            ['front' => '楽しい', 'back' => 'たのしい', 'key' => 'tanoshii', 'example_japanese' => '毎日の生活は楽しいです', 'example_blocks_json' => ['毎日', 'の', '生活', 'は', '楽しい', 'です']],
            ['front' => '桜', 'back' => 'さくら', 'key' => 'sakura', 'example_japanese' => '桜がきれいです', 'example_blocks_json' => ['桜', 'が', 'きれい', 'です']],
            ['front' => '山', 'back' => 'やま', 'key' => 'yama', 'example_japanese' => '高い山', 'example_blocks_json' => ['高い', '山']],
            ['front' => '町', 'back' => 'まち', 'key' => 'machi', 'example_japanese' => '静かな町', 'example_blocks_json' => ['静か', 'な', '町']],
            ['front' => '食べ物', 'back' => 'たべもの', 'key' => 'tabemono', 'example_japanese' => 'ベトナムの食べ物はおいしいです', 'example_blocks_json' => ['ベトナム', 'の', '食べ物', 'は', 'おいしい', 'です']],
            ['front' => '仕事', 'back' => 'しごと', 'key' => 'shigoto', 'example_japanese' => 'お仕事はどうですか', 'example_blocks_json' => ['お仕事', 'は', 'どう', 'ですか']],
            ['front' => 'どう', 'back' => 'どう', 'key' => 'dou', 'example_japanese' => '日本の生活はどうですか', 'example_blocks_json' => ['日本', 'の', '生活', 'は', 'どう', 'ですか']],
            ['front' => 'どんな', 'back' => 'どんな', 'key' => 'donna', 'example_japanese' => 'ハノイはどんな町ですか', 'example_blocks_json' => ['ハノイ', 'は', 'どんな', '町', 'ですか']],
            ['front' => 'とても', 'back' => 'とても', 'key' => 'totemo', 'example_japanese' => 'とても寒いです', 'example_blocks_json' => ['とても', '寒い', 'です']],
            ['front' => 'あまり', 'back' => 'あまり', 'key' => 'amari', 'example_japanese' => 'あまり寒くないです', 'example_blocks_json' => ['あまり', '寒くない', 'です']],
            ['front' => 'そして', 'back' => 'そして', 'key' => 'soshite', 'example_japanese' => '安いです。そして、おいしいです', 'example_blocks_json' => ['安い', 'です', '。', 'そして', '、', 'おいしい', 'です']],
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
                    'back_text' => "N5.lesson8.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson8.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
