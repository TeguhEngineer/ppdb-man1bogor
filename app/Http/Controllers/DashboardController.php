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
            $pendaftaran = Pendaftaran::with(['jalur', 'biodata', 'berkas', 'pengumumans'])
                ->where('user_id', $user->id)
                ->first();

            return view('dashboard.peserta', compact('pendaftaran'));
        }

        if ($user->role === 'admin') {
            $totalPendaftar = Pendaftaran::count();
            $pendaftarBaru = Pendaftaran::whereDate('created_at', today())->count();
            $menungguVerifikasi = Pendaftaran::where('status_pendaftaran', 'pending')->count();
            
            $recentRegistrations = Pendaftaran::with(['user', 'jalur'])->latest()->take(5)->get();

            return view('dashboard.admin', compact('totalPendaftar', 'pendaftarBaru', 'menungguVerifikasi', 'recentRegistrations'));
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

        if (!$pendaftaran || !$pendaftaran->biodata) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi biodata terlebih dahulu sebelum mencetak formulir.');
        }

        return view('peserta.cetak-formulir', compact('pendaftaran'));
    }
}
