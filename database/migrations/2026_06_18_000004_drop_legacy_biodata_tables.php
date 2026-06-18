<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('biodatas') && Schema::hasTable('data_pribadi') && Schema::hasTable('data_orangtua')) {
            $now = now();

            DB::table('biodatas')->orderBy('id')->chunkById(100, function ($biodatas) use ($now) {
                foreach ($biodatas as $biodata) {
                    DB::table('data_pribadi')->updateOrInsert(
                        ['pendaftaran_id' => $biodata->pendaftaran_id],
                        [
                            'foto_profil' => $biodata->foto_profil,
                            'nama_lengkap' => $biodata->nama_lengkap,
                            'tempat_lahir' => $biodata->tempat_lahir,
                            'tanggal_lahir' => $biodata->tanggal_lahir,
                            'jenis_kelamin' => $biodata->jenis_kelamin,
                            'nik' => trim((string) $biodata->nik) === '' ? null : $biodata->nik,
                            'no_kk' => $biodata->no_kk,
                            'tinggi_badan' => $biodata->tinggi_badan,
                            'berat_badan' => $biodata->berat_badan,
                            'status_dalam_keluarga' => $biodata->status_dalam_keluarga,
                            'tinggal_bersama' => $biodata->tinggal_bersama,
                            'anak_ke' => $biodata->anak_ke,
                            'jumlah_saudara' => $biodata->jumlah_saudara,
                            'agama' => $biodata->agama,
                            'no_whatsapp' => $biodata->no_whatsapp,
                            'alamat' => $biodata->alamat,
                            'desa' => $biodata->desa,
                            'kecamatan' => $biodata->kecamatan,
                            'kabupaten' => $biodata->kabupaten,
                            'provinsi' => $biodata->provinsi,
                            'kode_pos' => $biodata->kode_pos,
                            'jarak_ke_sekolah' => $biodata->jarak_ke_sekolah,
                            'waktu_tempuh_ke_sekolah' => $biodata->waktu_tempuh_ke_sekolah,
                            'asal_satuan_pendidikan' => $biodata->asal_satuan_pendidikan,
                            'nama_asal_sekolah' => $biodata->nama_asal_sekolah,
                            'npsn' => $biodata->npsn,
                            'created_at' => $biodata->created_at ?? $now,
                            'updated_at' => $now,
                        ]
                    );

                    DB::table('data_orangtua')->updateOrInsert(
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
                            'nama_ibu' => $biodata->nama_ibu,
                            'nik_ibu' => $biodata->nik_ibu,
                            'tempat_lahir_ibu' => $biodata->tempat_lahir_ibu,
                            'tanggal_lahir_ibu' => $biodata->tanggal_lahir_ibu,
                            'pendidikan_terakhir_ibu' => $biodata->pendidikan_terakhir_ibu,
                            'pekerjaan_ibu' => $biodata->pekerjaan_ibu,
                            'penghasilan_ibu' => $biodata->penghasilan_ibu,
                            'no_hp_ibu' => $biodata->no_hp_ibu,
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

        foreach ([
            'biodata_data_walis',
            'biodata_data_ibus',
            'biodata_data_ayahs',
            'biodata_penunjang_prestasis',
            'biodata_pendidikans',
            'biodata_alamats',
            'biodata_pribadis',
            'biodatas',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }

    public function down(): void
    {
        //
    }
};
