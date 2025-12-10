<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class RichText extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'record_id',
        'record_type',
        'field',
        'body',
    ];

    /**
     * Get the owning model.
     */
    public function record()
    {
        return $this->morphTo();
    }
}
