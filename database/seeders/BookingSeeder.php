<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Booking::truncate();
        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 7; $i++) {
            $subtotal_hotels = fake()->randomFloat(2, 50, 90000);
            $subtotal_transport = fake()->randomFloat(2, 50, 90000);
            $subtotal_services = fake()->randomFloat(2, 50, 90000);
            $grand_total = (int) $subtotal_hotels + $subtotal_transport + $subtotal_services;

            Booking::create([
                'user_id' => auth()->id() ?? 1,
                'status' => fake()->randomElement(['draft', 'submitted', 'cancelled']),
                'first_name' => fake()->name(),
                'last_name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '+962' . rand(100000, 999999) . '900',
                'adults' => fake()->randomElement([rand(1, 10), rand(1, 9) . '0']),
                'children' => rand(0, 3),
                'infants' => rand(0, 2),
                'arrival_date' => '2025-09-11',
                'departure_date' => '2025-09-' . rand(12, 30),
                'nights' => rand(1, 7),
                'nationality_id' => 1,
                'currency_id' => 1,
                'hotel_id' => 1,
                'hotel_season_id' => 1,
                'subtotal_hotels' => fake()->randomFloat(2, 50, 90000),
                'subtotal_transport' => fake()->randomFloat(2, 50, 90000),
                'subtotal_services' => fake()->randomFloat(2, 50, 90000),
                'discount' => rand(1, 20),
                'tax' => $grand_total * (rand(1, 10) / 100),
                'grand_total' => $grand_total,
            ]);
        }
    }
}