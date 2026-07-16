<?php

namespace App\Filament\Resources\BoutiqueEnquiryResource\Pages;

use App\Filament\Resources\BoutiqueEnquiryResource;
use App\Models\Boutique;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditBoutiqueEnquiry extends EditRecord
{
    protected static string $resource = BoutiqueEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->approve();

                    Notification::make()
                        ->success()
                        ->title('Boutique Approved')
                        ->body("The boutique '{$this->record->name}' has been approved.")
                        ->send();

                    return redirect()->to(BoutiqueEnquiryResource::getUrl('index'));
                })
                ->visible(fn () => $this->record->status === Boutique::STATUS_PENDING),

            Actions\Action::make('reject')
                ->icon(Heroicon::OutlinedXCircle)
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->reject();

                    Notification::make()
                        ->warning()
                        ->title('Boutique Rejected')
                        ->body("The boutique '{$this->record->name}' has been rejected.")
                        ->send();

                    return redirect()->to(BoutiqueEnquiryResource::getUrl('index'));
                })
                ->visible(fn () => $this->record->status === Boutique::STATUS_PENDING),

            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
