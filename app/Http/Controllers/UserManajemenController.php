<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class UserManajemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->paginate($perPage)
            ->appends(request()->query());

        return view('userManajemen.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
                'telepon' => 'nullable|numeric|digits_between:11,13|unique:users,telepon',
                'role' => 'required|in:administrator,operator',
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email telah terdaftar',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sama',
                'telepon.numeric' => 'Nomor telepon harus angka',
                'telepon.digits_between' => 'Nomor telepon harus 11-13 digit',
                'telepon.unique' => 'Nomor telepon sudah terdaftar',
                'role.required' => 'Role harus dipilih',
                'role.in' => 'Role tidak valid'
            ]);

            $validateData['password'] = bcrypt($validateData['password']);

            User::create($validateData);
            return back()->with('success', 'Data user "' . $validateData['name'] . '" berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('add');
        } catch (\Throwable $th) {
            Log::error('Error saat menyimpan data: ' . $th->getMessage());
            return back()->with('error', 'Gagal menyimpan data' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $id,
                'telepon' => 'nullable|numeric|digits_between:11,13|unique:users,telepon,' . $id,
                'role' => 'required|in:administrator,operator',
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email telah terdaftar',
                'telepon.numeric' => 'Nomor telepon harus angka',
                'telepon.digits_between' => 'Nomor telepon harus 11-13 digit',
                'telepon.unique' => 'Nomor telepon sudah terdaftar',
                'role.required' => 'Role harus dipilih',
                'role.in' => 'Role tidak valid'
            ]);

            User::findOrFail($id)->update($validateData);
            return back()->with('success', 'Data user "' . $validateData['name'] . '" berhasil diubah.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('edit_id', $id);
        } catch (\Throwable $th) {
            Log::error('Error saat menyimpan data: ' . $th->getMessage());
            return back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $nama = $user->name;
        $user->delete();

        return back()->with('success', 'Data user ' . "$nama" . ' berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
