<?php

namespace App\Filament\Resources\BoutiqueResource\Pages;

use App\Filament\Resources\BoutiqueResource;
use App\Models\Boutique;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListBoutiques extends ListRecords
{
    protected static string $resource = BoutiqueResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->showPendingNotification();
    }

    protected function showPendingNotification(): void
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner()) {
            $pendingBoutique = Boutique::where('submitted_by', $user->id)
                ->where('status', Boutique::STATUS_PENDING)
                ->first();

            if ($pendingBoutique) {
                Notification::make()
                    ->info()
                    ->title('Boutique Enquiry Pending')
                    ->body("Your boutique enquiry for \"{$pendingBoutique->name}\" is awaiting admin approval. Once approved, you'll be able to add products and manage your boutique.")
                    ->icon(Heroicon::OutlinedClock)
                    ->persistent()
                    ->send();
            }
        }
    }

    protected function getHeaderActions(): array
    {
        $user = auth()->user();

        $hasPendingEnquiry = $user && $user->isBoutiqueOwner()
            && Boutique::where('submitted_by', $user->id)
                ->where('status', Boutique::STATUS_PENDING)
                ->exists();

        return [
            Actions\CreateAction::make()
                ->disabled($hasPendingEnquiry)
                ->tooltip($hasPendingEnquiry ? 'You have a pending boutique enquiry awaiting approval' : null),
        ];
    }
}
