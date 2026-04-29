<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jalur;
use Illuminate\Http\Request;

class JalurController extends Controller
{
    public function updateQuota(Request $request)
    {
        $request->validate([
            'quotas' => 'required|array',
            'quotas.*' => 'required|integer|min:0',
        ]);

        foreach ($request->quotas as $id => $quota) {
            $jalur = Jalur::withCount('pendaftarans')->find($id);
            
            if ($jalur && $quota < $jalur->pendaftarans_count) {
                return redirect()->back()->with('error', "Kuota Jalur {$jalur->nama_jalur} tidak bisa kurang dari jumlah pendaftar saat ini ({$jalur->pendaftarans_count} pendaftar).");
            }

            Jalur::where('id', $id)->update(['total_kuota' => $quota]);
        }

        return redirect()->back()->with('success', 'Kuota jalur pendaftaran berhasil diperbarui.');
    }
}
