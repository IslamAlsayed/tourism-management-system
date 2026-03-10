<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_definitions', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('uuid');
        });

        // Generate codes for existing records
        $definitions = \Modules\Core\Entities\PricingDefinition::all();
        foreach ($definitions as $index => $definition) {
            $definition->update(['code' => 'PD-' . str_pad($definition->id, 5, '0', STR_PAD_LEFT)]);
        }
    }

    public function down(): void
    {
        Schema::table('pricing_definitions', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
