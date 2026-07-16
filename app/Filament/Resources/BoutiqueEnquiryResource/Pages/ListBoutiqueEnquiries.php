<?php

namespace App\Filament\Resources\BoutiqueEnquiryResource\Pages;

use App\Filament\Resources\BoutiqueEnquiryResource;
use Filament\Resources\Pages\ListRecords;

class ListBoutiqueEnquiries extends ListRecords
{
    protected static string $resource = BoutiqueEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
