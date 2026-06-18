<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jalur extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'tgl_buka' => 'datetime',
        'tgl_tutup' => 'datetime',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'jalur_mapel')
            ->withPivot('urutan')
            ->withTimestamps()
            ->orderByPivot('urutan');
    }

    public function jadwalUjians()
    {
        return $this->hasMany(JadwalUjian::class);
    }

    /**
     * Check if jalur is currently open for registration
     * Returns: 'belum_dibuka', 'terbuka', or 'ditutup'
     */
    public function getStatus()
    {
        $now = Carbon::now();

        // If tgl_buka is set and current time is before it
        if ($this->tgl_buka && $now < $this->tgl_buka) {
            return 'belum_dibuka';
        }

        // If tgl_tutup is set and current time is after it
        if ($this->tgl_tutup && $now > $this->tgl_tutup) {
            return 'ditutup';
        }

        // Otherwise jalur is open (even if no dates are set)
        return 'terbuka';
    }

    /**
     * Check if jalur is open (for blade @if conditions)
     */
    public function isOpen()
    {
        return $this->getStatus() === 'terbuka';
    }

    /**
     * Get human-readable status message for UI
     */
    public function getStatusMessage()
    {
        $status = $this->getStatus();

        if ($status === 'belum_dibuka') {
            return 'Jalur belum dibuka';
        }

        if ($status === 'ditutup') {
            return 'Jalur telah ditutup';
        }

        return 'Daftar Jalur';
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedTglBuka()
    {
        return $this->tgl_buka ? $this->tgl_buka->format('d M Y H:i') : '-';
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedTglTutup()
    {
        return $this->tgl_tutup ? $this->tgl_tutup->format('d M Y H:i') : '-';
    }
}
