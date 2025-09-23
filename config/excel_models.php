<?php
/**
 * Configuration file for Excel import/export models.
 *
 * This file maps model keys to their respective titles, Eloquent model classes,
 * and Excel importer/exporter classes. It is used to manage the import and export
 * functionality for various entities in the application via Excel files.
 */

return [
    'users' => [
        'title' => 'users',
        'model' => \App\Models\User::class,
        'importer' => \App\Excels\Users\ImportUsers::class,
        'exporter' => \App\Excels\Users\ExportUsers::class,
    ],
    'currencies' => [
        'title' => 'currencies',
        'model' => \App\Models\Currency::class,
        'importer' => \App\Excels\Currencies\ImportCurrencies::class,
        'exporter' => \App\Excels\Currencies\ExportCurrencies::class,
    ],
    'regions' => [
        'title' => 'regions',
        'model' => \App\Models\Region::class,
        'importer' => \App\Excels\Regions\ImportRegions::class,
        'exporter' => \App\Excels\Regions\ExportRegions::class,
    ],
    'subregions' => [
        'title' => 'subregions',
        'model' => \App\Models\Subregion::class,
        'importer' => \App\Excels\Subregions\ImportSubregions::class,
        'exporter' => \App\Excels\Subregions\ExportSubregions::class,
    ],
    'countries' => [
        'title' => 'countries',
        'model' => \App\Models\Country::class,
        'importer' => \App\Excels\Countries\ImportCountries::class,
        'exporter' => \App\Excels\Countries\ExportCountries::class,
    ],
    'states' => [
        'title' => 'states',
        'model' => \App\Models\State::class,
        'importer' => \App\Excels\States\ImportStates::class,
        'exporter' => \App\Excels\States\ExportStates::class,
    ],
    'cities' => [
        'title' => 'cities',
        'model' => \App\Models\City::class,
        'importer' => \App\Excels\Cities\ImportCities::class,
        'exporter' => \App\Excels\Cities\ExportCities::class,
    ],
    'nationalities' => [
        'title' => 'nationalities',
        'model' => \App\Models\Nationality::class,
        'importer' => \App\Excels\Nationalities\ImportNationalities::class,
        'exporter' => \App\Excels\Nationalities\ExportNationalities::class,
    ],
    'restaurants' => [
        'title' => 'restaurants',
        'model' => \App\Models\Restaurant::class,
        'importer' => \App\Excels\Restaurants\ImportRestaurants::class,
        'exporter' => \App\Excels\Restaurants\ExportRestaurants::class,
    ],

    // Accommodations
    'accommodations' => [
        'title' => 'accommodations',
        'model' => \App\Models\Accommodation::class,
        'importer' => \App\Excels\Accommodations\Accommodations\ImportAccommodations::class,
        'exporter' => \App\Excels\Accommodations\Accommodations\ExportAccommodations::class,
    ],
    'types' => [
        'title' => 'types',
        'model' => \App\Models\Type::class,
        'importer' => \App\Excels\Accommodations\Types\ImportTypes::class,
        'exporter' => \App\Excels\Accommodations\Types\ExportTypes::class,
    ],
    'hotels' => [
        'title' => 'hotels',
        'model' => \App\Models\Hotel::class,
        'importer' => \App\Excels\Accommodations\Hotels\ImportHotels::class,
        'exporter' => \App\Excels\Accommodations\Hotels\ExportHotels::class,
    ],
    'seasons' => [
        'title' => 'seasons',
        'model' => \App\Models\Season::class,
        'importer' => \App\Excels\Accommodations\Seasons\ImportSeasons::class,
        'exporter' => \App\Excels\Accommodations\Seasons\ExportSeasons::class,
    ],
    'supplements' => [
        'title' => 'supplements',
        'model' => \App\Models\Supplement::class,
        'importer' => \App\Excels\Accommodations\Supplements\ImportSupplements::class,
        'exporter' => \App\Excels\Accommodations\Supplements\ExportSupplements::class,
    ],
    'roomsTypes' => [
        'title' => 'roomsTypes',
        'model' => \App\Models\RoomType::class,
        'importer' => \App\Excels\Accommodations\RoomsTypes\ImportRoomsTypes::class,
        'exporter' => \App\Excels\Accommodations\RoomsTypes\ExportRoomsTypes::class,
    ],
    'rate' => [
        'title' => 'rates',
        'model' => \App\Models\Rate::class,
        'importer' => \App\Excels\Accommodations\Rates\ImportRates::class,
        'exporter' => \App\Excels\Accommodations\Rates\ExportRates::class,
    ],
    'rate_details' => [
        'title' => 'rate_details',
        'model' => \App\Models\RateDetail::class,
        'importer' => \App\Excels\Accommodations\RateDetails\ImportRateDetails::class,
        'exporter' => \App\Excels\Accommodations\RateDetails\ExportRateDetails::class,
    ],
];