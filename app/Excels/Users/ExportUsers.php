<?php

namespace App\Excels\Users;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportUsers implements FromArray, WithHeadings, WithCustomCsvSettings
{
    protected $arrayData;

    public function __construct($arrayData)
    {
        $this->arrayData = $arrayData;
    }

    public function array(): array
    {
        $list = [];
        foreach ($this->arrayData as $data) {
            $list[] = [
                $data->name,
                $data->email,
                $data->password,
                $data->bio,
                $data->phone,
                $data->first_name,
                $data->last_name,
                $data->phone,
                $data->mobile,
                $data->address,
                $data->user_code,
                $data->employee_id,
                $data->hire_date,
                $data->department,
                $data->position,
                $data->preferred_language,
                $data->timezone,
                $data->preferences,
                $data->email_verified_at,
                $data->is_admin,
                $data->photo,
                $data->is_active,
                $data->is_verified,
                $data->force_password_change,
                $data->last_login_at,
                $data->last_login_ip,
                $data->notes,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'password',
            'bio',
            'phone',
            'first_name',
            'last_name',
            'phone',
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
            'email_verified_at',
            'is_admin',
            'photo',
            'is_active',
            'is_verified',
            'force_password_change',
            'last_login_at',
            'last_login_ip',
            'notes',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => true, // <--- دي مهمة جداً للغة العربية
        ];
    }
}