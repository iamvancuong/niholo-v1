<?php

namespace App\Filament\Resources\Cards\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->required(),
                Select::make('type')
                    ->options(['vocabulary' => 'Vocabulary', 'kanji' => 'Kanji', 'grammar' => 'Grammar'])
                    ->required(),
                TextInput::make('front_text')
                    ->required(),
                TextInput::make('back_text')
                    ->required(),
                TextInput::make('reading'),
                TextInput::make('audio_url')
                    ->url(),
                TextInput::make('image_url')->url(),
                Textarea::make('mnemonic')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Section::make('Câu Ví Dụ & Bài Tập Kéo Thả')
                    ->schema([
                        TextInput::make('example_japanese')->label('Câu tiếng Nhật'),
                        TextInput::make('example_vietnamese')->label('Nghĩa tiếng Việt'),
                        TextInput::make('example_audio_url')->label('Audio Câu')->url(),
                        \Filament\Forms\Components\TagsInput::make('example_blocks_json')
                            ->label('Mảnh ghép (Blocks)')
                            ->placeholder('Thêm từ để người dùng kéo thả...'),
                    ])
            ]);
    }
}
