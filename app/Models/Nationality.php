<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'is_active',
        'country_id',
    ];

    public function getRelationshipNames()
    {
        return ['country'];
    }

    public function getExcludedColumns()
    {
        return ['country_id'];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}