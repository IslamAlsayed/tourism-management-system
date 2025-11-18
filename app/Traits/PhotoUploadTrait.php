<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait PhotoUploadTrait
{
    /**
     * Upload and delete old photo for any model.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $model
     * @param  string  $photoColumn
     * @param  string  $folder
     * @return void
     */
    public function uploadPhoto($request, $model, $photoColumn = 'photo', $folder = 'other')
    {
        if ($request->hasFile($photoColumn)) {
            // Delete the old photo if exists
            if ($model->{$photoColumn}) {
                Storage::disk('public')->delete($model->{$photoColumn});
            }

            // Store the new photo
            $filename = $request->file($photoColumn)->hashName();
            $path = $request->file($photoColumn)->storeAs('uploads/' . $folder . '/' . $model->id, $filename, 'public');

            // Update the model with the new photo path
            $model->{$photoColumn} = $path;
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