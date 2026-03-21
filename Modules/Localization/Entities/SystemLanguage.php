<?php

namespace Modules\Localization\Entities;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
class SystemLanguage extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'code',
        'name',
        'name_ar',
        'native',
        'dir',
        'photo',
        'is_active',
        'is_default',
        'sort_order',
    ];

    public function getExcludedColumns()
    {
        return ['is_active', 'is_default', 'uuid'];
    }
}
