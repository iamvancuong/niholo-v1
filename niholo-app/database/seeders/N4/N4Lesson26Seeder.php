<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson26Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        // Lesson 26 là bài đầu tiên của Minna 2 (N4)
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 26],
            [
                'title' => 'N4.lesson26.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson26.grammar_focus',
                'is_published' => true,
            ]
        );

        // Danh sách từ vựng bài 26 (Minna no Nihongo)
        $vocab = [
            ['front' => '見ます / 診ます', 'back' => 'みます', 'key' => 'mimasu', 'example_japanese' => '医者に診てもらいます', 'example_blocks_json' => ['医者', 'に', '診て', 'もらいます']],
            ['front' => '探します / 捜します', 'back' => 'さがします', 'key' => 'sagashimasu', 'example_japanese' => 'かぎを探します', 'example_blocks_json' => ['かぎ', 'を', '探します']],
            ['front' => '遅れます', 'back' => 'おくれます', 'key' => 'okuremasu', 'example_japanese' => '時間に遅れます', 'example_blocks_json' => ['時間', 'に', '遅れます']],
            ['front' => '間に合います', 'back' => 'まにあいます', 'key' => 'maniaimasu', 'example_japanese' => '電車に間に合います', 'example_blocks_json' => ['電車', 'に', '間に合います']],
            ['front' => 'やります', 'back' => 'やります', 'key' => 'yarimasu', 'example_japanese' => 'パーティーをやります', 'example_blocks_json' => ['パーティー', 'を', 'やります']],
            ['front' => '参加します', 'back' => 'さんかします', 'key' => 'sankashimasu', 'example_japanese' => 'パーティーに参加します', 'example_blocks_json' => ['パーティー', 'に', '参加します']],
            ['front' => '申し込みます', 'back' => 'もうしこみます', 'key' => 'moushikomimasu', 'example_japanese' => '試験を申し込みます', 'example_blocks_json' => ['試験', 'を', '申し込みます']],
            ['front' => '都合がいい', 'back' => 'つごうがいい', 'key' => 'tsugougaii', 'example_japanese' => '明日は都合がいいです', 'example_blocks_json' => ['明日', 'は', '都合がいい', 'です']],
            ['front' => '都合が悪い', 'back' => 'つごうがわるい', 'key' => 'tsugougawarui', 'example_japanese' => '今日は都合が悪い', 'example_blocks_json' => ['今日', 'は', '都合が悪い']],
            ['front' => '気分がいい', 'back' => 'きぶんがいい', 'key' => 'kibungaii', 'example_japanese' => '気分がいいです', 'example_blocks_json' => ['気分がいい', 'です']],
            ['front' => '気分が悪い', 'back' => 'きぶんがわるい', 'key' => 'kibungawarui', 'example_japanese' => '気分が悪いです', 'example_blocks_json' => ['気分が悪い', 'です']],
            ['front' => '新聞社', 'back' => 'しんぶんしゃ', 'key' => 'shinbunsha', 'example_japanese' => '新聞社で働きます', 'example_blocks_json' => ['新聞社', 'で', '働きます']],
            ['front' => '柔道', 'back' => 'じゅうどう', 'key' => 'juudou', 'example_japanese' => '柔道を習います', 'example_blocks_json' => ['柔道', 'を', '習います']],
            ['front' => '運動会', 'back' => 'うんどうかい', 'key' => 'undoukai', 'example_japanese' => '運動会に行きます', 'example_blocks_json' => ['運動会', 'に', '行きます']],
            ['front' => '場所', 'back' => 'ばしょ', 'key' => 'basho', 'example_japanese' => '場所を教えてください', 'example_blocks_json' => ['場所', 'を', '教えて', 'ください']],
            ['front' => 'ボランティア', 'back' => 'ボランティア', 'key' => 'borantia', 'example_japanese' => 'ボランティアをします', 'example_blocks_json' => ['ボランティア', 'を', 'します']],
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
                    'back_text' => "N4.lesson26.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson26.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
