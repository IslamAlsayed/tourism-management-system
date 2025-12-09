<?php

namespace App\Console\Commands;

use App\Models\Season;
use Illuminate\Console\Command;

class RemoveDuplicateSeasons extends Command
{
    protected $signature = 'seasons:remove-duplicates';
    protected $description = 'Remove duplicate seasons keeping only one of each type';

    public function handle()
    {
        $this->info('Starting to remove duplicate seasons...');

        // Get all unique season names
        $uniqueNames = Season::distinct('name')->pluck('name');

        $totalBefore = Season::count();
        $this->info("Total seasons before: {$totalBefore}");

        $deletedCount = 0;

        foreach ($uniqueNames as $name) {
            $seasons = Season::where('name', $name)->orderBy('id', 'asc')->get();

            if ($seasons->count() > 1) {
                $this->info("Found {$seasons->count()} seasons with name: {$name}");

                // Keep the first one (oldest), delete the rest
                $keepId = $seasons->first()->id;
                $deleteIds = $seasons->where('id', '!=', $keepId)->pluck('id');

                $deleted = Season::whereIn('id', $deleteIds)->delete();
                $deletedCount += $deleted;

                $this->comment("  Kept ID: {$keepId}, Deleted: {$deleted} records");
            }
        }

        $totalAfter = Season::count();
        $this->info("Total seasons after: {$totalAfter}");
        $this->info("Total deleted: {$deletedCount}");

        // Show remaining seasons
        $this->newLine();
        $this->info('Remaining unique seasons:');
        $remaining = Season::orderBy('name')->get(['id', 'name', 'season_from', 'season_to']);

        $this->table(
            ['ID', 'Name', 'From', 'To'],
            $remaining->map(fn($s) => [
                $s->id,
                $s->name,
                $s->season_from?->format('Y-m-d') ?? 'N/A',
                $s->season_to?->format('Y-m-d') ?? 'N/A'
            ])
        );

        $this->info('Done!');

        return 0;
    }
}