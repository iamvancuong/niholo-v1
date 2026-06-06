<?php

namespace App\Filament\Resources\GrammarPoints\Pages;

use App\Filament\Resources\GrammarPoints\GrammarPointResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGrammarPoint extends ViewRecord
{
    protected static string $resource = GrammarPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
