<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\GrammarPoint;
use App\Models\Card;

class DataGrammarSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['N5', 'N4'];
        
        $viPath = resource_path('js/locales/vi.json');
        $enPath = resource_path('js/locales/en.json');

        $viData = json_decode(file_get_contents($viPath), true);
        $enData = json_decode(file_get_contents($enPath), true);

        foreach ($levels as $level) {
            $grammarPath = database_path("seeders/data/grammar/{$level}/*.json");
            $files = glob($grammarPath);

            if (empty($files)) {
                $this->command->warn("No grammar JSON files found in database/seeders/data/grammar/{$level}/");
                continue;
            }

            $course = Course::where('level', $level)->first();
            if (!$course) {
                $this->command->error("Course {$level} not found.");
                continue;
            }

            foreach ($files as $file) {
                $data = json_decode(file_get_contents($file), true);
                if (!$data) continue;

                $lessonIndex = $data[0]['lesson_id'] ?? null;
                if (!$lessonIndex) continue;
                
                $lessonKey = "lesson{$lessonIndex}";

                if (!isset($viData[$level][$lessonKey]['grammar'])) {
                    $viData[$level][$lessonKey]['grammar'] = [];
                }
                if (!isset($enData[$level][$lessonKey]['grammar'])) {
                    $enData[$level][$lessonKey]['grammar'] = [];
                }

                // Create Lesson for Grammar Category
                $lesson = Lesson::firstOrCreate(
                    [
                        'course_id' => $course->id,
                        'order_index' => $lessonIndex,
                        'category' => 'grammar'
                    ],
                    [
                        'title' => "{$level}.{$lessonKey}.title",
                        'is_published' => true
                    ]
                );

                // Calculate current grammar count
                $grammarCount = count($viData[$level][$lessonKey]['grammar']) + 1;

                foreach ($data as $lessonData) {
                    $gKey = "g{$grammarCount}";
                    
                    // Store in vi.json
                    $viData[$level][$lessonKey]['grammar'][$gKey] = [
                        'title' => $lessonData['title'],
                        'description' => $lessonData['description'],
                        'exercises' => []
                    ];
                    $enData[$level][$lessonKey]['grammar'][$gKey] = [
                        'title' => "(EN) " . $lessonData['title'],
                        'description' => "(EN) " . $lessonData['description'],
                        'exercises' => []
                    ];

                    // Create GrammarPoint in DB
                    $grammarPoint = GrammarPoint::firstOrCreate(
                        [
                            'lesson_id' => $lesson->id,
                            'title' => "{$level}.{$lessonKey}.grammar.{$gKey}.title"
                        ],
                        [
                            'cure_dolly_explanation' => "{$level}.{$lessonKey}.grammar.{$gKey}.description"
                        ]
                    );

                    if (isset($lessonData['exercises'])) {
                        foreach ($lessonData['exercises'] as $index => $ex) {
                            $exKey = "ex" . ($index + 1);

                            $viData[$level][$lessonKey]['grammar'][$gKey]['exercises'][$exKey] = $ex['vietnamese_meaning'];
                            $enData[$level][$lessonKey]['grammar'][$gKey]['exercises'][$exKey] = "(EN) " . $ex['vietnamese_meaning'];

                            $blocksJson = [
                                'blocks' => $ex['blocks'],
                                'correct_order' => $ex['correct_order']
                            ];

                            // Create Card in DB
                            Card::firstOrCreate(
                                [
                                    'lesson_id' => $lesson->id,
                                    'grammar_point_id' => $grammarPoint->id,
                                    'type' => 'grammar',
                                    'front_text' => "{$level}.{$lessonKey}.grammar.{$gKey}.exercises.{$exKey}",
                                ],
                                [
                                    'back_text' => "{$level}.{$lessonKey}.grammar.{$gKey}.exercises.{$exKey}",
                                    'example_japanese' => $ex['correct_sentence'],
                                    'example_blocks_json' => $blocksJson
                                ]
                            );
                        }
                    }
                    
                    $grammarCount++;
                }
            }
        }

        file_put_contents($viPath, json_encode($viData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        file_put_contents($enPath, json_encode($enData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->command->info("Grammar data seeded successfully from JSON files!");
    }
}
