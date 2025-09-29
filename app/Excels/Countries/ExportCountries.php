<?php

namespace App\Excels\Countries;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportCountries implements FromArray, WithHeadings, WithCustomCsvSettings
{
    protected $arrayData;

    public function __construct($arrayData)
    {
        $this->arrayData = $arrayData;
    }

    public function array(): array
    {
        $list = [];
        foreach ($this->arrayData as $key => $data) {
            $list[] = [
                $data->name,
                $data->name_ar,
                $data->iso2,
                $data->iso3,
                $data->numeric_code,
                $data->phone_code,
                $data->capital,
                $data->tld,
                $data->native,
                $data->timezone,
                $data->latitude,
                $data->longitude,
                $data->emoji,
                $data->emojiU,
                $data->population,
                $data->flag_url,
                $data->photo,
                $data->continent,
                $data->area,
                $data->is_active,
                $data->wikipedia_link,
                $data->currency_id,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'iso2',
            'iso3',
            'numeric_code',
            'phone_code',
            'capital',
            'tld',
            'native',
            'timezone',
            'latitude',
            'longitude',
            'emoji',
            'emojiU',
            'population',
            'flag_url',
            'photo',
            'continent',
            'area',
            'is_active',
            'wikipedia_link',
            'currency_id',
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