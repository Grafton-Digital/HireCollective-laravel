<?php

namespace App\Filament\Resources\ProductEnquiryResource\Pages;

use App\Filament\Resources\ProductEnquiryResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditProductEnquiry extends EditRecord
{
    protected static string $resource = ProductEnquiryResource::class;

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
                        ->title('Product Approved')
                        ->body("The product '{$this->record->name}' has been approved.")
                        ->send();

                    return redirect()->to(ProductEnquiryResource::getUrl('index'));
                })
                ->visible(fn () => $this->record->status === Product::STATUS_PENDING),

            Actions\Action::make('reject')
                ->icon(Heroicon::OutlinedXCircle)
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->reject();

                    Notification::make()
                        ->warning()
                        ->title('Product Rejected')
                        ->body("The product '{$this->record->name}' has been rejected.")
                        ->send();

                    return redirect()->to(ProductEnquiryResource::getUrl('index'));
                })
                ->visible(fn () => $this->record->status === Product::STATUS_PENDING),

            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
