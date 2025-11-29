<?php

namespace App\Events;

class RecordEvent
{
    public function __construct(public $status, public $record = null, public $type = null)
    {
        $this->status = $status;
        $this->record = $record;
        $this->type = $type;
    }
}