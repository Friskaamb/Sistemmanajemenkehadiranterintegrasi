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
        Schema::table('attendances', function (Blueprint $table) {
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('foto_masuk')->nullable();
    $table->string('foto_pulang')->nullable();
    $table->string('status')->nullable();
    $table->string('gps_status')->nullable();
    $table->integer('total_jam')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
        });
    }
};
