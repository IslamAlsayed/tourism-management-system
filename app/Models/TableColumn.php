<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class TableColumn extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
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
