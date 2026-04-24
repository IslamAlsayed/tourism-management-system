<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RestoreCityNames extends Command
{
    protected $signature = 'fix:restore-city-names {--dry-run : Preview changes without applying}';
    protected $description = 'Restore corrupted city names using Wikidata IDs';

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        // Find corrupted cities (containing literal ? which replaced special chars)
        $corrupted = DB::table('cities')
            ->whereRaw("name LIKE '%\?%' OR name REGEXP '\\\\?'")
            ->whereNotNull('wiki_data_id')
            ->where('wiki_data_id', '!=', '')
            ->get(['id', 'name', 'wiki_data_id']);

        $this->info("Found {$corrupted->count()} corrupted city names with wikidata IDs");

        if ($corrupted->isEmpty()) {
            $this->info('No corrupted cities found!');
            return 0;
        }

        // Batch Wikidata IDs (max 50 per request)
        $batches = $corrupted->chunk(50);
        $totalFixed = 0;
        $totalFailed = 0;

        foreach ($batches as $batchIndex => $batch) {
            $ids = $batch->pluck('wiki_data_id')->toArray();
            $idsString = implode('|', $ids);

            $this->info("Fetching batch " . ($batchIndex + 1) . "/" . $batches->count() . " (" . count($ids) . " cities)...");

            try {
                $response = Http::timeout(30)->get('https://www.wikidata.org/w/api.php', [
                    'action' => 'wbgetentities',
                    'ids' => $idsString,
                    'props' => 'labels',
                    'languages' => 'en',
                    'format' => 'json',
                ]);

                if (!$response->successful()) {
                    $this->error("API request failed: HTTP " . $response->status());
                    continue;
                }

                $data = $response->json();
                $entities = $data['entities'] ?? [];

                foreach ($batch as $city) {
                    $wikidataId = $city->wiki_data_id;
                    $entity = $entities[$wikidataId] ?? null;

                    if (!$entity || isset($entity['missing'])) {
                        $this->warn("  ✗ {$city->name} ({$wikidataId}) - not found on Wikidata");
                        $totalFailed++;
                        continue;
                    }

                    $newName = $entity['labels']['en']['value'] ?? null;

                    if (!$newName) {
                        $this->warn("  ✗ {$city->name} ({$wikidataId}) - no English label");
                        $totalFailed++;
                        continue;
                    }

                    if ($newName === $city->name) {
                        continue; // Already correct
                    }

                    if (!$dryRun) {
                        DB::table('cities')->where('id', $city->id)->update(['name' => $newName]);
                    }

                    $this->line("  <info>✓</info> <comment>{$city->name}</comment> → <info>{$newName}</info>");
                    $totalFixed++;
                }

                // Rate limiting
                usleep(500000); // 0.5 second between batches

            } catch (\Exception $e) {
                $this->error("API error: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("✅ Done! Fixed: {$totalFixed}, Failed: {$totalFailed}");

        if ($dryRun && $totalFixed > 0) {
            $this->warn('Run without --dry-run to apply changes.');
        }

        return 0;
    }
}
