<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:move-private-files-to-public')]
#[Description('Move uploaded files from private storage to public storage')]
class MovePrivateFilesToPublic extends Command
{
    public function handle(): int
    {
        $this->info('Moving files from private to public storage...');

        $directories = ['boutiques/logos', 'boutiques/covers', 'products/featured', 'products/gallery'];
        $movedCount = 0;

        foreach ($directories as $directory) {
            $privateFiles = Storage::disk('local')->files($directory);

            foreach ($privateFiles as $file) {
                if (Storage::disk('public')->exists($file)) {
                    $this->warn("File already exists in public: {$file}");

                    continue;
                }

                $contents = Storage::disk('local')->get($file);
                Storage::disk('public')->put($file, $contents);

                $this->info("Moved: {$file}");
                $movedCount++;
            }
        }

        $this->info("Successfully moved {$movedCount} files to public storage.");

        return self::SUCCESS;
    }
}
