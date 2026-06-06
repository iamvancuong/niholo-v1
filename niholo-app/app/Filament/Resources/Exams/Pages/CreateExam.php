<?php

namespace App\Filament\Resources\Exams\Pages;

use App\Filament\Resources\Exams\ExamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExam extends CreateRecord
{
    protected static string $resource = ExamResource::class;

    protected function afterCreate(): void
    {
        $exam = $this->record;

        $sections = [
            ['type' => 'moji_goi', 'duration_minutes' => 25],
            ['type' => 'bunpou_dokkai', 'duration_minutes' => 50],
            ['type' => 'choukai', 'duration_minutes' => 30],
        ];

        foreach ($sections as $section) {
            $exam->sections()->create($section);
        }
    }
}
