<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasSearch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasSearch,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'photo',
        'name',
        'email',
        'email_verified_at',
        'password',
        'bio',
        'phone',
        'first_name',
        'last_name',
        'mobile',
        'address',
        'user_code',
        'employee_id',
        'hire_date',
        'department',
        'position',
        'preferred_language',
        'timezone',
        'preferences',
        'is_admin',
        'is_active',
        'is_verified',
        'force_password_change',
        'last_login_at',
        'last_login_ip',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function getExcludedColumns()
    {
        return [
            'password',
            'bio',
            'first_name',
            'last_name',
            'employee_id',
            'email_verified_at',
            'force_password_change',
            'preferred_language',
            'preferences',
            'last_login_at',
            'last_login_ip',
            'notes',
            'created_by',
            'updated_by',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}