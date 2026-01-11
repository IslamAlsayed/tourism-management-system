<?php

namespace Database\Seeders;

use App\Models\RichText;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        State::truncate();
        RichText::where('record_type', State::class)->delete();
        Schema::enableForeignKeyConstraints();

        // State::query()->delete();

        // foreach ($states as $state) {
        //     State::create($state);
        // }
    }
}