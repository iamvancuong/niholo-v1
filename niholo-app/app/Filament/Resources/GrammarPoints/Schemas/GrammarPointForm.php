<?php

namespace App\Filament\Resources\GrammarPoints\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GrammarPointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('lesson_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('cure_dolly_explanation')
                    ->columnSpanFull(),
                TextInput::make('visual_model_url')
                    ->url(),
            ]);
    }
}
