<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jalur;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

            $tglBuka = $request->input("tgl_buka.$id");
            $tglTutup = $request->input("tgl_tutup.$id");

            // Normalize HTML datetime-local values before saving to DATETIME columns.
            $updateData['tgl_buka'] = filled($tglBuka)
                ? Carbon::createFromFormat('Y-m-d\TH:i', $tglBuka)->format('Y-m-d H:i:s')
                : null;

            $updateData['tgl_tutup'] = filled($tglTutup)
                ? Carbon::createFromFormat('Y-m-d\TH:i', $tglTutup)->format('Y-m-d H:i:s')
                : null;

            Jalur::where('id', $id)->update($updateData);
        }

        return redirect()->back()->with('success', 'Kuota jalur pendaftaran berhasil diperbarui.');
    }
}
