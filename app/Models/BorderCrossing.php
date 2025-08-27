<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorderCrossing extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_type',
        'nullable',
        'default_value',
    ];
}