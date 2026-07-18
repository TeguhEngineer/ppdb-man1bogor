<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_sistems', function (Blueprint $table) {
            $table->id();
            $table->string('skl_agenda_tanggal', 150)->nullable();
            $table->string('skl_agenda_waktu', 100)->nullable();
            $table->string('skl_agenda_tempat', 150)->nullable();
            $table->string('skl_agenda_keperluan', 150)->nullable();
            $table->string('skl_ttd_tempat_tanggal', 100)->nullable();
            $table->string('skl_ketua_panitia', 150)->nullable();
            $table->string('skl_nip_ketua_panitia', 30)->nullable();
            $table->string('skl_tanda_tangan_ketua_panitia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_sistems');
    }
};
