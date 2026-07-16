<?php

namespace App\Filament\Resources\ProductEnquiryResource\Pages;

use App\Filament\Resources\ProductEnquiryResource;
use Filament\Resources\Pages\ListRecords;

class ListProductEnquiries extends ListRecords
{
    protected static string $resource = ProductEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
