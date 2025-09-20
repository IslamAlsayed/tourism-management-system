<?php

namespace App\Excels\Accommodations\Accommodations;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportAccommodations implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->type_id,
                $data->name,
                $data->name_ar,
                $data->classification,
                $data->stars,
                $data->cat,
                $data->description,
                $data->is_active,
                $data->general_mobile,
                $data->general_email,
                $data->email,
                $data->website,
                $data->phone,
                $data->phone_ext,
                $data->fax,
                $data->contact_person,
                $data->contact_position,
                $data->contact_mobile,
                $data->contact_email,
                $data->country_id,
                $data->city_id,
                $data->region_id,
                $data->street,
                $data->box,
                $data->postal_code,
                $data->latitude,
                $data->longitude,
                $data->contract_file_path,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'type_id',
            'name',
            'name_ar',
            'classification',
            'stars',
            'cat',
            'description',
            'is_active',
            'general_mobile',
            'general_email',
            'email',
            'website',
            'phone',
            'phone_ext',
            'fax',
            'contact_person',
            'contact_position',
            'contact_mobile',
            'contact_email',
            'country_id',
            'city_id',
            'region_id',
            'street',
            'box',
            'postal_code',
            'latitude',
            'longitude',
            'contract_file_path',
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