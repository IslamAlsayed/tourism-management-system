<?php

namespace App\Traits;

use App\Models\MediaFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

trait PhotoUploadTrait
{
    /**
     * Upload and delete old photo for any model.
     *
     * @param  \Illuminate\Http\Request|\Illuminate\Http\UploadedFile  $request
     * @param  mixed  $model
     * @param  string  $photoColumn
     * @param  string  $folder
     * @return void
     */
    public function uploadPhoto($request, $model, $photoColumn = 'photo', $folder = 'other', $column = null)
    {
        // Handle if $request is an UploadedFile directly
        $file = $request instanceof UploadedFile ? $request : null;

        // Handle if $request is a Request object
        if (!$file && $request->hasFile($photoColumn)) {
            $file = $request->file($photoColumn);
        }

        if ($file) {
            // Store the new photo
            $filename = $file->hashName();
            $path = $file->storeAs('uploads/' . $folder . '/' . $model->id . ($column ? '/' . $column : ''), $filename, 'public');

            // Handle gallery_images (array) vs single photo (string)
            if ($photoColumn === 'gallery_images' || is_array($model->{$photoColumn})) {
                // Add to existing array
                $existing = $model->{$photoColumn} ?? [];
                if (is_string($existing)) {
                    $existing = json_decode($existing, true) ?? [];
                }
                // Clean empty arrays and ensure we only have strings
                $existing = array_filter($existing, function ($item) {
                    return is_string($item) && !empty($item);
                });
                $existing[] = $path;
                $model->{$photoColumn} = array_values($existing);
            } else {
                // Delete the old photo if exists (single photo)
                if ($model->{$photoColumn} && is_string($model->{$photoColumn})) {
                    Storage::disk('public')->delete($model->{$photoColumn});
                }
                // Update with new photo path
                $model->{$photoColumn} = $path;
            }

            $model->save();
        }
    }

    public function deletePhoto($model, $photoColumn = 'photo')
    {
        // Check if the photo exists before attempting to delete it
        if (!empty($model->{$photoColumn})) {
            // Delete the photo
            Storage::disk($model->disk ?? 'public')->delete($model->{$photoColumn});

            // Delete the folder if it's empty
            $folderPath = dirname($model->{$photoColumn});
            if (Storage::disk('public')->exists('uploads/' . $folderPath) && count(Storage::disk('public')->files('uploads/' . $folderPath)) == 0) {
                Storage::disk('public')->deleteDirectory('uploads/' . $folderPath);
            }
        }
    }

    /**
     * Upload media file to MediaFile table
     */
    public function uploadMediaFile($file, $folder, $model, $collection)
    {
        try {
            $filename = time() . '_' . Str::random(10) . '.' . $file->extension();
            $path = $file->storeAs('uploads/' . $folder . '/' . $model->id . ($collection ? '/' . $collection : ''), $filename, 'public');
            $mimeType = $file->getMimeType();
            $fileType = strpos($mimeType, 'image') !== false ? 'image' : 'file';
            \Illuminate\Support\Facades\Log::info("path: " . $path);
            // Get image dimensions if it's an image
            $dimensions = [];
            if ($fileType === 'image') {
                try {
                    $imageInfo = getimagesize($file->getRealPath());
                    if ($imageInfo) {
                        $dimensions = ['width' => $imageInfo[0], 'height' => $imageInfo[1]];
                    }
                } catch (\Exception $e) {
                    // If we can't get dimensions, continue without them
                }
            }

            MediaFile::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize(),
                'disk' => 'public',
                'collection_name' => $collection,
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'width' => $dimensions['width'] ?? null,
                'height' => $dimensions['height'] ?? null,
                'uploaded_by' => getActiveUserId(),
                'uploaded_at' => now(),
                'is_active' => true,
            ]);

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Media upload failed: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteMedia($model, $collection)
    {
        $model->media()->where('collection_name', $collection)->get()->each(function ($media) {
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        });
    }

    public function uploadSinglePhoto(Request $request, Model $model, string $column = 'photo', string $folder = 'other')
    {
        if (!$request->hasFile($column)) {
            return;
        }
        // Store old photo path BEFORE any updates
        $oldPhoto = $model->{$column};
        // dd($model->toArray(), $oldPhoto, $request->file($column));

        // if (Storage::disk('public')->exists($oldPhoto)) {
        // dd("Old photo exists at path: {$oldPhoto}. Deletion is deferred until after new photo is uploaded and model is updated.");
        // }
        // dd($request->input('remove_photo'), $request->all(), $request->file($column));

        // Upload new photo
        $path = $request->file($column)->store("uploads/{$folder}/{$model->id}", 'public');

        // Update model with new path
        $model->update([$column => $path]);

        // Delete old photo AFTER successful update
        if (!empty($oldPhoto)) {
            if (Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            // Delete the folder if empty
            $folderPath = "uploads/{$folder}/{$model->id}";
            if (Storage::disk('public')->exists($folderPath)) {
                $files = Storage::disk('public')->files($folderPath);
                if (empty($files)) {
                    Storage::disk('public')->deleteDirectory($folderPath);
                }
            }
        }
    }

    public function uploadGallery(Request $request, Model $model, string $column = 'gallery', string $folder = 'other')
    {
        if (!$request->hasFile($column)) {
            return;
        }

        $gallery = $model->{$column} ?? [];

        foreach ($request->file($column) as $file) {
            $gallery[] = $file->store("uploads/{$folder}/{$model->id}/gallery", 'public');
        }

        $model->update([$column => array_values($gallery),]);
    }

    public function deleteGalleryImages(Model $model, array $removedImages, string $column = 'gallery')
    {
        $gallery = $model->{$column} ?? [];

        foreach ($removedImages as $image) {
            Storage::disk('public')->delete($image);
            $gallery = array_diff($gallery, [$image]);
        }

        $model->update([$column => array_values($gallery),]);
    }
}
