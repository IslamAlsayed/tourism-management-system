<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Airline;
use App\Models\Country;
use App\Models\MediaFile;
use App\Models\TourGuide;
use App\Models\Restaurant;
use App\Models\TouristService;
use App\Models\CrossingPort;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class MediaFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(MediaFile::class);

        // First: Store photos from models that have photo column
        $this->storeExistingPhotos(User::class, 'users');
        $this->storeExistingPhotos(Client::class, 'clients');
        $this->storeExistingPhotos(TouristService::class, 'tourist-services');
        $this->storeExistingPhotos(CrossingPort::class, 'crossing-ports');
        $this->storeExistingPhotos(Airline::class, 'airlines');
        $this->storeExistingPhotos(Restaurant::class, 'restaurants');
        $this->storeExistingPhotos(TourGuide::class, 'tour-guides');
        $this->storeExistingPhotos(Country::class, 'countries');

        // Second: Store all remaining files in uploads directory
        $this->storeAllUploadedFiles();
    }

    /**
     * Store existing photos from model to media_files table
     */
    private function storeExistingPhotos(string $modelClass, string $collectionName): void
    {
        // Get table name from model
        $model = new $modelClass;
        $tableName = $model->getTable();

        // Check if 'photo' column exists
        if (!Schema::hasColumn($tableName, 'photo')) {
            return;
        }

        $models = $modelClass::whereNotNull('photo')
            ->where('photo', '!=', '')
            ->get();

        foreach ($models as $model) {
            // Skip if already has media file record
            $existingMedia = MediaFile::where('model_type', $modelClass)
                ->where('model_id', $model->id)
                ->where('file_path', $model->photo)
                ->first();

            if ($existingMedia) {
                continue;
            }

            // Get file info
            $photoPath = $model->photo;
            $fullPath = public_path('storage/' . $photoPath);

            // Get file information if file exists, otherwise use defaults
            $fileExists = File::exists($fullPath);
            $fileInfo = pathinfo($photoPath);
            $mimeType = $fileExists ? mime_content_type($fullPath) : 'image/jpeg';
            $fileSize = $fileExists ? File::size($fullPath) : 0;

            // Get image dimensions if it's an image
            $width = null;
            $height = null;
            if ($fileExists && str_starts_with($mimeType, 'image/')) {
                $dimensions = @getimagesize($fullPath);
                if ($dimensions) {
                    [$width, $height] = $dimensions;
                }
            }

            // Create MediaFile record
            MediaFile::create([
                'file_name' => $fileInfo['basename'],
                'file_path' => $photoPath,
                'file_type' => str_starts_with($mimeType, 'image/') ? 'image' : 'file',
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
                'disk' => 'public',
                'collection_name' => $collectionName,
                'model_type' => $modelClass,
                'model_id' => $model->id,
                'width' => $width,
                'height' => $height,
                'is_featured' => false,
                'is_active' => true,
                'uploaded_at' => $model->created_at ?? now(),
            ]);
        }
    }

    /**
     * Store all uploaded files from uploads directory
     */
    private function storeAllUploadedFiles(): void
    {
        $uploadsPath = public_path('storage/uploads');

        if (!File::exists($uploadsPath)) {
            $this->command->warn("Uploads directory not found");
            return;
        }

        $allFiles = File::allFiles($uploadsPath);
        $storedCount = 0;

        foreach ($allFiles as $file) {
            // Get relative path from storage directory (uploads/collection/file.ext)
            $fullPath = str_replace('\\', '/', $file->getPathname());
            $storagePath = str_replace('\\', '/', public_path('storage'));
            $relativePath = str_replace($storagePath . '/', '', $fullPath);

            // Check if this file is already stored (check by file_name to match unique constraint)
            $existingMedia = MediaFile::where('file_name', $file->getFilename())->first();
            if ($existingMedia) {
                continue;
            }

            // Get file information
            $mimeType = mime_content_type($file->getPathname());
            $fileSize = $file->getSize();

            // Get image dimensions if it's an image
            $width = null;
            $height = null;
            if (str_starts_with($mimeType, 'image/')) {
                $dimensions = @getimagesize($file->getPathname());
                if ($dimensions) {
                    [$width, $height] = $dimensions;
                }
            }

            // Determine collection name from path (first folder after uploads/)
            $pathParts = explode('/', $relativePath);
            $collectionName = isset($pathParts[1]) ? $pathParts[1] : 'general';

            // Create MediaFile record without model association
            MediaFile::create([
                'file_name' => $file->getFilename(),
                'file_path' => $relativePath,
                'file_type' => str_starts_with($mimeType, 'image/') ? 'image' : 'file',
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
                'disk' => 'public',
                'collection_name' => $collectionName,
                'model_type' => null,
                'model_id' => null,
                'width' => $width,
                'height' => $height,
                'is_featured' => false,
                'is_active' => true,
                'uploaded_at' => now(),
            ]);

            $storedCount++;
        }
    }
}
