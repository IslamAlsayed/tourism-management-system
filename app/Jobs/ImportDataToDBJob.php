<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportDataToDBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $model, protected $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if (!class_exists($this->model)) {
            \Log::error("Model {$this->model} not found.");
            return;
        }

        $data = $this->data;
        if (is_array($data)) {
            foreach ($data as $item) {
                $this->model::create($item);
            }
            return;
        }
        $this->model::create($data);
    }
}