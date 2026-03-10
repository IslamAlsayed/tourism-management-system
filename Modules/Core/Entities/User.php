<?php

namespace Modules\Core\Entities;

use App\Models\TableColumn;
use App\Traits\BroadcastsRecordEvents;
use App\Traits\FiltersByUserRole;
use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Modules\Geography\Entities\Country;
use Modules\Localization\Entities\Timezone;
use Modules\Subscriptions\Entities\Subscription;
use Modules\Subscriptions\Traits\HasSubscriptions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, HasApiTokens, Notifiable, HasSearch, HasUuid, FiltersByUserRole, BroadcastsRecordEvents, HasSubscriptions;

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
        'company_name',
        'company_website',
        'country_id',
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

    public function getRelationshipNames()
    {
        return ['timezone', 'creator', 'updater'];
    }

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'datetime',
            'hire_date' => 'datetime',
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Modules\Core\Database\Factories\UserFactory::new();
    }

    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
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
        return $query->where('id', '!=', getActiveUserId());
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

    public function tableColumns()
    {
        return $this->hasMany(TableColumn::class);
    }

    public function getTableColumnsFor(string $modelClass)
    {
        $userSettings = $this->tableColumns()
            ->where('model_class', $modelClass)
            ->first();

        return $userSettings ? $userSettings->columns : null;
    }

    public function saveTableColumnsFor(string $modelClass, array $columns)
    {
        $this->tableColumns()->updateOrCreate(
            ['model_class' => $modelClass],
            ['columns' => $columns]
        );
    }

    public function deleteTableColumnsFor(string $modelClass)
    {
        $this->tableColumns()->where('model_class', $modelClass)->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'tenant_id');
    }

    public function getActiveModules()
    {
        return $this->subscriptions()->where('is_active', true)->pluck('module_key')->toArray();
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }
}
