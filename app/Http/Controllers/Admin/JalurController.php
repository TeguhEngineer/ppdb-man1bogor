<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jalur;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class JalurController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.pengaturan-sistem.index');
    }

    public function create()
    {
        return view('admin.jalur.create');
    }

    public function store(Request $request)
    {
        Jalur::create($this->validatedData($request));

        return redirect()
            ->route('admin.pengaturan-sistem.index')
            ->with('success', 'Jalur pendaftaran berhasil ditambahkan.');
    }

    public function edit(Jalur $jalur)
    {
        $jalur->loadCount('pendaftarans');

        return view('admin.jalur.edit', compact('jalur'));
    }

    public function update(Request $request, Jalur $jalur)
    {
        $data = $this->validatedData($request);

        $jalur->loadCount('pendaftarans');

        if ($data['total_kuota'] < $jalur->pendaftarans_count) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Kuota Jalur {$jalur->nama_jalur} tidak bisa kurang dari jumlah pendaftar saat ini ({$jalur->pendaftarans_count} pendaftar).");
        }

        $jalur->update($data);

        return redirect()
            ->route('admin.pengaturan-sistem.index')
            ->with('success', 'Jalur pendaftaran berhasil diperbarui.');
    }

    public function destroy(Jalur $jalur)
    {
        $jalur->loadCount('pendaftarans');

        if ($jalur->pendaftarans_count > 0) {
            return redirect()
                ->back()
                ->with('error', "Jalur {$jalur->nama_jalur} tidak dapat dihapus karena sudah memiliki {$jalur->pendaftarans_count} pendaftar.");
        }

        $jalur->delete();

        return redirect()
            ->route('admin.pengaturan-sistem.index')
            ->with('success', 'Jalur pendaftaran berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'nama_jalur' => 'required|string|max:50',
            'total_kuota' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'tgl_buka' => 'nullable|date_format:Y-m-d\TH:i',
            'tgl_tutup' => 'nullable|date_format:Y-m-d\TH:i',
        ], [
            'nama_jalur.required' => 'Nama jalur wajib diisi.',
            'total_kuota.required' => 'Total kuota wajib diisi.',
            'total_kuota.integer' => 'Total kuota harus berupa angka.',
            'total_kuota.min' => 'Total kuota minimal 0.',
            'tgl_buka.date_format' => 'Format tanggal buka tidak valid.',
            'tgl_tutup.date_format' => 'Format tanggal tutup tidak valid.',
        ]);

        if (filled($data['tgl_buka'] ?? null) && filled($data['tgl_tutup'] ?? null)) {
            $tglBuka = Carbon::createFromFormat('Y-m-d\TH:i', $data['tgl_buka']);
            $tglTutup = Carbon::createFromFormat('Y-m-d\TH:i', $data['tgl_tutup']);

            if ($tglTutup->lt($tglBuka)) {
                throw ValidationException::withMessages([
                    'tgl_tutup' => 'Tanggal tutup tidak boleh lebih awal dari tanggal buka.',
                ]);
            }
        }

        $data['tgl_buka'] = filled($data['tgl_buka'] ?? null)
            ? Carbon::createFromFormat('Y-m-d\TH:i', $data['tgl_buka'])->format('Y-m-d H:i:s')
            : null;

        $data['tgl_tutup'] = filled($data['tgl_tutup'] ?? null)
            ? Carbon::createFromFormat('Y-m-d\TH:i', $data['tgl_tutup'])->format('Y-m-d H:i:s')
            : null;

        return $data;
    }
}
