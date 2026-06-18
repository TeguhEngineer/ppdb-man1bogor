<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DataPribadi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->safe()->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($request->hasFile('foto_profil')) {
            $pendaftaran = $user->pendaftarans()->latest()->first();
            if ($pendaftaran) {
                $pendaftaran->load(['biodata', 'dataPribadi']);
                $existingPhoto = optional($pendaftaran->dataPribadi)->foto_profil ?? optional($pendaftaran->biodata)->foto_profil;

                if ($pendaftaran->dataPribadi || $pendaftaran->biodata) {
                    if ($existingPhoto && Storage::disk('public')->exists($existingPhoto)) {
                        Storage::disk('public')->delete($existingPhoto);
                    }

                    $path = $request->file('foto_profil')->store('berkas/foto_profil', 'public');
                    DataPribadi::updateOrCreate(
                        ['pendaftaran_id' => $pendaftaran->id],
                        ['foto_profil' => $path]
                    );

                    $pendaftaran->fresh([
                        'dataPribadi',
                        'dataOrangtua',
                    ])->syncBiodataAggregate();
                } else {
                    return Redirect::route('profile.index')->with('error', 'Gagal mengunggah foto. Anda belum mengisi biodata pendaftaran.');
                }
            }
        }

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
