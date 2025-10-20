<?php

namespace App\Excels\TourGuides;

use App\Models\TourGuide;
use App\Models\Language;
use App\Jobs\ImportDataToDBJob;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportTourGuides implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty())
            return;

        $allFillable = (new TourGuide())->getFillable();
        $relations = method_exists((new TourGuide()), 'getRelationshipNames') ? (new TourGuide())->getRelationshipNames() : [];
        $fillableTourGuide = array_filter($allFillable, fn($c) => !in_array($c, $relations));

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
            $languageIds = [];

            // ✅ 1. تجهيز بيانات TourGuide
            foreach ($fillableTourGuide as $column) {
                if (in_array($column, $headers)) {
                    $excelKey = array_search($column, $headers);
                    $dataTourGuide[$column] = isset($rowArray[$excelKey]) ? $rowArray[$excelKey] : null;
                }
            }

            if (in_array('language', $headers)) {
                $excelKey = array_search('language', $headers);
                if (isset($rowArray[$excelKey])) {
                    $langs = explode('،', $rowArray[$excelKey]);

                    foreach ($langs as $lang) {
                        $lang = ucfirst(trim($lang));

                        if (!empty($lang)) {
                            $guideLang = Language::updateOrCreate(['name' => $lang], ['name' => $lang]);
                            if ($guideLang) {
                                $languageIds[] = $guideLang->id;
                            }
                        }
                    }
                }
            }

            if (!empty($dataTourGuide)) {
                $tourGuide = TourGuide::updateOrCreate(['name' => $dataTourGuide['name']], $dataTourGuide);

                if (!empty($languageIds)) {
                    foreach ($languageIds as $langId) {
                        $batchTourGuideLangs[] = [
                            'tour_guide_id' => $tourGuide->id,
                            'language_id' => $langId,
                        ];
                    }
                }

                $this->rowCount++;
            }

            if (count($batchTourGuideLangs) >= $batchSize) {
                // foreach ($batchTourGuideLangs as $batchTourGuideLang) {
                //     TourGuideLanguage::create($batchTourGuideLang);
                // }
                TourGuideLanguage::insert($batchTourGuideLangs);
                $batchTourGuideLangs = [];
            }
        }

        if (count($batchTourGuideLangs) > 0) {
            // foreach ($batchTourGuideLangs as $batchTourGuideLang) {
            //     TourGuideLanguage::create($batchTourGuideLang);
            // }
            TourGuideLanguage::insert($batchTourGuideLangs);
        }
    }
}