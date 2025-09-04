<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\HotelSeason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class HotelSeasonSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HotelSeason::truncate();
        Schema::enableForeignKeyConstraints();

        $seasons = [
            'Spring' => ['start' => '2025-03-21', 'end' => '2025-06-20'],
            'Summer' => ['start' => '2025-06-21', 'end' => '2025-09-20'],
            'Autumn' => ['start' => '2025-09-21', 'end' => '2025-12-20'],
            'Winter' => ['start' => '2025-12-21', 'end' => '2025-03-20'],
        ];

        foreach (Hotel::all() as $hotel) {
            foreach ($seasons as $season_name => $dates) {
                HotelSeason::create([
                    'season_name' => $season_name,
                    'hotel_id' => $hotel->id,
                    'start_date' => $dates['start'],
                    'end_date' => $dates['end'],
                ]);
            }
        }

        // ==================================================
        // $seasons = [
        //     'Low Season' => ['start' => '2025-01-01', 'end' => '2025-03-31'],
        //     'High Season' => ['start' => '2025-06-01', 'end' => '2025-08-31'],
        //     'Shoulder Season' => ['start' => '2025-04-01', 'end' => '2025-05-31'],
        // ];

        // foreach ($seasons as $season_name => $dates) {
        //     HotelSeason::create([
        //         'season_name' => $season_name,
        //         'hotel_id' => Hotel::inRandomOrder()->first()?->id ?? 1,
        //         'start_date' => $dates['start'],
        //         'end_date' => $dates['end'],
        //     ]);
        // }

        // ================================================== 
        // $total_seasons = 3;
        // $start_date = Carbon::parse('2025-01-01');
        // $end_date = Carbon::parse('2025-12-31');
        // $season_duration = $end_date->diffInDays($start_date) / $total_seasons;

        // for ($i = 0; $i < $total_seasons; $i++) {
        //     $season_start = $start_date->copy()->addDays($i * $season_duration);
        //     $season_end = $season_start->copy()->addDays($season_duration - 1);

        //     HotelSeason::create([
        //         'season_name' => 'Season ' . ($i + 1),
        //         'hotel_id' => Hotel::inRandomOrder()->first()?->id ?? 1,
        //         'start_date' => $season_start->toDateString(),
        //         'end_date' => $season_end->toDateString(),
        //     ]);
        // }
    }
}