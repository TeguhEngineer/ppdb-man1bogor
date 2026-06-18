<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_pribadi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained()->onDelete('cascade');
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
            $table->text('alamat')->nullable();
            $table->string('desa', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 5)->nullable();
            $table->string('jarak_ke_sekolah', 50)->nullable();
            $table->string('waktu_tempuh_ke_sekolah', 50)->nullable();
            $table->enum('asal_satuan_pendidikan', ['SMP', 'MTS'])->nullable();
            $table->string('nama_asal_sekolah', 150)->nullable();
            $table->string('npsn', 8)->nullable();
            $table->timestamps();
        });

        Schema::create('data_orangtua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nama_ayah', 150)->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_terakhir_ayah', 50)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('penghasilan_ayah', 50)->nullable();
            $table->string('no_hp_ayah', 20)->nullable();
            $table->string('nama_ibu', 150)->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_terakhir_ibu', 50)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('penghasilan_ibu', 50)->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
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

        DB::table('pendaftarans')->select('id')->orderBy('id')->chunkById(100, function ($pendaftarans) use ($now) {
            foreach ($pendaftarans as $pendaftaran) {
                $legacy = Schema::hasTable('biodatas')
                    ? DB::table('biodatas')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;

                $pribadi = Schema::hasTable('biodata_pribadis')
                    ? DB::table('biodata_pribadis')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;
                $alamat = Schema::hasTable('biodata_alamats')
                    ? DB::table('biodata_alamats')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;
                $pendidikan = Schema::hasTable('biodata_pendidikans')
                    ? DB::table('biodata_pendidikans')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;

                $dataPribadi = $this->mapData($pribadi, $legacy, [
                    'foto_profil', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                    'nik', 'no_kk', 'tinggi_badan', 'berat_badan', 'status_dalam_keluarga',
                    'tinggal_bersama', 'anak_ke', 'jumlah_saudara', 'agama', 'no_whatsapp',
                ]);
                $dataPribadi += $this->mapData($alamat, $legacy, [
                    'alamat', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos',
                    'jarak_ke_sekolah', 'waktu_tempuh_ke_sekolah',
                ]);
                $dataPribadi += $this->mapData($pendidikan, $legacy, [
                    'asal_satuan_pendidikan', 'nama_asal_sekolah', 'npsn',
                ]);

                if ($this->hasValue($dataPribadi)) {
                    DB::table('data_pribadi')->updateOrInsert(
                        ['pendaftaran_id' => $pendaftaran->id],
                        $dataPribadi + ['created_at' => $now, 'updated_at' => $now]
                    );
                }

                $ayah = Schema::hasTable('biodata_data_ayahs')
                    ? DB::table('biodata_data_ayahs')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;
                $ibu = Schema::hasTable('biodata_data_ibus')
                    ? DB::table('biodata_data_ibus')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;
                $wali = Schema::hasTable('biodata_data_walis')
                    ? DB::table('biodata_data_walis')->where('pendaftaran_id', $pendaftaran->id)->first()
                    : null;

                $dataOrangtua = $this->mapData($ayah, $legacy, [
                    'nama_ayah', 'nik_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
                    'pendidikan_terakhir_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'no_hp_ayah',
                ]);
                $dataOrangtua += $this->mapData($ibu, $legacy, [
                    'nama_ibu', 'nik_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
                    'pendidikan_terakhir_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'no_hp_ibu',
                ]);
                $dataOrangtua += $this->mapData($wali, $legacy, [
                    'nama_wali', 'nik_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali',
                    'pendidikan_terakhir_wali', 'pekerjaan_wali', 'penghasilan_wali', 'no_hp_wali',
                ]);

                if ($this->hasValue($dataOrangtua)) {
                    DB::table('data_orangtua')->updateOrInsert(
                        ['pendaftaran_id' => $pendaftaran->id],
                        $dataOrangtua + ['created_at' => $now, 'updated_at' => $now]
                    );
                }
            }
        });

        foreach ([
            'biodata_data_walis',
            'biodata_data_ibus',
            'biodata_data_ayahs',
            'biodata_penunjang_prestasis',
            'biodata_pendidikans',
            'biodata_alamats',
            'biodata_pribadis',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::dropIfExists('biodatas');
    }

    public function down(): void
    {
        Schema::dropIfExists('data_orangtua');
        Schema::dropIfExists('data_pribadi');
    }

    private function mapData(?object $source, ?object $fallback, array $fields): array
    {
        $data = [];

        foreach ($fields as $field) {
            $value = $source->{$field} ?? $fallback->{$field} ?? null;
            $data[$field] = $field === 'nik' && trim((string) $value) === '' ? null : $value;
        }

        return $data;
    }

    private function hasValue(array $data): bool
    {
        foreach ($data as $value) {
            if (!is_null($value) && trim((string) $value) !== '') {
                return true;
            }
        }

        return false;
    }
};
