<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalurs')->cascadeOnDelete();
            $table->date('tanggal_ujian');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->date('tanggal_wawancara_btq')->nullable();
            $table->time('waktu_wawancara_btq')->nullable();
            $table->string('tempat_wawancara_btq', 150)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_ujians');
    }
};
