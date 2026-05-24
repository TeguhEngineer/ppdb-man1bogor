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
            'tgl_buka' => 'nullable|array',
            'tgl_buka.*' => 'nullable|date_format:Y-m-d\TH:i',
            'tgl_tutup' => 'nullable|array',
            'tgl_tutup.*' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        foreach ($request->quotas as $id => $quota) {
            $jalur = Jalur::withCount('pendaftarans')->find($id);
            
            if ($jalur && $quota < $jalur->pendaftarans_count) {
                return redirect()->back()->with('error', "Kuota Jalur {$jalur->nama_jalur} tidak bisa kurang dari jumlah pendaftar saat ini ({$jalur->pendaftarans_count} pendaftar).");
            }

            $updateData = ['total_kuota' => $quota];

            // Add schedule fields if provided
            if (isset($request->tgl_buka[$id]) && !empty($request->tgl_buka[$id])) {
                $updateData['tgl_buka'] = $request->tgl_buka[$id];
            }

            if (isset($request->tgl_tutup[$id]) && !empty($request->tgl_tutup[$id])) {
                $updateData['tgl_tutup'] = $request->tgl_tutup[$id];
            }

            Jalur::where('id', $id)->update($updateData);
        }

        return redirect()->back()->with('success', 'Kuota jalur pendaftaran berhasil diperbarui.');
    }
}
