<?php

namespace App\Observers;

use App\Models\MediaFile;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class PhotoObserver
{
    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        // Check if model has 'photo' attribute
        if (!$this->hasPhotoColumn($model)) {
            return;
        }

        $this->handlePhotoUpload($model);
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated(Model $model): void
    {
        // Check if model has 'photo' attribute
        if (!$this->hasPhotoColumn($model)) {
            return;
        }

        // Only handle if photo was changed
        if ($model->isDirty('photo')) {
            $this->handlePhotoUpload($model);
        }
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        // Check if model has 'photo' attribute
        if (!$this->hasPhotoColumn($model)) {
            return;
        }

        // Delete associated media files
        if ($model->photo) {
            MediaFile::where('model_type', get_class($model))
                ->where('model_id', $model->id)
                ->where('file_path', $model->photo)
                ->delete();
        }
    }

    /**
     * Check if model has photo column
     */
    private function hasPhotoColumn(Model $model): bool
    {
        return \Illuminate\Support\Facades\Schema::hasColumn($model->getTable(), 'photo');
    }

    /**
     * Handle photo upload and create MediaFile record
     */
    private function handlePhotoUpload(Model $model): void
    {
        if (!$model->photo || empty($model->photo)) {
            return;
        }

        // Check if media file record already exists
        $existingMedia = MediaFile::where('model_type', get_class($model))
            ->where('model_id', $model->id)
            ->where('file_path', $model->photo)
            ->first();

        if ($existingMedia) {
            return;
        }

        // Get collection name from model class
        $collectionName = $this->getCollectionName($model);

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
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'width' => $width,
            'height' => $height,
            'is_featured' => false,
            'is_active' => true,
            'uploaded_at' => now(),
        ]);
    }

    /**
     * Get collection name based on model class
     */
    private function getCollectionName(Model $model): string
    {
        $className = class_basename($model);

        return match ($className) {
            'User' => 'users',
            'Client' => 'clients',
            'touristService' => 'tourist-services',
            'EntryPoint' => 'crossing-ports',
            'Airline' => 'airlines',
            'Restaurant' => 'restaurants',
            'TourGuide' => 'tour-guides',
            'Country' => 'countries',
            default => strtolower(str_replace('_', '-', \Illuminate\Support\Str::snake($className . 's'))),
        };
    }
}
