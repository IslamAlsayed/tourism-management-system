<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Localization\Entities\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync currency exchange rates from ExchangeRate-API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting currency sync...');

        // Find the base currency
        $baseCurrency = Currency::where('is_base_currency', true)->first();

        if (!$baseCurrency) {
            $this->error('No base currency found in the database. Cannot sync.');
            Log::error('Currency Sync Failed: No base currency defined.');
            return 1;
        }

        $baseCode = $baseCurrency->code;
        $this->info("Base currency is {$baseCode}. Fetching rates...");

        // Call the free ExchangeRate-API
        $response = Http::get("https://open.er-api.com/v6/latest/{$baseCode}");

        if ($response->failed()) {
            $this->error('Failed to fetch data from the API.');
            Log::error('Currency Sync Failed: API request failed', ['status' => $response->status(), 'body' => $response->body()]);
            return 1;
        }

        $data = $response->json();

        if (($data['result'] ?? '') !== 'success') {
            $this->error('API returned an error or unrecognized format.');
            Log::error('Currency Sync Failed: Unsuccessful result from API', ['data' => $data]);
            return 1;
        }

        $rates = $data['rates'] ?? [];
        $updatedCount = 0;

        // Fetch all active currencies except the base that have auto update enabled (base rate is always 1)
        $currencies = Currency::where('is_active', true)
            ->where('is_auto_update', true)
            ->where('id', '!=', $baseCurrency->id)
            ->get();

        foreach ($currencies as $currency) {
            $code = $currency->code;
            if (isset($rates[$code])) {
                // Update the currency rate
                $currency->exchange_rate = $rates[$code];
                $currency->save();
                $updatedCount++;
                $this->info("Updated {$code} to {$rates[$code]}");
            } else {
                $this->warn("Rate for {$code} not found in API response.");
            }
        }

        // Ensure base currency rate is exactly 1
        if ($baseCurrency->exchange_rate != 1) {
            $baseCurrency->exchange_rate = 1;
            $baseCurrency->save();
        }

        $this->info("Currency sync completed successfully. Updated {$updatedCount} currencies.");
        Log::info("Currency Sync Success: Updated {$updatedCount} exchange rates against base {$baseCode}.");
        
        return 0;
    }
}
