<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasSearch;

    protected $fillable = [
        'id',
        'app_name',
        'app_url',
        'app_timezone',
        'app_language',
        'app_version',
        'app_php_version',
        'app_columns_length',
        'photo',
        'app_status',
        'app_password_length',
        'app_session_lifetime',
        'app_password_confirmation',
        'app_two_factor_authentication',
        'app_backup_frequency',
        'app_auto_backup',
        'app_email_notifications',
        'app_sms_notifications',
        'app_push_notifications',
        'app_notifications_new_user',
        'app_notifications_data_update',
        'app_notifications_system_report',
        'app_notifications_security_update',
        'app_paginate_count',
    ];
}