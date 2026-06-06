<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\ExamSection;
use App\Models\ExamQuestion;
use Illuminate\Support\Facades\File;

class DataExamSeeder extends Seeder
{
    public function run(): void
    {
        $examFiles = glob(database_path('seeders/data/exams/N5/*.json'));

        foreach ($examFiles as $file) {
            $jsonData = json_decode(file_get_contents($file), true);

            if (!$jsonData) {
                continue;
            }

            $exam = Exam::firstOrCreate(
                ['title' => $jsonData['title']],
                [
                    'level' => $jsonData['level'] ?? 'N5',
                    'is_published' => $jsonData['is_published'] ?? true,
                ]
            );

            if (isset($jsonData['sections'])) {
                foreach ($jsonData['sections'] as $sectionData) {
                    $section = ExamSection::firstOrCreate(
                        [
                            'exam_id' => $exam->id,
                            'type' => $sectionData['type']
                        ],
                        [
                            'duration_minutes' => $sectionData['duration_minutes'] ?? 0
                        ]
                    );

                    if (isset($sectionData['mondais'])) {
                        foreach ($sectionData['mondais'] as $mondaiData) {
                            if (isset($mondaiData['questions'])) {
                                foreach ($mondaiData['questions'] as $qData) {
                                    ExamQuestion::updateOrCreate(
                                        [
                                            'section_id' => $section->id,
                                            'mondai_number' => $mondaiData['mondai_number'],
                                            'text' => $qData['text'] ?? null,
                                        ],
                                        [
                                            'instruction' => $mondaiData['instruction'] ?? '',
                                            'passage' => $mondaiData['passage'] ?? null,
                                            'image_url' => $qData['image_url'] ?? null,
                                            'audio_timestamp' => $qData['audio_timestamp'] ?? null,
                                            'options_json' => $qData['options'] ?? [],
                                            'correct_option_id' => $qData['correct_option_id'] ?? 1,
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
