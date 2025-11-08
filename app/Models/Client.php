<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasSearch, HasFactory;

    protected $fillable = [
        'id',

        // Personal name information
        'first_name',
        'last_name',

        // Personal details
        'gender',
        'birth_date',

        // Location information
        'region_id',
        'subregion_id',
        'country_id',
        'state_id',
        'city_id',
        'nationality_id',
        'currency',

        // Passport information
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',

        // Email addresses
        'personal_email',
        'email_primary',
        'work_email',
        'secondary_email',

        // Phone numbers
        'primary_phone',
        'secondary_phone',
        'mobile',
        'home_phone',
        'work_phone',
        'work_phone_ext',
        'fax_number',
        'whatsapp',

        // Company/Business information
        'company_name',
        'company_phone',
        'company_email',
        'job_title',
        'sector',
        'department',
        'business_type',
        'business_registration_number',
        'tax_id',

        // Address information
        'box',
        'postal_code',
        'street_address',
        'address_line_2',

        // Online presence
        'website_url',
        'linkedin_url',

        // Status and preferences
        'status',
        'timezone',
        'notes',

        // Tracking
        'created_by',
        'updated_by',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['region', 'subregion', 'country', 'state', 'city'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return [
            'region_id',
            'subregion_id',
            'country_id',
            'state_id',
            'city_id',
            'nationality_id',
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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subregion()
    {
        return $this->belongsTo(Subregion::class);
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

    // Creator relationship
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updater relationship
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scopes
     */

    // Active clients only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
    // public function scopeOfStatus($query, $status)
    // {
    //     return $query->where('client_status', $status);
    // }

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
}