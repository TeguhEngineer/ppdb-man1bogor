<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jalur;
use App\Models\Pendaftaran;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:150'],
                'nisn' => ['required', 'numeric', 'digits:10'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:191', 'unique:'.User::class],
                'password' => ['required', 'digits:10', 'same:nisn'],
                'jalur' => ['nullable', 'string']
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.max' => 'Nama maksimal 255 karakter.',
                'nisn.required' => 'NISN wajib diisi.',
                'nisn.numeric' => 'NISN harus berupa angka.',
                'nisn.digits' => 'NISN harus berjumlah tepat 10 digit.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email tersebut sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.digits' => 'Password harus sama dengan NISN dan berjumlah 10 digit.',
                'password.same' => 'Password harus sama dengan NISN.',
            ]);

            // 1. Create User as Peserta
            $user = User::create([
                'name' => $validated['name'],
                'nisn' => $validated['nisn'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'peserta',
            ]);

            // 2. Determine Jalur
            $namaJalurInput = ucfirst($request->input('jalur', 'Reguler'));
            $jalur = Jalur::where('nama_jalur', $namaJalurInput)->first();
            
            if (!$jalur) {
                // Fallback to Reguler if somehow invalid
                $jalur = Jalur::where('nama_jalur', 'Reguler')->first();
            }

            // 3. Generate No Pendaftaran (Format: PPDBYYYYMMDD0001)
            $datePrefix = 'PPDB' . date('Ymd');
            $lastPendaftaran = Pendaftaran::where('no_pendaftaran', 'like', $datePrefix . '%')
                                ->orderBy('no_pendaftaran', 'desc')
                                ->first();

            if ($lastPendaftaran) {
                $lastSequence = intval(substr($lastPendaftaran->no_pendaftaran, -4));
                $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newSequence = '0001';
            }

            $noPendaftaran = $datePrefix . $newSequence;

            // 4. Create Pendaftaran Record
            Pendaftaran::create([
                'no_pendaftaran' => $noPendaftaran,
                'user_id' => $user->id,
                'jalur_id' => $jalur->id,
                'nisn' => $validated['nisn'],
                'status_pendaftaran' => 'pending'
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal melakukan registrasi: ' . $th->getMessage()]);
        }
    }
}
