<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportUpdateDataToDBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $model, protected $data, protected $columnKey = 'name')
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
                $this->model::updateOrCreate([$this->columnKey => $item[$this->columnKey]], $item);
            }
            return;
        }
        $this->model::updateOrCreate([$this->columnKey => $data[$this->columnKey]], $data);
    }
}