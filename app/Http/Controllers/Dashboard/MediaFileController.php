<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\MediaFile;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaFile\MediaFileCreateRequest;
use App\Http\Requests\MediaFile\MediaFileUpdateRequest;

class MediaFileController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.dashboard.media-files.index');
    }

    public function create()
    {
        $availableCollection = MediaFile::getAvailableCollection();
        return view('pages.dashboard.media-files.create', compact('availableCollection'));
    }

    public function store(MediaFileCreateRequest $request)
    {
        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $mediaFile = MediaFile::create([
                    'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'file_path' => '',
                    'file_type' => $this->getFileType($file->getMimeType()),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'disk' => 'public',
                    'collection_name' => $request->collection_name,
                ]);

                $filename = $file->hashName();
                $path = $file->storeAs('uploads/media-files/' . $mediaFile->id, $filename, 'public');
                $mediaFile->update(['file_path' => $path]);
                $uploadedFiles[] = $mediaFile;
            }
        }

        return redirect()->route('media-files.index')->withSuccess(__('messages.type_updated_count', ['type' => __('main.files'), 'count' => count($uploadedFiles)]));
    }


    public function show(MediaFile $mediaFile)
    {
        $availableCollection = MediaFile::getAvailableCollection();
        return view('pages.dashboard.media-files.show', compact('mediaFile', 'availableCollection'));
    }

    public function edit($id)
    {
        $mediaFile = MediaFile::findOrFail($id);
        $availableCollection = MediaFile::getAvailableCollection();
        return view('pages.dashboard.media-files.edit', compact('mediaFile', 'availableCollection'));
    }

    public function update(MediaFileUpdateRequest $request, MediaFile $mediaFile)
    {
        $data = $request->safe()->except('replace_file');
        $mediaFile->update($data);

        if ($request->hasFile('replace_file')) {
            if ($mediaFile->file_path) {
                $this->deletePhoto($mediaFile, 'file_path');
            }
            $file = $request->file('replace_file');
            $filename = $file->hashName();
            $path = $file->storeAs('uploads/media-files/' . $mediaFile->id, $filename, 'public');
            $mediaFile->update([
                'file_path' => $path,
                'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'file_type' => $this->getFileType($file->getMimeType()),
            ]);
        }

        return redirect()->route('media-files.index')->withSuccess(__('main.media_file_updated_successfully'));
    }


    public function destroy($id)
    {
        $mediaFile = MediaFile::findOrFail($id);
        $mediaFile->deleteFile();
        $mediaFile->delete();
        return redirect()->route('media-files.index')->withSuccess(__('main.media_file_deleted_successfully'));
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:media-files,id']);
        $files = MediaFile::whereIn('id', $request->ids)->get();
        foreach ($files as $file) {
            $file->deleteFile();
            $file->delete();
        }
        return back()->withSuccess(__('main.files_deleted_successfully', ['count' => count($request->ids)]));
    }

    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } elseif (in_array($mimeType, ['application/pdf'])) {
            return 'document';
        } elseif (
            in_array($mimeType, [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv'
            ])
        ) {
            return 'spreadsheet';
        } else {
            return 'other';
        }
    }
}