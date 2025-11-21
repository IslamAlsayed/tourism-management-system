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
    use HasSearch, HasFactory, Notifiable;

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
        'user_status',
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
        'birth_date',
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

    /**
     * Get columns to exclude from search/display
     */
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
            'birth_date' => 'datetime',
            'hire_date' => 'datetime',
        ];
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('Y-m-d') : null;
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getFormattedHireDateAttribute()
    {
        return $this->hire_date ? $this->hire_date->format('Y-m-d') : null;
    }

    public function getDurationAttribute()
    {
        if (!$this->hire_date) {
            return null;
        }

        $diff = $this->hire_date->diff(now());

        $parts = [];

        if ($diff->y > 0) {
            $parts[] = $diff->y . ' ' . ($diff->y == 1 ? __('main.year') : __('main.years'));
        }

        if ($diff->m > 0) {
            $parts[] = $diff->m . ' ' . ($diff->m == 1 ? __('main.month') : __('main.months'));
        }

        if ($diff->d > 0 && $diff->y == 0) {
            $parts[] = $diff->d . ' ' . ($diff->d == 1 ? __('main.day') : __('main.days'));
        }

        return count($parts) ? implode(', ', $parts) : '0 ' . __('main.days');
    }

    /**
     * Get the table column settings for this user
     */
    public function tableColumns()
    {
        return $this->hasMany(TableColumn::class);
    }

    /**
     * Get columns for a specific model class
     */
    public function getTableColumnsFor(string $modelClass)
    {
        $userSettings = $this->tableColumns()
            ->where('model_class', $modelClass)
            ->first();

        return $userSettings ? $userSettings->columns : null;
    }

    /**
     * Save table columns for a specific model class
     */
    public function saveTableColumnsFor(string $modelClass, array $columns)
    {
        $this->tableColumns()->updateOrCreate(
            ['model_class' => $modelClass],
            ['columns' => $columns]
        );
    }

    /**
     * Delete table columns settings for a specific model class
     */
    public function deleteTableColumnsFor(string $modelClass)
    {
        $this->tableColumns()
            ->where('model_class', $modelClass)
            ->delete();
    }
}