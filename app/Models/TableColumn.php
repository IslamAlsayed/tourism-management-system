<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableColumn extends Model
{
    protected $fillable = [
        'user_id',
        'model_class',
        'columns',
    ];

    protected $casts = ['columns' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}