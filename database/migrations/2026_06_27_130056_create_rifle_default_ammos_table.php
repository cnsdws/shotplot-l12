<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rifle_default_ammos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rifle_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('distance');

            $table->foreignId('ballistic_profile_id')
                  ->nullable()
                  ->constrained('ballistic_profiles')
                  ->nullOnDelete();

            $table->timestamps();

            $table->unique(['rifle_id', 'distance']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rifle_default_ammos');
    }
};
