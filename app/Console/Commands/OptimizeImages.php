<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\Finder\Finder;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize {--path=public : The path to optimize}';
    protected $description = 'Bulk optimize all images in the specified storage path';

    public function handle()
    {
        $path = $this->option('path');
        $directory = storage_path('app/' . $path);

        if (!is_dir($directory)) {
            $this->error("Directory not found: $directory");
            return;
        }

        $finder = new Finder();
        $finder->files()->in($directory)->name('/\.(jpg|jpeg|png|webp)$/i');

        $this->info("Found " . $finder->count() . " images. Starting optimization...");

        $bar = $this->output->createProgressBar($finder->count());
        $bar->start();

        foreach ($finder as $file) {
            try {
                $image = Image::make($file->getRealPath());
                
                // Max width/height to avoid huge files
                if ($image->width() > 1920 || $image->height() > 1080) {
                    $image->resize(1920, 1080, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Compress and save
                $image->save($file->getRealPath(), 80);
                
            } catch (\Exception $e) {
                // Skip if not an image or error
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nOptimization complete!");
    }
}
