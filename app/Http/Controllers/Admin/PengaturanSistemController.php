<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jalur;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanSistemController extends Controller
{
    public function index()
    {
        $jalurs = Jalur::withCount('pendaftarans')->latest()->paginate(10);
        $sklSettings = PengaturanSistem::getMany(array_keys(PengaturanSistem::defaults()));

        return view('admin.pengaturan-sistem.index', compact('jalurs', 'sklSettings'));
    }

    public function updateSkl(Request $request)
    {
        $data = $request->validate([
            'skl_agenda_tanggal' => ['required', 'string', 'max:150'],
            'skl_agenda_waktu' => ['required', 'string', 'max:100'],
            'skl_agenda_tempat' => ['required', 'string', 'max:150'],
            'skl_agenda_keperluan' => ['required', 'string', 'max:150'],
            'skl_ttd_tempat_tanggal' => ['required', 'string', 'max:100'],
            'skl_ketua_panitia' => ['required', 'string', 'max:150'],
            'skl_nip_ketua_panitia' => ['required', 'string', 'max:30'],
            'skl_tanda_tangan_ketua_panitia' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:1024'],
        ], [
            'skl_agenda_tanggal.required' => 'Hari dan tanggal kegiatan wajib diisi.',
            'skl_agenda_waktu.required' => 'Waktu kegiatan wajib diisi.',
            'skl_agenda_tempat.required' => 'Tempat kegiatan wajib diisi.',
            'skl_agenda_keperluan.required' => 'Keperluan kegiatan wajib diisi.',
            'skl_ttd_tempat_tanggal.required' => 'Tempat dan tanggal tanda tangan wajib diisi.',
            'skl_ketua_panitia.required' => 'Nama ketua panitia wajib diisi.',
            'skl_nip_ketua_panitia.required' => 'NIP ketua panitia wajib diisi.',
            'skl_tanda_tangan_ketua_panitia.image' => 'Tanda tangan harus berupa file gambar.',
            'skl_tanda_tangan_ketua_panitia.mimes' => 'Tanda tangan harus berformat PNG, JPG, JPEG, atau WEBP.',
            'skl_tanda_tangan_ketua_panitia.max' => 'Ukuran tanda tangan maksimal 1 MB.',
        ]);

        if ($request->hasFile('skl_tanda_tangan_ketua_panitia')) {
            $oldSignature = PengaturanSistem::getValue('skl_tanda_tangan_ketua_panitia');

            if ($oldSignature && Storage::disk('public')->exists($oldSignature)) {
                Storage::disk('public')->delete($oldSignature);
            }

            $data['skl_tanda_tangan_ketua_panitia'] = $request
                ->file('skl_tanda_tangan_ketua_panitia')
                ->store('pengaturan/skl', 'public');
        } else {
            unset($data['skl_tanda_tangan_ketua_panitia']);
        }

        PengaturanSistem::setMany($data);

        return redirect()
            ->route('admin.pengaturan-sistem.index')
            ->with('success', 'Pengaturan Surat Keterangan Lulus berhasil diperbarui.');
    }
}
