<?php

use Illuminate\Support\Facades\DB;
use App\Models\GrammarPoint;
use App\Models\Card;
use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$json = <<<JSON
[
  {
    "lesson_id": 1,
    "title": "Khẳng định: N1 は N2 です",
    "description": "Dùng để giới thiệu N1 là N2. Trợ từ 'は' đọc là 'wa'.",
    "jlpt_level": "N5",
    "exercises": [
      {
        "exercise_id": "g1_ex1",
        "vietnamese_meaning": "Tôi là học sinh.",
        "correct_sentence": "わたし は がくせい です",
        "blocks": [
          { "id": "b1", "type": "vocabulary", "text": "わたし", "furigana": "watashi", "meaning": "Tôi" },
          { "id": "b2", "type": "vocabulary", "text": "がくせい", "furigana": "gakusei", "meaning": "Học sinh" },
          { "id": "b3", "type": "particle", "text": "は", "furigana": "wa", "meaning": "thì/là" },
          { "id": "b4", "type": "grammar_ending", "text": "です", "furigana": "desu", "meaning": "là" },
          { "id": "b5", "type": "distractor", "text": "が", "furigana": "ga", "meaning": "(Nhiễu)" }
        ],
        "correct_order": ["b1", "b3", "b2", "b4"]
      },
      {
        "exercise_id": "g1_ex2",
        "vietnamese_meaning": "Cô ấy là người Việt Nam.",
        "correct_sentence": "かのじょ は べとなむ じん です",
        "blocks": [
          { "id": "b1", "type": "vocabulary", "text": "かのじょ", "furigana": "kanojo", "meaning": "Cô ấy" },
          { "id": "b2", "type": "particle", "text": "は", "furigana": "wa", "meaning": "thì/là" },
          { "id": "b3", "type": "vocabulary", "text": "べとなむ", "furigana": "betonamu", "meaning": "Việt Nam" },
          { "id": "b4", "type": "vocabulary", "text": "じん", "furigana": "jin", "meaning": "Người" },
          { "id": "b5", "type": "grammar_ending", "text": "です", "furigana": "desu", "meaning": "là" },
          { "id": "b6", "type": "distractor", "text": "も", "furigana": "mo", "meaning": "cũng" }
        ],
        "correct_order": ["b1", "b2", "b3", "b4", "b5"]
      }
    ]
  },
  {
    "lesson_id": 2,
    "title": "Phủ định: N1 は N2 じゃありません",
    "description": "Dùng để phủ định: N1 không phải là N2.",
    "jlpt_level": "N5",
    "exercises": [
      {
        "exercise_id": "g1_ex3",
        "vietnamese_meaning": "Anh ấy không phải là giáo viên.",
        "correct_sentence": "かれ は せんせい じゃありません",
        "blocks": [
          { "id": "b1", "type": "vocabulary", "text": "かれ", "furigana": "kare", "meaning": "Anh ấy" },
          { "id": "b2", "type": "particle", "text": "は", "furigana": "wa", "meaning": "thì/là" },
          { "id": "b3", "type": "vocabulary", "text": "せんせい", "furigana": "sensei", "meaning": "Giáo viên" },
          { "id": "b4", "type": "grammar_ending", "text": "じゃありません", "furigana": "ja arimasen", "meaning": "không phải là" },
          { "id": "b5", "type": "distractor", "text": "です", "furigana": "desu", "meaning": "là" }
        ],
        "correct_order": ["b1", "b2", "b3", "b4"]
      }
    ]
  },
  {
    "lesson_id": 3,
    "title": "Câu hỏi: N1 は N2 ですか / Từ để hỏi: だれ",
    "description": "Dùng để hỏi N1 có phải là N2 không? Hoặc hỏi thông tin (Ai).",
    "jlpt_level": "N5",
    "exercises": [
      {
        "exercise_id": "g1_ex4",
        "vietnamese_meaning": "Bạn là nhân viên ngân hàng phải không?",
        "correct_sentence": "あなた は ぎんこういん ですか",
        "blocks": [
          { "id": "b1", "type": "vocabulary", "text": "あなた", "furigana": "anata", "meaning": "Bạn" },
          { "id": "b2", "type": "particle", "text": "は", "furigana": "wa", "meaning": "thì/là" },
          { "id": "b3", "type": "vocabulary", "text": "ぎんこういん", "furigana": "ginkouin", "meaning": "Nhân viên NH" },
          { "id": "b4", "type": "grammar_ending", "text": "ですか", "furigana": "desuka", "meaning": "phải không?" }
        ],
        "correct_order": ["b1", "b2", "b3", "b4"]
      },
      {
        "exercise_id": "g1_ex5",
        "vietnamese_meaning": "Người kia là ai?",
        "correct_sentence": "あのひと は だれ ですか",
        "blocks": [
          { "id": "b1", "type": "vocabulary", "text": "あのひと", "furigana": "anohito", "meaning": "Người kia" },
          { "id": "b2", "type": "particle", "text": "は", "furigana": "wa", "meaning": "thì/là" },
          { "id": "b3", "type": "vocabulary", "text": "だれ", "furigana": "dare", "meaning": "Ai" },
          { "id": "b4", "type": "grammar_ending", "text": "ですか", "furigana": "desuka", "meaning": "vậy?" },
          { "id": "b5", "type": "distractor", "text": "も", "furigana": "mo", "meaning": "cũng" }
        ],
        "correct_order": ["b1", "b2", "b3", "b4"]
      }
    ]
  },
  {
    "lesson_id": 4,
    "title": "Trợ từ も (Cũng)",
    "description": "Dùng để thể hiện sự tương đồng, thay thế cho trợ từ は.",
    "jlpt_level": "N5",
    "exercises": [
      {
        "exercise_id": "g1_ex6",
        "vietnamese_meaning": "Tôi cũng là kỹ sư.",
        "correct_sentence": "わたし も えんじにあ です",
        "blocks": [
          { "id": "b1", "type": "vocabulary", "text": "わたし", "furigana": "watashi", "meaning": "Tôi" },
          { "id": "b2", "type": "particle", "text": "も", "furigana": "mo", "meaning": "cũng" },
          { "id": "b3", "type": "vocabulary", "text": "えんじにあ", "furigana": "enjinia", "meaning": "Kỹ sư" },
          { "id": "b4", "type": "grammar_ending", "text": "です", "furigana": "desu", "meaning": "là" },
          { "id": "b5", "type": "distractor", "text": "は", "furigana": "wa", "meaning": "thì/là" }
        ],
        "correct_order": ["b1", "b2", "b3", "b4"]
      }
    ]
  }
]
JSON;

