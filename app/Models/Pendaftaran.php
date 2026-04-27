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

    public function berkas()
    {
        return $this->hasOne(Berkas::class);
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class);
    }

    public function isBerkasLengkap()
    {
        if (!$this->berkas) return false;

        $berkas = $this->berkas;
        
        // Berkas wajib dasar
        if (!$berkas->file_raport || !$berkas->file_nisn || !$berkas->file_foto || !$berkas->file_surat_keterangan_aktif || !$berkas->file_slip_gaji || !$berkas->file_kk) {
            return false;
        }

        // Berkas khusus jalur
        $namaJalur = $this->jalur->nama_jalur;
        if ($namaJalur == 'Prestasi' && !$berkas->file_sertifikat) {
            return false;
        }

        if ($namaJalur == 'Afirmasi' && !$berkas->file_sktm) {
            return false;
        }

        return true;
    }
}
