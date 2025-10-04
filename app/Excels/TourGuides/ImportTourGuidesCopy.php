<?php

namespace App\Excels\TourGuides;

use App\Models\TourGuide;
use App\Models\GuideLanguage;
use App\Jobs\ImportDataToDBJob;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTourGuidesCopy implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty())
            return;

        $allFillable = (new TourGuide())->getFillable();
        $relations = method_exists((new TourGuide()), 'getRelationshipNames') ? (new TourGuide())->getRelationshipNames() : [];
        $fillableTourGuide = array_filter($allFillable, fn($c) => !in_array($c, $relations));

        $fillableTourGuide = (new TourGuideLanguage())->getFillable();
        $allFillable = (new TourGuideLanguage())->getFillable();
        $relations = method_exists((new TourGuideLanguage()), 'getRelationshipNames') ? (new TourGuideLanguage())->getRelationshipNames() : [];
        $fillableTourGuideLang = array_filter($allFillable, fn($c) => !in_array($c, $relations));

        $headers = $rows->first()->toArray();

        $batchSize = 1000;
        $batchTourGuideLangs = [];

        foreach ($rows as $index => $row) {
            if ($index === 0)
                continue; // Skip header

            $rowArray = $row->toArray();
            $dataTourGuide = [];
            $guideLanguageIds = [];

            // ✅ 1. تجهيز بيانات TourGuide
            foreach ($fillableTourGuide as $column) {
                if (in_array($column, $headers)) {
                    $excelKey = array_search($column, $headers);
                    $dataTourGuide[$column] = isset($rowArray[$excelKey]) ? $rowArray[$excelKey] : null;
                }
            }

            Log::info('Prepared TourGuide Data: ' . json_encode($dataTourGuide));

            // ✅ 2. استخراج اللغات لو العمود موجود
            // if (in_array('guide_language', $headers)) {
            //     $excelKey = array_search('guide_language', $headers);
            //     if (isset($rowArray[$excelKey])) {
            //         $langs = explode('،', $rowArray[$excelKey]);

            //         foreach ($langs as $lang) {
            //             $lang = ucfirst(trim($lang));

            //             if (!empty($lang)) {
            //                 $guideLang = GuideLanguage::updateOrCreate(
            //                     ['name' => $lang],
            //                     ['name' => $lang]
            //                 );

            //                 Log::info('Created/Found GuideLanguage: ' . $guideLang->name);

            //                 if ($guideLang) {
            //                     $guideLanguageIds[] = $guideLang->id;
            //                 }
            //             }
            //         }
            //     }
            // }

            // ✅ 3. إنشاء TourGuide فقط لو فيه بيانات
            // if (!empty($dataTourGuide)) {
            //     $tourGuide = TourGuide::updateOrCreate(['name' => $dataTourGuide['name']], $dataTourGuide);

            //     // ✅ 4. ربط اللغات لو فيه لغات
            //     if (!empty($guideLanguageIds)) {
            //         foreach ($guideLanguageIds as $langId) {
            //             $batchTourGuideLangs[] = [
            //                 'tour_guide_id' => $tourGuide->id,
            //                 'guide_language_id' => $langId,
            //             ];

            //             Log::info('Created/Found GuideLanguage: ' . $langId);
            //         }
            //     }

            //     $this->rowCount++;
            // }

            // // ✅ 5. حفظ كل batch
            // if (count($batchTourGuideLangs) >= $batchSize) {
            //     foreach ($batchTourGuideLangs as $batchTourGuideLang) {
            //         TourGuideLanguage::create($batchTourGuideLang);
            //     }
            //     // TourGuideLanguage::insert($batchTourGuideLangs);
            //     $batchTourGuideLangs = [];
            // }
        }

        // ✅ 6. حفظ أي بيانات متبقية
        if (count($batchTourGuideLangs) > 0) {
            foreach ($batchTourGuideLangs as $batchTourGuideLang) {
                TourGuideLanguage::create($batchTourGuideLang);
            }
            // TourGuideLanguage::insert($batchTourGuideLangs);
        }
    }
}