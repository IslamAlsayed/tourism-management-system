<?php

namespace App\Excels\TourGuides;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportTourGuides implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->name_ar,
                $data->email,
                $data->mobile_01,
                $data->mobile_02,
                $data->home_city,
                $data->birth_year,
                $data->gender,
                $data->national_guide_id,
                $data->tourism_ministry_code,
                $data->fd_day_fees,
                $data->hd_day_fees,
                $data->extra_fees_1,
                $data->extra_fees_2,
                $data->status,
                $data->notes,
                $data->country_id,
                $data->currency_id,
                $data->languages->ids,
                $data->guide_type_id,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'name',
            'name_ar',
            'email',
            'mobile_01',
            'mobile_02',
            'home_city',
            'birth_year',
            'gender',
            'national_guide_id',
            'tourism_ministry_code',
            'fd_day_fees',
            'hd_day_fees',
            'extra_fees_1',
            'extra_fees_2',
            'status',
            'notes',
            'country_id',
            'currency_id',
            'languages_ids',
            'guide_type_id',
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