$data = json_decode($json, true);

$viPath = __DIR__ . '/resources/js/locales/vi.json';
$enPath = __DIR__ . '/resources/js/locales/en.json';

$viData = json_decode(file_get_contents($viPath), true);
$enData = json_decode(file_get_contents($enPath), true);

$grammarCount = 1;

foreach ($data as $lessonData) {
    $lessonId = $lessonData['lesson_id'];
    $lessonKey = "lesson{$lessonId}";

    if (!isset($viData['N5'][$lessonKey]['grammar'])) {
        $viData['N5'][$lessonKey]['grammar'] = [];
    }
    if (!isset($enData['N5'][$lessonKey]['grammar'])) {
        $enData['N5'][$lessonKey]['grammar'] = [];
    }

    $gKey = "g{$grammarCount}";
    
    // Store in vi.json
    $viData['N5'][$lessonKey]['grammar'][$gKey] = [
        'title' => $lessonData['title'],
        'description' => $lessonData['description'],
        'exercises' => []
    ];
    // English placeholder (normally translated by AI, keeping basic for now)
    $enData['N5'][$lessonKey]['grammar'][$gKey] = [
        'title' => "(EN) " . $lessonData['title'],
        'description' => "(EN) " . $lessonData['description'],
        'exercises' => []
    ];

    // Create GrammarPoint in DB
    $grammarPoint = GrammarPoint::firstOrCreate(
        [
            'lesson_id' => $lessonId,
            'title' => "N5.{$lessonKey}.grammar.{$gKey}.title"
        ],
        [
            'cure_dolly_explanation' => "N5.{$lessonKey}.grammar.{$gKey}.description"
        ]
    );

    foreach ($lessonData['exercises'] as $index => $ex) {
        $exKey = "ex" . ($index + 1);

        $viData['N5'][$lessonKey]['grammar'][$gKey]['exercises'][$exKey] = $ex['vietnamese_meaning'];
        $enData['N5'][$lessonKey]['grammar'][$gKey]['exercises'][$exKey] = "(EN) " . $ex['vietnamese_meaning'];

        $blocksJson = [
            'blocks' => $ex['blocks'],
            'correct_order' => $ex['correct_order']
        ];

        // Create Card in DB
        Card::firstOrCreate(
            [
                'lesson_id' => $lessonId,
                'grammar_point_id' => $grammarPoint->id,
                'type' => 'grammar',
                'front_text' => "N5.{$lessonKey}.grammar.{$gKey}.exercises.{$exKey}", // Mapped to Vietnamese Meaning
                'back_text' => "N5.{$lessonKey}.grammar.{$gKey}.exercises.{$exKey}",  // Can reuse or make new key
            ],
            [
                'example_japanese' => $ex['correct_sentence'],
                'example_blocks_json' => $blocksJson
            ]
        );
    }
    
    $grammarCount++;
}

file_put_contents($viPath, json_encode($viData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents($enPath, json_encode($enData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Grammar data seeded successfully!\n";
