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
        Schema::table('image_metadata', function (Blueprint $table) {
            $table->boolean('verify')->default('0');
            $table->softDeletes();
        });
        Schema::table('images', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_metadata', function (Blueprint $table) {
            $table->boolean('verify')->default('0');
            $table->dropSoftDeletes();
        });
        Schema::table('images', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
