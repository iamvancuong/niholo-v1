<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson20Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 20],
            [
                'title' => 'N5.lesson20.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson20.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'いります', 'back' => 'いります', 'key' => 'irimasu', 'example_japanese' => 'ビザがいります', 'example_blocks_json' => ['ビザ', 'が', 'いります']],
            ['front' => '調べます', 'back' => 'しらべます', 'key' => 'shirabemasu', 'example_japanese' => 'パソコンで調べます', 'example_blocks_json' => ['パソコン', 'で', '調べます']],
            ['front' => '直します', 'back' => 'なおします', 'key' => 'naoshimasu', 'example_japanese' => '自転車を直します', 'example_blocks_json' => ['自転車', 'を', '直します']],
            ['front' => '修理します', 'back' => 'しゅうりします', 'key' => 'shuurishimasu', 'example_japanese' => '靴を修理します', 'example_blocks_json' => ['靴', 'を', '修理します']],
            ['front' => '電話します', 'back' => 'でんわします', 'key' => 'denwashimasu', 'example_japanese' => '友達に電話します', 'example_blocks_json' => ['友達', 'に', '電話します']],
            ['front' => '僕', 'back' => 'ぼく', 'key' => 'boku', 'example_japanese' => '僕は学生です', 'example_blocks_json' => ['僕', 'は', '学生', 'です']],
            ['front' => '君', 'back' => 'きみ', 'key' => 'kimi', 'example_japanese' => '君はどう思う？', 'example_blocks_json' => ['君', 'は', 'どう', '思う', '？']],
            ['front' => '君たち', 'back' => 'きみたち', 'key' => 'kimitachi', 'example_japanese' => '君たちは何歳？', 'example_blocks_json' => ['君たち', 'は', '何歳', '？']],
            ['front' => 'うん', 'back' => 'うん', 'key' => 'un', 'example_japanese' => 'うん、行くよ', 'example_blocks_json' => ['うん', '、', '行くよ']],
            ['front' => 'ううん', 'back' => 'ううん', 'key' => 'uun', 'example_japanese' => 'ううん、行かない', 'example_blocks_json' => ['ううん', '、', '行かない']],
            ['front' => 'サラリーマン', 'back' => 'サラリーマン', 'key' => 'sarariiman', 'example_japanese' => '父はサラリーマンです', 'example_blocks_json' => ['父', 'は', 'サラリーマン', 'です']],
            ['front' => '言葉', 'back' => 'ことば', 'key' => 'kotoba', 'example_japanese' => '日本の言葉', 'example_blocks_json' => ['日本', 'の', '言葉']],
            ['front' => '物価', 'back' => 'ぶっか', 'key' => 'bukka', 'example_japanese' => '日本の物価は高いです', 'example_blocks_json' => ['日本', 'の', '物価', 'は', '高い', 'です']],
            ['front' => '着物', 'back' => 'きもの', 'key' => 'kimono', 'example_japanese' => '着物を着ます', 'example_blocks_json' => ['着物', 'を', '着ます']],
            ['front' => 'ビザ', 'back' => 'ビザ', 'key' => 'biza', 'example_japanese' => 'ビザがいります', 'example_blocks_json' => ['ビザ', 'が', 'いります']],
            ['front' => '初め', 'back' => 'はじめ', 'key' => 'hajime', 'example_japanese' => '初めは難しいです', 'example_blocks_json' => ['初め', 'は', '難しい', 'です']],
            ['front' => '終わり', 'back' => 'おわり', 'key' => 'owari', 'example_japanese' => '映画の終わり', 'example_blocks_json' => ['映画', 'の', '終わり']],
            ['front' => 'こっち', 'back' => 'こっち', 'key' => 'kotchi', 'example_japanese' => 'こっちへ来てください', 'example_blocks_json' => ['こっち', 'へ', '来て', 'ください']],
            ['front' => 'そっち', 'back' => 'そっち', 'key' => 'sotchi', 'example_japanese' => 'そっちはどうですか', 'example_blocks_json' => ['そっち', 'は', 'どう', 'ですか']],
            ['front' => 'あっち', 'back' => 'あっち', 'key' => 'atchi', 'example_japanese' => 'あっちは暑いです', 'example_blocks_json' => ['あっち', 'は', '暑い', 'です']],
            ['front' => 'どっち', 'back' => 'どっち', 'key' => 'dotchi', 'example_japanese' => 'どっちがいい？', 'example_blocks_json' => ['どっち', 'が', 'いい', '？']],
            ['front' => 'この間', 'back' => 'このあいだ', 'key' => 'konoaida', 'example_japanese' => 'この間、映画を見ました', 'example_blocks_json' => ['この間', '、', '映画', 'を', '見ました']],
            ['front' => 'みんなで', 'back' => 'みんなで', 'key' => 'minnade', 'example_japanese' => 'みんなで食べましょう', 'example_blocks_json' => ['みんな', 'で', '食べましょう']],
            ['front' => '～けど', 'back' => '～けど', 'key' => 'kedo', 'example_japanese' => '行きたいけど、時間がありません', 'example_blocks_json' => ['行きたい', 'けど', '、', '時間', 'が', 'ありません']],
            ['front' => '国へ帰るの？', 'back' => 'くにへかえるの？', 'key' => 'kunihekaeruno', 'example_japanese' => '明日、国へ帰るの？', 'example_blocks_json' => ['明日', '、', '国', 'へ', '帰る', 'の', '？']],
            ['front' => 'どうするの？', 'back' => 'どうするの？', 'key' => 'dousuruno', 'example_japanese' => 'これからどうするの？', 'example_blocks_json' => ['これから', 'どうする', 'の', '？']],
            ['front' => 'どうしようかな', 'back' => 'どうしようかな', 'key' => 'doushiyoukana', 'example_japanese' => 'どうしようかな', 'example_blocks_json' => ['どうしようかな']],
            ['front' => 'よかったら', 'back' => 'よかったら', 'key' => 'yokattara', 'example_japanese' => 'よかったら、一緒に飲みませんか', 'example_blocks_json' => ['よかったら', '、', '一緒', 'に', '飲みません', 'か']],
            ['front' => '色々', 'back' => 'いろいろ', 'key' => 'iroiro_20', 'example_japanese' => '色々ありがとう', 'example_blocks_json' => ['色々', 'ありがとう']],
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
                    'back_text' => "N5.lesson20.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson20.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
