<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jalur()
    {
        return $this->belongsTo(Jalur::class);
    }

    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function dataPribadi()
    {
        return $this->hasOne(BiodataPribadi::class);
    }

    public function alamat()
    {
        return $this->hasOne(BiodataAlamat::class);
    }

    public function pendidikan()
    {
        return $this->hasOne(BiodataPendidikan::class);
    }

    public function penunjangPrestasi()
    {
        return $this->hasOne(BiodataPenunjangPrestasi::class);
    }

    public function dataAyah()
    {
        return $this->hasOne(BiodataDataAyah::class);
    }

    public function dataIbu()
    {
        return $this->hasOne(BiodataDataIbu::class);
    }

    public function dataWali()
    {
        return $this->hasOne(BiodataDataWali::class);
    }

    public function berkas()
    {
        return $this->hasOne(Berkas::class);
    }

    public function kartuPesertaUjian()
    {
        return $this->hasOne(KartuPesertaUjian::class);
    }

    public function isBerkasLengkap()
    {
        if (!$this->berkas) return false;

        $berkas = $this->berkas;
        
        // Berkas wajib dasar
        $requiredFiles = [
            'file_raport',
            'file_nisn',
            'file_foto',
            'file_surat_keterangan_aktif',
            'file_slip_gaji',
            'file_kk',
        ];

        foreach ($requiredFiles as $field) {
            if (!isset($berkas->$field) || trim((string) $berkas->$field) === '') {
                return false;
            }
        }

        // Berkas khusus jalur
        $namaJalur = $this->jalur->nama_jalur;
        if ($namaJalur == 'Prestasi' && (!isset($berkas->file_sertifikat) || trim((string) $berkas->file_sertifikat) === '')) {
            return false;
        }

        if ($namaJalur == 'Afirmasi' && (!isset($berkas->file_sktm) || trim((string) $berkas->file_sktm) === '')) {
            return false;
        }

        return true;
    }

    public function isBiodataLengkap()
    {
        if ($this->dataPribadi || $this->alamat || $this->pendidikan || $this->dataAyah || $this->dataIbu) {
            $requiredGroups = [
                [
                    'model' => $this->dataPribadi,
                    'fields' => [
                        'nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                        'no_kk', 'tinggi_badan', 'berat_badan', 'status_dalam_keluarga',
                        'tinggal_bersama', 'anak_ke', 'jumlah_saudara', 'agama', 'no_whatsapp',
                    ],
                ],
                [
                    'model' => $this->alamat,
                    'fields' => [
                        'alamat', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos',
                        'jarak_ke_sekolah', 'waktu_tempuh_ke_sekolah',
                    ],
                ],
                [
                    'model' => $this->pendidikan,
                    'fields' => [
                        'asal_satuan_pendidikan', 'nama_asal_sekolah', 'npsn',
                    ],
                ],
                [
                    'model' => $this->dataAyah,
                    'fields' => [
                        'nama_ayah', 'pendidikan_terakhir_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'no_hp_ayah',
                    ],
                ],
                [
                    'model' => $this->dataIbu,
                    'fields' => [
                        'nama_ibu', 'pendidikan_terakhir_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'no_hp_ibu',
                    ],
                ],
            ];

            foreach ($requiredGroups as $group) {
                $model = $group['model'];
                $fields = $group['fields'];

                if (!$model) {
                    return false;
                }

                foreach ($fields as $field) {
                    if (!isset($model->$field)) {
                        return false;
                    }

                    $value = $model->$field;

                    if (is_string($value) && trim($value) === '') {
                        return false;
                    }

                    if (is_null($value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        if (!$this->biodata) return false;

        $b = $this->biodata;
        
        // Cek field wajib (Seksi 1-4)
        $requiredFields = [
            'nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
            'no_kk', 'tinggi_badan', 'berat_badan', 'status_dalam_keluarga', 
            'tinggal_bersama', 'anak_ke', 'jumlah_saudara', 'agama', 'no_whatsapp',
            'alamat', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 
            'jarak_ke_sekolah', 'waktu_tempuh_ke_sekolah', 'asal_satuan_pendidikan', 
            'nama_asal_sekolah', 'npsn', 'nama_ayah', 'pendidikan_terakhir_ayah', 
            'pekerjaan_ayah', 'penghasilan_ayah', 'no_hp_ayah', 'nama_ibu', 
            'pendidikan_terakhir_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'no_hp_ibu'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($b->$field)) {
                return false;
            }

            $value = $b->$field;

            if (is_string($value) && trim($value) === '') {
                return false;
            }

            if (is_null($value)) {
                return false;
            }
        }

        return true;
    }

    public function isLengkap()
    {
        return $this->isBiodataLengkap() && $this->isBerkasLengkap();
    }

    public function syncBiodataAggregate(): ?Biodata
    {
        $data = [];

        foreach ([
            $this->dataPribadi,
            $this->alamat,
            $this->pendidikan,
            $this->penunjangPrestasi,
            $this->dataAyah,
            $this->dataIbu,
            $this->dataWali,
        ] as $model) {
            if ($model) {
                $data = array_merge($data, collect($model->getAttributes())->except(['id', 'pendaftaran_id', 'created_at', 'updated_at'])->toArray());
            }
        }

        $requiredForLegacyBiodata = [
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'nik',
            'no_kk',
            'agama',
            'no_whatsapp',
            'alamat',
            'desa',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'kode_pos',
            'asal_satuan_pendidikan',
            'nama_asal_sekolah',
        ];

        if (!$this->biodata) {
            foreach ($requiredForLegacyBiodata as $field) {
                if (!array_key_exists($field, $data) || trim((string) $data[$field]) === '') {
                    return null;
                }
            }
        }

        return $this->biodata()->updateOrCreate(
            ['pendaftaran_id' => $this->id],
            $data
        );
    }
}
