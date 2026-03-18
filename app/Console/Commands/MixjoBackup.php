<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MixjoBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mixjo:backup {--message= : Custom commit message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely commits and pushes all current changes to the emix37 branch on GitHub.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔒 Starting MixJo Daily Safe Backup to GitHub (Branch: emix37)...');

        $message = $this->option('message') ?? 'Daily automated safe backup and checkpoint - ' . now()->format('Y-m-d H:i:s');

        // 1. Git Add All
        $this->runProcess(['git', 'add', '.']);
        
        // 2. Git Commit
        $this->runProcess(['git', 'commit', '-m', $message], true); // Allow empty commit status

        // 3. Git Push
        $this->info('📤 Uploading to GitHub...');
        $pushProcess = $this->runProcess(['git', 'push', 'tawfiq', 'emix37']);

        if ($pushProcess->isSuccessful()) {
            $this->info('✅ Backup completed successfully. All files synced to branch emix37!');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Push failed. Check your internet connection or git permissions.');
            return Command::FAILURE;
        }
    }

    private function runProcess(array $command, bool $ignoreFailure = false)
    {
        $process = new Process($command);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(300);

        $process->run(function ($type, $buffer) {
            // Uncomment next line for detailed step tracking, but keep silent for clean UI
            // $this->line($buffer);
        });

        if (!$process->isSuccessful() && !$ignoreFailure) {
            $this->error("Command failed: " . implode(' ', $command));
            $this->error($process->getErrorOutput());
        }

        return $process;
    }
}
