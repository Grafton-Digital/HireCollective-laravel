<?php

namespace App\Filament\Resources\BoutiqueResource\Pages;

use App\Filament\Resources\BoutiqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoutique extends EditRecord
{
    protected static string $resource = BoutiqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $socialLinks = $data['social_links'] ?? [];

        if (! empty($socialLinks) && ! array_is_list($socialLinks)) {
            $data['social_links'] = collect($socialLinks)
                ->map(fn (string $handle, string $platform) => ['platform' => $platform, 'handle' => $handle])
                ->values()
                ->all();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['social_links'] = collect($data['social_links'] ?? [])
            ->filter(fn (array $item) => ! empty($item['platform']) && ! empty($item['handle']))
            ->mapWithKeys(fn (array $item) => [$item['platform'] => $item['handle']])
            ->all();

        return $data;
    }
}
