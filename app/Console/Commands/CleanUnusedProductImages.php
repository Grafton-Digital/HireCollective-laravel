<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('products:clean-images')]
#[Description('Clean unused product images from storage')]
class CleanUnusedProductImages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning for unused product images...');

        // Get all images used in database
        $usedImages = [];
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->featured_image) {
                $usedImages[] = $product->featured_image;
            }

            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    $usedImages[] = $image;
                }
            }
        }

        $this->info('Found '.count($usedImages).' images in database');

        // Get all files from storage
        $allFiles = array_merge(
            Storage::disk('public')->files('products'),
            Storage::disk('public')->files('products/featured'),
            Storage::disk('public')->files('products/gallery')
        );

        $this->info('Found '.count($allFiles).' files in storage');

        // Find unused files
        $unusedFiles = [];
        foreach ($allFiles as $file) {
            if (! in_array($file, $usedImages)) {
                $unusedFiles[] = $file;
            }
        }

        if (empty($unusedFiles)) {
            $this->info('No unused images found!');

            return 0;
        }

        $this->warn('Found '.count($unusedFiles).' unused images:');
        foreach ($unusedFiles as $file) {
            $this->line('  - '.$file);
        }

        if ($this->confirm('Do you want to delete these files?', false)) {
            $deleted = 0;
            foreach ($unusedFiles as $file) {
                if (Storage::disk('public')->delete($file)) {
                    $deleted++;
                    $this->line('Deleted: '.$file);
                }
            }

            $this->info("Deleted {$deleted} unused images!");
        } else {
            $this->info('Cleanup cancelled.');
        }

        return 0;
    }
}
