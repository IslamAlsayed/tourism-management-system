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
        'file_name',
        'record_count',
        'total_records',
        'processed_records',
        'source',
        'status',
        'error_message',
        'file_path',
        'error_log',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
