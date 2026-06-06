<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson22Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 22],
            [
                'title' => 'N5.lesson22.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson22.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '着ます', 'back' => 'きます', 'key' => 'kimasu_22', 'example_japanese' => 'シャツを着ます', 'example_blocks_json' => ['シャツ', 'を', '着ます']],
            ['front' => 'はきます', 'back' => 'はきます', 'key' => 'hakimasu', 'example_japanese' => '靴をはきます', 'example_blocks_json' => ['靴', 'を', 'はきます']],
            ['front' => 'かぶります', 'back' => 'かぶります', 'key' => 'kaburimasu', 'example_japanese' => '帽子をかぶります', 'example_blocks_json' => ['帽子', 'を', 'かぶります']],
            ['front' => 'かけます', 'back' => 'かけます', 'key' => 'kakemasu_megane', 'example_japanese' => '眼鏡をかけます', 'example_blocks_json' => ['眼鏡', 'を', 'かけます']],
            ['front' => '生まれます', 'back' => 'うまれます', 'key' => 'umaremasu', 'example_japanese' => '東京で生まれました', 'example_blocks_json' => ['東京', 'で', '生まれました']],
            ['front' => 'コート', 'back' => 'コート', 'key' => 'kooto', 'example_japanese' => 'コートを着ます', 'example_blocks_json' => ['コート', 'を', '着ます']],
            ['front' => 'スーツ', 'back' => 'スーツ', 'key' => 'suutsu', 'example_japanese' => 'スーツを着ます', 'example_blocks_json' => ['スーツ', 'を', '着ます']],
            ['front' => 'セーター', 'back' => 'セーター', 'key' => 'seetaa', 'example_japanese' => 'セーターを着ます', 'example_blocks_json' => ['セーター', 'を', '着ます']],
            ['front' => '帽子', 'back' => 'ぼうし', 'key' => 'boushi', 'example_japanese' => '帽子をかぶります', 'example_blocks_json' => ['帽子', 'を', 'かぶります']],
            ['front' => '眼鏡', 'back' => 'めがね', 'key' => 'megane', 'example_japanese' => '眼鏡をかけます', 'example_blocks_json' => ['眼鏡', 'を', 'かけます']],
            ['front' => 'よく', 'back' => 'よく', 'key' => 'yoku', 'example_japanese' => 'よく映画を見ます', 'example_blocks_json' => ['よく', '映画', 'を', '見ます']],
            ['front' => 'おめでとうございます', 'back' => 'おめでとうございます', 'key' => 'omedetougozaimasu', 'example_japanese' => '誕生日おめでとうございます', 'example_blocks_json' => ['誕生日', 'おめでとうございます']],
            ['front' => 'こちら', 'back' => 'こちら', 'key' => 'kochira', 'example_japanese' => 'こちらは田中さんです', 'example_blocks_json' => ['こちら', 'は', '田中さん', 'です']],
            ['front' => '家賃', 'back' => 'やちん', 'key' => 'yachin', 'example_japanese' => '家賃が高いです', 'example_blocks_json' => ['家賃', 'が', '高い', 'です']],
            ['front' => '和室', 'back' => 'わしつ', 'key' => 'washitsu', 'example_japanese' => '家に和室があります', 'example_blocks_json' => ['家', 'に', '和室', 'が', 'あります']],
            ['front' => '押し入れ', 'back' => 'おしいれ', 'key' => 'oshiire', 'example_japanese' => '押し入れに布団を入れます', 'example_blocks_json' => ['押し入れ', 'に', '布団', 'を', '入れます']],
            ['front' => '布団', 'back' => 'ふとん', 'key' => 'futon', 'example_japanese' => '布団で寝ます', 'example_blocks_json' => ['布団', 'で', '寝ます']],
            ['front' => 'アパート', 'back' => 'アパート', 'key' => 'apaato', 'example_japanese' => 'アパートに住んでいます', 'example_blocks_json' => ['アパート', 'に', '住んでいます']],
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
                    'back_text' => "N5.lesson22.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson22.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
