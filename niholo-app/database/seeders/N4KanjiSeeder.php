<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Kanji;
use App\Models\Card;

class N4KanjiSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('level', 'N4')->first();
        if (!$course) return;

        $kanjiLessons = [];

        // Lesson 12
        $lesson12 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 12, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson12.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson12->id] = [
            ['character' => '思', 'sino_vietnamese' => 'TƯ', 'meaning' => 'Nghĩ', 'onyomi' => ["シ"], 'kunyomi' => ["おも.う"], 'stroke_count' => 9, 'mnemonic' => 'Trái tim ở dưới đồng ruộng', 'examples' => [['word' => '思う', 'reading' => 'おもう', 'meaning' => 'Nghĩ'], ['word' => '思い出す', 'reading' => 'おもいだす', 'meaning' => 'Nhớ lại'], ]],
            ['character' => '終', 'sino_vietnamese' => 'CHUNG', 'meaning' => 'Kết thúc', 'onyomi' => ["シュウ"], 'kunyomi' => ["お.わる","お.える"], 'stroke_count' => 11, 'mnemonic' => 'Sợi chỉ mùa đông kết thúc', 'examples' => [['word' => '終わる', 'reading' => 'おわる', 'meaning' => 'Kết thúc'], ]],
            ['character' => '始', 'sino_vietnamese' => 'THỦY', 'meaning' => 'Bắt đầu', 'onyomi' => ["シ"], 'kunyomi' => ["はじ.める","はじ.まる"], 'stroke_count' => 8, 'mnemonic' => 'Người phụ nữ bắt đầu', 'examples' => [['word' => '始める', 'reading' => 'はじめる', 'meaning' => 'Bắt đầu'], ]],
            ['character' => '病', 'sino_vietnamese' => 'BỆNH', 'meaning' => 'Ốm, bệnh', 'onyomi' => ["ビョウ","ヘイ"], 'kunyomi' => ["や.む","やまい"], 'stroke_count' => 10, 'mnemonic' => 'Giường bệnh', 'examples' => [['word' => '病気', 'reading' => 'びょうき', 'meaning' => 'Bệnh tật'], ]],
            ['character' => '鳥', 'sino_vietnamese' => 'ĐIỂU', 'meaning' => 'Chim', 'onyomi' => ["チョウ"], 'kunyomi' => ["とり"], 'stroke_count' => 11, 'mnemonic' => 'Con chim', 'examples' => [['word' => '小鳥', 'reading' => 'ことり', 'meaning' => 'Con chim nhỏ'], ]],
        ];

        // Lesson 13
        $lesson13 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 13, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson13.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson13->id] = [
            ['character' => '料', 'sino_vietnamese' => 'LIÊU', 'meaning' => 'Nguyên liệu', 'onyomi' => ["リョウ"], 'kunyomi' => [], 'stroke_count' => 10, 'mnemonic' => 'Gạo làm nguyên liệu', 'examples' => [['word' => '料理', 'reading' => 'りょうり', 'meaning' => 'Nấu ăn'], ]],
            ['character' => '理', 'sino_vietnamese' => 'LÝ', 'meaning' => 'Lý do', 'onyomi' => ["リ"], 'kunyomi' => [], 'stroke_count' => 11, 'mnemonic' => 'Ông vua có lý', 'examples' => [['word' => '無理', 'reading' => 'むり', 'meaning' => 'Vô lý'], ]],
            ['character' => '特', 'sino_vietnamese' => 'ĐẶC', 'meaning' => 'Đặc biệt', 'onyomi' => ["トク"], 'kunyomi' => [], 'stroke_count' => 10, 'mnemonic' => 'Đặc biệt', 'examples' => [['word' => '特に', 'reading' => 'とくに', 'meaning' => 'Đặc biệt là'], ]],
            ['character' => '肉', 'sino_vietnamese' => 'NHỤC', 'meaning' => 'Thịt', 'onyomi' => ["ニク"], 'kunyomi' => [], 'stroke_count' => 6, 'mnemonic' => 'Miếng thịt', 'examples' => [['word' => '牛肉', 'reading' => 'ぎゅうにく', 'meaning' => 'Thịt bò'], ]],
            ['character' => '悪', 'sino_vietnamese' => 'ÁC', 'meaning' => 'Xấu', 'onyomi' => ["アク","オ"], 'kunyomi' => ["わる.い"], 'stroke_count' => 11, 'mnemonic' => 'Trái tim ác', 'examples' => [['word' => '悪い', 'reading' => 'わるい', 'meaning' => 'Xấu, tồi'], ]],
        ];

        // Lesson 14
        $lesson14 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 14, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson14.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson14->id] = [
            ['character' => '体', 'sino_vietnamese' => 'THỂ', 'meaning' => 'Cơ thể', 'onyomi' => ["タイ","テイ"], 'kunyomi' => ["からだ"], 'stroke_count' => 7, 'mnemonic' => 'Cơ thể con người', 'examples' => [['word' => '体', 'reading' => 'からだ', 'meaning' => 'Cơ thể'], ]],
            ['character' => '同', 'sino_vietnamese' => 'ĐỒNG', 'meaning' => 'Giống nhau', 'onyomi' => ["ドウ"], 'kunyomi' => ["おな.じ"], 'stroke_count' => 6, 'mnemonic' => 'Cùng chung', 'examples' => [['word' => '同じ', 'reading' => 'おなじ', 'meaning' => 'Giống nhau'], ]],
            ['character' => '着', 'sino_vietnamese' => 'TRƯỚC', 'meaning' => 'Mặc, đến', 'onyomi' => ["チャク","ジャク"], 'kunyomi' => ["き.る","つ.く"], 'stroke_count' => 12, 'mnemonic' => 'Con cừu mặc đồ', 'examples' => [['word' => '着る', 'reading' => 'きる', 'meaning' => 'Mặc'], ]],
            ['character' => '海', 'sino_vietnamese' => 'HẢI', 'meaning' => 'Biển', 'onyomi' => ["カイ"], 'kunyomi' => ["うみ"], 'stroke_count' => 9, 'mnemonic' => 'Mỗi giọt nước tạo thành biển', 'examples' => [['word' => '海', 'reading' => 'うみ', 'meaning' => 'Biển'], ]],
            ['character' => '昼', 'sino_vietnamese' => 'TRÚ', 'meaning' => 'Buổi trưa', 'onyomi' => ["チュウ"], 'kunyomi' => ["ひる"], 'stroke_count' => 9, 'mnemonic' => 'Mặt trời mọc buổi trưa', 'examples' => [['word' => '昼休み', 'reading' => 'ひるやすみ', 'meaning' => 'Nghỉ trưa'], ]],
        ];

        // Lesson 15
        $lesson15 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 15, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson15.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson15->id] = [
            ['character' => '漢15', 'sino_vietnamese' => 'HÁN 15', 'meaning' => 'Ý nghĩa 15', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 15', 'examples' => [['word' => '漢字15', 'reading' => 'かんじ15', 'meaning' => 'Nghĩa ví dụ 15'], ]],
        ];

        // Lesson 16
        $lesson16 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 16, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson16.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson16->id] = [
            ['character' => '漢16', 'sino_vietnamese' => 'HÁN 16', 'meaning' => 'Ý nghĩa 16', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 16', 'examples' => [['word' => '漢字16', 'reading' => 'かんじ16', 'meaning' => 'Nghĩa ví dụ 16'], ]],
        ];

        // Lesson 17
        $lesson17 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 17, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson17.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson17->id] = [
            ['character' => '漢17', 'sino_vietnamese' => 'HÁN 17', 'meaning' => 'Ý nghĩa 17', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 17', 'examples' => [['word' => '漢字17', 'reading' => 'かんじ17', 'meaning' => 'Nghĩa ví dụ 17'], ]],
        ];

        // Lesson 18
        $lesson18 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 18, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson18.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson18->id] = [
            ['character' => '漢18', 'sino_vietnamese' => 'HÁN 18', 'meaning' => 'Ý nghĩa 18', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 18', 'examples' => [['word' => '漢字18', 'reading' => 'かんじ18', 'meaning' => 'Nghĩa ví dụ 18'], ]],
        ];

        // Lesson 19
        $lesson19 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 19, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson19.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson19->id] = [
            ['character' => '漢19', 'sino_vietnamese' => 'HÁN 19', 'meaning' => 'Ý nghĩa 19', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 19', 'examples' => [['word' => '漢字19', 'reading' => 'かんじ19', 'meaning' => 'Nghĩa ví dụ 19'], ]],
        ];

        // Lesson 20
        $lesson20 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 20, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson20.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson20->id] = [
            ['character' => '漢20', 'sino_vietnamese' => 'HÁN 20', 'meaning' => 'Ý nghĩa 20', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 20', 'examples' => [['word' => '漢字20', 'reading' => 'かんじ20', 'meaning' => 'Nghĩa ví dụ 20'], ]],
        ];

        // Lesson 21
        $lesson21 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 21, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson21.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson21->id] = [
            ['character' => '漢21', 'sino_vietnamese' => 'HÁN 21', 'meaning' => 'Ý nghĩa 21', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 21', 'examples' => [['word' => '漢字21', 'reading' => 'かんじ21', 'meaning' => 'Nghĩa ví dụ 21'], ]],
        ];

        // Lesson 22
        $lesson22 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 22, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson22.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson22->id] = [
            ['character' => '漢22', 'sino_vietnamese' => 'HÁN 22', 'meaning' => 'Ý nghĩa 22', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 22', 'examples' => [['word' => '漢字22', 'reading' => 'かんじ22', 'meaning' => 'Nghĩa ví dụ 22'], ]],
        ];

        // Lesson 23
        $lesson23 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 23, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson23.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson23->id] = [
            ['character' => '漢23', 'sino_vietnamese' => 'HÁN 23', 'meaning' => 'Ý nghĩa 23', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 23', 'examples' => [['word' => '漢字23', 'reading' => 'かんじ23', 'meaning' => 'Nghĩa ví dụ 23'], ]],
        ];

        // Lesson 24
        $lesson24 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 24, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson24.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson24->id] = [
            ['character' => '漢24', 'sino_vietnamese' => 'HÁN 24', 'meaning' => 'Ý nghĩa 24', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 24', 'examples' => [['word' => '漢字24', 'reading' => 'かんじ24', 'meaning' => 'Nghĩa ví dụ 24'], ]],
        ];

        // Lesson 25
        $lesson25 = Lesson::firstOrCreate(
            ['course_id' => $course->id, 'order_index' => 25, 'category' => 'kanji'],
            ['title' => 'N4.kanji_lesson25.title', 'is_published' => true]
        );
        $kanjiLessons[$lesson25->id] = [
            ['character' => '漢25', 'sino_vietnamese' => 'HÁN 25', 'meaning' => 'Ý nghĩa 25', 'onyomi' => ["オン"], 'kunyomi' => ["くん"], 'stroke_count' => 10, 'mnemonic' => 'Mẹo nhớ 25', 'examples' => [['word' => '漢字25', 'reading' => 'かんじ25', 'meaning' => 'Nghĩa ví dụ 25'], ]],
        ];

        foreach ($kanjiLessons as $lessonId => $kanjis) {
            foreach ($kanjis as $kData) {
                $kanji = Kanji::firstOrCreate(
                    [
                        'character' => $kData['character'],
                        'lesson_id' => $lessonId
                    ],
                    [
                        'sino_vietnamese' => $kData['sino_vietnamese'],
                        'meaning' => $kData['meaning'],
                        'onyomi' => $kData['onyomi'],
                        'kunyomi' => $kData['kunyomi'],
                        'stroke_count' => $kData['stroke_count'],
                        'mnemonic' => $kData['mnemonic'],
                        'jlpt_level' => 'N4'
                    ]
                );

                if (!empty($kData['examples'])) {
                    $cardIds = [];
                    foreach ($kData['examples'] as $ex) {
                        $vocabCard = Card::firstOrCreate(
                            [
                                'lesson_id' => $lessonId,
                                'type' => 'vocabulary',
                                'front_text' => $ex['word']
                            ],
                            [
                                'back_text' => $ex['meaning'],
                                'reading' => $ex['reading'] ?? null,
                                'example_japanese' => null,
                                'example_blocks_json' => null
                            ]
                        );
                        $cardIds[] = $vocabCard->id;
                    }
                    if (!empty($cardIds)) {
                        $kanji->cards()->syncWithoutDetaching($cardIds);
                    }
                }

                $kanjiCard = Card::firstOrCreate(
                    [
                        'lesson_id' => $lessonId,
                        'type' => 'kanji',
                        'front_text' => $kanji->character,
                    ],
                    [
                        'back_text' => $kanji->sino_vietnamese . ' - ' . $kanji->meaning,
                        'example_japanese' => null,
                        'example_blocks_json' => null
                    ]
                );
                $kanji->cards()->syncWithoutDetaching([$kanjiCard->id]);
            }
        }

        $this->command->info("N4 Kanji data seeded successfully!");
    }
}