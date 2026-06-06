<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson15Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 15],
            [
                'title' => 'N5.lesson15.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson15.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '置きます', 'back' => 'おきます', 'key' => 'okimasu', 'example_japanese' => 'ここに荷物を置きます', 'example_blocks_json' => ['ここ', 'に', '荷物', 'を', '置きます']],
            ['front' => '作ります', 'back' => 'つくる', 'key' => 'tsukurimasu', 'example_japanese' => '会社で車を作っています', 'example_blocks_json' => ['会社', 'で', '車', 'を', '作っています']],
            ['front' => '売ります', 'back' => 'うります', 'key' => 'urimasu', 'example_japanese' => 'スーパーでパンを売っています', 'example_blocks_json' => ['スーパー', 'で', 'パン', 'を', '売っています']],
            ['front' => '知ります', 'back' => 'しります', 'key' => 'shirimasu', 'example_japanese' => 'そのニュースを知りました', 'example_blocks_json' => ['その', 'ニュース', 'を', '知りました']],
            ['front' => '住みます', 'back' => 'すみます', 'key' => 'sumimasu', 'example_japanese' => '大阪に住みます', 'example_blocks_json' => ['大阪', 'に', '住みます']],
            ['front' => '研究します', 'back' => 'けんきゅうします', 'key' => 'kenkyuushimasu', 'example_japanese' => '大学で経済を研究しています', 'example_blocks_json' => ['大学', 'で', '経済', 'を', '研究しています']],
            ['front' => '知っています', 'back' => 'しっています', 'key' => 'shitteimasu', 'example_japanese' => '彼の名前を知っています', 'example_blocks_json' => ['彼', 'の', '名前', 'を', '知っています']],
            ['front' => '住んでいます', 'back' => 'すんでいます', 'key' => 'sundeimasu', 'example_japanese' => '東京に住んでいます', 'example_blocks_json' => ['東京', 'に', '住んでいます']],
            ['front' => '資料', 'back' => 'しりょう', 'key' => 'shiryou', 'example_japanese' => '会議の資料', 'example_blocks_json' => ['会議', 'の', '資料']],
            ['front' => 'カタログ', 'back' => 'カタログ', 'key' => 'katarogu', 'example_japanese' => '車のカタログ', 'example_blocks_json' => ['車', 'の', 'カタログ']],
            ['front' => '時刻表', 'back' => 'じこくひょう', 'key' => 'jikokuhyou', 'example_japanese' => '電車の時刻表', 'example_blocks_json' => ['電車', 'の', '時刻表']],
            ['front' => '服', 'back' => 'ふく', 'key' => 'fuku', 'example_japanese' => '新しい服を買います', 'example_blocks_json' => ['新しい', '服', 'を', '買います']],
            ['front' => '製品', 'back' => 'せいひん', 'key' => 'seihin', 'example_japanese' => '日本の製品', 'example_blocks_json' => ['日本', 'の', '製品']],
            ['front' => 'ソフト', 'back' => 'ソフト', 'key' => 'sofuto', 'example_japanese' => 'コンピューターのソフト', 'example_blocks_json' => ['コンピューター', 'の', 'ソフト']],
            ['front' => '専門', 'back' => 'せんもん', 'key' => 'senmon', 'example_japanese' => '専門は経済です', 'example_blocks_json' => ['専門', 'は', '経済', 'です']],
            ['front' => '歯医者', 'back' => 'はいしゃ', 'key' => 'haisha', 'example_japanese' => '歯医者へ行きます', 'example_blocks_json' => ['歯医者', 'へ', '行きます']],
            ['front' => '床屋', 'back' => 'とこや', 'key' => 'tokoya', 'example_japanese' => '床屋で髪を切ります', 'example_blocks_json' => ['床屋', 'で', '髪', 'を', '切ります']],
            ['front' => 'プレイガイド', 'back' => 'プレイガイド', 'key' => 'pureigaido', 'example_japanese' => 'プレイガイドでチケットを買います', 'example_blocks_json' => ['プレイガイド', 'で', 'チケット', 'を', '買います']],
            ['front' => '独身', 'back' => 'どくしん', 'key' => 'dokushin', 'example_japanese' => '私は独身です', 'example_blocks_json' => ['私', 'は', '独身', 'です']],
            ['front' => '特に', 'back' => 'とくに', 'key' => 'tokuni', 'example_japanese' => '特にスポーツが好きです', 'example_blocks_json' => ['特に', 'スポーツ', 'が', '好き', 'です']],
            ['front' => '思い出します', 'back' => 'おもいだします', 'key' => 'omoidashimasu', 'example_japanese' => '家族を思い出します', 'example_blocks_json' => ['家族', 'を', '思い出します']],
            ['front' => 'ご家族', 'back' => 'ごかぞく', 'key' => 'gokazoku', 'example_japanese' => 'ご家族はお元気ですか', 'example_blocks_json' => ['ご家族', 'は', 'お元気', 'ですか']],
            ['front' => 'いらっしゃいます', 'back' => 'いらっしゃいます', 'key' => 'irasshaimasu', 'example_japanese' => 'ご両親はどちらにいらっしゃいますか', 'example_blocks_json' => ['ご両親', 'は', 'どちら', 'に', 'いらっしゃいます', 'か']],
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
                    'back_text' => "N5.lesson15.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson15.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
