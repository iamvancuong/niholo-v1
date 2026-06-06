<?php

namespace App\Filament\Resources\Exams\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin Đề thi')
                    ->schema([
                        TextInput::make('title')
                            ->label('Tên đề thi')
                            ->required(),
                        Select::make('level')
                            ->label('Trình độ')
                            ->options([
                                'N5' => 'N5',
                                'N4' => 'N4',
                                'N3' => 'N3',
                                'N2' => 'N2',
                                'N1' => 'N1',
                            ])
                            ->required()
                            ->default('N5'),
                        Toggle::make('is_published')
                            ->label('Xuất bản')
                    ])->columns(3),
            ]);
    }
}
