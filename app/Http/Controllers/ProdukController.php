<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Traits\HasActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProdukController extends Controller
{
    use HasActivityLog;

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $produks = Produk::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate($perPage)
            ->appends(request()->query());

        return view('produk.index', compact('produks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'Nama produk tidak boleh kosong',
                'price.required' => 'Harga tidak boleh kosong',
                'price.numeric' => 'Harga harus berupa angka',
                'price.min' => 'Harga tidak boleh kurang dari 0',
                'stock.required' => 'Stok tidak boleh kosong',
                'stock.integer' => 'Stok harus berupa angka',
                'stock.min' => 'Stok tidak boleh kurang dari 0',
                'image.image' => 'File harus berupa gambar',
                'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'image.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $produk = Produk::create($validated);

            self::logActivity('create', 'Created product: ' . $produk->name, ['produk_id' => $produk->id]);

            return back()->with('success', 'Produk "' . $produk->name . '" berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('add');
        } catch (\Throwable $th) {
            Log::error('Error saat menyimpan produk: ' . $th->getMessage());
            return back()->with('error', 'Gagal menyimpan produk: ' . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $produk = Produk::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'Nama produk tidak boleh kosong',
                'price.required' => 'Harga tidak boleh kosong',
                'price.numeric' => 'Harga harus berupa angka',
                'price.min' => 'Harga tidak boleh kurang dari 0',
                'stock.required' => 'Stok tidak boleh kosong',
                'stock.integer' => 'Stok harus berupa angka',
                'stock.min' => 'Stok tidak boleh kurang dari 0',
                'image.image' => 'File harus berupa gambar',
                'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'image.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                    Storage::disk('public')->delete($produk->image);
                }
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $produk->update($validated);

            self::logActivity('update', 'Updated product: ' . $produk->name, ['produk_id' => $produk->id]);

            return back()->with('success', 'Produk "' . $produk->name . '" berhasil diubah.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('edit_id', $id);
        } catch (\Throwable $th) {
            Log::error('Error saat mengubah produk: ' . $th->getMessage());
            return back()->with('error', 'Gagal mengubah produk: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $nama = $produk->name;

            // Delete image
            if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                Storage::disk('public')->delete($produk->image);
            }

            $produk->delete();

            self::logActivity('delete', 'Deleted product: ' . $nama, ['produk_id' => $id]);

            return back()->with('success', 'Produk "' . $nama . '" berhasil dihapus.');
        } catch (\Throwable $th) {
            Log::error('Error saat menghapus produk: ' . $th->getMessage());
            return back()->with('error', 'Gagal menghapus produk: ' . $th->getMessage());
        }
    }
}
