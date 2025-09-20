<?php

namespace App\Excels\Accommodations\Seasons;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ExportSeasons implements FromArray, WithHeadings, WithCustomCsvSettings
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
                $data->season_name,
                $data->season_from,
                $data->season_to,
                $data->is_special,
                $data->special_type,
                $data->accommodation_id,
            ];
        }
        return $list;
    }

    public function headings(): array
    {
        return [
            'season_name',
            'season_from',
            'season_to',
            'is_special',
            'special_type',
            'accommodation_id',
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