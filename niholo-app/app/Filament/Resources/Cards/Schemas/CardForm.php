<?php

namespace App\Filament\Resources\Cards\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Card Details')
                    ->tabs([
                        Tabs\Tab::make('Thông tin chung')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Select::make('lesson_id')
                                    ->relationship('lesson', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('type')
                                    ->options(['vocabulary' => 'Từ vựng', 'kanji' => 'Kanji', 'grammar' => 'Ngữ pháp'])
                                    ->required(),
                                TextInput::make('front_text')
                                    ->label('Mặt trước (Từ/Chữ/Ngữ pháp)')
                                    ->required(),
                                TextInput::make('back_text')
                                    ->label('Mặt sau (Nghĩa)')
                                    ->required(),
                                TextInput::make('reading')
                                    ->label('Cách đọc (Kana)'),
                            ])->columns(2),

                        Tabs\Tab::make('Mở rộng & Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Textarea::make('mnemonic')
                                    ->label('Mẹo nhớ (Mnemonic)')
                                    ->columnSpanFull(),
                                FileUpload::make('image_url')
                                    ->label('Hình ảnh')
                                    ->disk('public')
                                    ->directory('cards/images')
                                    ->image(),
                                FileUpload::make('audio_url')
                                    ->label('Âm thanh')
                                    ->disk('public')
                                    ->directory('cards/audios')
                                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg']),
                            ])->columns(2),

                        Tabs\Tab::make('Ví dụ & Bài tập')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                TextInput::make('example_japanese')->label('Câu tiếng Nhật'),
                                TextInput::make('example_vietnamese')->label('Nghĩa tiếng Việt'),
                                FileUpload::make('example_audio_url')
                                    ->label('Audio Câu')
                                    ->disk('public')
                                    ->directory('cards/audios')
                                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg']),
                                TagsInput::make('example_blocks_json')
                                    ->label('Mảnh ghép (Blocks) cho bài tập kéo thả')
                                    ->placeholder('Thêm từ để người dùng kéo thả...')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
