<?php

namespace App\Filament\Resources\Cards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->modifyQueryUsing(fn (Builder $query) => $query->select([
                'id', 'lesson_id', 'type', 'front_text', 'back_text', 'reading', 'image_url', 'audio_url', 'created_at', 'updated_at'
            ])->with('lesson'))
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Ảnh')
                    ->circular(),
                TextColumn::make('lesson.title')
                    ->label('Bài học')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Loại')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vocabulary' => 'success',
                        'kanji' => 'danger',
                        'grammar' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('front_text')
                    ->label('Mặt trước')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('back_text')
                    ->label('Mặt sau')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('reading')
                    ->label('Cách đọc')
                    ->searchable(),
                IconColumn::make('audio_url')
                    ->label('Âm thanh')
                    ->icon(fn (string $state): string => $state ? 'heroicon-o-speaker-wave' : '')
                    ->color('primary'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Loại thẻ')
                    ->options([
                        'vocabulary' => 'Từ vựng',
                        'kanji' => 'Kanji',
                        'grammar' => 'Ngữ pháp',
                    ]),
                SelectFilter::make('lesson_id')
                    ->label('Bài học')
                    ->relationship('lesson', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
