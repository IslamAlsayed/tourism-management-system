<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Geography\Entities\Country;
use Illuminate\Support\Facades\File;

class DownloadCountryFlags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geography:download-flags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download country flags as SVG from a public source to public/assets/media/flags';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to download country flags...');

        $countries = Country::whereNotNull('iso2')->get();
        $flagsPath = public_path('assets/media/flags');

        // Ensure directory exists
        if (!File::exists($flagsPath)) {
            File::makeDirectory($flagsPath, 0755, true);
        }

        $bar = $this->output->createProgressBar(count($countries));
        $bar->start();

        $successCount = 0;
        $failedCount = 0;

        foreach ($countries as $country) {
            $iso2 = strtolower($country->iso2);
            $filePath = $flagsPath . '/' . $iso2 . '.svg';

            // Skip if already exists to save bandwidth and time on subsequent runs
            if (File::exists($filePath)) {
                $successCount++;
                $bar->advance();
                continue;
            }

            // Using flagcdn just as the source for the ONE-TIME download.
            // The user's system will then use the downloaded local SVGs.
            $url = "https://flagcdn.com/{$iso2}.svg";

            try {
                $response = Http::timeout(10)->get($url);

                if ($response->successful()) {
                    File::put($filePath, $response->body());
                    $successCount++;
                } else {
                    $this->error("\nFailed to download flag for {$country->name} ({$iso2})");
                    $failedCount++;
                }
            } catch (\Exception $e) {
                $this->error("\nException downloading flag for {$country->name} ({$iso2}): " . $e->getMessage());
                $failedCount++;
            }

            $bar->advance();
            
            // Sleep slightly to avoid rate limiting
            usleep(100000); // 100ms
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("Completed! Successfully downloaded or found {$successCount} flags.");
        if ($failedCount > 0) {
            $this->warn("Failed to download {$failedCount} flags.");
        }
    }
}
