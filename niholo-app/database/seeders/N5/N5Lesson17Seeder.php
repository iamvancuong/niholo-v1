<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson17Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 17],
            [
                'title' => 'N5.lesson17.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson17.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '覚えます', 'back' => 'おぼえます', 'key' => 'oboemasu', 'example_japanese' => '漢字を覚えます', 'example_blocks_json' => ['漢字', 'を', '覚えます']],
            ['front' => '忘れます', 'back' => 'わすれます', 'key' => 'wasuremasu', 'example_japanese' => '傘を忘れました', 'example_blocks_json' => ['傘', 'を', '忘れました']],
            ['front' => 'なくします', 'back' => 'なくします', 'key' => 'nakushimasu', 'example_japanese' => '時計をなくしました', 'example_blocks_json' => ['時計', 'を', 'なくしました']],
            ['front' => '払います', 'back' => 'はらいます', 'key' => 'haraimasu', 'example_japanese' => 'お金を払います', 'example_blocks_json' => ['お金', 'を', '払います']],
            ['front' => '返します', 'back' => 'かえします', 'key' => 'kaeshimasu', 'example_japanese' => '本を返します', 'example_blocks_json' => ['本', 'を', '返します']],
            ['front' => '出かけます', 'back' => 'でかけます', 'key' => 'dekakemasu', 'example_japanese' => '買い物に出かけます', 'example_blocks_json' => ['買い物', 'に', '出かけます']],
            ['front' => '脱ぎます', 'back' => 'ぬぎます', 'key' => 'nugimasu', 'example_japanese' => '靴を脱ぎます', 'example_blocks_json' => ['靴', 'を', '脱ぎます']],
            ['front' => '持って行きます', 'back' => 'もっていきます', 'key' => 'motteikimasu', 'example_japanese' => '傘を持って行きます', 'example_blocks_json' => ['傘', 'を', '持って行きます']],
            ['front' => '持って来ます', 'back' => 'もってきます', 'key' => 'mottekimasu', 'example_japanese' => '友達を連れて来ます', 'example_blocks_json' => ['友達', 'を', '連れて来ます']],
            ['front' => '心配します', 'back' => 'しんぱいします', 'key' => 'shinpaishimasu', 'example_japanese' => '心配しないでください', 'example_blocks_json' => ['心配しない', 'で', 'ください']],
            ['front' => '残業します', 'back' => 'ざんぎょうします', 'key' => 'zangyoushimasu', 'example_japanese' => '今日は残業します', 'example_blocks_json' => ['今日', 'は', '残業します']],
            ['front' => '出張します', 'back' => 'しゅっちょうします', 'key' => 'shucchoushimasu', 'example_japanese' => '東京へ出張します', 'example_blocks_json' => ['東京', 'へ', '出張します']],
            ['front' => '飲みます（薬を～）', 'back' => 'のみます', 'key' => 'nomimasu_kusuri', 'example_japanese' => '薬を飲みます', 'example_blocks_json' => ['薬', 'を', '飲みます']],
            ['front' => '入ります（お風呂に～）', 'back' => 'はいります', 'key' => 'hairimasu_ofuro', 'example_japanese' => 'お風呂に入ります', 'example_blocks_json' => ['お風呂', 'に', '入ります']],
            ['front' => '大切（な）', 'back' => 'たいせつ（な）', 'key' => 'taisetsu', 'example_japanese' => '大切な書類', 'example_blocks_json' => ['大切', 'な', '書類']],
            ['front' => '大丈夫（な）', 'back' => 'だいじょうぶ（な）', 'key' => 'daijoubu', 'example_japanese' => '大丈夫ですか', 'example_blocks_json' => ['大丈夫', 'ですか']],
            ['front' => '危ない', 'back' => 'あぶない', 'key' => 'abunai', 'example_japanese' => 'ここは危ないです', 'example_blocks_json' => ['ここ', 'は', '危ない', 'です']],
            ['front' => '禁煙', 'back' => 'きんえん', 'key' => 'kinen', 'example_japanese' => 'ここは禁煙です', 'example_blocks_json' => ['ここ', 'は', '禁煙', 'です']],
            ['front' => '健康保険証', 'back' => 'けんこうほけんしょう', 'key' => 'kenkouhokenshou', 'example_japanese' => '健康保険証を見せてください', 'example_blocks_json' => ['健康保険証', 'を', '見せて', 'ください']],
            ['front' => '熱', 'back' => 'ねつ', 'key' => 'netsu', 'example_japanese' => '熱があります', 'example_blocks_json' => ['熱', 'が', 'あります']],
            ['front' => '病気', 'back' => 'びょうき', 'key' => 'byouki', 'example_japanese' => '病気になりました', 'example_blocks_json' => ['病気', 'に', 'なりました']],
            ['front' => '薬', 'back' => 'くすり', 'key' => 'kusuri', 'example_japanese' => '薬を買います', 'example_blocks_json' => ['薬', 'を', '買います']],
            ['front' => 'お風呂', 'back' => 'おふろ', 'key' => 'ofuro', 'example_japanese' => 'お風呂が好きです', 'example_blocks_json' => ['お風呂', 'が', '好き', 'です']],
            ['front' => '上着', 'back' => 'うわぎ', 'key' => 'uwagi', 'example_japanese' => '上着を着ます', 'example_blocks_json' => ['上着', 'を', '着ます']],
            ['front' => '下着', 'back' => 'したぎ', 'key' => 'shitagi', 'example_japanese' => '下着を洗います', 'example_blocks_json' => ['下着', 'を', '洗います']],
            ['front' => '２、３日', 'back' => 'に、さんにち', 'key' => 'nisannichi', 'example_japanese' => '２、３日休みます', 'example_blocks_json' => ['２、３日', '休みます']],
            ['front' => '２、３～', 'back' => 'に、さん～', 'key' => 'nisan', 'example_japanese' => '２、３回行きました', 'example_blocks_json' => ['２、３回', '行きました']],
            ['front' => '～までに', 'back' => '～までに', 'key' => 'madeni', 'example_japanese' => '明日までに提出してください', 'example_blocks_json' => ['明日', 'までに', '提出して', 'ください']],
            ['front' => 'ですから', 'back' => 'ですから', 'key' => 'desukara', 'example_japanese' => 'ですから、ダメです', 'example_blocks_json' => ['ですから', '、', 'ダメ', 'です']],
            ['front' => 'どうしましたか', 'back' => 'どうしましたか', 'key' => 'doushimashitaka', 'example_japanese' => 'どうしましたか', 'example_blocks_json' => ['どうしましたか']],
            ['front' => '痛い', 'back' => 'いたい', 'key' => 'itai', 'example_japanese' => 'お腹が痛いです', 'example_blocks_json' => ['お腹', 'が', '痛い', 'です']],
            ['front' => 'お大事に', 'back' => 'おだいじに', 'key' => 'odaijini', 'example_japanese' => 'お大事に', 'example_blocks_json' => ['お大事に']],
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
                    'back_text' => "N5.lesson17.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson17.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
