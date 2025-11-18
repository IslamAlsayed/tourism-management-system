<?php

namespace App\Console\Commands;

use App\Models\MediaFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImportExistingMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:import-existing {--path=uploads}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import existing files from storage/app/public/uploads to media_files table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->option('path');
        $storagePath = storage_path("app/public/{$path}");

        if (!File::exists($storagePath)) {
            $this->error("Path does not exist: {$storagePath}");
            return 1;
        }

        $this->info("Scanning files in: {$storagePath}");

        $files = File::allFiles($storagePath);
        $totalFiles = count($files);

        $this->info("Found {$totalFiles} files");

        $bar = $this->output->createProgressBar($totalFiles);
        $bar->start();

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($files as $file) {
            try {
                // Get relative path from storage/app/public
                $relativePath = str_replace(storage_path('app/public/'), '', $file->getPathname());
                $relativePath = str_replace('\\', '/', $relativePath);

                // Check if already exists
                $exists = MediaFile::where('file_path', $relativePath)->exists();

                if ($exists) {
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // Determine collection from folder structure
                $collection = $this->determineCollection($relativePath);

                // Get file info
                $mimeType = File::mimeType($file->getPathname());
                $fileSize = File::size($file->getPathname());
                $fileType = $this->getFileType($mimeType);

                // Get dimensions for images
                $width = null;
                $height = null;
                if ($fileType === 'image' && function_exists('getimagesize')) {
                    $imageSize = @getimagesize($file->getPathname());
                    if ($imageSize) {
                        $width = $imageSize[0];
                        $height = $imageSize[1];
                    }
                }

                // Create media file record
                MediaFile::create([
                    'file_name' => $file->getFilename(),
                    'file_path' => $relativePath,
                    'file_type' => $fileType,
                    'mime_type' => $mimeType,
                    'file_size' => $fileSize,
                    'disk' => 'public',
                    'collection_name' => $collection,
                    'width' => $width,
                    'height' => $height,
                    'is_featured' => false,
                    'is_active' => true,
                    'display_order' => 0,
                    'uploaded_by' => 1, // Admin user
                ]);

                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $this->error("\nError importing {$file->getFilename()}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Summary
        $this->info("Import completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Imported', $imported],
                ['Skipped (already exists)', $skipped],
                ['Errors', $errors],
                ['Total', $totalFiles],
            ]
        );

        return 0;
    }

    /**
     * Determine collection name from file path
     */
    private function determineCollection(string $path): ?string
    {
        $path = strtolower($path);

        if (str_contains($path, 'flags')) {
            return 'general'; // Country flags
        }

        if (str_contains($path, 'logos') || str_contains($path, 'logo')) {
            return 'logos';
        }

        if (str_contains($path, 'profile') || str_contains($path, 'user')) {
            return 'users';
        }

        if (str_contains($path, 'banner')) {
            return 'banners';
        }

        if (str_contains($path, 'hotel') || str_contains($path, 'accommodation')) {
            return 'accommodations';
        }

        if (str_contains($path, 'restaurant')) {
            return 'restaurants';
        }

        if (str_contains($path, 'guide')) {
            return 'tour_guides';
        }

        if (str_contains($path, 'client')) {
            return 'clients';
        }

        return 'general';
    }

    /**
     * Get file type from MIME type
     */
    private function getFileType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }

        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        }

        if (
            in_array($mimeType, [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
        ) {
            return 'document';
        }

        if (
            in_array($mimeType, [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
        ) {
            return 'spreadsheet';
        }

        return 'other';
    }
}