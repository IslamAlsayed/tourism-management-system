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

    /**
     * Render the rich text as HTML.
     */
    public function render()
    {
        return $this->body;
    }

    /**
     * Convert the model to string (HTML content).
     */
    public function __toString()
    {
        return (string) ($this->render() ?? '');
    }
}
