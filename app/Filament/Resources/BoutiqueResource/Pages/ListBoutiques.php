<?php

namespace App\Filament\Resources\BoutiqueResource\Pages;

use App\Filament\Resources\BoutiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoutiques extends ListRecords
{
    protected static string $resource = BoutiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
