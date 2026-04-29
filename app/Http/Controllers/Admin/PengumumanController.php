<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('pendaftaran.user')->latest();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('pendaftaran.user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $pengumumans = $query->paginate(20)->withQueryString();

        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_status' => 'required|in:semua,pending,verifikasi,tes,lulus,tidak_lulus,personal',
            'pendaftaran_id' => 'required_if:target_status,personal|nullable|exists:pendaftarans,id',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $pendaftarans = collect();

        if ($request->target_status === 'personal') {
            $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);
            $pendaftarans->push($pendaftaran);
        } else {
            $query = Pendaftaran::query();
            if ($request->target_status !== 'semua') {
                $query->where('status_pendaftaran', $request->target_status);
            }
            $pendaftarans = $query->get();
        }
        
        if ($pendaftarans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada peserta yang ditemukan dengan target tersebut. Pesan tidak dikirim.')->withInput();
        }

        $insertData = [];
        $now = now();
        foreach ($pendaftarans as $pendaftaran) {
            $insertData[] = [
                'pendaftaran_id' => $pendaftaran->id,
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Pengumuman::insert($insertData);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Berhasil mengirim pengumuman kepada ' . count($insertData) . ' peserta!');
    }

    public function searchParticipants(Request $request)
    {
        $search = $request->q;
        $participants = Pendaftaran::with('user')
            ->where('no_pendaftaran', 'like', "%{$search}%")
            ->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'text' => $p->no_pendaftaran . ' - ' . $p->user->name
                ];
            });

        return response()->json($participants);
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
