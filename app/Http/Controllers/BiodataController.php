<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Pendaftaran;
use App\Models\Jalur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();

        if ($pendaftaran->biodata) {
            return redirect()->route('biodata.edit', $pendaftaran->biodata->id);
        }

        $jalurs = Jalur::all();

        return view('biodata.create', compact('pendaftaran', 'jalurs'));
    }

    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'nisn' => 'required|string|max:20',
            'jalur_id' => 'required|exists:jalurs,id',
            'kampus' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'required|string|unique:biodatas',
            'no_kk' => 'required|string',
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'status_dalam_keluarga' => 'nullable|string',
            'tinggal_bersama' => 'nullable|string',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'agama' => 'required|string',
            'no_whatsapp' => 'required|string',
            
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'required|string',
            'jarak_ke_sekolah' => 'nullable|string',
            'waktu_tempuh_ke_sekolah' => 'nullable|string',
            
            'asal_satuan_pendidikan' => 'required|in:SMP,MTS',
            'nama_asal_sekolah' => 'required|string',
            'npsn' => 'nullable|string',
            
            'kategori_prestasi' => 'nullable|string',
            'jumlah_juz' => 'nullable|integer',
            'tingkat_prestasi' => 'nullable|string',
            'jenis_prestasi' => 'nullable|string',
            'nama_lomba' => 'nullable|string',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            
            'nama_ayah' => 'nullable|string',
            'nik_ayah' => 'nullable|string',
            'tempat_lahir_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_terakhir_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'penghasilan_ayah' => 'nullable|string',
            'no_hp_ayah' => 'nullable|string',
            
            'nama_ibu' => 'nullable|string',
            'nik_ibu' => 'nullable|string',
            'tempat_lahir_ibu' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_terakhir_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'penghasilan_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string',
            
            'nama_wali' => 'nullable|string',
            'nik_wali' => 'nullable|string',
            'tempat_lahir_wali' => 'nullable|string',
            'tanggal_lahir_wali' => 'nullable|date',
            'pendidikan_terakhir_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',


            'slip_gaji' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);


        if ($request->hasFile('slip_gaji')) {
            $validated['slip_gaji'] = $request->file('slip_gaji')->store('biodata/slip', 'public');
        }
        if ($request->hasFile('kartu_keluarga')) {
            $validated['kartu_keluarga'] = $request->file('kartu_keluarga')->store('biodata/kk', 'public');
        }
        if ($request->hasFile('sertifikat')) {
            $validated['sertifikat'] = $request->file('sertifikat')->store('biodata/sertifikat', 'public');
        }

        $pendaftaran->update([
            'nisn' => $request->nisn,
            'jalur_id' => $request->jalur_id,
            'kampus' => $request->kampus,
        ]);

        unset($validated['nisn'], $validated['jalur_id'], $validated['kampus']);

        $validated['pendaftaran_id'] = $pendaftaran->id;
        
        Biodata::create($validated);

        return redirect()->back()->with('success', 'Biodata berhasil disimpan!');
    }

    public function edit(Biodata $biodatum)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();
        
        if ($biodatum->pendaftaran_id !== $pendaftaran->id) {
            abort(403);
        }

        $jalurs = Jalur::all();

        return view('biodata.edit', compact('biodatum', 'pendaftaran', 'jalurs'));
    }

    public function update(Request $request, Biodata $biodatum)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->firstOrFail();
        
        if ($biodatum->pendaftaran_id !== $pendaftaran->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nisn' => 'required|string|max:20',
            'jalur_id' => 'required|exists:jalurs,id',
            'kampus' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'required|string|unique:biodatas,nik,'.$biodatum->id,
            'no_kk' => 'required|string',
            'tinggi_badan' => 'nullable|integer',
            'berat_badan' => 'nullable|integer',
            'status_dalam_keluarga' => 'nullable|string',
            'tinggal_bersama' => 'nullable|string',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'agama' => 'required|string',
            'no_whatsapp' => 'required|string',
            
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'required|string',
            'jarak_ke_sekolah' => 'nullable|string',
            'waktu_tempuh_ke_sekolah' => 'nullable|string',
            
            'asal_satuan_pendidikan' => 'required|in:SMP,MTS',
            'nama_asal_sekolah' => 'required|string',
            'npsn' => 'nullable|string',
            
            'kategori_prestasi' => 'nullable|string',
            'jumlah_juz' => 'nullable|integer',
            'tingkat_prestasi' => 'nullable|string',
            'jenis_prestasi' => 'nullable|string',
            'nama_lomba' => 'nullable|string',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            
            'nama_ayah' => 'nullable|string',
            'nik_ayah' => 'nullable|string',
            'tempat_lahir_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_terakhir_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'penghasilan_ayah' => 'nullable|string',
            'no_hp_ayah' => 'nullable|string',
            
            'nama_ibu' => 'nullable|string',
            'nik_ibu' => 'nullable|string',
            'tempat_lahir_ibu' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_terakhir_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'penghasilan_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string',
            
            'nama_wali' => 'nullable|string',
            'nik_wali' => 'nullable|string',
            'tempat_lahir_wali' => 'nullable|string',
            'tanggal_lahir_wali' => 'nullable|date',
            'pendidikan_terakhir_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',


            'slip_gaji' => $biodatum->slip_gaji ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => $biodatum->kartu_keluarga ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);


        if ($request->hasFile('slip_gaji')) {
            if ($biodatum->slip_gaji) Storage::disk('public')->delete($biodatum->slip_gaji);
            $validated['slip_gaji'] = $request->file('slip_gaji')->store('biodata/slip', 'public');
        }
        if ($request->hasFile('kartu_keluarga')) {
            if ($biodatum->kartu_keluarga) Storage::disk('public')->delete($biodatum->kartu_keluarga);
            $validated['kartu_keluarga'] = $request->file('kartu_keluarga')->store('biodata/kk', 'public');
        }
        if ($request->hasFile('sertifikat')) {
            if ($biodatum->sertifikat) Storage::disk('public')->delete($biodatum->sertifikat);
            $validated['sertifikat'] = $request->file('sertifikat')->store('biodata/sertifikat', 'public');
        }

        $pendaftaran->update([
            'nisn' => $request->nisn,
            'jalur_id' => $request->jalur_id,
            'kampus' => $request->kampus,
        ]);

        unset($validated['nisn'], $validated['jalur_id'], $validated['kampus']);

        $biodatum->update($validated);

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui!');
    }
}
