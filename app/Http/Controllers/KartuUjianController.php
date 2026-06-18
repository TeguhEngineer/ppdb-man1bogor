<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class KartuUjianController extends Controller
{
    public function cetakPeserta()
    {
        $pendaftaran = Pendaftaran::with([
                'user',
                'jalur.mapels',
                'dataPribadi',
                'berkas',
                'kartuPesertaUjian.ruangan',
                'kartuPesertaUjian.jadwalUjian',
            ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->authorizePrintable($pendaftaran);

        return view('peserta.kartu-ujian', compact('pendaftaran'));
    }

    public function cetakAdmin(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load([
            'user',
            'jalur.mapels',
            'dataPribadi',
            'berkas',
            'kartuPesertaUjian.ruangan',
            'kartuPesertaUjian.jadwalUjian',
        ]);

        $this->authorizePrintable($pendaftaran);

        return view('peserta.kartu-ujian', compact('pendaftaran'));
    }

    private function authorizePrintable(Pendaftaran $pendaftaran): void
    {
        $kartu = $pendaftaran->kartuPesertaUjian;

        if (
            ! $pendaftaran->berkas ||
            $pendaftaran->berkas->status_berkas !== 'terima' ||
            ! $kartu ||
            ! $kartu->ruangan_id ||
            ! $kartu->jadwal_ujian_id
        ) {
            abort(404);
        }
    }
}
