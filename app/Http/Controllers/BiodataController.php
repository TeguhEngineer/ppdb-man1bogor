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

        if ($pendaftaran->status_pendaftaran === 'verifikasi') {
            return redirect()->back()->with('error', 'Data sudah diverifikasi dan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'nisn' => 'required|numeric|digits:10',
            'jalur_id' => 'required|exists:jalurs,id',
            'kampus' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'required|numeric|digits:16|unique:biodatas',
            'no_kk' => 'required|numeric|digits:16',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
            'status_dalam_keluarga' => 'required|string',
            'tinggal_bersama' => 'required|string',
            'anak_ke' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'agama' => 'required|string',
            'no_whatsapp' => 'required|string',
            
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'required|string|digits:5',
            'jarak_ke_sekolah' => 'required|string',
            'waktu_tempuh_ke_sekolah' => 'required|string',
            
            'asal_satuan_pendidikan' => 'required|in:SMP,MTS',
            'nama_asal_sekolah' => 'required|string',
            'npsn' => 'required|string',
            
            'kategori_prestasi' => 'nullable|string',
            'jumlah_juz' => 'nullable|integer',
            'tingkat_prestasi' => 'nullable|string',
            'jenis_prestasi' => 'nullable|string',
            'nama_lomba' => 'nullable|string',
            
            'nama_ayah' => 'required|string',
            'nik_ayah' => 'nullable|string',
            'tempat_lahir_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_terakhir_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'penghasilan_ayah' => 'required|string',
            'no_hp_ayah' => 'required|string',
            
            'nama_ibu' => 'required|string',
            'nik_ibu' => 'nullable|string',
            'tempat_lahir_ibu' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_terakhir_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'penghasilan_ibu' => 'required|string',
            'no_hp_ibu' => 'required|string',
            
            'nama_wali' => 'nullable|string',
            'nik_wali' => 'nullable|string',
            'tempat_lahir_wali' => 'nullable|string',
            'tanggal_lahir_wali' => 'nullable|date',
            'pendidikan_terakhir_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'nisn.digits' => 'NISN harus berjumlah tepat 10 digit.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus berjumlah tepat 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.numeric' => 'Nomor KK harus berupa angka.',
            'no_kk.digits' => 'Nomor KK harus berjumlah tepat 16 digit.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'desa.required' => 'Desa/Kelurahan wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.digits' => 'Kode pos harus berjumlah 5 digit.',
            'asal_satuan_pendidikan.required' => 'Asal satuan pendidikan wajib diisi.',
            'nama_asal_sekolah.required' => 'Nama asal sekolah wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'pendidikan_terakhir_ayah.required' => 'Pendidikan terakhir ayah wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'penghasilan_ayah.required' => 'Penghasilan ayah wajib diisi.',
            'no_hp_ayah.required' => 'Nomor HP ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'pendidikan_terakhir_ibu.required' => 'Pendidikan terakhir ibu wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'penghasilan_ibu.required' => 'Penghasilan ibu wajib diisi.',
            'no_hp_ibu.required' => 'Nomor HP ibu wajib diisi.',
            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'tinggi_badan.integer' => 'Tinggi badan harus berupa angka.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.integer' => 'Berat badan harus berupa angka.',
            'status_dalam_keluarga.required' => 'Status dalam keluarga wajib diisi.',
            'tinggal_bersama.required' => 'Tinggal bersama wajib diisi.',
            'anak_ke.required' => 'Anak ke berapa wajib diisi.',
            'anak_ke.integer' => 'Anak ke harus berupa angka.',
            'jumlah_saudara.required' => 'Jumlah saudara wajib diisi.',
            'jumlah_saudara.integer' => 'Jumlah saudara harus berupa angka.',
            'npsn.required' => 'NPSN sekolah asal wajib diisi.',
            'jarak_ke_sekolah.required' => 'Jarak ke sekolah wajib diisi.',
            'waktu_tempuh_ke_sekolah.required' => 'Waktu tempuh ke sekolah wajib diisi.',
        ]);




        $pendaftaran->update([
            'nisn' => $request->nisn,
            'jalur_id' => $request->jalur_id,
            'kampus' => $request->kampus,
        ]);

        unset($validated['nisn'], $validated['jalur_id'], $validated['kampus']);

        $validated['pendaftaran_id'] = $pendaftaran->id;
        
        $biodatum = Biodata::create($validated);

        return redirect()->route('biodata.edit', $biodatum->id)->with('success', 'Biodata berhasil disimpan!');
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

        if ($pendaftaran->status_pendaftaran === 'verifikasi') {
            return redirect()->back()->with('error', 'Data sudah diverifikasi dan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'nisn' => 'required|numeric|digits:10',
            'jalur_id' => 'required|exists:jalurs,id',
            'kampus' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'required|numeric|digits:16|unique:biodatas,nik,'.$biodatum->id,
            'no_kk' => 'required|numeric|digits:16',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
            'status_dalam_keluarga' => 'required|string',
            'tinggal_bersama' => 'required|string',
            'anak_ke' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'agama' => 'required|string',
            'no_whatsapp' => 'required|string',
            
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'required|string|digits:5',
            'jarak_ke_sekolah' => 'required|string',
            'waktu_tempuh_ke_sekolah' => 'required|string',
            
            'asal_satuan_pendidikan' => 'required|in:SMP,MTS',
            'nama_asal_sekolah' => 'required|string',
            'npsn' => 'required|string',
            
            'kategori_prestasi' => 'nullable|string',
            'jumlah_juz' => 'nullable|integer',
            'tingkat_prestasi' => 'nullable|string',
            'jenis_prestasi' => 'nullable|string',
            'nama_lomba' => 'nullable|string',
            
            'nama_ayah' => 'required|string',
            'nik_ayah' => 'nullable|string',
            'tempat_lahir_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_terakhir_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'penghasilan_ayah' => 'required|string',
            'no_hp_ayah' => 'required|string',
            
            'nama_ibu' => 'required|string',
            'nik_ibu' => 'nullable|string',
            'tempat_lahir_ibu' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_terakhir_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'penghasilan_ibu' => 'required|string',
            'no_hp_ibu' => 'required|string',
            
            'nama_wali' => 'nullable|string',
            'nik_wali' => 'nullable|string',
            'tempat_lahir_wali' => 'nullable|string',
            'tanggal_lahir_wali' => 'nullable|date',
            'pendidikan_terakhir_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'nisn.digits' => 'NISN harus berjumlah tepat 10 digit.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus berjumlah tepat 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.numeric' => 'Nomor KK harus berupa angka.',
            'no_kk.digits' => 'Nomor KK harus berjumlah tepat 16 digit.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'desa.required' => 'Desa/Kelurahan wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.digits' => 'Kode pos harus berjumlah 5 digit.',
            'asal_satuan_pendidikan.required' => 'Asal satuan pendidikan wajib diisi.',
            'nama_asal_sekolah.required' => 'Nama asal sekolah wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'pendidikan_terakhir_ayah.required' => 'Pendidikan terakhir ayah wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'penghasilan_ayah.required' => 'Penghasilan ayah wajib diisi.',
            'no_hp_ayah.required' => 'Nomor HP ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'pendidikan_terakhir_ibu.required' => 'Pendidikan terakhir ibu wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'penghasilan_ibu.required' => 'Penghasilan ibu wajib diisi.',
            'no_hp_ibu.required' => 'Nomor HP ibu wajib diisi.',
            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'tinggi_badan.integer' => 'Tinggi badan harus berupa angka.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.integer' => 'Berat badan harus berupa angka.',
            'status_dalam_keluarga.required' => 'Status dalam keluarga wajib diisi.',
            'tinggal_bersama.required' => 'Tinggal bersama wajib diisi.',
            'anak_ke.required' => 'Anak ke berapa wajib diisi.',
            'anak_ke.integer' => 'Anak ke harus berupa angka.',
            'jumlah_saudara.required' => 'Jumlah saudara wajib diisi.',
            'jumlah_saudara.integer' => 'Jumlah saudara harus berupa angka.',
            'npsn.required' => 'NPSN sekolah asal wajib diisi.',
            'jarak_ke_sekolah.required' => 'Jarak ke sekolah wajib diisi.',
            'waktu_tempuh_ke_sekolah.required' => 'Waktu tempuh ke sekolah wajib diisi.',
        ]);




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
