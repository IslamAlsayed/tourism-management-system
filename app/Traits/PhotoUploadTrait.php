<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
}