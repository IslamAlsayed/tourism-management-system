<?php

namespace App\Console\Commands;

use App\Models\MediaFile;
use Illuminate\Console\Command;

class MediaShow extends Command
{
    protected $signature = 'media:show {--limit=10}';
    protected $description = 'Display media files sample';

    public function handle()
    {
        $limit = $this->option('limit');

        $files = MediaFile::latest()
            ->take($limit)
            ->get();

        if ($files->isEmpty()) {
            $this->warn('No media files found!');
            return 0;
        }

        $data = [];
        foreach ($files as $file) {
            $data[] = [
                $file->id,
                substr($file->file_name, 0, 30),
                $file->collection_name ?? '-',
                $file->file_type,
                $this->formatBytes($file->file_size),
                $file->width ? "{$file->width}x{$file->height}" : '-',
                $file->is_active ? '✓' : '✗',
            ];
        }

        $this->table(
            ['ID', 'File Name', 'Collection', 'Type', 'Size', 'Dimensions', 'Active'],
            $data
        );

        return 0;
    }

    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
