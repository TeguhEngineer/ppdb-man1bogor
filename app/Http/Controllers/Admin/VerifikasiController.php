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
        $jalurs = \App\Models\Jalur::all();

        return view('admin.verifikasi.index', compact('pendaftarans', 'jalurs'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user', 'jalur', 'biodata', 'berkas']);
        return view('admin.verifikasi.show', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_pendaftaran' => 'required|in:pending,verifikasi,tes,lulus,tidak_lulus'
        ]);

        $statusLevel = [
            'pending' => 1,
            'verifikasi' => 2,
            'tes' => 3,
            'lulus' => 4,
            'tidak_lulus' => 4,
        ];

        $currentLevel = $statusLevel[$pendaftaran->status_pendaftaran];
        $newLevel = $statusLevel[$request->status_pendaftaran];

        if ($newLevel < $currentLevel) {
            return redirect()->back()->withErrors(['status_pendaftaran' => 'Status pendaftaran tidak dapat dikembalikan ke tahap sebelumnya.']);
        }

        if (!$pendaftaran->isLengkap()) {
            return redirect()->back()->withErrors(['status_pendaftaran' => 'Status tidak dapat diubah karena peserta belum melengkapi biodata atau berkas wajib.']);
        }

        $pendaftaran->update([
            'status_pendaftaran' => $request->status_pendaftaran
        ]);

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
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
