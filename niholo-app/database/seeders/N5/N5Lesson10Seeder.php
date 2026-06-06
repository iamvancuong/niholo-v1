<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson10Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 10],
            [
                'title' => 'N5.lesson10.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson10.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => 'います', 'back' => 'います', 'key' => 'imasu', 'example_japanese' => 'あそこに男の人がいます', 'example_blocks_json' => ['あそこ', 'に', '男の人', 'が', 'います']],
            ['front' => 'あります', 'back' => 'あります', 'key' => 'arimasu', 'example_japanese' => '机の上に本があります', 'example_blocks_json' => ['机', 'の', '上', 'に', '本', 'が', 'あります']],
            ['front' => 'いろいろ（な）', 'back' => 'いろいろ（な）', 'key' => 'iroiro', 'example_japanese' => 'いろいろな物があります', 'example_blocks_json' => ['いろいろ', 'な', '物', 'が', 'あります']],
            ['front' => '男の人', 'back' => 'おとこのひと', 'key' => 'otokonohito', 'example_japanese' => 'あの男の人はだれですか', 'example_blocks_json' => ['あの', '男の人', 'は', 'だれ', 'ですか']],
            ['front' => '女の人', 'back' => 'おんなのひと', 'key' => 'onnanohito', 'example_japanese' => '女の人がいます', 'example_blocks_json' => ['女の人', 'が', 'います']],
            ['front' => '男の子', 'back' => 'おとこのこ', 'key' => 'otokonoko', 'example_japanese' => '男の子が遊んでいます', 'example_blocks_json' => ['男の子', 'が', '遊んでいます']],
            ['front' => '女の子', 'back' => 'おんなのこ', 'key' => 'onnanoko', 'example_japanese' => 'かわいい女の子', 'example_blocks_json' => ['かわいい', '女の子']],
            ['front' => '犬', 'back' => 'いぬ', 'key' => 'inu', 'example_japanese' => '犬がいます', 'example_blocks_json' => ['犬', 'が', 'います']],
            ['front' => '猫', 'back' => 'ねこ', 'key' => 'neko', 'example_japanese' => '猫が好きです', 'example_blocks_json' => ['猫', 'が', '好き', 'です']],
            ['front' => '木', 'back' => 'き', 'key' => 'ki', 'example_japanese' => '木の下に猫がいます', 'example_blocks_json' => ['木', 'の', '下', 'に', '猫', 'が', 'います']],
            ['front' => '物', 'back' => 'もの', 'key' => 'mono', 'example_japanese' => 'おいしい物', 'example_blocks_json' => ['おいしい', '物']],
            ['front' => 'フィルム', 'back' => 'フィルム', 'key' => 'firumu', 'example_japanese' => 'カメラのフィルム', 'example_blocks_json' => ['カメラ', 'の', 'フィルム']],
            ['front' => '電池', 'back' => 'でんち', 'key' => 'denchi', 'example_japanese' => '電池を買います', 'example_blocks_json' => ['電池', 'を', '買います']],
            ['front' => '箱', 'back' => 'はこ', 'key' => 'hako', 'example_japanese' => '箱の中にりんごがあります', 'example_blocks_json' => ['箱', 'の', '中', 'に', 'りんご', 'が', 'あります']],
            ['front' => 'スイッチ', 'back' => 'スイッチ', 'key' => 'suitchi', 'example_japanese' => 'スイッチを入れます', 'example_blocks_json' => ['スイッチ', 'を', '入れます']],
            ['front' => '冷蔵庫', 'back' => 'れいぞうこ', 'key' => 'reizouko', 'example_japanese' => '冷蔵庫の中にビールがあります', 'example_blocks_json' => ['冷蔵庫', 'の', '中', 'に', 'ビール', 'が', 'あります']],
            ['front' => 'テーブル', 'back' => 'テーブル', 'key' => 'teeburu', 'example_japanese' => 'テーブルの上', 'example_blocks_json' => ['テーブル', 'の', '上']],
            ['front' => 'ベッド', 'back' => 'ベッド', 'key' => 'beddo', 'example_japanese' => 'ベッドで寝ます', 'example_blocks_json' => ['ベッド', 'で', '寝ます']],
            ['front' => '棚', 'back' => 'たな', 'key' => 'tana', 'example_japanese' => '棚に本があります', 'example_blocks_json' => ['棚', 'に', '本', 'が', 'あります']],
            ['front' => 'ドア', 'back' => 'ドア', 'key' => 'doa', 'example_japanese' => 'ドアを開けます', 'example_blocks_json' => ['ドア', 'を', '開けます']],
            ['front' => '窓', 'back' => 'まど', 'key' => 'mado', 'example_japanese' => '窓を閉めます', 'example_blocks_json' => ['窓', 'を', '閉めます']],
            ['front' => 'ポスト', 'back' => 'ポスト', 'key' => 'posuto', 'example_japanese' => '手紙をポストに入れます', 'example_blocks_json' => ['手紙', 'を', 'ポスト', 'に', '入れます']],
            ['front' => 'ビル', 'back' => 'ビル', 'key' => 'biru', 'example_japanese' => '高いビル', 'example_blocks_json' => ['高い', 'ビル']],
            ['front' => '公園', 'back' => 'こうえん', 'key' => 'kouen', 'example_japanese' => '公園で遊びます', 'example_blocks_json' => ['公園', 'で', '遊びます']],
            ['front' => '喫茶店', 'back' => 'きっさてん', 'key' => 'kissaten', 'example_japanese' => '喫茶店でコーヒーを飲みます', 'example_blocks_json' => ['喫茶店', 'で', 'コーヒー', 'を', '飲みます']],
            ['front' => '本屋', 'back' => 'ほんや', 'key' => 'honya', 'example_japanese' => '本屋で本を買います', 'example_blocks_json' => ['本屋', 'で', '本', 'を', '買います']],
            ['front' => '乗り場', 'back' => 'のりば', 'key' => 'noriba', 'example_japanese' => 'タクシー乗り場はどこですか', 'example_blocks_json' => ['タクシー', '乗り場', 'は', 'どこ', 'ですか']],
            ['front' => '上', 'back' => 'うえ', 'key' => 'ue', 'example_japanese' => '机の上', 'example_blocks_json' => ['机', 'の', '上']],
            ['front' => '下', 'back' => 'した', 'key' => 'shita', 'example_japanese' => '木の下', 'example_blocks_json' => ['木', 'の', '下']],
            ['front' => '前', 'back' => 'まえ', 'key' => 'mae', 'example_japanese' => '駅の前', 'example_blocks_json' => ['駅', 'の', '前']],
            ['front' => '後ろ', 'back' => 'うしろ', 'key' => 'ushiro', 'example_japanese' => '家の後ろ', 'example_blocks_json' => ['家', 'の', '後ろ']],
            ['front' => '右', 'back' => 'みぎ', 'key' => 'migi', 'example_japanese' => '右へ曲がります', 'example_blocks_json' => ['右', 'へ', '曲がります']],
            ['front' => '左', 'back' => 'ひだり', 'key' => 'hidari', 'example_japanese' => '左を見てください', 'example_blocks_json' => ['左', 'を', '見てください']],
            ['front' => '中', 'back' => 'なか', 'key' => 'naka', 'example_japanese' => '箱の中', 'example_blocks_json' => ['箱', 'の', '中']],
            ['front' => '外', 'back' => 'そと', 'key' => 'soto', 'example_japanese' => '外は寒いです', 'example_blocks_json' => ['外', 'は', '寒い', 'です']],
            ['front' => '隣', 'back' => 'となり', 'key' => 'tonari', 'example_japanese' => '隣の部屋', 'example_blocks_json' => ['隣', 'の', '部屋']],
            ['front' => '近く', 'back' => 'ちかく', 'key' => 'chikaku', 'example_japanese' => '駅の近くにあります', 'example_blocks_json' => ['駅', 'の', '近く', 'に', 'あります']],
            ['front' => '間', 'back' => 'あいだ', 'key' => 'aida', 'example_japanese' => '銀行と郵便局の間', 'example_blocks_json' => ['銀行', 'と', '郵便局', 'の', '間']],
            ['front' => '～や～', 'back' => '～や～', 'key' => 'ya', 'example_japanese' => 'パンや卵を買います', 'example_blocks_json' => ['パン', 'や', '卵', 'を', '買います']],
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
                    'back_text' => "N5.lesson10.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson10.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
