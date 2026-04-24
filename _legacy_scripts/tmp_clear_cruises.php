<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Temporarily Disable foreign key checks to drop tables
DB::statement('SET FOREIGN_KEY_CHECKS = 0');

Schema::dropIfExists('cruise_prices');
Schema::dropIfExists('cruise_cancellation_rules');
Schema::dropIfExists('cruise_cabins');
Schema::dropIfExists('cruise_cabin_categories');
Schema::dropIfExists('cruise_seasons');
Schema::dropIfExists('cruise_ports');
Schema::dropIfExists('cruises');

// Delete from migrations table to allow re-running
DB::table('migrations')->where('migration', 'LIKE', '%cruise%')->delete();

DB::statement('SET FOREIGN_KEY_CHECKS = 1');

echo "Cruise tables and migration records cleared successfully.\n";
