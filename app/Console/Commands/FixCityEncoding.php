<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixCityEncoding extends Command
{
    protected $signature = 'fix:city-encoding {--dry-run : Show what would be changed without making changes}';
    protected $description = 'Fix double-encoded UTF-8 city names in the database';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $this->info($dryRun ? '🔍 DRY RUN - No changes will be made' : '🔧 Fixing city name encoding...');

        $cities = DB::table('cities')->get();
        $fixed = 0;
        $skipped = 0;

        foreach ($cities as $city) {
            $name = $city->name;
            if (!$name) {
                $skipped++;
                continue;
            }

            // Detect if the name has double-encoded UTF-8 characters
            // Pattern: UTF-8 bytes interpreted as Latin-1 (e.g., Å« = ū, Ä = ā)
            $decoded = $this->fixDoubleEncoding($name);

            if ($decoded !== $name) {
                if ($dryRun) {
                    $this->line("  Would fix: <comment>{$name}</comment> → <info>{$decoded}</info>");
                } else {
                    DB::table('cities')->where('id', $city->id)->update(['name' => $decoded]);
                    $this->line("  Fixed: <comment>{$name}</comment> → <info>{$decoded}</info>");
                }
                $fixed++;
            } else {
                $skipped++;
            }
        }

        $this->newLine();
        $this->info("✅ Done! Fixed: {$fixed}, Skipped: {$skipped}");

        if ($dryRun && $fixed > 0) {
            $this->warn('Run without --dry-run to apply changes.');
        }
    }

    private function fixDoubleEncoding(string $text): string
    {
        // Try to detect and fix double-encoded UTF-8
        // Double encoding happens when UTF-8 text is encoded again as UTF-8
        // resulting in sequences like Ã¡ instead of á, Å« instead of ū

        // Method 1: Try mb_convert_encoding from UTF-8 to Latin-1 then back
        if (function_exists('mb_detect_encoding')) {
            $attempt = @mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
            if ($attempt !== false) {
                // Check if the result is valid UTF-8
                $reEncoded = @mb_convert_encoding($attempt, 'UTF-8', 'UTF-8');
                if ($reEncoded === $attempt && mb_check_encoding($attempt, 'UTF-8')) {
                    // Verify it actually changed something meaningful
                    if ($attempt !== $text && strlen($attempt) < strlen($text)) {
                        return $attempt;
                    }
                }
            }
        }

        // Method 2: Use utf8_decode for PHP < 8.2 compatibility
        if (preg_match('/[\xC3\xC4\xC5][\x80-\xBF]/', $text)) {
            $decoded = mb_convert_encoding($text, 'Windows-1252', 'UTF-8');
            if ($decoded !== false && mb_check_encoding($decoded, 'UTF-8')) {
                return $decoded;
            }
        }

        return $text;
    }
}
