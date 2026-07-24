<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Notifications\NewProductSubmittedNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner() && $user->boutique_id) {
            $data['boutique_id'] = $user->boutique_id;
            $data['status'] = Product::STATUS_PENDING;
            $data['submitted_by'] = $user->id;
            $data['is_active'] = false;
        } else {
            $data['status'] = Product::STATUS_APPROVED;
            $data['submitted_by'] = $user->id;
        }

        return $data;
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
            return 'Product enquiry submitted';
        }

        return 'Product created';
    }

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner()) {
            Notification::route('mail', config('app.admin_email'))
                ->notify(new NewProductSubmittedNotification($this->record));
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
