<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalDescription(function () {
                    if ($this->record->isBoutiqueOwner() && $this->record->boutique) {
                        $productsCount = $this->record->boutique->products()->count();

                        return "This user is a boutique owner. Deleting them will also permanently remove their boutique \"{$this->record->boutique->name}\" and all {$productsCount} associated product(s). This action cannot be undone.";
                    }

                    return 'Are you sure you would like to do this?';
                }),
        ];
    }
}
