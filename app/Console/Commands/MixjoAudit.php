<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MixjoAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mixjo:audit {--url= : Optional URL for deep performance tests}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the master Antigravity Kit checklist for security, schema, and testing.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Antigravity Master Checklist...');

        $url = $this->option('url');
        $scriptPath = base_path('.agent/scripts/checklist.py');

        $command = ['python', $scriptPath, base_path()];
        if ($url) {
            $command[] = '--url';
            $command[] = $url;
        }

        $process = new Process($command);
        $process->setTimeout(600); 

        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (!$process->isSuccessful()) {
            $this->error('❌ Audit Failed! Please fix the errors reported above.');
            return Command::FAILURE;
        }

        $this->info('✅ Audit completed successfully.');
        return Command::SUCCESS;
    }
}
