<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .container {
            width: 190mm;
            margin: 0 auto;
            padding: 10mm;
        }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #22690f;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: auto;
            margin-right: 20px;
        }
        .header-text {
            flex: 1;
            text-align: center;
        }
        .header-text h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            color: #22690f;
        }
        .header-text h2 {
            margin: 5px 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header-text p {
            margin: 0;
            font-size: 11px;
            color: #666;
        }
        .form-title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .registration-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .registration-box table {
            width: 100%;
        }
        .registration-box td {
            padding: 2px 5px;
        }
        .section-title {
            background-color: #22690f;
            color: #white;
            padding: 5px 10px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 13px;
            color: #fff;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table.data-table td {
            padding: 6px 5px;
            vertical-align: top;
        }
        table.data-table td.label {
            width: 30%;
            font-weight: bold;
        }
        table.data-table td.separator {
            width: 2%;
        }
        .photo-box {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 10px;
            float: right;
            margin-left: 20px;
            background-size: cover;
            background-position: center;
        }
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
        .print-btn-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        @media print {
            .print-btn-container {
                display: none;
            }
            body {
                background-color: white;
            }
        }
        .btn-print {
            background-color: #22690f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header / Kop Surat -->
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            <div class="header-text">
                <h1>Kementerian Agama Republik Indonesia</h1>
                <h2>MAN 1 BOGOR</h2>
                <p>Jl. Lingkungan Kayu Manis No. 30, Desa Cirimekar, Kecamatan Cibinong, Kabupaten Bogor</p>
                <p>Website: www.man1bogor.sch.id | Email: info@man1bogor.sch.id</p>
            </div>
        </div>

        <div class="form-title">Formulir Pendaftaran Peserta Didik Baru</div>

        <div class="registration-box">
            <table>
                <tr>
                    <td width="20%">No. Pendaftaran</td>
                    <td width="2%">:</td>
                    <td width="30%"><strong>{{ $pendaftaran->no_pendaftaran }}</strong></td>
                    <td width="20%">Jalur Pendaftaran</td>
                    <td width="2%">:</td>
                    <td width="26%"><strong>{{ $pendaftaran->jalur->nama_jalur }}</strong></td>
                </tr>
                <tr>
                    <td>Tanggal Daftar</td>
                    <td>:</td>
                    <td>{{ $pendaftaran->created_at->format('d F Y') }}</td>
                    <td>Status</td>
                    <td>:</td>
                    <td>{{ ucfirst($pendaftaran->status_pendaftaran) }}</td>
                </tr>
            </table>
        </div>

        @if($pendaftaran->biodata->foto_profil)
            <div class="photo-box" style="background-image: url('{{ Storage::url($pendaftaran->biodata->foto_profil) }}')">
            </div>
        @else
            <div class="photo-box">
                Pas Foto<br>3 x 4
            </div>
        @endif

        <div class="section-title">I. DATA PRIBADI SISWA</div>
        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="label">NISN / NIK</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->nisn ?? '-' }} / {{ $pendaftaran->biodata->nik }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->biodata->tanggal_lahir)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="separator">:</td>
                <td>{{ ucfirst($pendaftaran->biodata->jenis_kelamin) }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->agama }}</td>
            </tr>
            <tr>
                <td class="label">No. WhatsApp</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->no_whatsapp }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Lengkap</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->alamat }}, Desa {{ $pendaftaran->biodata->desa }}, Kec. {{ $pendaftaran->biodata->kecamatan }}, {{ $pendaftaran->biodata->kabupaten }}, {{ $pendaftaran->biodata->provinsi }}</td>
            </tr>
        </table>

        <div class="section-title">II. DATA PENDIDIKAN ASAL</div>
        <table class="data-table">
            <tr>
                <td class="label">Asal Sekolah</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->asal_satuan_pendidikan }} {{ $pendaftaran->biodata->nama_asal_sekolah }}</td>
            </tr>
            <tr>
                <td class="label">NPSN Sekolah Asal</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->npsn ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">III. DATA ORANG TUA / WALI</div>
        <table class="data-table">
            <tr>
                <td class="label">Nama Ayah</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->nama_ayah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan Ayah</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->pekerjaan_ayah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nama Ibu</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->nama_ibu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan Ibu</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->pekerjaan_ibu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">No. HP Orang Tua</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->biodata->no_hp_ayah ?? $pendaftaran->biodata->no_hp_ibu ?? '-' }}</td>
            </tr>
        </table>

        @if($pendaftaran->jalur->nama_jalur != 'Reguler')
        <div class="section-title">IV. BERKAS KHUSUS</div>
        <table class="data-table">
            @if($pendaftaran->jalur->nama_jalur == 'Prestasi')
            <tr>
                <td class="label">Sertifikat/Piagam</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->berkas && $pendaftaran->berkas->file_sertifikat ? 'Sudah Diupload' : 'Belum Diupload' }}</td>
            </tr>
            @endif
            @if($pendaftaran->jalur->nama_jalur == 'Afirmasi')
            <tr>
                <td class="label">SKTM</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->berkas && $pendaftaran->berkas->file_sktm ? 'Sudah Diupload' : 'Belum Diupload' }}</td>
            </tr>
            <tr>
                <td class="label">Kartu KIP</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->berkas && $pendaftaran->berkas->file_kip ? 'Sudah Diupload' : 'Belum Diupload' }}</td>
            </tr>
            @endif
        </table>
        @endif

        <div class="footer">
            <div class="signature-box">
                <p>Panitia PPDB,</p>
                <div class="signature-space"></div>
                <p>( .................................... )</p>
            </div>
            <div class="signature-box">
                <p>Bogor, {{ date('d F Y') }}</p>
                <p>Calon Siswa,</p>
                <div class="signature-space"></div>
                <p><strong>{{ $pendaftaran->biodata->nama_lengkap }}</strong></p>
            </div>
        </div>

        <div style="margin-top: 50px; font-size: 10px; color: #888; font-style: italic; border-top: 1px dashed #ccc; padding-top: 5px;">
            * Dokumen ini dicetak secara otomatis melalui Sistem PPDB MAN 1 BOGOR pada {{ date('d/m/Y H:i:s') }}.
        </div>
    </div>

    <div class="print-btn-container">
        <button onclick="window.print()" class="btn-print">Cetak Sekarang</button>
        <button onclick="window.close()" class="btn-print" style="background-color: #666; margin-left: 10px;">Tutup</button>
    </div>

    <script>
        window.onload = function() {
            // Optional: Auto print on load
            // window.print();
        }
    </script>
</body>
</html>
