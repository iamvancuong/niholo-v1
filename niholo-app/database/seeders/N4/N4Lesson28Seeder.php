<?php

namespace Database\Seeders\N4;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Card;

class N4Lesson28Seeder extends Seeder
{
    public function run(int $courseId): void
    {
        $lesson = Lesson::firstOrCreate(
            ['course_id' => $courseId, 'order_index' => 28],
            [
                'title' => 'N4.lesson28.title',
                'category' => 'vocabulary',
                'grammar_focus' => 'N4.lesson28.grammar_focus',
                'is_published' => true,
            ]
        );

        $vocab = [
            ['front' => '売れます', 'back' => 'うれます', 'key' => 'uremasu', 'example_japanese' => 'パンが売れます', 'example_blocks_json' => ["パン","が","売れます"]],
            ['front' => '踊ります', 'back' => 'おどります', 'key' => 'odorimasu', 'example_japanese' => '音楽に合わせて踊ります', 'example_blocks_json' => ["音楽","に","合わせて","踊ります"]],
            ['front' => 'かみます', 'back' => 'かみます', 'key' => 'kamimasu', 'example_japanese' => 'ガムをかみます', 'example_blocks_json' => ["ガム","を","かみます"]],
            ['front' => '選びます', 'back' => 'えらびます', 'key' => 'erabimasu', 'example_japanese' => '服を選びます', 'example_blocks_json' => ["服","を","選びます"]],
            ['front' => '通います', 'back' => 'かよいます', 'key' => 'kaioimasu', 'example_japanese' => '大学に通います', 'example_blocks_json' => ["大学","に","通います"]],
            ['front' => 'メモします', 'back' => 'メモします', 'key' => 'memoshimasu', 'example_japanese' => 'ノートにメモします', 'example_blocks_json' => ["ノート","に","メモします"]],
            ['front' => 'まじめ', 'back' => 'まじめ', 'key' => 'majime', 'example_japanese' => 'まじめな学生', 'example_blocks_json' => ["まじめな","学生"]],
            ['front' => '熱心', 'back' => 'ねっしん', 'key' => 'nesshin', 'example_japanese' => '熱心に勉強します', 'example_blocks_json' => ["熱心","に","勉強します"]],
            ['front' => '偉い', 'back' => 'えらい', 'key' => 'erai', 'example_japanese' => '偉い人', 'example_blocks_json' => ["偉い","人"]],
            ['front' => 'ちょうどいい', 'back' => 'ちょうどいい', 'key' => 'choudoii', 'example_japanese' => 'サイズがちょうどいい', 'example_blocks_json' => ["サイズ","が","ちょうどいい"]],
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
                    'back_text' => "N4.lesson28.vocab.{$key}.meaning",
                    'reading' => $item['back'],
                    'type' => 'vocabulary',
                    'example_japanese' => $item['example_japanese'] ?? null,
                    'example_vietnamese' => isset($item['example_japanese']) ? "N4.lesson28.vocab.{$key}.example" : null,
                    'example_blocks_json' => $item['example_blocks_json'] ?? null,
                ]
            );
        }
    }
}
