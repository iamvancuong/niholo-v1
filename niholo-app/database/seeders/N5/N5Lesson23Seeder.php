<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson23Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 23],
            [
                'title' => 'N5.lesson23.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson23.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '聞きます', 'back' => 'ききます', 'key' => 'kikimasu_sensei', 'example_japanese' => '先生に聞きます', 'example_blocks_json' => ['先生', 'に', '聞きます']],
            ['front' => '回します', 'back' => 'まわします', 'key' => 'mawashimasu', 'example_japanese' => 'つまみを回します', 'example_blocks_json' => ['つまみ', 'を', '回します']],
            ['front' => '引きます', 'back' => 'ひきます', 'key' => 'hikimasu_23', 'example_japanese' => 'ドアを引きます', 'example_blocks_json' => ['ドア', 'を', '引きます']],
            ['front' => '変えます', 'back' => 'かえます', 'key' => 'kaemasu', 'example_japanese' => 'サイズを変えます', 'example_blocks_json' => ['サイズ', 'を', '変えます']],
            ['front' => '触ります', 'back' => 'さわります', 'key' => 'sawarimasu', 'example_japanese' => 'ドアに触ります', 'example_blocks_json' => ['ドア', 'に', '触ります']],
            ['front' => '出ます', 'back' => 'でます', 'key' => 'demasu_otsuri', 'example_japanese' => 'お釣りが出ます', 'example_blocks_json' => ['お釣り', 'が', '出ます']],
            ['front' => '動きます', 'back' => 'うごきます', 'key' => 'ugokimasu', 'example_japanese' => '時計が動きます', 'example_blocks_json' => ['時計', 'が', '動きます']],
            ['front' => '歩きます', 'back' => 'あるきます', 'key' => 'arukimasu', 'example_japanese' => '道を歩きます', 'example_blocks_json' => ['道', 'を', '歩きます']],
            ['front' => '渡ります', 'back' => 'わたります', 'key' => 'watarimasu', 'example_japanese' => '橋を渡ります', 'example_blocks_json' => ['橋', 'を', '渡ります']],
            ['front' => '曲がります', 'back' => 'まがります', 'key' => 'magarimasu', 'example_japanese' => '右へ曲がります', 'example_blocks_json' => ['右', 'へ', '曲がります']],
            ['front' => '気をつけます', 'back' => 'きをつけます', 'key' => 'kiotsukemasu', 'example_japanese' => '車に気をつけます', 'example_blocks_json' => ['車', 'に', '気をつけます']],
            ['front' => '引っ越しします', 'back' => 'ひっこしします', 'key' => 'hikkoshishimasu', 'example_japanese' => '東京へ引っ越しします', 'example_blocks_json' => ['東京', 'へ', '引っ越しします']],
            ['front' => '道', 'back' => 'みち', 'key' => 'michi', 'example_japanese' => '道を歩きます', 'example_blocks_json' => ['道', 'を', '歩きます']],
            ['front' => '交差点', 'back' => 'こうさてん', 'key' => 'kousaten', 'example_japanese' => '交差点を左へ曲がります', 'example_blocks_json' => ['交差点', 'を', '左', 'へ', '曲がります']],
            ['front' => '信号', 'back' => 'しんごう', 'key' => 'shingou', 'example_japanese' => '信号が赤です', 'example_blocks_json' => ['信号', 'が', '赤', 'です']],
            ['front' => '角', 'back' => 'かど', 'key' => 'kado', 'example_japanese' => '角を曲がります', 'example_blocks_json' => ['角', 'を', '曲がります']],
            ['front' => '橋', 'back' => 'はし', 'key' => 'hashi', 'example_japanese' => '橋を渡ります', 'example_blocks_json' => ['橋', 'を', '渡ります']],
            ['front' => '駐車場', 'back' => 'ちゅうしゃじょう', 'key' => 'chuushajou', 'example_japanese' => '駐車場に車を止めます', 'example_blocks_json' => ['駐車場', 'に', '車', 'を', '止めます']],
            ['front' => '建物', 'back' => 'たてもの', 'key' => 'tatemono', 'example_japanese' => '高い建物', 'example_blocks_json' => ['高い', '建物']],
            ['front' => '～目', 'back' => '～め', 'key' => 'nandome', 'example_japanese' => '２つ目の交差点', 'example_blocks_json' => ['２つ目', 'の', '交差点']],
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
                    'back_text' => "N5.lesson23.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson23.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
