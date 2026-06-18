<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
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
        $validated = $this->validatePengumuman($request);

        Pengumuman::create([
            'judul' => $validated['judul'],
            'keterangan' => $validated['keterangan'],
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $request->boolean('is_published', true) ? now() : null,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $this->validatePengumuman($request);
        $isPublished = $request->boolean('is_published');

        $pengumuman->update([
            'judul' => $validated['judul'],
            'keterangan' => $validated['keterangan'],
            'is_published' => $isPublished,
            'published_at' => $isPublished ? ($pengumuman->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function validatePengumuman(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'keterangan' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.max' => 'Judul pengumuman maksimal :max karakter.',
            'keterangan.required' => 'Isi pengumuman wajib diisi.',
        ]);
    }
}
