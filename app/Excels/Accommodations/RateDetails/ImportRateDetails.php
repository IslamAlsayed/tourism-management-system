<?php

namespace App\Excels\Accommodations\RateDetails;

use App\Models\Rate;
use App\Models\Season;
use App\Models\Currency;
use App\Models\RateDetail;
use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportRateDetails implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        $headers = $rows->first()->toArray();

        $batchSize = 1000;
        $batchData = [];

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;

            $accommodationId = $row[array_search('accommodation_id', $headers)] ?? null;

            $rate = Rate::where('accommodation_id', $accommodationId)->first();

            if (!$rate) {
                continue;
            }

            $priceColumns = [
                'p.p.double_room' => 'double_room',
                'single_room_supp' => 'single_room_supp',
                'triple_room' => 'triple_room',
                '3rd person' => 'third_person',
            ];

            $data = [];

            foreach ($priceColumns as $excelColumn => $priceType) {
                $excelKey = array_search($excelColumn, $headers);

                if ($excelKey !== false && isset($row[$excelKey])) {
                    $price = (float) $row[$excelKey] ?? 0.0;

                    if ($price !== 0.0 && $price !== '') {
                        $data[] = [
                            'rate_id' => $rate->id,
                            'room_type_id' => null,
                            'price_type' => $priceType,
                            'price' => $price,
                        ];
                    }
                }
            }

            $batchData[] = $data;

            // Send batch job when full
            if (count($batchData) >= $batchSize) {
                // ImportDataToDBJob::dispatch(RateDetail::class, $batchData);
                foreach ($batchData as $item) {
                    RateDetail::create($item);
                }
                $this->rowCount += count($batchData);
                $batchData = [];
            }
        }

        // Send remaining data
        if (count($batchData) > 0) {
            // ImportDataToDBJob::dispatch(RateDetail::class, $batchData);
            foreach ($batchData as $item) {
                RateDetail::create($item);
            }
            $this->rowCount += count($batchData);
        }
    }
}