<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        truncateWithReset(State::class);
        RichText::where('record_type', State::class)->delete();
        // State::query()->delete();

        // foreach ($states as $state) {
        //     State::create($state);
        // }
    }
}
