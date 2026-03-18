<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MixjoScanRoutes extends Command
{
    protected $signature = 'mixjo:scan-routes {--output=routes_audit_report.md}';
    protected $description = 'Scans all accessible GET routes in the dashboard to detect 500 database errors.';

    public function handle()
    {
        $this->info("🔍 Starting Deep Route Scan...");

        // Login as Super Admin to bypass auth middlewares
        Auth::loginUsingId(1);

        $routes = Route::getRoutes();
        $baseUri = config('app.url');
        
        $tested = 0;
        $passed = [];
        $failed = [];
        $skipped = [];

        foreach ($routes as $route) {
            // Only care about GET requests
            if (!in_array('GET', $route->methods())) continue;

            $uri = $route->uri();

            // Only test dashboard/admin routes or main application routes, skip API/ignition
            if (str_contains($uri, '_ignition') || str_contains($uri, 'api/') || str_contains($uri, 'livewire/')) {
                continue;
            }

            // Skip routes with parameters for now to avoid dealing with complex mock data
            if (str_contains($uri, '{')) {
                $skipped[] = $uri . " (Has Parameters)";
                continue;
            }

            $this->output->write("Testing: /" . ltrim($uri, '/') . " ... ");

            try {
                $request = Request::create($uri, 'GET');
                $request->headers->set('Accept', 'application/json');

                // Simulate request through the kernel
                $kernel = app()->make(\Illuminate\Contracts\Http\Kernel::class);
                $response = $kernel->handle($request);

                $status = $response->getStatusCode();

                if ($status >= 500) {
                    $this->error("FAILED ($status)");
                    $content = json_decode($response->getContent(), true);
                    $errMsg = isset($content['message']) ? $content['message'] : substr(strip_tags($response->getContent()), 0, 200);
                    $failed[] = [
                        'uri' => $uri,
                        'status' => $status,
                        'error' => $errMsg
                    ];
                } elseif ($status == 404) {
                    $this->warn("NOT FOUND ($status)");
                    $skipped[] = $uri . " (404 Not Found)";
                } else {
                    $this->info("OK ($status)");
                    $passed[] = $uri;
                }
            } catch (\Exception $e) {
                $this->error("CRASHED: " . $e->getMessage());
                $failed[] = [
                    'uri' => $uri,
                    'status' => 'Exception',
                    'error' => $e->getMessage()
                ];
            }
            
            $tested++;
        }

        // Generate Report Map
        $reportPath = base_path($this->option('output'));
        $content = "# 🗺️ MixJo Project Internal Route Scan Report\n\n";
        $content .= "Date: " . now()->toDateTimeString() . "\n";
        $content .= "Total Routes Tested (Parameter-less): " . $tested . "\n";
        $content .= "✅ Passed: " . count($passed) . "\n";
        $content .= "❌ Failed (500/Crash): " . count($failed) . "\n";
        $content .= "⏭️ Skipped: " . count($skipped) . "\n\n";

        if (count($failed) > 0) {
            $content .= "## ❌ FAILED ROUTES (ACTION REQUIRED)\n";
            foreach ($failed as $f) {
                $content .= "- **`/{$f['uri']}`** -> Status: {$f['status']}\n";
                $content .= "  - Error: `{$f['error']}`\n";
            }
            $content .= "\n";
        }

        $content .= "## ✅ PASSED ROUTES\n";
        foreach ($passed as $p) {
            $content .= "- `/{$p}`\n";
        }

        $content .= "\n## ⏭️ SKIPPED ROUTES\n";
        foreach ($skipped as $s) {
            $content .= "- `/{$s}`\n";
        }

        file_put_contents($reportPath, $content);

        $this->info("\n✅ Scan Complete! Report saved to: {$reportPath}");
        
        return count($failed) > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
