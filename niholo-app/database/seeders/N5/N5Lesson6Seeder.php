<?php

namespace Database\Seeders\N5;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N5Lesson6Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 6],
            [
                'title' => 'N5.lesson6.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N5.lesson6.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '食べます', 'back' => 'たべます', 'key' => 'tabemasu', 'example_japanese' => '朝ごはんを食べます', 'example_blocks_json' => ["朝ごはん","を","食べます"], 'image_prompt' => 'A person eating a delicious breakfast'],
            ['front' => '飲みます', 'back' => 'のみます', 'key' => 'nomimasu', 'example_japanese' => '水を飲みます', 'example_blocks_json' => ["水","を","飲みます"], 'image_prompt' => 'A person drinking a glass of water'],
            ['front' => '吸います', 'back' => 'すいます', 'key' => 'suimasu', 'example_japanese' => 'たばこを吸います', 'example_blocks_json' => ["たばこ","を","吸います"], 'image_prompt' => 'A person smoking a cigarette'],
            ['front' => '見ます', 'back' => 'みます', 'key' => 'mimasu', 'example_japanese' => '映画を見ます', 'example_blocks_json' => ["映画","を","見ます"], 'image_prompt' => 'A person watching a beautiful scenery'],
            ['front' => '聞きます', 'back' => 'ききます', 'key' => 'kikimasu', 'example_japanese' => '音楽を聞きます', 'example_blocks_json' => ["音楽","を","聞きます"], 'image_prompt' => 'A person listening to music with headphones'],
            ['front' => '読みます', 'back' => 'よみます', 'key' => 'yomimasu', 'example_japanese' => '本を読みます', 'example_blocks_json' => ["本","を","読みます"], 'image_prompt' => 'A person reading a book in a library'],
            ['front' => '書きます', 'back' => 'かきます', 'key' => 'kakimasu', 'example_japanese' => '手紙を書きます', 'example_blocks_json' => ["手紙","を","書きます"], 'image_prompt' => 'A person writing a letter with a pen'],
            ['front' => '買います', 'back' => 'かいます', 'key' => 'kaimasu', 'example_japanese' => '靴を買います', 'example_blocks_json' => ["靴","を","買います"], 'image_prompt' => 'A person shopping in a supermarket'],
            ['front' => '撮ります', 'back' => 'とります', 'key' => 'torimasu', 'example_japanese' => '写真を撮ります', 'example_blocks_json' => ["写真","を","撮ります"], 'image_prompt' => 'A person taking a photo with a camera'],
            ['front' => 'します', 'back' => 'します', 'key' => 'shimasu', 'example_japanese' => 'サッカーをします', 'example_blocks_json' => ["サッカー","を","します"], 'image_prompt' => 'A person playing sports outside'],
            ['front' => '会います', 'back' => 'あいます', 'key' => 'aimasu', 'example_japanese' => '友達に会います', 'example_blocks_json' => ["友達","に","会います"], 'image_prompt' => 'Two friends meeting and greeting each other'],
            ['front' => 'ごはん', 'back' => 'ごはん', 'key' => 'gohan', 'example_japanese' => 'ごはんを食べます', 'example_blocks_json' => ["ごはん","を","食べます"], 'image_prompt' => 'A bowl of delicious Japanese rice'],
            ['front' => '朝ごはん', 'back' => 'あさごはん', 'key' => 'asagohan', 'example_japanese' => '朝ごはんを食べます', 'example_blocks_json' => ["朝ごはん","を","食べます"], 'image_prompt' => 'A traditional Japanese breakfast'],
            ['front' => '昼ごはん', 'back' => 'ひるごはん', 'key' => 'hirugohan', 'example_japanese' => '昼ごはんを食べます', 'example_blocks_json' => ["昼ごはん","を","食べます"], 'image_prompt' => 'A delicious lunch bento box'],
            ['front' => '晩ごはん', 'back' => 'ばんごはん', 'key' => 'bangohan', 'example_japanese' => '晩ごはんを食べます', 'example_blocks_json' => ["晩ごはん","を","食べます"], 'image_prompt' => 'A warm dinner meal on a table'],
            ['front' => 'パン', 'back' => 'パン', 'key' => 'pan', 'example_japanese' => 'パンを食べます', 'example_blocks_json' => ["パン","を","食べます"], 'image_prompt' => 'Freshly baked bread'],
            ['front' => '卵', 'back' => 'たまご', 'key' => 'tamago', 'example_japanese' => '卵を買います', 'example_blocks_json' => ["卵","を","買います"], 'image_prompt' => 'A fresh egg'],
            ['front' => '肉', 'back' => 'にく', 'key' => 'niku', 'example_japanese' => '肉を食べます', 'example_blocks_json' => ["肉","を","食べます"], 'image_prompt' => 'Fresh raw meat on a cutting board'],
            ['front' => '魚', 'back' => 'さかな', 'key' => 'sakana', 'example_japanese' => '魚を買います', 'example_blocks_json' => ["魚","を","買います"], 'image_prompt' => 'A fresh fish ready to be cooked'],
            ['front' => '野菜', 'back' => 'やさい', 'key' => 'yasai', 'example_japanese' => '野菜を食べます', 'example_blocks_json' => ["野菜","を","食べます"], 'image_prompt' => 'Fresh green vegetables'],
            ['front' => '果物', 'back' => 'くだもの', 'key' => 'kudamono', 'example_japanese' => '果物を食べます', 'example_blocks_json' => ["果物","を","食べます"], 'image_prompt' => 'A basket of colorful fresh fruits'],
            ['front' => '水', 'back' => 'みず', 'key' => 'mizu', 'example_japanese' => '水を飲みます', 'example_blocks_json' => ["水","を","飲みます"], 'image_prompt' => 'A clear glass of water'],
            ['front' => 'お茶', 'back' => 'おちゃ', 'key' => 'ocha', 'example_japanese' => 'お茶を飲みます', 'example_blocks_json' => ["お茶","を","飲みます"], 'image_prompt' => 'A cup of hot Japanese green tea'],
            ['front' => '紅茶', 'back' => 'こうちゃ', 'key' => 'koucha', 'example_japanese' => '紅茶を飲みます', 'example_blocks_json' => ["紅茶","を","飲みます"], 'image_prompt' => 'A cup of black tea'],
            ['front' => '牛乳 / ミルク', 'back' => 'ぎゅうにゅう / ミルク', 'key' => 'gyuunyuu_miruku', 'example_japanese' => '牛乳を飲みます', 'example_blocks_json' => ["牛乳","を","飲みます"], 'image_prompt' => 'A glass of fresh milk'],
            ['front' => 'ジュース', 'back' => 'ジュース', 'key' => 'juusu', 'example_japanese' => 'ジュースを飲みます', 'example_blocks_json' => ["ジュース","を","飲みます"], 'image_prompt' => 'A glass of fresh orange juice'],
            ['front' => 'ビール', 'back' => 'ビール', 'key' => 'biiru', 'example_japanese' => 'ビールを飲みます', 'example_blocks_json' => ["ビール","を","飲みます"], 'image_prompt' => 'A cold glass of beer'],
            ['front' => 'お酒', 'back' => 'おさけ', 'key' => 'osake', 'example_japanese' => 'お酒を飲みます', 'example_blocks_json' => ["お酒","を","飲みます"], 'image_prompt' => 'Japanese sake bottle and cups'],
            ['front' => '手紙', 'back' => 'てがみ', 'key' => 'tegami', 'example_japanese' => '手紙を読みます', 'example_blocks_json' => ["手紙","を","読みます"], 'image_prompt' => 'A handwritten letter in an envelope'],
            ['front' => 'レポート', 'back' => 'レポート', 'key' => 'repooto', 'example_japanese' => 'レポートを書きます', 'example_blocks_json' => ["レポート","を","書きます"], 'image_prompt' => 'A stack of report documents on a desk'],
            ['front' => '写真', 'back' => 'しゃしん', 'key' => 'shashin', 'example_japanese' => '写真を撮ります', 'example_blocks_json' => ["写真","を","撮ります"], 'image_prompt' => 'A printed photograph'],
            ['front' => '店', 'back' => 'みせ', 'key' => 'mise', 'example_japanese' => '店で買います', 'example_blocks_json' => ["店","で","買います"], 'image_prompt' => 'A small cozy Japanese shop storefront'],
            ['front' => '庭', 'back' => 'にわ', 'key' => 'niwa', 'example_japanese' => '庭で写真を撮ります', 'example_blocks_json' => ["庭","で","写真を撮ります"], 'image_prompt' => 'A beautiful Japanese zen garden'],
            ['front' => '何', 'back' => 'なに', 'key' => 'nani', 'example_japanese' => '何を買いますか', 'example_blocks_json' => ["何","を","買いますか"], 'image_prompt' => 'A person looking confused with a question mark'],
            ['front' => '一緒に', 'back' => 'いっしょに', 'key' => 'isshoni', 'example_japanese' => '一緒に食べましょう', 'example_blocks_json' => ["一緒に","食べましょう"], 'image_prompt' => 'People doing something together happily'],
            ['front' => 'ちょっと', 'back' => 'ちょっと', 'key' => 'chotto', 'example_japanese' => 'ちょっと待ちます', 'example_blocks_json' => ["ちょっと","待ちます"], 'image_prompt' => 'A person showing a small amount with fingers'],
            ['front' => 'いつも', 'back' => 'いつも', 'key' => 'itsumo', 'example_japanese' => 'いつもパンを食べます', 'example_blocks_json' => ["いつも","パン","を","食べます"], 'image_prompt' => 'A calendar with every day marked'],
            ['front' => '時々', 'back' => 'ときどき', 'key' => 'tokidoki', 'example_japanese' => '時々映画を見ます', 'example_blocks_json' => ["時々","映画","を","見ます"], 'image_prompt' => 'A weather icon showing sometimes sun sometimes rain'],
            ['front' => '～ませんか', 'back' => '～ませんか', 'key' => 'masenka', 'example_japanese' => '一緒にビールを飲みませんか', 'example_blocks_json' => ["一緒に","ビール","を","飲みませんか"], 'image_prompt' => 'A person inviting another person to drink beer'],
            ['front' => '～ましょう', 'back' => '～ましょう', 'key' => 'mashou', 'example_japanese' => '行きましょう', 'example_blocks_json' => ["行きましょう"], 'image_prompt' => 'Two people agreeing enthusiastically'],
            ['front' => '分かりました', 'back' => 'わかりました', 'key' => 'wakarimashita', 'example_japanese' => 'はい、分かりました', 'example_blocks_json' => ["はい、","分かりました"], 'image_prompt' => 'A person nodding and understanding'],
        ];

        $this->seedCards($lesson->id, $vocab);
    }

    private function seedCards(int $lessonId, array $list): void
    {
        foreach ($list as $item) {
            $key = $item['key'];
            $imageUrl = null;
            if (isset($item['image_prompt'])) {
                // Lưu lại prompt để Command GenerateImages đọc và gọi DALL-E
                $fullPrompt = $item['image_prompt'] . ', studio ghibli anime style, vibrant colors';
                $imageUrl = '[PROMPT]' . $fullPrompt;
            }

            Card::updateOrCreate(
                ['lesson_id' => $lessonId, 'front_text' => $item['front']],
                [
                    'back_text' => "N5.lesson6.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'image_url' => $imageUrl,
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N5.lesson6.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}