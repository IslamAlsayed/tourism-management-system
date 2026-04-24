<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixAllEncoding extends Command
{
    protected $signature = 'fix:all-encoding {--dry-run : Show what would be changed without making changes}';
    protected $description = 'Fix double-encoded UTF-8 text across ALL database tables';

    private $textColumns = ['name', 'title', 'name_ar', 'name_en', 'description', 'address', 'notes'];

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $this->info($dryRun ? '🔍 DRY RUN mode' : '🔧 Fixing encoding across all tables...');

        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            $tables = collect(DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name"))
                ->pluck('name');
        } elseif ($driver === 'mysql' || $driver === 'mariadb') {
            $tables = collect(DB::select('SHOW TABLES'))
                ->map(fn($t) => array_values((array)$t)[0]);
        } else {
            $this->error("Unsupported driver: {$driver}");
            return 1;
        }

        $this->info("Database driver: {$driver} | Tables found: " . $tables->count());

        $totalFixed = 0;
        $tablesFixed = [];

        foreach ($tables as $table) {
            try {
                $columns = Schema::getColumnListing($table);
            } catch (\Exception $e) {
                continue;
            }
            
            $targetCols = array_intersect($this->textColumns, $columns);
            if (empty($targetCols)) continue;

            foreach ($targetCols as $col) {
                try {
                    $rows = DB::table($table)
                        ->whereNotNull($col)
                        ->where($col, '!=', '')
                        ->select(['id', $col])
                        ->get();
                } catch (\Exception $e) {
                    continue;
                }

                $fixCount = 0;
                foreach ($rows as $row) {
                    $val = $row->$col ?? null;
                    if (!$val || !is_string($val)) continue;

                    $decoded = $this->fixDoubleEncoding($val);
                    if ($decoded !== $val) {
                        if (!$dryRun) {
                            DB::table($table)->where('id', $row->id)->update([$col => $decoded]);
                        }
                        $fixCount++;
                        $totalFixed++;
                    }
                }

                if ($fixCount > 0) {
                    $tablesFixed[] = "{$table}.{$col}";
                    $this->line("  <info>✓</info> <comment>{$table}.{$col}</comment>: Fixed {$fixCount} entries");
                }
            }
        }

        $this->newLine();
        if ($totalFixed > 0) {
            $this->info("✅ Total fixed: {$totalFixed} entries across " . count($tablesFixed) . " columns");
            if ($dryRun) {
                $this->warn('Run without --dry-run to apply changes.');
            }
        } else {
            $this->info('✅ No encoding issues found!');
        }

        return 0;
    }

    private function fixDoubleEncoding(string $text): string
    {
        // Detect double-encoded UTF-8: UTF-8 bytes misinterpreted as Latin-1
        if (preg_match('/[\xC3\xC4\xC5][\x80-\xBF]/', $text)) {
            $decoded = @mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
            if ($decoded !== false && $decoded !== $text && mb_check_encoding($decoded, 'UTF-8') && strlen($decoded) < strlen($text)) {
                return $decoded;
            }
        }
        return $text;
    }
}
