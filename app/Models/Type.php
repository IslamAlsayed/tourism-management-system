<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name',
        'name_ar'
    ];

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'type_id');
    }
}