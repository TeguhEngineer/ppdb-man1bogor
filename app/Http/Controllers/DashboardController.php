<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'peserta') {
            $pendaftaran = Pendaftaran::with([
                'jalur',
                'biodata',
                'berkas',
                'pengumumans',
                'dataPribadi',
                'alamat',
                'pendidikan',
                'penunjangPrestasi',
                'dataAyah',
                'dataIbu',
                'dataWali',
                'kartuPesertaUjian.ruangan',
                'kartuPesertaUjian.jadwalUjian',
            ])
                ->where('user_id', $user->id)
                ->first();

            return view('dashboard.peserta', compact('pendaftaran'));
        }

        if ($user->role === 'admin') {
            $totalPendaftar = Pendaftaran::count();
            $pendaftarBaru = Pendaftaran::whereDate('created_at', today())->count();
            $menungguVerifikasi = Pendaftaran::where('status_pendaftaran', 'pending')->count();
            $terverifikasi = Pendaftaran::where('status_pendaftaran', 'verifikasi')->count();
            $tahapTes = Pendaftaran::where('status_pendaftaran', 'tes')->count();
            $lulus = Pendaftaran::where('status_pendaftaran', 'lulus')->count();
            $tidakLulus = Pendaftaran::where('status_pendaftaran', 'tidak_lulus')->count();
            
            // Counts by Jalur
            $regulerCount = Pendaftaran::whereHas('jalur', function($q) { $q->where('nama_jalur', 'Reguler'); })->count();
            $prestasiCount = Pendaftaran::whereHas('jalur', function($q) { $q->where('nama_jalur', 'Prestasi'); })->count();
            $afirmasiCount = Pendaftaran::whereHas('jalur', function($q) { $q->where('nama_jalur', 'Afirmasi'); })->count();
            
            $recentRegistrations = Pendaftaran::with(['user', 'jalur'])->latest()->take(20)->get();

            return view('dashboard.admin', compact(
                'totalPendaftar', 'pendaftarBaru', 'menungguVerifikasi', 
                'terverifikasi', 'tahapTes', 'lulus', 'tidakLulus', 
                'regulerCount', 'prestasiCount', 'afirmasiCount',
                'recentRegistrations'
            ));
        }
    }

    public function cetakFormulir()
    {
        $user = Auth::user();

        if ($user->role !== 'peserta') {
            abort(403);
        }

        $pendaftaran = Pendaftaran::with(['jalur', 'biodata', 'user'])
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran || !$pendaftaran->isBiodataLengkap()) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi biodata terlebih dahulu sebelum mencetak formulir.');
        }

        return view('peserta.cetak-formulir', compact('pendaftaran'));
    }
}
