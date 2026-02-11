<?php

namespace Modules\Transportation\Entities;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyContact extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'transportations_company_contacts';

    protected $fillable = [
        'id',
        'uuid',
        'company_id',
        'department',
        'contact_person',
        'email',
        'phone',
        'mobile',
        'fax',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
