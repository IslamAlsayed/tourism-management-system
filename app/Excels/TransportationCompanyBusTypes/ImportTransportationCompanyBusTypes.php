<?php

namespace App\Excels\TransportationCompanyBusTypes;

use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use App\Models\TransportationBusType;
use App\Models\TransportationCompany;
use App\Models\TransportationCompanyBusType;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTransportationCompanyBusTypes implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $headers = $rows->first()->toArray();

        foreach ($rows as $index => $row) {
            if ($index === 0)
                continue;

            $companyName = trim($row[array_search('company_name', $headers)]);
            $companyNameAr = $row[array_search('company_name_ar', $headers)] ?? null;
            $busTypeName = trim($row[array_search('bus_type', $headers)]);
            $minSeats = $row[array_search('min_seats', $headers)] ?? null;
            $maxSeats = $row[array_search('max_seats', $headers)] ?? null;
            $seats = $row[array_search('seats', $headers)] ?? null;

            // ✅ Basic validation
            if (empty($companyName) || empty($busTypeName))
                continue;

            if ($minSeats && !is_numeric($minSeats))
                $minSeats = null;
            if ($maxSeats && !is_numeric($maxSeats))
                $maxSeats = null;
            if ($seats && !is_numeric($seats))
                $seats = null;

            $busTypeName = ucfirst(strtolower($busTypeName));

            $company = TransportationCompany::firstOrCreate(['name' => $companyName], ['name_ar' => $companyNameAr]);
            $busType = TransportationBusType::firstOrCreate(['name' => $busTypeName], ['name_ar' => $busTypeName]);

            TransportationCompanyBusType::create([
                'company_id' => $company->id,
                'bus_type_id' => $busType->id,
                'min_seats' => $minSeats,
                'max_seats' => $maxSeats,
                'seats' => $seats,
            ]);

            $this->rowCount++;
        }
    }
}