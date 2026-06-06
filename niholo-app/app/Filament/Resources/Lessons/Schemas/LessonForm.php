<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                \Filament\Forms\Components\Select::make('category')
                    ->options([
                        'vocabulary' => 'Từ vựng',
                        'grammar' => 'Ngữ pháp',
                        'kanji' => 'Chữ Hán'
                    ])
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('jf_standard_code'),
                TextInput::make('order_index')
                    ->required()
                    ->numeric(),
                Textarea::make('grammar_focus')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
