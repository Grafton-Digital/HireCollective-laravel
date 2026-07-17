<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected $listeners = ['delete-gallery-image' => 'deleteGalleryImage'];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function deleteGalleryImage($index)
    {
        $images = $this->record->images ?? [];

        if (! is_array($images)) {
            $images = [];
        }

        if (isset($images[$index])) {
            // Delete file from storage
            Storage::disk('public')->delete($images[$index]);

            // Remove from array
            array_splice($images, $index, 1);

            // Update record
            $this->record->update(['images' => array_values($images)]);

            // Refresh the form
            $this->fillForm();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Image deleted successfully',
            ]);
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle new gallery images
        if (isset($data['new_gallery_images']) && is_array($data['new_gallery_images']) && ! empty($data['new_gallery_images'])) {
            // Get existing images
            $existingImages = $this->record->images ?? [];
            if (! is_array($existingImages)) {
                $existingImages = [];
            }

            // Merge with new images
            $data['images'] = array_merge($existingImages, $data['new_gallery_images']);
        }

        // Remove temporary fields from data
        unset($data['new_gallery_images']);
        unset($data['existing_images']);

        return $data;
    }
}
