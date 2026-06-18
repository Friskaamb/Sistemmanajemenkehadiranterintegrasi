<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');
        $table->string('nama');

        $table->date('tanggal');

        $table->time('jam_masuk')->nullable();
        $table->time('jam_pulang')->nullable();

        $table->string('foto_masuk')->nullable();
        $table->string('foto_pulang')->nullable();

        $table->string('status')->nullable();
        $table->string('status_pulang')->nullable();

        $table->string('gps_status')->nullable();

        $table->integer('total_jam')->nullable();

        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};