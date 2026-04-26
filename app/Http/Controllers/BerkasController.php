<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function create()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();

        if ($pendaftaran->berkas) {
            return redirect()->route('berkas.edit', $pendaftaran->berkas->id);
        }

        if (!$pendaftaran->biodata || !$pendaftaran->biodata->kartu_keluarga || !$pendaftaran->biodata->slip_gaji) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi biodata Anda terlebih dahulu.');
        }

        return view('berkas.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'file_raport' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_nisn' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_foto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_surat_keterangan_aktif' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
        ]);

        $berkasData = ['pendaftaran_id' => $pendaftaran->id];

        if ($request->hasFile('file_raport')) {
            $berkasData['file_raport'] = $request->file('file_raport')->store('berkas/raport', 'public');
        }
        if ($request->hasFile('file_nisn')) {
            $berkasData['file_nisn'] = $request->file('file_nisn')->store('berkas/nisn', 'public');
        }
        if ($request->hasFile('file_foto')) {
            $berkasData['file_foto'] = $request->file('file_foto')->store('berkas/foto', 'public');
        }
        if ($request->hasFile('file_surat_keterangan_aktif')) {
            $berkasData['file_surat_keterangan_aktif'] = $request->file('file_surat_keterangan_aktif')->store('berkas/skl', 'public');
        }

        $berkas = Berkas::create($berkasData);

        return redirect()->route('berkas.edit', $berkas->id)->with('success', 'Berkas berhasil diunggah!');
    }

    public function edit(Berkas $berka)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();
        
        if ($berka->pendaftaran_id !== $pendaftaran->id) {
            abort(403);
        }

        return view('berkas.edit', compact('berka', 'pendaftaran'));
    }

    public function update(Request $request, Berkas $berka)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();
        
        if ($berka->pendaftaran_id !== $pendaftaran->id) {
            abort(403);
        }

        $request->validate([
            'file_raport' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_nisn' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_foto' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_surat_keterangan_aktif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
        ]);

        if ($request->hasFile('file_raport')) {
            if ($berka->file_raport) Storage::disk('public')->delete($berka->file_raport);
            $berka->file_raport = $request->file('file_raport')->store('berkas/raport', 'public');
        }
        if ($request->hasFile('file_nisn')) {
            if ($berka->file_nisn) Storage::disk('public')->delete($berka->file_nisn);
            $berka->file_nisn = $request->file('file_nisn')->store('berkas/nisn', 'public');
        }
        if ($request->hasFile('file_foto')) {
            if ($berka->file_foto) Storage::disk('public')->delete($berka->file_foto);
            $berka->file_foto = $request->file('file_foto')->store('berkas/foto', 'public');
        }
        if ($request->hasFile('file_surat_keterangan_aktif')) {
            if ($berka->file_surat_keterangan_aktif) Storage::disk('public')->delete($berka->file_surat_keterangan_aktif);
            $berka->file_surat_keterangan_aktif = $request->file('file_surat_keterangan_aktif')->store('berkas/skl', 'public');
        }

        $berka->save();

        return redirect()->back()->with('success', 'Berkas berhasil diperbarui!');
    }
}
