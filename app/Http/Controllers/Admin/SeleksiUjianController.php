<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\Jalur;
use App\Models\KartuPesertaUjian;
use App\Models\Mapel;
use App\Models\Pendaftaran;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class SeleksiUjianController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::with([
                'user',
                'jalur.mapels',
                'dataPribadi',
                'berkas',
                'kartuPesertaUjian.ruangan',
                'kartuPesertaUjian.jadwalUjian',
            ])
            ->whereHas('berkas', fn ($query) => $query->where('status_berkas', 'terima'))
            ->latest()
            ->paginate(10);

        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        $mapels = Mapel::with('jalurs')->orderBy('nama_mapel')->get();
        $jalurs = Jalur::with('mapels')->orderBy('nama_jalur')->get();
        $jadwalUjians = JadwalUjian::with('jalur.mapels')->latest('tanggal_ujian')->get();

        return view('admin.seleksi-ujian.index', compact(
            'pendaftarans',
            'ruangans',
            'mapels',
            'jalurs',
            'jadwalUjians'
        ));
    }

    public function storeRuangan(Request $request)
    {
        $data = $request->validate([
            'nama_ruangan' => 'required|string|max:8|unique:ruangans,nama_ruangan',
            'lokasi' => 'nullable|string|max:21',
            'kapasitas' => 'nullable|integer|min:1|max:99',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_ruangan.max' => 'Nama ruangan maksimal 8 karakter.',
            'lokasi.max' => 'Lokasi maksimal 21 karakter.',
            'kapasitas.max' => 'Kapasitas maksimal 99.',
        ]);

        Ruangan::create($data);

        return redirect()->back()->with('success', 'Ruangan ujian berhasil ditambahkan.');
    }

    public function updateRuangan(Request $request, Ruangan $ruangan)
    {
        $data = $request->validate([
            'nama_ruangan' => 'required|string|max:8|unique:ruangans,nama_ruangan,' . $ruangan->id,
            'lokasi' => 'nullable|string|max:21',
            'kapasitas' => 'nullable|integer|min:1|max:99',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_ruangan.max' => 'Nama ruangan maksimal 8 karakter.',
            'lokasi.max' => 'Lokasi maksimal 21 karakter.',
            'kapasitas.max' => 'Kapasitas maksimal 99.',
        ]);

        $ruangan->update($data);

        return redirect()->back()->with('success', 'Ruangan ujian berhasil diperbarui.');
    }

    public function destroyRuangan(Ruangan $ruangan)
    {
        if ($ruangan->kartuPesertaUjians()->exists()) {
            return redirect()->back()->with('error', 'Ruangan tidak dapat dihapus karena sudah dipakai kartu peserta.');
        }

        $ruangan->delete();

        return redirect()->back()->with('success', 'Ruangan ujian berhasil dihapus.');
    }

    public function storeMapel(Request $request)
    {
        $data = $request->validate([
            'nama_mapel' => 'required|string|max:22',
            'deskripsi' => 'nullable|string',
            'jalur_ids' => 'nullable|array',
            'jalur_ids.*' => 'exists:jalurs,id',
        ], [
            'nama_mapel.max' => 'Nama mata pelajaran maksimal 22 karakter.',
        ]);

        $mapel = Mapel::create([
            'nama_mapel' => $data['nama_mapel'],
            'deskripsi' => $data['deskripsi'] ?? null,
        ]);

        $this->syncMapelJalurs($mapel, $data['jalur_ids'] ?? []);

        return redirect()->back()->with('success', 'Mata pelajaran ujian berhasil ditambahkan.');
    }

    public function updateMapel(Request $request, Mapel $mapel)
    {
        $data = $request->validate([
            'nama_mapel' => 'required|string|max:22',
            'deskripsi' => 'nullable|string',
            'jalur_ids' => 'nullable|array',
            'jalur_ids.*' => 'exists:jalurs,id',
        ], [
            'nama_mapel.max' => 'Nama mata pelajaran maksimal 22 karakter.',
        ]);

        $mapel->update([
            'nama_mapel' => $data['nama_mapel'],
            'deskripsi' => $data['deskripsi'] ?? null,
        ]);

        $this->syncMapelJalurs($mapel, $data['jalur_ids'] ?? []);

        return redirect()->back()->with('success', 'Mata pelajaran ujian berhasil diperbarui.');
    }

    public function destroyMapel(Mapel $mapel)
    {
        $mapel->jalurs()->detach();
        $mapel->delete();

        return redirect()->back()->with('success', 'Mata pelajaran ujian berhasil dihapus.');
    }

    public function storeJadwal(Request $request)
    {
        JadwalUjian::create($this->validatedJadwal($request));

        return redirect()->back()->with('success', 'Jadwal ujian berhasil ditambahkan.');
    }

    public function updateJadwal(Request $request, JadwalUjian $jadwalUjian)
    {
        $jadwalUjian->update($this->validatedJadwal($request));

        return redirect()->back()->with('success', 'Jadwal ujian berhasil diperbarui.');
    }

    public function destroyJadwal(JadwalUjian $jadwalUjian)
    {
        if ($jadwalUjian->kartuPesertaUjians()->exists()) {
            return redirect()->back()->with('error', 'Jadwal tidak dapat dihapus karena sudah dipakai kartu peserta.');
        }

        $jadwalUjian->delete();

        return redirect()->back()->with('success', 'Jadwal ujian berhasil dihapus.');
    }

    public function updateKartu(Request $request, Pendaftaran $pendaftaran)
    {
        $data = $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'jadwal_ujian_id' => 'required|exists:jadwal_ujians,id',
            'username_ujian' => 'required|string|max:10',
            'password_ujian' => 'required|string|max:10',
        ], [
            'username_ujian.max' => 'Username ujian maksimal 10 karakter.',
            'password_ujian.max' => 'Password ujian maksimal 10 karakter.',
        ]);

        if (!$pendaftaran->berkas || $pendaftaran->berkas->status_berkas !== 'terima') {
            return redirect()->back()->with('error', 'Kartu ujian hanya dapat dibuat setelah berkas diterima.');
        }

        $pendaftaran->kartuPesertaUjian()->updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            array_merge($data, [
                'nomor_peserta_ujian' => $pendaftaran->kartuPesertaUjian->nomor_peserta_ujian
                    ?? $this->generateNomorPeserta($pendaftaran),
                'generated_at' => now(),
            ])
        );

        $pendaftaran->update(['status_pendaftaran' => 'tes']);

        return redirect()->back()->with('success', 'Kartu peserta ujian berhasil diperbarui.');
    }

    private function validatedJadwal(Request $request): array
    {
        return $request->validate([
            'jalur_id' => 'required|exists:jalurs,id',
            'tanggal_ujian' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'tanggal_wawancara_btq' => 'nullable|date',
            'waktu_wawancara_btq' => 'nullable|date_format:H:i',
            'tempat_wawancara_btq' => 'nullable|string|max:150',
            'catatan' => 'nullable|string',
        ], [
            'tempat_wawancara_btq.max' => 'Tempat wawancara BTQ maksimal 150 karakter.',
        ]);
    }

    private function syncMapelJalurs(Mapel $mapel, array $jalurIds): void
    {
        $mapel->jalurs()->sync($jalurIds);
    }

    private function generateNomorPeserta(Pendaftaran $pendaftaran): string
    {
        $year = now()->format('Y');
        
        return 'UJ-' . $year . '-' . str_pad((string) $pendaftaran->id, 5, '0', STR_PAD_LEFT);
    }
}
