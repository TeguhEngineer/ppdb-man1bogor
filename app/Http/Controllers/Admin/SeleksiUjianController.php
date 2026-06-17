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
                'biodata',
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
            'nama_ruangan' => 'required|string|max:255|unique:ruangans,nama_ruangan',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        Ruangan::create($data);

        return redirect()->back()->with('success', 'Ruangan ujian berhasil ditambahkan.');
    }

    public function updateRuangan(Request $request, Ruangan $ruangan)
    {
        $data = $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangans,nama_ruangan,' . $ruangan->id,
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
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
            'nama_mapel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jalur_ids' => 'nullable|array',
            'jalur_ids.*' => 'exists:jalurs,id',
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
            'nama_mapel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jalur_ids' => 'nullable|array',
            'jalur_ids.*' => 'exists:jalurs,id',
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
            'username_ujian' => 'required|string|max:255',
            'password_ujian' => 'required|string|max:255',
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
            'tempat_wawancara_btq' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);
    }

    private function syncMapelJalurs(Mapel $mapel, array $jalurIds): void
    {
        $syncData = [];

        foreach (array_values($jalurIds) as $index => $jalurId) {
            $syncData[$jalurId] = ['urutan' => $index + 1];
        }

        $mapel->jalurs()->sync($syncData);
    }

    private function generateNomorPeserta(Pendaftaran $pendaftaran): string
    {
        $year = now()->format('Y');
        $base = 'UJ-' . $year . '-' . str_pad((string) $pendaftaran->id, 5, '0', STR_PAD_LEFT);

        if (! KartuPesertaUjian::where('nomor_peserta_ujian', $base)->exists()) {
            return $base;
        }

        $sequence = KartuPesertaUjian::where('nomor_peserta_ujian', 'like', $base . '-%')->count() + 1;

        return $base . '-' . $sequence;
    }
}
