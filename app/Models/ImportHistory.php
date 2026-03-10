<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasUuid;
use Modules\Core\Entities\User;

class ImportHistory extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'model_type',
        'user_id',
        'record_count',
        'source',
        'status',
        'error_message',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
