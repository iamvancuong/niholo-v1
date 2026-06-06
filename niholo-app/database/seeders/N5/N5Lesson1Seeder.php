<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson1Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 1],
            [
                'title' => 'N5.lesson1.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson1.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '私', 'back' => 'わたし', 'key' => 'watashi', 'example_japanese' => 'わたしは学生です', 'example_blocks_json' => ['わたし', 'は', '学生', 'です']],
            ['front' => '私たち', 'back' => 'わたしたち', 'key' => 'watashitachi', 'example_japanese' => 'わたしたちはベトナム人です', 'example_blocks_json' => ['わたしたち', 'は', 'ベトナム人', 'です']],
            ['front' => 'あなた', 'back' => 'あなた', 'key' => 'anata', 'example_japanese' => 'あなたは先生ですか', 'example_blocks_json' => ['あなた', 'は', '先生', 'ですか']],
            ['front' => '彼', 'back' => 'かれ', 'key' => 'kare', 'example_japanese' => '彼はエンジニアです', 'example_blocks_json' => ['彼', 'は', 'エンジニア', 'です']],
            ['front' => '彼女', 'back' => 'かのじょ', 'key' => 'kanojo', 'example_japanese' => '彼女は銀行員です', 'example_blocks_json' => ['彼女', 'は', '銀行員', 'です']],
            ['front' => 'あの人 / あの方', 'back' => 'あのひと / あのかた', 'key' => 'anohito', 'example_japanese' => 'あの人は木村さんです', 'example_blocks_json' => ['あの人', 'は', '木村さん', 'です']],
            ['front' => '皆さん', 'back' => 'みなさん', 'key' => 'minasan', 'example_japanese' => '皆さん、おはようございます', 'example_blocks_json' => ['皆さん', '、', 'おはようございます']],
            ['front' => 'だれ / どなた', 'back' => 'だれ / どなた', 'key' => 'dare', 'example_japanese' => 'あの人はだれですか', 'example_blocks_json' => ['あの人', 'は', 'だれ', 'ですか']],

            ['front' => '教師', 'back' => 'きょうし', 'key' => 'kyoushi', 'example_japanese' => '私は教師です', 'example_blocks_json' => ['私', 'は', '教師', 'です']],
            ['front' => '先生', 'back' => 'せんせい', 'key' => 'sensei', 'example_japanese' => '先生、こんにちは', 'example_blocks_json' => ['先生', '、', 'こんにちは']],
            ['front' => '学生', 'back' => 'がくせい', 'key' => 'gakusei', 'example_japanese' => '彼は学生じゃありません', 'example_blocks_json' => ['彼', 'は', '学生', 'じゃありません']],
            ['front' => '留学生', 'back' => 'りゅうがくせい', 'key' => 'ryuugakusei', 'example_japanese' => 'アリさんは留学生です', 'example_blocks_json' => ['アリさん', 'は', '留学生', 'です']],
            ['front' => '会社員', 'back' => 'かいしゃいん', 'key' => 'kaishain', 'example_japanese' => '父は会社員です', 'example_blocks_json' => ['父', 'は', '会社員', 'です']],
            ['front' => '社員', 'back' => 'しゃいん', 'key' => 'shain', 'example_japanese' => '私はIMCの社員です', 'example_blocks_json' => ['私', 'は', 'IMC', 'の', '社員', 'です']],
            ['front' => '銀行員', 'back' => 'ぎんこういん', 'key' => 'ginkouin', 'example_japanese' => '姉は銀行員です', 'example_blocks_json' => ['姉', 'は', '銀行員', 'です']],
            ['front' => '医者', 'back' => 'いしゃ', 'key' => 'isha', 'example_japanese' => 'かれは医者です', 'example_blocks_json' => ['かれ', 'は', '医者', 'です']],
            ['front' => 'エンジニア', 'back' => 'エンジニア', 'key' => 'enjinia', 'example_japanese' => 'シュミットさんはエンジニアです', 'example_blocks_json' => ['シュミットさん', 'は', 'エンジニア', 'です']],
            ['front' => '研究者', 'back' => 'けんきゅうしゃ', 'key' => 'kenkyuusha', 'example_japanese' => 'ワットさんは研究者です', 'example_blocks_json' => ['ワットさん', 'は', '研究者', 'です']],
            ['front' => '運転手', 'back' => 'うんてんしゅ', 'key' => 'untenshu', 'example_japanese' => '兄は運転手です', 'example_blocks_json' => ['兄', 'は', '運転手', 'です']],

            ['front' => '日本', 'back' => 'にほん', 'key' => 'nihon', 'example_japanese' => '日本から来ました', 'example_blocks_json' => ['日本', 'から', '来ました']],
            ['front' => 'ベトナム', 'back' => 'ベトナム', 'key' => 'betonamu', 'example_japanese' => 'ベトナムは暑いです', 'example_blocks_json' => ['ベトナム', 'は', '暑い', 'です']],
            ['front' => '韓国', 'back' => 'かんこく', 'key' => 'kankoku', 'example_japanese' => '彼女は韓国人です', 'example_blocks_json' => ['彼女', 'は', '韓国人', 'です']],
            ['front' => '中国', 'back' => 'ちゅうごく', 'key' => 'chuugoku', 'example_japanese' => '中国へ行きます', 'example_blocks_json' => ['中国', 'へ', '行きます']],
            ['front' => 'アメリカ', 'back' => 'アメリカ', 'key' => 'amerika', 'example_japanese' => 'アメリカの大学です', 'example_blocks_json' => ['アメリカ', 'の', '大学', 'です']],
            ['front' => 'イギリス', 'back' => 'イギリス', 'key' => 'igirisu', 'example_japanese' => 'イギリス人ですか', 'example_blocks_json' => ['イギリス人', 'ですか']],
            ['front' => '～人', 'back' => '～じん', 'key' => 'jin', 'example_japanese' => '私はベトナム人です', 'example_blocks_json' => ['私', 'は', 'ベトナム人', 'です']],
            ['front' => '～語', 'back' => '～ご', 'key' => 'go', 'example_japanese' => '日本語を勉強します', 'example_blocks_json' => ['日本語', 'を', '勉強します']],
            ['front' => '出身', 'back' => 'しゅっしん', 'key' => 'shusshin', 'example_japanese' => 'ご出身はどこですか', 'example_blocks_json' => ['ご出身', 'は', 'どこ', 'ですか']],
            ['front' => '～から来ました', 'back' => '～からきました', 'key' => 'karakimashita', 'example_japanese' => 'わたしはベトナムから来ました', 'example_blocks_json' => ['わたし', 'は', 'ベトナム', 'から', '来ました']],

            ['front' => 'はい / いいえ', 'back' => 'はい / いいえ', 'key' => 'hai_iie', 'example_japanese' => 'はい、そうです', 'example_blocks_json' => ['はい', '、', 'そう', 'です']],
            ['front' => '失礼ですが', 'back' => 'しつれいですが', 'key' => 'shitsureidesuga', 'example_japanese' => '失礼ですが、お名前は？', 'example_blocks_json' => ['失礼ですが', '、', 'お名前', 'は？']],
            ['front' => 'どうぞよろしくお願いします', 'back' => 'どうぞよろしくおねがいします', 'key' => 'douzoyoroshiku', 'example_japanese' => 'はじめまして、どうぞよろしくお願いします', 'example_blocks_json' => ['はじめまして', '、', 'どうぞよろしくお願いします']],
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
                    'back_text' => "N5.lesson1.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson1.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}