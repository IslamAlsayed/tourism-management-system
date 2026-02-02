<?php

namespace App\Console\Commands;

use App\Jobs\UpdateUserColumns;
use Illuminate\Console\Command;

class UpdateDatabaseUserColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update-user-columns
                            {--queue : استخدام queue لتنفيذ العملية}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث أعمدة created_by و updated_by بقيمة 2 في كل الجداول';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('جاري تحديث أعمدة المستخدم...');

        if ($this->option('queue')) {
            UpdateUserColumns::dispatch();
            $this->info('✓ تم إرسال المهمة إلى الـ Queue');
        } else {
            (new UpdateUserColumns())->handle();
            $this->info('✓ تم إكمال التحديث بنجاح');
        }

        return self::SUCCESS;
    }
}
