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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete();
            
            // Data Pribadi
            // $table->string('foto_profil')->nullable();
            $table->string('nama_lengkap', 150);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('status_dalam_keluarga', 50)->nullable();
            $table->string('tinggal_bersama', 50)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('agama', 20);
            $table->string('no_whatsapp', 20);
            
            // Data Alamat
            $table->text('alamat');
            $table->string('desa', 100);
            $table->string('kecamatan', 100);
            $table->string('kabupaten', 100);
            $table->string('provinsi', 100);
            $table->string('kode_pos', 5);
            $table->string('jarak_ke_sekolah', 50)->nullable();
            $table->string('waktu_tempuh_ke_sekolah', 50)->nullable();
            
            // Data Pendidikan
            $table->enum('asal_satuan_pendidikan', ['SMP', 'MTS']);
            $table->string('nama_asal_sekolah', 150);
            $table->string('npsn', 8)->nullable();
            
            // Data Penunjang Prestasi
            $table->string('kategori_prestasi', 100)->nullable();
            $table->integer('jumlah_juz')->nullable();
            $table->string('tingkat_prestasi', 50)->nullable();
            $table->string('jenis_prestasi', 100)->nullable();
            $table->string('nama_lomba', 150)->nullable();
            $table->string('sertifikat', 500)->nullable();
            
            // Data Slip Gaji
            $table->string('slip_gaji', 500)->nullable();
            
            // Data Ayah
            $table->string('nama_ayah', 150)->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_terakhir_ayah', 50)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('penghasilan_ayah', 50)->nullable();
            $table->string('no_hp_ayah', 20)->nullable();
            
            // Data Ibu
            $table->string('nama_ibu', 150)->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_terakhir_ibu', 50)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('penghasilan_ibu', 50)->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
            $table->string('kartu_keluarga', 500)->nullable();
            
            // Data Wali
            $table->string('nama_wali', 150)->nullable();
            $table->string('nik_wali', 16)->nullable();
            $table->string('tempat_lahir_wali', 100)->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('pendidikan_terakhir_wali', 50)->nullable();
            $table->string('pekerjaan_wali', 100)->nullable();
            $table->string('penghasilan_wali', 50)->nullable();
            $table->string('no_hp_wali', 20)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
