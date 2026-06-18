<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biodata_pribadis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('foto_profil')->nullable();
            $table->string('nama_lengkap', 150)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('no_kk', 16)->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('status_dalam_keluarga', 50)->nullable();
            $table->string('tinggal_bersama', 50)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('no_whatsapp', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_alamats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->text('alamat')->nullable();
            $table->string('desa', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 5)->nullable();
            $table->string('jarak_ke_sekolah', 50)->nullable();
            $table->string('waktu_tempuh_ke_sekolah', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->enum('asal_satuan_pendidikan', ['SMP', 'MTS'])->nullable();
            $table->string('nama_asal_sekolah', 150)->nullable();
            $table->string('npsn', 8)->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_penunjang_prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('kategori_prestasi', 100)->nullable();
            $table->integer('jumlah_juz')->nullable();
            $table->string('tingkat_prestasi', 50)->nullable();
            $table->string('jenis_prestasi', 100)->nullable();
            $table->string('nama_lomba', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_data_ayahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('nama_ayah', 150)->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_terakhir_ayah', 50)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('penghasilan_ayah', 50)->nullable();
            $table->string('no_hp_ayah', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_data_ibus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_terakhir_ibu', 50)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('penghasilan_ibu', 50)->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_data_walis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
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

        $now = now();

        DB::table('biodatas')->orderBy('id')->chunkById(100, function ($biodatas) use ($now) {
            foreach ($biodatas as $biodata) {
                DB::table('biodata_pribadis')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'foto_profil' => $biodata->foto_profil,
                        'nama_lengkap' => $biodata->nama_lengkap,
                        'tempat_lahir' => $biodata->tempat_lahir,
                        'tanggal_lahir' => $biodata->tanggal_lahir,
                        'jenis_kelamin' => $biodata->jenis_kelamin,
                        'nik' => $biodata->nik,
                        'no_kk' => $biodata->no_kk,
                        'tinggi_badan' => $biodata->tinggi_badan,
                        'berat_badan' => $biodata->berat_badan,
                        'status_dalam_keluarga' => $biodata->status_dalam_keluarga,
                        'tinggal_bersama' => $biodata->tinggal_bersama,
                        'anak_ke' => $biodata->anak_ke,
                        'jumlah_saudara' => $biodata->jumlah_saudara,
                        'agama' => $biodata->agama,
                        'no_whatsapp' => $biodata->no_whatsapp,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('biodata_alamats')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'alamat' => $biodata->alamat,
                        'desa' => $biodata->desa,
                        'kecamatan' => $biodata->kecamatan,
                        'kabupaten' => $biodata->kabupaten,
                        'provinsi' => $biodata->provinsi,
                        'kode_pos' => $biodata->kode_pos,
                        'jarak_ke_sekolah' => $biodata->jarak_ke_sekolah,
                        'waktu_tempuh_ke_sekolah' => $biodata->waktu_tempuh_ke_sekolah,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('biodata_pendidikans')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'asal_satuan_pendidikan' => $biodata->asal_satuan_pendidikan,
                        'nama_asal_sekolah' => $biodata->nama_asal_sekolah,
                        'npsn' => $biodata->npsn,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('biodata_penunjang_prestasis')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'kategori_prestasi' => $biodata->kategori_prestasi,
                        'jumlah_juz' => $biodata->jumlah_juz,
                        'tingkat_prestasi' => $biodata->tingkat_prestasi,
                        'jenis_prestasi' => $biodata->jenis_prestasi,
                        'nama_lomba' => $biodata->nama_lomba,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('biodata_data_ayahs')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'nama_ayah' => $biodata->nama_ayah,
                        'nik_ayah' => $biodata->nik_ayah,
                        'tempat_lahir_ayah' => $biodata->tempat_lahir_ayah,
                        'tanggal_lahir_ayah' => $biodata->tanggal_lahir_ayah,
                        'pendidikan_terakhir_ayah' => $biodata->pendidikan_terakhir_ayah,
                        'pekerjaan_ayah' => $biodata->pekerjaan_ayah,
                        'penghasilan_ayah' => $biodata->penghasilan_ayah,
                        'no_hp_ayah' => $biodata->no_hp_ayah,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('biodata_data_ibus')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'nama_ibu' => $biodata->nama_ibu,
                        'nik_ibu' => $biodata->nik_ibu,
                        'tempat_lahir_ibu' => $biodata->tempat_lahir_ibu,
                        'tanggal_lahir_ibu' => $biodata->tanggal_lahir_ibu,
                        'pendidikan_terakhir_ibu' => $biodata->pendidikan_terakhir_ibu,
                        'pekerjaan_ibu' => $biodata->pekerjaan_ibu,
                        'penghasilan_ibu' => $biodata->penghasilan_ibu,
                        'no_hp_ibu' => $biodata->no_hp_ibu,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('biodata_data_walis')->updateOrInsert(
                    ['pendaftaran_id' => $biodata->pendaftaran_id],
                    [
                        'nama_wali' => $biodata->nama_wali,
                        'nik_wali' => $biodata->nik_wali,
                        'tempat_lahir_wali' => $biodata->tempat_lahir_wali,
                        'tanggal_lahir_wali' => $biodata->tanggal_lahir_wali,
                        'pendidikan_terakhir_wali' => $biodata->pendidikan_terakhir_wali,
                        'pekerjaan_wali' => $biodata->pekerjaan_wali,
                        'penghasilan_wali' => $biodata->penghasilan_wali,
                        'no_hp_wali' => $biodata->no_hp_wali,
                        'created_at' => $biodata->created_at ?? $now,
                        'updated_at' => $now,
                    ]
                );
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodata_data_walis');
        Schema::dropIfExists('biodata_data_ibus');
        Schema::dropIfExists('biodata_data_ayahs');
        Schema::dropIfExists('biodata_penunjang_prestasis');
        Schema::dropIfExists('biodata_pendidikans');
        Schema::dropIfExists('biodata_alamats');
        Schema::dropIfExists('biodata_pribadis');
    }
};
