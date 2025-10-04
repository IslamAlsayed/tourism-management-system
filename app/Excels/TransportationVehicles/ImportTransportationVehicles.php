<?php

namespace App\Excels\TransportationVehicles;

use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\TransportationCarRoute;
use App\Models\TransportationCarRoutePrice;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTransportationVehicles implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $headers = $rows->first()->toArray();

        foreach ($rows as $index => $row) {
            if ($index === 0)
                continue;

            $routeIndex = array_search('route', $headers);
            $routeArIndex = array_search('route_ar', $headers);
            $durationIndex = array_search('duration', $headers);
            $distanceIndex = array_search('distance', $headers);
            $currencyIndex = array_search('currency_id', $headers);
            $priceIndex = array_search('price', $headers);
            $seatsIndex = array_search('seats', $headers);

            $data = [
                'route' => isset($row[$routeIndex]) ? trim($row[$routeIndex]) : null,
                'route_ar' => isset($row[$routeArIndex]) ? trim($row[$routeArIndex]) : null,
                'duration' => $row[$durationIndex] ?? null,
                'distance' => $row[$distanceIndex] ?? null,
            ];

            Log::info('Importing route: ' . json_encode($data));

            $currency_id = $row[$currencyIndex] ?? null;
            $price = $row[$priceIndex] ?? null;
            $seats = $row[$seatsIndex] ?? null;

            if (empty($data['route']) && empty($data['route_ar']))
                continue;

            $route = TransportationCarRoute::create($data);

            if (!$route)
                continue;

            Log::info(json_encode($route));

            TransportationCarRoutePrice::create([
                'car_route_id' => $route->id,
                'seats' => $seats,
                'currency_id' => $currency_id,
                'price' => $price,
            ]);

            $this->rowCount++;
        }
    }
}