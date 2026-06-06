<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson11Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 11],
            [
                'title' => 'N5.lesson11.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson11.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'います（子供が～）', 'back' => 'います', 'key' => 'imasu_kodomo', 'example_japanese' => '子どもが２人います', 'example_blocks_json' => ['子ども', 'が', '２人', 'います']],
            ['front' => 'います（日本に～）', 'back' => 'います', 'key' => 'imasu_nihon', 'example_japanese' => '日本に１年います', 'example_blocks_json' => ['日本', 'に', '１年', 'います']],
            ['front' => 'かかります', 'back' => 'かかります', 'key' => 'kakarimasu', 'example_japanese' => 'バスで１０分かかります', 'example_blocks_json' => ['バス', 'で', '１０分', 'かかります']],
            ['front' => '休みます', 'back' => 'やすみます', 'key' => 'yasumimasu', 'example_japanese' => '会社を休みます', 'example_blocks_json' => ['会社', 'を', '休みます']],
            ['front' => '１つ', 'back' => 'ひとつ', 'key' => 'hitotsu', 'example_japanese' => 'りんごを１つ買います', 'example_blocks_json' => ['りんご', 'を', '１つ', '買います']],
            ['front' => '２つ', 'back' => 'ふたつ', 'key' => 'futatsu', 'example_japanese' => 'みかんを２つ食べます', 'example_blocks_json' => ['みかん', 'を', '２つ', '食べます']],
            ['front' => '３つ', 'back' => 'みっつ', 'key' => 'mittsu', 'example_japanese' => 'いすを３つ並べます', 'example_blocks_json' => ['いす', 'を', '３つ', '並べます']],
            ['front' => '４つ', 'back' => 'よっつ', 'key' => 'yottsu', 'example_japanese' => '机が４つあります', 'example_blocks_json' => ['机', 'が', '４つ', 'あります']],
            ['front' => '５つ', 'back' => 'いつつ', 'key' => 'itsutsu', 'example_japanese' => '星が５つ', 'example_blocks_json' => ['星', 'が', '５つ']],
            ['front' => '６つ', 'back' => 'むっつ', 'key' => 'muttsu', 'example_japanese' => '６つの箱', 'example_blocks_json' => ['６つ', 'の', '箱']],
            ['front' => '７つ', 'back' => 'ななつ', 'key' => 'nanatsu', 'example_japanese' => '７つのお願い', 'example_blocks_json' => ['７つ', 'の', 'お願い']],
            ['front' => '８つ', 'back' => 'やっつ', 'key' => 'yattsu', 'example_japanese' => '８つのドア', 'example_blocks_json' => ['８つ', 'の', 'ドア']],
            ['front' => '９つ', 'back' => 'ここのつ', 'key' => 'kokonotsu', 'example_japanese' => 'りんごが９つ', 'example_blocks_json' => ['りんご', 'が', '９つ']],
            ['front' => '１０', 'back' => 'とお', 'key' => 'too', 'example_japanese' => '卵を１０買いました', 'example_blocks_json' => ['卵', 'を', '１０', '買いました']],
            ['front' => 'いくつ', 'back' => 'いくつ', 'key' => 'ikutsu', 'example_japanese' => 'りんごはいくつですか', 'example_blocks_json' => ['りんご', 'は', 'いくつ', 'ですか']],
            ['front' => '１人', 'back' => 'ひとり', 'key' => 'hitori', 'example_japanese' => '１人で来ました', 'example_blocks_json' => ['１人', 'で', '来ました']],
            ['front' => '２人', 'back' => 'ふたり', 'key' => 'futari', 'example_japanese' => '２人で食べます', 'example_blocks_json' => ['２人', 'で', '食べます']],
            ['front' => '～人', 'back' => '～にん', 'key' => 'nin', 'example_japanese' => '学生が３人います', 'example_blocks_json' => ['学生', 'が', '３人', 'います']],
            ['front' => '～台', 'back' => '～だい', 'key' => 'dai', 'example_japanese' => '車が２台あります', 'example_blocks_json' => ['車', 'が', '２台', 'あります']],
            ['front' => '～枚', 'back' => '～まい', 'key' => 'mai', 'example_japanese' => '切手を３枚買います', 'example_blocks_json' => ['切手', 'を', '３枚', '買います']],
            ['front' => '～回', 'back' => '～かい', 'key' => 'kai', 'example_japanese' => '１週間に２回テニスをします', 'example_blocks_json' => ['１週間', 'に', '２回', 'テニス', 'を', 'します']],
            ['front' => 'りんご', 'back' => 'りんご', 'key' => 'ringo', 'example_japanese' => 'りんごがおいしい', 'example_blocks_json' => ['りんご', 'が', 'おいしい']],
            ['front' => 'みかん', 'back' => 'みかん', 'key' => 'mikan', 'example_japanese' => 'みかんを食べます', 'example_blocks_json' => ['みかん', 'を', '食べます']],
            ['front' => 'サンドイッチ', 'back' => 'サンドイッチ', 'key' => 'sandoitchi', 'example_japanese' => 'サンドイッチを作ります', 'example_blocks_json' => ['サンドイッチ', 'を', '作ります']],
            ['front' => 'カレー（ライス）', 'back' => 'カレー', 'key' => 'karee', 'example_japanese' => 'カレーライスを食べます', 'example_blocks_json' => ['カレーライス', 'を', '食べます']],
            ['front' => 'アイスクリーム', 'back' => 'アイスクリーム', 'key' => 'aisukuriimu', 'example_japanese' => 'アイスクリームが好きです', 'example_blocks_json' => ['アイスクリーム', 'が', '好き', 'です']],
            ['front' => '切手', 'back' => 'きって', 'key' => 'kitte', 'example_japanese' => '切手を貼ります', 'example_blocks_json' => ['切手', 'を', '貼ります']],
            ['front' => 'はがき', 'back' => 'はがき', 'key' => 'hagaki', 'example_japanese' => 'はがきを送ります', 'example_blocks_json' => ['はがき', 'を', '送ります']],
            ['front' => '封筒', 'back' => 'ふうとう', 'key' => 'fuutou', 'example_japanese' => '手紙を封筒に入れます', 'example_blocks_json' => ['手紙', 'を', '封筒', 'に', '入れます']],
            ['front' => '両親', 'back' => 'りょうしん', 'key' => 'ryoushin', 'example_japanese' => '両親に会います', 'example_blocks_json' => ['両親', 'に', '会います']],
            ['front' => '兄弟', 'back' => 'きょうだい', 'key' => 'kyoudai', 'example_japanese' => '兄弟は３人です', 'example_blocks_json' => ['兄弟', 'は', '３人', 'です']],
            ['front' => '兄', 'back' => 'あに', 'key' => 'ani', 'example_japanese' => '兄は医者です', 'example_blocks_json' => ['兄', 'は', '医者', 'です']],
            ['front' => 'お兄さん', 'back' => 'おにいさん', 'key' => 'oniisan', 'example_japanese' => 'お兄さんはお元気ですか', 'example_blocks_json' => ['お兄さん', 'は', 'お元気', 'ですか']],
            ['front' => '姉', 'back' => 'あね', 'key' => 'ane', 'example_japanese' => '姉は会社員です', 'example_blocks_json' => ['姉', 'は', '会社員', 'です']],
            ['front' => 'お姉さん', 'back' => 'おねえさん', 'key' => 'oneesan', 'example_japanese' => 'お姉さんはきれいです', 'example_blocks_json' => ['お姉さん', 'は', 'きれい', 'です']],
            ['front' => '弟', 'back' => 'おとうと', 'key' => 'otouto', 'example_japanese' => '弟は学生です', 'example_blocks_json' => ['弟', 'は', '学生', 'です']],
            ['front' => '弟さん', 'back' => 'おとうとさん', 'key' => 'otoutosan', 'example_japanese' => '弟さんは何歳ですか', 'example_blocks_json' => ['弟さん', 'は', '何歳', 'ですか']],
            ['front' => '妹', 'back' => 'いもうと', 'key' => 'imouto', 'example_japanese' => '妹がいます', 'example_blocks_json' => ['妹', 'が', 'います']],
            ['front' => '妹さん', 'back' => 'いもうとさん', 'key' => 'imoutosan', 'example_japanese' => '妹さんはかわいいですね', 'example_blocks_json' => ['妹さん', 'は', 'かわいい', 'ですね']],
            ['front' => '外国', 'back' => 'がいこく', 'key' => 'gaikoku', 'example_japanese' => '外国へ行きます', 'example_blocks_json' => ['外国', 'へ', '行きます']],
            ['front' => '留学生', 'back' => 'りゅうがくせい', 'key' => 'ryuugakusei', 'example_japanese' => '留学生がたくさんいます', 'example_blocks_json' => ['留学生', 'が', 'たくさん', 'います']],
            ['front' => 'クラス', 'back' => 'クラス', 'key' => 'kurasu', 'example_japanese' => 'クラスに学生がいます', 'example_blocks_json' => ['クラス', 'に', '学生', 'が', 'います']],
            ['front' => '～時間', 'back' => '～じかん', 'key' => 'jikan', 'example_japanese' => '毎日３時間勉強します', 'example_blocks_json' => ['毎日', '３時間', '勉強します']],
            ['front' => '～週間', 'back' => '～しゅうかん', 'key' => 'shuukan', 'example_japanese' => '２週間旅行します', 'example_blocks_json' => ['２週間', '旅行します']],
            ['front' => '～か月', 'back' => '～かげつ', 'key' => 'kagetsu', 'example_japanese' => '１か月日本語を勉強しました', 'example_blocks_json' => ['１か月', '日本語', 'を', '勉強しました']],
            ['front' => '～年', 'back' => '～ねん', 'key' => 'nen', 'example_japanese' => '３年日本にいます', 'example_blocks_json' => ['３年', '日本', 'に', 'います']],
            ['front' => 'どのくらい', 'back' => 'どのくらい', 'key' => 'donokurai', 'example_japanese' => 'どのくらいかかりますか', 'example_blocks_json' => ['どのくらい', 'かかります', 'か']],
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
                    'back_text' => "N5.lesson11.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson11.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
