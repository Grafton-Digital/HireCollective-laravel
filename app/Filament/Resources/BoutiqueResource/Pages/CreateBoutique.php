<?php

namespace App\Filament\Resources\BoutiqueResource\Pages;

use App\Filament\Resources\BoutiqueResource;
use App\Models\Boutique;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateBoutique extends CreateRecord
{
    protected static string $resource = BoutiqueResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner()) {
            $data['status'] = Boutique::STATUS_PENDING;
            $data['submitted_by'] = $user->id;
            $data['is_active'] = false;
        } else {
            $data['status'] = Boutique::STATUS_APPROVED;
            $data['submitted_by'] = $user->id;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner() && $user->boutique_id === null && $this->record->isApproved()) {
            $user->update(['boutique_id' => $this->record->id]);
        }
    }

    protected function getCreateFormAction(): Actions\Action
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner()) {
            return Actions\Action::make('create')
                ->label('Submit for Approval')
                ->icon(Heroicon::OutlinedPaperAirplane)
                ->action('create')
                ->keyBindings(['mod+s'])
                ->color('primary');
        }

        return parent::getCreateFormAction();
    }

    protected function getCreateAnotherFormAction(): Actions\Action
    {
        return Actions\Action::make('createAnother')
            ->label('Create & create another')
            ->action('createAnother')
            ->keyBindings(['mod+shift+s'])
            ->color('gray')
            ->hidden(fn () => auth()->user()?->isBoutiqueOwner() ?? false);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner()) {
            return 'Boutique enquiry submitted';
        }

        return 'Boutique created';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
