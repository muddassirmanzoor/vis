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
        Schema::create('schools_verify_logs', function (Blueprint $table) {
            $table->id();
            $table->string('emis_code');
            $table->unsignedBigInteger('u_id');
            $table->string('user_type');
            $table->string('category_type');
            $table->boolean('verify');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools_verify_logs');
    }
};
