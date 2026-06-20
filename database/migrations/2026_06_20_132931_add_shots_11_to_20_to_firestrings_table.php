<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('firestrings', function (Blueprint $table) {
            for ($i = 11; $i <= 20; $i++) {
                $table->string("shot{$i}value", 128)->nullable();
                $table->string("shot{$i}x", 128)->nullable();
                $table->string("shot{$i}y", 128)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('firestrings', function (Blueprint $table) {
            for ($i = 11; $i <= 20; $i++) {
                $table->dropColumn([
                    "shot{$i}value",
                    "shot{$i}x",
                    "shot{$i}y",
                ]);
            }
        });
    }
};
