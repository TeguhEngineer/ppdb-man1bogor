<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdukResource;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $search = $request->query('search');

            $produks = Produk::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->latest()->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => ProdukResource::collection($produks),
                'meta' => [
                    'current_page' => $produks->currentPage(),
                    'last_page' => $produks->lastPage(),
                    'per_page' => $produks->perPage(),
                    'total' => $produks->total(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
                'error' => $th->getMessage(),
            ], 500);
        }
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
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $produk = Produk::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => new ProdukResource($produk),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $th->getMessage(),
            ], 422);
        }
    }

    public function show($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => new ProdukResource($produk),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
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
            ]);

            if ($request->hasFile('image')) {
                if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                    Storage::disk('public')->delete($produk->image);
                }
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $produk->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => new ProdukResource($produk),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $th->getMessage(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);

            if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                Storage::disk('public')->delete($produk->image);
            }

            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
            ], 500);
        }
    }
}
