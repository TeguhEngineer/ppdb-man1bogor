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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->char('no_pendaftaran', 16)->change();
            $table->char('nisn', 10)->nullable()->change();
        });

        Schema::table('data_pribadi', function (Blueprint $table) {
            $table->char('nik', 16)->nullable()->change();
            $table->char('no_kk', 16)->nullable()->change();
            $table->char('kode_pos', 5)->nullable()->change();
            $table->char('npsn', 8)->nullable()->change();
            $table->unsignedTinyInteger('tinggi_badan')->nullable()->change();
            $table->unsignedTinyInteger('berat_badan')->nullable()->change();
            $table->unsignedTinyInteger('anak_ke')->nullable()->change();
            $table->unsignedTinyInteger('jumlah_saudara')->nullable()->change();
        });

        Schema::table('data_orangtua', function (Blueprint $table) {
            $table->char('nik_ayah', 16)->nullable()->change();
            $table->char('nik_ibu', 16)->nullable()->change();
            $table->char('nik_wali', 16)->nullable()->change();
        });

        Schema::table('kartu_peserta_ujians', function (Blueprint $table) {
            $table->char('nomor_peserta_ujian', 13)->change();
            $table->char('username_ujian', 10)->change();
            $table->char('password_ujian', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('no_pendaftaran', 30)->change();
            $table->string('nisn', 10)->nullable()->change();
        });

        Schema::table('data_pribadi', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->change();
            $table->string('no_kk', 16)->nullable()->change();
            $table->string('kode_pos', 5)->nullable()->change();
            $table->string('npsn', 8)->nullable()->change();
            $table->integer('tinggi_badan')->nullable()->change();
            $table->integer('berat_badan')->nullable()->change();
            $table->integer('anak_ke')->nullable()->change();
            $table->integer('jumlah_saudara')->nullable()->change();
        });

        Schema::table('data_orangtua', function (Blueprint $table) {
            $table->string('nik_ayah', 16)->nullable()->change();
            $table->string('nik_ibu', 16)->nullable()->change();
            $table->string('nik_wali', 16)->nullable()->change();
        });

        Schema::table('kartu_peserta_ujians', function (Blueprint $table) {
            $table->string('nomor_peserta_ujian', 30)->change();
            $table->string('username_ujian', 50)->change();
            $table->string('password_ujian', 50)->change();
        });
    }
};
