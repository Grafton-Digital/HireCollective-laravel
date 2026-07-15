<?php

namespace App\Filament\Resources\BoutiqueResource\Pages;

use App\Filament\Resources\BoutiqueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBoutique extends CreateRecord
{
    protected static string $resource = BoutiqueResource::class;

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner() && $user->boutique_id === null) {
            $user->update(['boutique_id' => $this->record->id]);
        }
    }
}
