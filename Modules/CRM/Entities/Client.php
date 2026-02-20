<?php

namespace Modules\CRM\Entities;

use App\Traits\BroadcastsRecordEvents;
use App\Traits\ClearsEmptyRichText;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\User;
use Modules\CRM\Database\Factories\ClientFactory;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Nationality;
use Modules\Geography\Entities\State;
use Modules\Localization\Entities\Currency;
use Modules\Localization\Entities\Timezone;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Client extends Model
{
    use HasSearch, HasRichText, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, ClearsEmptyRichText;
    protected $richTextAttributes = [
        'description',
        'notes',
    ];

    protected $fillable = [
        'id',
        'uuid',
        'code',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',
        'personal_email',
        'email_primary',
        'work_email',
        'secondary_email',
        'primary_phone',
        'secondary_phone',
        'mobile',
        'home_phone',
        'work_phone',
        'work_phone_ext',
        'fax_number',
        'company_name',
        'job_title',
        'sector',
        'department',
        'business_type',
        'business_registration_number',
        'tax_id',
        'box',
        'postal_code',
        'street_address',
        'address_line_2',
        'website_url',
        'linkedin_url',
        'client_status',
        'whatsapp',
        'company_phone',
        'company_email',
        'is_active',
        'description',
        'notes',
        'currency_id',
        'timezone_id',
        'country_id',
        'state_id',
        'city_id',
        'nationality_id',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($item) {
            // Auto-fill code
            if (empty($item->code)) {
                $item->code = generateCode('CLT-', 5);
            }
        });
    }

    public function getRelationshipNames()
    {
        return ['timezone', 'currency', 'country', 'state', 'city', 'nationality', 'creator', 'updater'];
    }

    public function getExcludedColumns()
    {
        return [
            'timezone_id',
            'currency_id',
            'country_id',
            'state_id',
            'city_id',
            'nationality_id',
            'description',
            'notes'
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'datetime',
        'passport_issue_date' => 'datetime',
        'passport_expiry_date' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('Y-m-d') : null;
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    /**
     * Relationships
     */

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Verified clients only
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Filter by client type
    public function scopeOfType($query, $type)
    {
        return $query->where('client_type', $type);
    }

    // Filter by client status
    public function scopeOfStatus($query, $status)
    {
        return $query->where('client_status', $status);
    }

    /**
     * Accessors & Mutators
     */

    // Get full name
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Get client display name (company or personal)
    public function getDisplayNameAttribute()
    {
        return $this->client_type === 'corporate' && $this->company_name
            ? $this->company_name
            : $this->full_name;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return ClientFactory::new();
    }
}
