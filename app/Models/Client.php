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
        'photo',
        'name',
        'email',
        'phone',
        'first_name',
        'last_name',
        'mobile',
        'address',
        'client_code',
        'company_name',
        'company_address',
        'tax_number',
        'commercial_registration',
        'passport_number',
        'id_number',
        'birth_date',
        'preferred_language',
        'timezone',
        'preferences',
        'client_type', // individual, corporate
        'client_status', // active, inactive, blacklisted
        'credit_limit',
        'payment_terms',
        'discount_rate',
        'is_active',
        'is_verified',
        'notes',
        'created_by',
        'updated_by',
        'nationality_id',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['nationality'];
    }

    /**
     * Get columns to exclude from search/display
     */
    public function getExcludedColumns()
    {
        return [
            'nationality_id',
            'preferences',
            'tax_number',
            'commercial_registration',
            'passport_number',
            'id_number',
            'credit_limit',
            'payment_terms',
            'discount_rate',
            'notes',
            'created_by',
            'updated_by',
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'credit_limit' => 'decimal:2',
            'discount_rate' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */

    // Nationality relationship
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
}