<?php

namespace App\Filament\Resources\GrammarPoints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GrammarPointInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('lesson_id')
                    ->numeric(),
                TextEntry::make('title'),
                TextEntry::make('cure_dolly_explanation')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('visual_model_url')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
