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
        Schema::create('rifle_zeros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rifle_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('distance');

            $table->integer('elevation')->nullable();
            $table->integer('windage')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rifle_zeros');
    }
};
