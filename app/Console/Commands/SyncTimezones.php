<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Timezone;

class SyncTimezones extends Command
{
    protected $signature = 'geography:sync-timezones {--seed : Seed timezone table from PHP DateTimeZone data first}';

    protected $description = 'Seed timezone records from PHP DateTimeZone and link countries to their correct timezone';

    public function handle()
    {
        if ($this->option('seed') || Timezone::count() < 10) {
            $this->seedTimezones();
        }

        $this->linkCountriesToTimezones();

        return 0;
    }

    protected function seedTimezones()
    {
        $this->info('Seeding timezones from PHP DateTimeZone...');

        $identifiers = \DateTimeZone::listIdentifiers();
        $bar = $this->output->createProgressBar(count($identifiers));
        $bar->start();

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($identifiers as $tzName) {
            try {
                $tz = new \DateTimeZone($tzName);
                $now = new \DateTime('now', $tz);
                $offsetSeconds = $tz->getOffset($now);

                // Get country code from PHP transitions data
                $countryCode = null;
                $location = $tz->getLocation();
                if ($location && !empty($location['country_code']) && $location['country_code'] !== '??') {
                    $countryCode = $location['country_code'];
                }

                // Build abbreviation
                $abbreviation = $now->format('T');

                // Build GMT offset name
                $hours = floor(abs($offsetSeconds) / 3600);
                $minutes = floor((abs($offsetSeconds) % 3600) / 60);
                $sign = $offsetSeconds >= 0 ? '+' : '-';
                $gmtOffsetName = sprintf('UTC%s%02d:%02d', $sign, $hours, $minutes);

                $existingTz = Timezone::where('name', $tzName)->first();

                if ($existingTz) {
                    $existingTz->update([
                        'abbreviation' => $abbreviation,
                        'offset' => $offsetSeconds,
                        'country_code' => $countryCode,
                        'gmt_offset_name' => $gmtOffsetName,
                        'supports_dst' => count($tz->getTransitions(time(), time() + 31536000)) > 1,
                        'sort_order' => $offsetSeconds,
                    ]);
                    $updatedCount++;
                } else {
                    Timezone::create([
                        'uuid' => Str::uuid()->toString(),
                        'name' => $tzName,
                        'abbreviation' => $abbreviation,
                        'offset' => $offsetSeconds,
                        'country_code' => $countryCode,
                        'gmt_offset_name' => $gmtOffsetName,
                        'supports_dst' => count($tz->getTransitions(time(), time() + 31536000)) > 1,
                        'is_active' => true,
                        'sort_order' => $offsetSeconds,
                    ]);
                    $createdCount++;
                }
            } catch (\Exception $e) {
                $this->error("  Failed: {$tzName} - {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Seeded {$createdCount} new timezones. Updated {$updatedCount} existing timezones.");
        $this->newLine();
    }

    protected function linkCountriesToTimezones()
    {
        $this->info('Linking countries to their correct timezone...');

        $countries = Country::whereNotNull('iso2')->get();
        $bar = $this->output->createProgressBar(count($countries));
        $bar->start();

        $fixedCount = 0;
        $alreadyCorrectCount = 0;
        $skippedCount = 0;

        foreach ($countries as $country) {
            $iso2 = strtoupper($country->iso2);

            // Find timezone by country_code in our DB
            $matchedTimezone = Timezone::where('country_code', $iso2)->first();

            if (!$matchedTimezone) {
                // Fallback: try PHP DateTimeZone per-country list
                try {
                    $phpTimezones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $iso2);
                    if (!empty($phpTimezones)) {
                        $matchedTimezone = Timezone::where('name', $phpTimezones[0])->first();
                    }
                } catch (\Exception $e) {
                    // Skip
                }
            }

            if ($matchedTimezone) {
                if ($country->timezone_id == $matchedTimezone->id) {
                    $alreadyCorrectCount++;
                } else {
                    $country->timezone_id = $matchedTimezone->id;
                    $country->save();
                    $fixedCount++;
                }
            } else {
                $skippedCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Done!");
        $this->info("  ✓ Fixed/Updated: {$fixedCount}");
        $this->info("  ✓ Already correct: {$alreadyCorrectCount}");

        if ($skippedCount > 0) {
            $this->warn("  ⚠ Skipped: {$skippedCount}");
        }
    }
}
