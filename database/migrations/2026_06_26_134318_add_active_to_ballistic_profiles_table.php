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
        Schema::table('ballistic_profiles', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('is_system');
        });
    }

    public function down(): void
    {
        Schema::table('ballistic_profiles', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
