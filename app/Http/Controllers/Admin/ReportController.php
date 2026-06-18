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
        $statusOptions = [
            'pending' => 'Registrasi',
            'verifikasi' => 'Verifikasi',
            'tes' => 'Tes',
            'lulus' => 'Lulus',
            'tidak_lulus' => 'Tidak Lulus',
        ];

        $isPrinting = $request->boolean('print');
        $jalurs = Jalur::orderBy('nama_jalur')->get();
        $query = Pendaftaran::with(['user', 'jalur', 'biodata', 'dataPribadi', 'berkas'])->latest();

        if ($isPrinting && $request->filled('status') && array_key_exists($request->status, $statusOptions)) {
            $query->where('status_pendaftaran', $request->status);
        }

        if ($isPrinting && $request->filled('jalur_id') && $jalurs->contains('id', (int) $request->jalur_id)) {
            $query->where('jalur_id', $request->jalur_id);
        }

        if ($isPrinting && $request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $pendaftarans = $isPrinting
            ? $query->paginate(20)->withQueryString()
            : Pendaftaran::whereRaw('1 = 0')->paginate(20)->withQueryString();

        return view('admin.report.index', compact('pendaftarans', 'statusOptions', 'jalurs', 'isPrinting'));
    }
}
