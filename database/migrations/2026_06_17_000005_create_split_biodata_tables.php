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
            $table->string('nama_lengkap')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('nik')->nullable()->unique();
            $table->string('no_kk')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('status_dalam_keluarga')->nullable();
            $table->string('tinggal_bersama')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('agama')->nullable();
            $table->string('no_whatsapp')->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_alamats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->text('alamat')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('jarak_ke_sekolah')->nullable();
            $table->string('waktu_tempuh_ke_sekolah')->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->enum('asal_satuan_pendidikan', ['SMP', 'MTS'])->nullable();
            $table->string('nama_asal_sekolah')->nullable();
            $table->string('npsn')->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_penunjang_prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('kategori_prestasi')->nullable();
            $table->integer('jumlah_juz')->nullable();
            $table->string('tingkat_prestasi')->nullable();
            $table->string('jenis_prestasi')->nullable();
            $table->string('nama_lomba')->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_data_ayahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_terakhir_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_data_ibus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_terakhir_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->timestamps();
        });

        Schema::create('biodata_data_walis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('pendidikan_terakhir_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
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
