<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson19Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 19],
            [
                'title' => 'N5.lesson19.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson19.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '登ります', 'back' => 'のぼります', 'key' => 'noborimasu', 'example_japanese' => '山に登ります', 'example_blocks_json' => ['山', 'に', '登ります']],
            ['front' => '泊まります', 'back' => 'とまります', 'key' => 'tomarimasu', 'example_japanese' => 'ホテルに泊まります', 'example_blocks_json' => ['ホテル', 'に', '泊まります']],
            ['front' => '掃除します', 'back' => 'そうじします', 'key' => 'soujishimasu', 'example_japanese' => '部屋を掃除します', 'example_blocks_json' => ['部屋', 'を', '掃除します']],
            ['front' => '洗濯します', 'back' => 'せんたくします', 'key' => 'sentakushimasu', 'example_japanese' => '服を洗濯します', 'example_blocks_json' => ['服', 'を', '洗濯します']],
            ['front' => '練習します', 'back' => 'れんしゅうします', 'key' => 'renshuushimasu', 'example_japanese' => 'ピアノを練習します', 'example_blocks_json' => ['ピアノ', 'を', '練習します']],
            ['front' => 'なります', 'back' => 'なります', 'key' => 'narimasu', 'example_japanese' => '医者になります', 'example_blocks_json' => ['医者', 'に', 'なります']],
            ['front' => '眠い', 'back' => 'ねむい', 'key' => 'nemui', 'example_japanese' => 'とても眠いです', 'example_blocks_json' => ['とても', '眠い', 'です']],
            ['front' => '強い', 'back' => 'つよい', 'key' => 'tsuyoi', 'example_japanese' => '風が強いです', 'example_blocks_json' => ['風', 'が', '強い', 'です']],
            ['front' => '弱い', 'back' => 'よわい', 'key' => 'yowai', 'example_japanese' => '体が弱いです', 'example_blocks_json' => ['体', 'が', '弱い', 'です']],
            ['front' => '調子がいい', 'back' => 'ちょうしがいい', 'key' => 'choushigaii', 'example_japanese' => '今日は調子がいいです', 'example_blocks_json' => ['今日', 'は', '調子', 'が', 'いい', 'です']],
            ['front' => '調子が悪い', 'back' => 'ちょうしがわるい', 'key' => 'choushigawarui', 'example_japanese' => 'パソコンの調子が悪い', 'example_blocks_json' => ['パソコン', 'の', '調子', 'が', '悪い']],
            ['front' => '調子', 'back' => 'ちょうし', 'key' => 'choushi', 'example_japanese' => '調子はどうですか', 'example_blocks_json' => ['調子', 'は', 'どう', 'ですか']],
            ['front' => 'ゴルフ', 'back' => 'ゴルフ', 'key' => 'gorufu', 'example_japanese' => 'ゴルフをします', 'example_blocks_json' => ['ゴルフ', 'を', 'します']],
            ['front' => '相撲', 'back' => 'すもう', 'key' => 'sumou', 'example_japanese' => '相撲を見ます', 'example_blocks_json' => ['相撲', 'を', '見ます']],
            ['front' => 'パチンコ', 'back' => 'パチンコ', 'key' => 'pachinko', 'example_japanese' => 'パチンコに行きます', 'example_blocks_json' => ['パチンコ', 'に', '行きます']],
            ['front' => 'お茶', 'back' => 'おちゃ', 'key' => 'ocha_19', 'example_japanese' => 'お茶を習います', 'example_blocks_json' => ['お茶', 'を', '習います']],
            ['front' => '日', 'back' => 'ひ', 'key' => 'hi', 'example_japanese' => '休みの日', 'example_blocks_json' => ['休み', 'の', '日']],
            ['front' => '一度', 'back' => 'いちど', 'key' => 'ichido', 'example_japanese' => '一度行きました', 'example_blocks_json' => ['一度', '行きました']],
            ['front' => '一度も', 'back' => 'いちども', 'key' => 'ichidomo', 'example_japanese' => '一度も行ったことがありません', 'example_blocks_json' => ['一度も', '行った', 'こと', 'が', 'ありません']],
            ['front' => 'だんだん', 'back' => 'だんだん', 'key' => 'dandan', 'example_japanese' => 'だんだん暖かくなります', 'example_blocks_json' => ['だんだん', '暖かく', 'なります']],
            ['front' => 'もうすぐ', 'back' => 'もうすぐ', 'key' => 'mousugu', 'example_japanese' => 'もうすぐ春になります', 'example_blocks_json' => ['もうすぐ', '春', 'に', 'なります']],
            ['front' => 'おかげさまで', 'back' => 'おかげさまで', 'key' => 'okagesamade', 'example_japanese' => 'おかげさまで元気です', 'example_blocks_json' => ['おかげさまで', '元気', 'です']],
            ['front' => '乾杯', 'back' => 'かんぱい', 'key' => 'kanpai', 'example_japanese' => '乾杯しましょう', 'example_blocks_json' => ['乾杯しましょう']],
            ['front' => '実は', 'back' => 'じつは', 'key' => 'jitsuha', 'example_japanese' => '実は、ダイエットをしています', 'example_blocks_json' => ['実は', '、', 'ダイエット', 'を', 'しています']],
            ['front' => 'ダイエット', 'back' => 'ダイエット', 'key' => 'daietto', 'example_japanese' => 'ダイエットをします', 'example_blocks_json' => ['ダイエット', 'を', 'します']],
            ['front' => '何回も', 'back' => 'なんかいも', 'key' => 'nankaimo', 'example_japanese' => '何回も行きました', 'example_blocks_json' => ['何回も', '行きました']],
            ['front' => 'しかし', 'back' => 'しかし', 'key' => 'shikashi', 'example_japanese' => 'しかし、高いです', 'example_blocks_json' => ['しかし', '、', '高い', 'です']],
            ['front' => '無理（な）', 'back' => 'むり（な）', 'key' => 'muri', 'example_japanese' => '無理なダイエット', 'example_blocks_json' => ['無理', 'な', 'ダイエット']],
            ['front' => '体にいい', 'back' => 'からだにいい', 'key' => 'karadaniii', 'example_japanese' => 'これは体にいいです', 'example_blocks_json' => ['これ', 'は', '体', 'に', 'いい', 'です']],
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
                    'back_text' => "N5.lesson19.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson19.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
