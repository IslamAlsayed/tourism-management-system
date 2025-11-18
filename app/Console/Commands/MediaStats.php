<?php

namespace App\Console\Commands;

use App\Models\MediaFile;
use Illuminate\Console\Command;

class MediaStats extends Command
{
    protected $signature = 'media:stats';
    protected $description = 'Display media files statistics';

    public function handle()
    {
        $total = MediaFile::count();

        $this->info("Media Files Statistics");
        $this->newLine();

        $this->info("Total Files: {$total}");
        $this->newLine();

        // By Collection
        $this->info("By Collection:");
        $collections = MediaFile::selectRaw('collection_name, count(*) as count')
            ->groupBy('collection_name')
            ->orderBy('count', 'desc')
            ->get();

        $collectionData = [];
        foreach ($collections as $item) {
            $collectionData[] = [
                $item->collection_name ?? 'NULL',
                $item->count
            ];
        }
        $this->table(['Collection', 'Count'], $collectionData);

        // By File Type
        $this->info("By File Type:");
        $types = MediaFile::selectRaw('file_type, count(*) as count')
            ->groupBy('file_type')
            ->orderBy('count', 'desc')
            ->get();

        $typeData = [];
        foreach ($types as $item) {
            $typeData[] = [
                $item->file_type,
                $item->count
            ];
        }
        $this->table(['File Type', 'Count'], $typeData);

        // Recent uploads
        $this->info("Recent Uploads (Last 5):");
        $recent = MediaFile::latest()
            ->take(5)
            ->get(['file_name', 'collection_name', 'file_type', 'created_at']);

        $recentData = [];
        foreach ($recent as $item) {
            $recentData[] = [
                $item->file_name,
                $item->collection_name,
                $item->file_type,
                $item->created_at->format('Y-m-d H:i:s')
            ];
        }
        $this->table(['File Name', 'Collection', 'Type', 'Created At'], $recentData);

        return 0;
    }
}