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

        if (!$pendaftaran->biodata) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi biodata Anda terlebih dahulu.');
        }

        return view('berkas.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();

        if ($pendaftaran->status_pendaftaran === 'verifikasi') {
            return redirect()->back()->with('error', 'Data sudah diverifikasi dan tidak dapat diubah.');
        }

        $request->validate([
            'file_raport' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_nisn' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_foto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_surat_keterangan_aktif' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_slip_gaji' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_sertifikat' => $pendaftaran->jalur->nama_jalur == 'Prestasi' ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'nullable',
            'file_sktm' => $pendaftaran->jalur->nama_jalur == 'Afirmasi' ? 'required|file|mimes:pdf,jpg,jpeg,png|max:1024' : 'nullable',
            'file_kip' => $pendaftaran->jalur->nama_jalur == 'Afirmasi' ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024' : 'nullable',
        ], [
            'required' => 'Berkas :attribute wajib diunggah.',
            'file' => 'Berkas :attribute harus berupa file.',
            'mimes' => 'Format berkas :attribute harus berupa: :values.',
            'max' => 'Ukuran berkas :attribute maksimal :max KB.',
        ]);

        $berkasData = ['pendaftaran_id' => $pendaftaran->id];

        $path = 'berkas/' . $pendaftaran->no_pendaftaran;

        if ($request->hasFile('file_raport')) {
            $berkasData['file_raport'] = $request->file('file_raport')->store($path, 'public');
        }
        if ($request->hasFile('file_nisn')) {
            $berkasData['file_nisn'] = $request->file('file_nisn')->store($path, 'public');
        }
        if ($request->hasFile('file_foto')) {
            $berkasData['file_foto'] = $request->file('file_foto')->store($path, 'public');
        }
        if ($request->hasFile('file_surat_keterangan_aktif')) {
            $berkasData['file_surat_keterangan_aktif'] = $request->file('file_surat_keterangan_aktif')->store($path, 'public');
        }
        if ($request->hasFile('file_slip_gaji')) {
            $berkasData['file_slip_gaji'] = $request->file('file_slip_gaji')->store($path, 'public');
        }
        if ($request->hasFile('file_kk')) {
            $berkasData['file_kk'] = $request->file('file_kk')->store($path, 'public');
        }
        if ($request->hasFile('file_sertifikat')) {
            $berkasData['file_sertifikat'] = $request->file('file_sertifikat')->store($path, 'public');
        }
        if ($request->hasFile('file_sktm')) {
            $berkasData['file_sktm'] = $request->file('file_sktm')->store($path, 'public');
        }
        if ($request->hasFile('file_kip')) {
            $berkasData['file_kip'] = $request->file('file_kip')->store($path, 'public');
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

        if ($pendaftaran->status_pendaftaran === 'verifikasi') {
            return redirect()->back()->with('error', 'Data sudah diverifikasi dan tidak dapat diubah.');
        }

        $request->validate([
            'file_raport' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_nisn' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_foto' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_surat_keterangan_aktif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_slip_gaji' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_sktm' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            'file_kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
        ], [
            'file' => 'Berkas :attribute harus berupa file.',
            'mimes' => 'Format berkas :attribute harus berupa: :values.',
            'max' => 'Ukuran berkas :attribute maksimal :max KB.',
        ]);

        $path = 'berkas/' . $pendaftaran->no_pendaftaran;

        if ($request->hasFile('file_raport')) {
            if ($berka->file_raport) Storage::disk('public')->delete($berka->file_raport);
            $berka->file_raport = $request->file('file_raport')->store($path, 'public');
        }
        if ($request->hasFile('file_nisn')) {
            if ($berka->file_nisn) Storage::disk('public')->delete($berka->file_nisn);
            $berka->file_nisn = $request->file('file_nisn')->store($path, 'public');
        }
        if ($request->hasFile('file_foto')) {
            if ($berka->file_foto) Storage::disk('public')->delete($berka->file_foto);
            $berka->file_foto = $request->file('file_foto')->store($path, 'public');
        }
        if ($request->hasFile('file_surat_keterangan_aktif')) {
            if ($berka->file_surat_keterangan_aktif) Storage::disk('public')->delete($berka->file_surat_keterangan_aktif);
            $berka->file_surat_keterangan_aktif = $request->file('file_surat_keterangan_aktif')->store($path, 'public');
        }
        if ($request->hasFile('file_slip_gaji')) {
            if ($berka->file_slip_gaji) Storage::disk('public')->delete($berka->file_slip_gaji);
            $berka->file_slip_gaji = $request->file('file_slip_gaji')->store($path, 'public');
        }
        if ($request->hasFile('file_kk')) {
            if ($berka->file_kk) Storage::disk('public')->delete($berka->file_kk);
            $berka->file_kk = $request->file('file_kk')->store($path, 'public');
        }
        if ($request->hasFile('file_sertifikat')) {
            if ($berka->file_sertifikat) Storage::disk('public')->delete($berka->file_sertifikat);
            $berka->file_sertifikat = $request->file('file_sertifikat')->store($path, 'public');
        }
        if ($request->hasFile('file_sktm')) {
            if ($berka->file_sktm) Storage::disk('public')->delete($berka->file_sktm);
            $berka->file_sktm = $request->file('file_sktm')->store($path, 'public');
        }
        if ($request->hasFile('file_kip')) {
            if ($berka->file_kip) Storage::disk('public')->delete($berka->file_kip);
            $berka->file_kip = $request->file('file_kip')->store($path, 'public');
        }

        $berka->save();

        return redirect()->back()->with('success', 'Berkas berhasil diperbarui!');
    }
}
