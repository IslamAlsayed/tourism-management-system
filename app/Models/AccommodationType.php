<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AccommodationType extends Pivot
{
    protected $table = 'accommodation_types';
    public $timestamps = true;
    protected $fillable = ['accommodation_id', 'type_id', 'notes'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}