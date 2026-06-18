<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('jadwals');
    }

    public function down(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalurs')->cascadeOnDelete();
            $table->date('tanggal_pendaftaran')->nullable();
            $table->date('tanggal_verifikasi')->nullable();
            $table->date('tanggal_tes')->nullable();
            $table->date('tanggal_pengumuman')->nullable();
            $table->date('tanggal_daftar_ulang')->nullable();
            $table->timestamps();
        });
    }
};
