<?php

namespace App\Filament\Resources\Exams\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('type')
                    ->label('Loại phần thi')
                    ->options([
                        'moji_goi' => 'Từ vựng - Chữ Hán',
                        'bunpou_dokkai' => 'Ngữ pháp - Đọc hiểu',
                        'choukai' => 'Nghe hiểu',
                    ])
                    ->required()
                    ->columnSpan(1),
                TextInput::make('duration_minutes')
                    ->label('Thời gian (phút)')
                    ->numeric()
                    ->required()
                    ->columnSpan(1),
                
                Repeater::make('questions')
                    ->relationship()
                    ->label('Danh sách câu hỏi')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('mondai_number')
                                ->label('Số Mondai')
                                ->numeric()
                                ->required()
                                ->columnSpan(1),
                            TextInput::make('audio_timestamp')
                                ->label('Thời điểm Audio (giây)')
                                ->numeric()
                                ->hint('Nếu dùng 1 file MP3 dài')
                                ->columnSpan(1),
                            Radio::make('correct_option_id')
                                ->label('Đáp án đúng')
                                ->options([
                                    1 => 'Đáp án 1',
                                    2 => 'Đáp án 2',
                                    3 => 'Đáp án 3',
                                    4 => 'Đáp án 4',
                                ])
                                ->inline()
                                ->required()
                                ->columnSpan(1),
                        ]),
                        
                        Textarea::make('instruction')
                            ->label('Hướng dẫn (VD: Chọn đáp án đúng)')
                            ->rows(2)
                            ->required(),
                            
                        Textarea::make('passage')
                            ->label('Đoạn văn (Cho bài đọc hiểu)')
                            ->rows(4),
                            
                        TextInput::make('text')
                            ->label('Nội dung câu hỏi (Tùy chọn)'),
                            
                        Grid::make(2)->schema([
                            FileUpload::make('image_url')
                                ->label('Hình ảnh')
                                ->disk('public')
                                ->directory('exams/images')
                                ->image(),
                            FileUpload::make('audio_url')
                                ->label('Audio riêng')
                                ->disk('public')
                                ->directory('exams/audios')
                                ->acceptedFileTypes(['audio/mpeg', 'audio/mp3']),
                        ]),
                        
                        Fieldset::make('Các đáp án (Nhập nội dung)')->schema([
                            Hidden::make('options_json.0.id')->default(1),
                            TextInput::make('options_json.0.text')->label('Đáp án 1')->required(),
                            
                            Hidden::make('options_json.1.id')->default(2),
                            TextInput::make('options_json.1.text')->label('Đáp án 2')->required(),
                            
                            Hidden::make('options_json.2.id')->default(3),
                            TextInput::make('options_json.2.text')->label('Đáp án 3')->required(),
                            
                            Hidden::make('options_json.3.id')->default(4),
                            TextInput::make('options_json.3.text')->label('Đáp án 4')->required(),
                        ])->columns(2),
                    ])
                    ->itemLabel(fn (array $state): ?string => $state['text'] ?? 'Câu hỏi mới')
                    ->collapsible()
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->label('Phần thi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'moji_goi' => 'primary',
                        'bunpou_dokkai' => 'success',
                        'choukai' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'moji_goi' => 'Từ vựng - Chữ Hán',
                        'bunpou_dokkai' => 'Ngữ pháp - Đọc hiểu',
                        'choukai' => 'Nghe hiểu',
                        default => $state,
                    }),
                TextColumn::make('duration_minutes')
                    ->label('Thời gian (phút)')
                    ->suffix(' phút'),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Số câu hỏi')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
