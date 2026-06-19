<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jalur;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $statusOptions = $this->statusOptions();
        $isPrinting = $request->boolean('print');
        $jalurs = Jalur::orderBy('nama_jalur')->get();
        $query = $this->filteredQuery($request, $statusOptions, $jalurs);

        $pendaftarans = $isPrinting
            ? $query->paginate(20)->withQueryString()
            : Pendaftaran::whereRaw('1 = 0')->paginate(20)->withQueryString();

        return view('admin.report.index', compact('pendaftarans', 'statusOptions', 'jalurs', 'isPrinting'));
    }

    public function export(Request $request)
    {
        $statusOptions = $this->statusOptions();
        $jalurs = Jalur::orderBy('nama_jalur')->get();
        $type = $request->get('type', 'csv') === 'excel' ? 'excel' : 'csv';
        $pendaftarans = $this->filteredQuery($request, $statusOptions, $jalurs)->get();
        $extension = $type === 'excel' ? 'xls' : 'csv';
        $fileName = 'report_pendaftaran_' . now()->format('YmdHis') . '.' . $extension;

        $headers = [
            'Content-type' => $type === 'excel' ? 'application/vnd.ms-excel' : 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'No. Pendaftaran',
            'Nama Peserta',
            'Email',
            'NISN',
            'Jalur',
            'Kampus',
            'Status',
            'Status Berkas',
            'Tanggal Daftar',
        ];

        $callback = function () use ($pendaftarans, $columns, $statusOptions) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($pendaftarans as $pendaftaran) {
                fputcsv($file, [
                    $pendaftaran->no_pendaftaran,
                    $pendaftaran->dataPribadi->nama_lengkap ?? $pendaftaran->user->name ?? '-',
                    $pendaftaran->user->email ?? '-',
                    $pendaftaran->nisn ?? '-',
                    $pendaftaran->jalur->nama_jalur ?? '-',
                    $pendaftaran->kampus ?? '-',
                    $statusOptions[$pendaftaran->status_pendaftaran] ?? ucfirst((string) $pendaftaran->status_pendaftaran),
                    $pendaftaran->berkas->status_berkas ?? '-',
                    $pendaftaran->created_at->format('d-m-Y H:i'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function filteredQuery(Request $request, array $statusOptions, $jalurs)
    {
        $query = Pendaftaran::with(['user', 'jalur', 'dataPribadi', 'berkas'])->latest();

        if ($request->filled('status') && array_key_exists($request->status, $statusOptions)) {
            $query->where('status_pendaftaran', $request->status);
        }

        if ($request->filled('jalur_id') && $jalurs->contains('id', (int) $request->jalur_id)) {
            $query->where('jalur_id', $request->jalur_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dataPribadi', function ($query) use ($search) {
                        $query->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    private function statusOptions(): array
    {
        return [
            'pending' => 'Registrasi',
            'verifikasi' => 'Verifikasi',
            'tes' => 'Tes',
            'lulus' => 'Lulus',
            'tidak_lulus' => 'Tidak Lulus',
        ];
    }
}
