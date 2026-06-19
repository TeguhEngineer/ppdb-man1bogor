<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Auth;

class HasilKelulusanController extends Controller
{
    public function index()
    {
        $pendaftaran = $this->pendaftaranPeserta();

        return view('peserta.hasil-kelulusan', compact('pendaftaran'));
    }

    public function cetak()
    {
        $pendaftaran = $this->pendaftaranPeserta();

        if (!in_array($pendaftaran->status_pendaftaran, ['lulus', 'tidak_lulus'], true)) {
            return redirect()->route('hasil-kelulusan.index')->with('error', 'Surat keterangan kelulusan seleksi belum dapat dicetak karena hasil seleksi belum diumumkan.');
        }

        $sklSettings = PengaturanSistem::getMany(array_keys(PengaturanSistem::defaults()));

        return view('peserta.kartu-kelulusan', compact('pendaftaran', 'sklSettings'));
    }

    private function pendaftaranPeserta(): Pendaftaran
    {
        abort_unless(Auth::user()->role === 'peserta', 403);

        return Pendaftaran::with(['user', 'jalur', 'dataPribadi', 'berkas'])
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }
}
