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
        Schema::create('ballistic_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->boolean('is_system')->default(false);

            $table->string('name');
            $table->string('type')->nullable(); // Factory or Handload

            $table->string('manufacturer')->nullable();
            $table->string('manufacturer_product_number')->nullable();
            $table->string('upc')->nullable();

            $table->string('cartridge')->nullable();
            $table->string('caliber')->nullable();

            $table->string('bullet_manufacturer')->nullable();
            $table->string('bullet_name')->nullable();
            $table->integer('bullet_weight')->nullable();
            $table->string('bullet_style')->nullable();

            $table->integer('muzzle_velocity')->nullable();
            $table->integer('muzzle_energy')->nullable();

            $table->decimal('g1_bc', 8, 4)->nullable();
            $table->decimal('g7_bc', 8, 4)->nullable();
            $table->decimal('sectional_density', 8, 4)->nullable();

            $table->decimal('test_barrel_length', 5, 2)->nullable();

            $table->string('case_type')->nullable();
            $table->string('primer_type')->nullable();

            $table->boolean('reloadable')->nullable();
            $table->boolean('lead_free')->nullable();
            $table->boolean('corrosive')->nullable();

            $table->string('powder')->nullable();
            $table->decimal('powder_charge', 6, 2)->nullable();
            $table->string('primer')->nullable();
            $table->string('brass')->nullable();
            $table->decimal('overall_length', 6, 3)->nullable();
            $table->string('lot_number')->nullable();
            $table->date('purchase_date')->nullable();

            $table->string('best_use')->nullable();
            $table->string('country_of_origin')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ballistic_profiles');
    }
};
