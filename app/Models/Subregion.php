<?php

namespace App\Models;


use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Subregion extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'wiki_data_id',
        'region_id',
    ];

    public function getRelationshipNames()
    {
        return ['region'];
    }

    public function getExcludedColumns()
    {
        return ['region_id'];
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}