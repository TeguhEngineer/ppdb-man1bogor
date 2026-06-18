<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::where('is_published', true)
            ->latest('published_at')
            ->latest()
            ->paginate(10);

        return view('pengumuman.index', compact('pengumumans'));
    }
}
