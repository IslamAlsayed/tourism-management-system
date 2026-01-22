<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'uuid',
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
        'timezone_id',
        'preferences',
        'role',
        'is_active',
        'is_verified',
        'password_changed_at',
        'force_password_change',
        'last_login_at',
        'last_login_ip',
        'button_display_mode',
        'notes',
        'created_by',
        'updated_by',
    ];

    /**
     * Get relationship names for eager loading
     */
    public function getRelationshipNames()
    {
        return ['timezone', 'creator', 'updater'];
    }

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
            'user_status',
            'timezone_id',
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

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeIsAdmin($query)
    {
        return $query->where('role', 'admin')->orWhere('role', 'superadmin');
    }

    public function scopeIsNotAdmin($query)
    {
        return $query->where('role', '!=', 'admin')->where('role', '!=', 'superadmin');
    }

    public function scopeWithNotMe($query)
    {
        return $query->where('id', '!=', getActiveUser()?->id);
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

    public function getHumanLastLoginAtAttribute()
    {
        return $this->last_login_at ? \Carbon\Carbon::parse($this->last_login_at)->diffForHumans() : null;
    }

    public function getHumanPasswordChangedAtAttribute()
    {
        return $this->password_changed_at ? \Carbon\Carbon::parse($this->password_changed_at)->diffForHumans() : null;
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
