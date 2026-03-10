<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Subregion;

class FixSubregionLinking extends Command
{
    protected $signature = 'geography:fix-subregions';

    protected $description = 'Fix countries that have missing subregion_id by matching them to subregions based on region_id';

    public function handle()
    {
        $this->info('Fixing subregion linking for countries...');

        $unlinkedCountries = Country::where(function ($q) {
            $q->whereNull('subregion_id')->orWhere('subregion_id', 0);
        })->get();

        if ($unlinkedCountries->isEmpty()) {
            $this->info('All countries are already linked to a subregion.');
            return 0;
        }

        $this->info("Found {$unlinkedCountries->count()} countries without subregion_id.");

        $fixedCount = 0;
        $failedCount = 0;

        foreach ($unlinkedCountries as $country) {
            if (!$country->region_id) {
                $this->warn("  ⚠ {$country->name} (ID: {$country->id}) has no region_id either. Skipping.");
                $failedCount++;
                continue;
            }

            // Try to find a matching subregion within the same region
            $subregion = Subregion::where('region_id', $country->region_id)->first();

            if ($subregion) {
                $country->subregion_id = $subregion->id;
                $country->save();
                $this->info("  ✓ {$country->name} → linked to subregion: {$subregion->name}");
                $fixedCount++;
            } else {
                $this->warn("  ⚠ {$country->name} (region_id: {$country->region_id}) — no matching subregion found.");
                $failedCount++;
            }
        }

        $this->newLine();
        $this->info("Done! Fixed: {$fixedCount}, Failed: {$failedCount}");

        return 0;
    }
}
