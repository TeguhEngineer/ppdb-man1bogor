<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'jalur', 'biodata', 'berkas'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status_pendaftaran', $request->status);
        }

        $pendaftarans = $query->paginate(15)->withQueryString();
        return view('admin.verifikasi.index', compact('pendaftarans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user', 'jalur', 'biodata', 'berkas']);
        return view('admin.verifikasi.show', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_pendaftaran' => 'required|in:lulus,tidak_lulus'
        ]);

        if (!$pendaftaran->isLengkap()) {
            return redirect()->back()->withErrors(['status_pendaftaran' => 'Status tidak dapat diubah karena peserta belum melengkapi biodata atau berkas wajib.']);
        }

        if (!$pendaftaran->berkas || $pendaftaran->berkas->status_berkas !== 'terima') {
            return redirect()->back()->withErrors([
                'status_pendaftaran' => 'Hasil seleksi tidak dapat diubah karena berkas belum diterima.',
            ]);
        }

        $pendaftaran->update([
            'status_pendaftaran' => $request->status_pendaftaran
        ]);

        return redirect()->back()->with('success', 'Hasil seleksi berhasil diperbarui.');
    }

    public function updateBerkasStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_berkas' => 'required|in:terima,tolak',
            'pesan' => 'nullable|string|max:1000',
        ]);

        if (!$pendaftaran->berkas) {
            return redirect()->back()->withErrors([
                'status_berkas' => 'Peserta belum mengunggah berkas.',
            ]);
        }

        if ($request->status_berkas === 'tolak' && trim((string) $request->pesan) === '') {
            return redirect()->back()->withErrors([
                'pesan' => 'Catatan penolakan wajib diisi saat status berkas ditolak.',
            ]);
        }

        $pendaftaran->berkas->update([
            'status_berkas' => $request->status_berkas,
            'pesan' => $request->status_berkas === 'terima' ? null : $request->pesan,
        ]);

        if ($request->status_berkas === 'terima') {
            $pendaftaran->update([
                'status_pendaftaran' => 'verifikasi',
            ]);
        }

        $message = $request->status_berkas === 'terima'
            ? 'Status berkas berhasil diterima.'
            : 'Status berkas berhasil ditolak.';

        return redirect()->back()->with('success', $message);
    }
    public function export(Request $request)
    {
        $type = $request->get('type', 'csv');
        $query = Pendaftaran::with(['user', 'jalur', 'biodata', 'berkas'])->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status_pendaftaran', $request->status);
        }

        $pendaftarans = $query->get();

        $fileName = 'data_pendaftar_' . now()->format('YmdHis') . '.' . ($type == 'excel' ? 'xls' : 'csv');
        
        $headers = [
            "Content-type"        => $type == 'excel' ? "application/vnd.ms-excel" : "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No. Pendaftaran', 'Nama', 'NISN', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Jalur', 'Status', 'Tanggal Daftar'];

        $callback = function() use($pendaftarans, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';'); // Use semicolon for better Excel compatibility in some regions

            foreach ($pendaftarans as $p) {
                fputcsv($file, [
                    $p->no_pendaftaran,
                    $p->user->name,
                    $p->nisn,
                    $p->biodata->jenis_kelamin ?? '-',
                    $p->biodata->tempat_lahir ?? '-',
                    $p->biodata->tanggal_lahir ?? '-',
                    $p->jalur->nama_jalur,
                    ucfirst($p->status_pendaftaran),
                    $p->created_at->format('d-m-Y')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
