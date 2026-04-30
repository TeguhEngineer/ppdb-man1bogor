<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();
        
        if (!$pendaftaran) {
            $pengumumans = collect();
        } else {
            $pengumumans = Pengumuman::where('pendaftaran_id', $pendaftaran->id)
                            ->latest()
                            ->paginate(10);
        }

        return view('pengumuman.index', compact('pengumumans', 'pendaftaran'));
    }

    public function tandaiDibaca($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();
        
        if (!$pendaftaran) {
            abort(404);
        }

        $pengumuman = Pengumuman::where('id', $id)
            ->where('pendaftaran_id', $pendaftaran->id)
            ->firstOrFail();

        $pengumuman->update([
            'sudah_dibaca' => true,
            'dibaca_pada' => now(),
        ]);

        return back()->with('success', 'Pengumuman telah ditandai sebagai dibaca.');
    }
}
