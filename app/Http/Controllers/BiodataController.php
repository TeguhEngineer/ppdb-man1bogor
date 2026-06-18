<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\BiodataAlamat;
use App\Models\BiodataDataAyah;
use App\Models\BiodataDataIbu;
use App\Models\BiodataDataWali;
use App\Models\BiodataPendidikan;
use App\Models\BiodataPenunjangPrestasi;
use App\Models\BiodataPribadi;
use App\Models\Jalur;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BiodataController extends Controller
{
    private array $tabs = [
        'registrasi',
        'pribadi',
        'alamat',
        'pendidikan',
        'prestasi',
        'ayah',
        'ibu',
        'wali',
        'berkas',
    ];

    public function create(Request $request)
    {
        $pendaftaran = $this->pendaftaran();

        if ($pendaftaran->biodata) {
            return redirect()->route('biodata.edit', [
                'biodatum' => $pendaftaran->biodata->id,
                'tab' => $request->query('tab', 'registrasi'),
            ]);
        }

        return $this->showForm($pendaftaran, null, $request->query('tab', 'registrasi'));
    }

    public function edit(Request $request, Biodata $biodatum)
    {
        $pendaftaran = $this->pendaftaran();

        if ($biodatum->pendaftaran_id !== $pendaftaran->id) {
            abort(403);
        }

        $pendaftaran = $this->loadBiodataRelations($pendaftaran);

        return $this->showForm($pendaftaran, $biodatum, $request->query('tab', 'registrasi'));
    }

    public function updateTab(Request $request, string $tab)
    {
        abort_unless(in_array($tab, $this->tabs, true), 404);
        abort_if($tab === 'berkas', 404);

        $pendaftaran = $this->pendaftaran();
        $this->ensureEditable($pendaftaran);

        match ($tab) {
            'registrasi' => $this->saveRegistrasi($request, $pendaftaran),
            'pribadi' => $this->savePribadi($request, $pendaftaran),
            'alamat' => $this->saveAlamat($request, $pendaftaran),
            'pendidikan' => $this->savePendidikan($request, $pendaftaran),
            'prestasi' => $this->savePrestasi($request, $pendaftaran),
            'ayah' => $this->saveAyah($request, $pendaftaran),
            'ibu' => $this->saveIbu($request, $pendaftaran),
            'wali' => $this->saveWali($request, $pendaftaran),
        };

        $biodata = $this->loadBiodataRelations($pendaftaran)->syncBiodataAggregate();

        $targetTab = $this->targetTab($request, $tab);
        $route = $biodata
            ? route('biodata.edit', ['biodatum' => $biodata->id, 'tab' => $targetTab])
            : route('biodata.create', ['tab' => $targetTab]);

        return redirect($route)->with('success', 'Data berhasil disimpan.');
    }

    private function targetTab(Request $request, string $currentTab): string
    {
        $nextTab = $request->input('next_tab');

        if ($nextTab && in_array($nextTab, $this->tabs, true)) {
            return $nextTab;
        }

        return $currentTab;
    }

    private function showForm(Pendaftaran $pendaftaran, ?Biodata $biodatum, string $activeTab)
    {
        $pendaftaran = $this->loadBiodataRelations($pendaftaran);
        $jalurs = Jalur::all();
        $activeTab = in_array($activeTab, $this->tabs, true) ? $activeTab : 'registrasi';

        return view('biodata.form', compact('pendaftaran', 'biodatum', 'jalurs', 'activeTab'));
    }

    private function pendaftaran(): Pendaftaran
    {
        return Pendaftaran::where('user_id', Auth::id())->firstOrFail();
    }

    private function loadBiodataRelations(Pendaftaran $pendaftaran): Pendaftaran
    {
        return $pendaftaran->load([
            'biodata',
            'berkas',
            'jalur',
            'dataPribadi',
            'alamat',
            'pendidikan',
            'penunjangPrestasi',
            'dataAyah',
            'dataIbu',
            'dataWali',
        ]);
    }

    private function ensureEditable(Pendaftaran $pendaftaran): void
    {
        if (in_array($pendaftaran->status_pendaftaran, ['verifikasi', 'tes', 'lulus', 'tidak_lulus'], true)) {
            throw ValidationException::withMessages([
                'biodata' => 'Data sudah masuk tahap verifikasi dan tidak dapat diubah.',
            ]);
        }
    }

    private function saveRegistrasi(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'nisn' => ['required', 'numeric', 'digits:10'],
            'jalur_id' => ['required', 'exists:jalurs,id'],
            'kampus' => ['required', 'string', 'max:255'],
        ]);

        $pendaftaran->update($validated);
    }

    private function savePribadi(Request $request, Pendaftaran $pendaftaran): void
    {
        $biodataId = optional($pendaftaran->biodata)->id;
        $dataPribadiId = optional($pendaftaran->dataPribadi)->id;

        $validated = $this->validateBiodata($request, [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:laki-laki,perempuan'],
            'nik' => [
                'required',
                'numeric',
                'digits:16',
                Rule::unique('biodatas', 'nik')->ignore($biodataId),
                Rule::unique('biodata_pribadis', 'nik')->ignore($dataPribadiId),
            ],
            'no_kk' => ['required', 'numeric', 'digits:16'],
            'tinggi_badan' => ['required', 'integer'],
            'berat_badan' => ['required', 'integer'],
            'status_dalam_keluarga' => ['required', 'string', 'max:255'],
            'tinggal_bersama' => ['required', 'string', 'max:255'],
            'anak_ke' => ['required', 'integer'],
            'jumlah_saudara' => ['required', 'integer'],
            'agama' => ['required', 'string', 'max:255'],
            'no_whatsapp' => ['required', 'string', 'max:30'],
        ]);

        BiodataPribadi::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function saveAlamat(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'alamat' => ['required', 'string'],
            'desa' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kode_pos' => ['required', 'digits:5'],
            'jarak_ke_sekolah' => ['required', 'string', 'max:255'],
            'waktu_tempuh_ke_sekolah' => ['required', 'string', 'max:255'],
        ]);

        BiodataAlamat::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function savePendidikan(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'asal_satuan_pendidikan' => ['required', 'in:SMP,MTS'],
            'nama_asal_sekolah' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:255'],
        ]);

        BiodataPendidikan::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function savePrestasi(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'kategori_prestasi' => ['nullable', 'string', 'max:255'],
            'jumlah_juz' => ['nullable', 'integer'],
            'tingkat_prestasi' => ['nullable', 'string', 'max:255'],
            'jenis_prestasi' => ['nullable', 'string', 'max:255'],
            'nama_lomba' => ['nullable', 'string', 'max:255'],
        ]);

        BiodataPenunjangPrestasi::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function saveAyah(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'nama_ayah' => ['required', 'string', 'max:255'],
            'nik_ayah' => ['nullable', 'string', 'max:255'],
            'tempat_lahir_ayah' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir_ayah' => ['nullable', 'date'],
            'pendidikan_terakhir_ayah' => ['required', 'string', 'max:255'],
            'pekerjaan_ayah' => ['required', 'string', 'max:255'],
            'penghasilan_ayah' => ['required', 'string', 'max:255'],
            'no_hp_ayah' => ['required', 'string', 'max:30'],
        ]);

        BiodataDataAyah::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function saveIbu(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'nama_ibu' => ['required', 'string', 'max:255'],
            'nik_ibu' => ['nullable', 'string', 'max:255'],
            'tempat_lahir_ibu' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir_ibu' => ['nullable', 'date'],
            'pendidikan_terakhir_ibu' => ['required', 'string', 'max:255'],
            'pekerjaan_ibu' => ['required', 'string', 'max:255'],
            'penghasilan_ibu' => ['required', 'string', 'max:255'],
            'no_hp_ibu' => ['required', 'string', 'max:30'],
        ]);

        BiodataDataIbu::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function saveWali(Request $request, Pendaftaran $pendaftaran): void
    {
        $validated = $this->validateBiodata($request, [
            'nama_wali' => ['nullable', 'string', 'max:255'],
            'nik_wali' => ['nullable', 'string', 'max:255'],
            'tempat_lahir_wali' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir_wali' => ['nullable', 'date'],
            'pendidikan_terakhir_wali' => ['nullable', 'string', 'max:255'],
            'pekerjaan_wali' => ['nullable', 'string', 'max:255'],
            'penghasilan_wali' => ['nullable', 'string', 'max:255'],
            'no_hp_wali' => ['nullable', 'string', 'max:30'],
        ]);

        BiodataDataWali::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validated);
    }

    private function validateBiodata(Request $request, array $rules): array
    {
        return $request->validate($rules, $this->validationMessages(), $this->validationAttributes());
    }

    private function validationMessages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'digits' => ':attribute harus berjumlah tepat :digits digit.',
            'integer' => ':attribute harus berupa angka.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'in' => ':attribute tidak valid.',
            'exists' => ':attribute tidak valid.',
            'unique' => ':attribute sudah terdaftar.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute maksimal :max karakter.',
        ];
    }

    private function validationAttributes(): array
    {
        return [
            'nisn' => 'NISN',
            'jalur_id' => 'jalur pendaftaran',
            'kampus' => 'pilihan kampus',
            'nama_lengkap' => 'nama lengkap',
            'tempat_lahir' => 'tempat lahir',
            'tanggal_lahir' => 'tanggal lahir',
            'jenis_kelamin' => 'jenis kelamin',
            'nik' => 'NIK',
            'no_kk' => 'nomor KK',
            'tinggi_badan' => 'tinggi badan',
            'berat_badan' => 'berat badan',
            'status_dalam_keluarga' => 'status dalam keluarga',
            'tinggal_bersama' => 'tinggal bersama',
            'anak_ke' => 'anak ke',
            'jumlah_saudara' => 'jumlah saudara',
            'agama' => 'agama',
            'no_whatsapp' => 'nomor WhatsApp',
            'alamat' => 'alamat lengkap',
            'desa' => 'desa/kelurahan',
            'kecamatan' => 'kecamatan',
            'kabupaten' => 'kabupaten/kota',
            'provinsi' => 'provinsi',
            'kode_pos' => 'kode pos',
            'jarak_ke_sekolah' => 'jarak ke sekolah',
            'waktu_tempuh_ke_sekolah' => 'waktu tempuh ke sekolah',
            'asal_satuan_pendidikan' => 'asal satuan pendidikan',
            'nama_asal_sekolah' => 'nama asal sekolah',
            'npsn' => 'NPSN',
            'kategori_prestasi' => 'kategori prestasi',
            'jumlah_juz' => 'jumlah juz hafalan',
            'tingkat_prestasi' => 'tingkat prestasi',
            'jenis_prestasi' => 'jenis prestasi',
            'nama_lomba' => 'nama lomba',
            'nama_ayah' => 'nama ayah',
            'nik_ayah' => 'NIK ayah',
            'tempat_lahir_ayah' => 'tempat lahir ayah',
            'tanggal_lahir_ayah' => 'tanggal lahir ayah',
            'pendidikan_terakhir_ayah' => 'pendidikan terakhir ayah',
            'pekerjaan_ayah' => 'pekerjaan ayah',
            'penghasilan_ayah' => 'penghasilan ayah',
            'no_hp_ayah' => 'nomor HP ayah',
            'nama_ibu' => 'nama ibu',
            'nik_ibu' => 'NIK ibu',
            'tempat_lahir_ibu' => 'tempat lahir ibu',
            'tanggal_lahir_ibu' => 'tanggal lahir ibu',
            'pendidikan_terakhir_ibu' => 'pendidikan terakhir ibu',
            'pekerjaan_ibu' => 'pekerjaan ibu',
            'penghasilan_ibu' => 'penghasilan ibu',
            'no_hp_ibu' => 'nomor HP ibu',
            'nama_wali' => 'nama wali',
            'nik_wali' => 'NIK wali',
            'tempat_lahir_wali' => 'tempat lahir wali',
            'tanggal_lahir_wali' => 'tanggal lahir wali',
            'pendidikan_terakhir_wali' => 'pendidikan terakhir wali',
            'pekerjaan_wali' => 'pekerjaan wali',
            'penghasilan_wali' => 'penghasilan wali',
            'no_hp_wali' => 'nomor HP wali',
        ];
    }
}
