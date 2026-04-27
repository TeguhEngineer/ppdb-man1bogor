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
        Schema::table('biodatas', function (Blueprint $table) {
            $table->dropColumn(['slip_gaji', 'kartu_keluarga', 'sertifikat']);
        });

        Schema::table('berkas', function (Blueprint $table) {
            $table->string('file_slip_gaji')->nullable()->after('file_surat_keterangan_aktif');
            $table->string('file_kk')->nullable()->after('file_slip_gaji');
            $table->string('file_sertifikat_hafalan')->nullable()->after('file_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn(['file_slip_gaji', 'file_kk', 'file_sertifikat_hafalan']);
        });

        Schema::table('biodatas', function (Blueprint $table) {
            $table->string('slip_gaji')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('sertifikat')->nullable();
        });
    }
};
