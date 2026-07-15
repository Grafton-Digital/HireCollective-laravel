<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner() && $user->boutique_id) {
            $data['boutique_id'] = $user->boutique_id;
        }

        return $data;
    }
}
