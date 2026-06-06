<?php

namespace App\Filament\Resources\Cards\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CardInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('lesson_id')
                    ->numeric(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('front_text'),
                TextEntry::make('back_text'),
                TextEntry::make('reading')
                    ->placeholder('-'),
                TextEntry::make('audio_url')
                    ->placeholder('-'),
                TextEntry::make('mnemonic')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
