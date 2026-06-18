<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_peserta_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->foreignId('ruangan_id')->nullable()->constrained('ruangans')->nullOnDelete();
            $table->foreignId('jadwal_ujian_id')->nullable()->constrained('jadwal_ujians')->nullOnDelete();
            $table->string('nomor_peserta_ujian', 30)->unique();
            $table->string('username_ujian', 50);
            $table->string('password_ujian', 50);
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_peserta_ujians');
    }
};
