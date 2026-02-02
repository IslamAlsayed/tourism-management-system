<?php

namespace App\Console\Commands;

use App\Jobs\UpdateTimestamps;
use Illuminate\Console\Command;

class UpdateDatabaseTimestamps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update-timestamps
                            {--queue : استخدام queue لتنفيذ العملية}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث أعمدة created_at و updated_at بالوقت الحالي في كل الجداول';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('جاري تحديث الأعمدة...');

        if ($this->option('queue')) {
            UpdateTimestamps::dispatch();
            $this->info('✓ تم إرسال المهمة إلى الـ Queue');
        } else {
            (new UpdateTimestamps())->handle();
            $this->info('✓ تم إكمال التحديث بنجاح');
        }

        return self::SUCCESS;
    }
}
