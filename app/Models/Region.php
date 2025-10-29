<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'wiki_data_id'
    ];

    public function subregions()
    {
        return $this->hasMany(Subregion::class);
    }
}