<?php

namespace App\Observers;

use App\Models\MediaFile;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaFileObserver
{
    use PhotoUploadTrait;

    public function created(MediaFile $mediaFile)
    {
        if (!empty($mediaFile->file_path)) {
            $fullPath = Storage::disk($mediaFile->disk)->path($mediaFile->file_path);

            if (file_exists($fullPath) && $mediaFile->is_image) {
                [$width, $height] = getimagesize($fullPath);

                $mediaFile->update([
                    'width' => $width,
                    'height' => $height,
                    'uploaded_by' => getActiveUser()?->id,
                    'uploaded_at' => now(),
                    'is_featured' => request()->is_featured ?? true,
                    'is_active' => request()->is_active ?? true,
                ]);
            }
        }
    }

    public function deleted(MediaFile $mediaFile)
    {
        $this->deletePhoto($mediaFile, 'file_path');
    }
}