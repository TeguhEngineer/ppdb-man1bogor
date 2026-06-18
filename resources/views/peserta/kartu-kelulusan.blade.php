<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kelulusan - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: Arial, sans-serif;
            color: #111827;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 170mm;
            min-height: 230mm;
            margin: 12mm auto;
            border: 2px solid #111827;
            padding: 12mm;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            display: grid;
            grid-template-columns: 70px 1fr 70px;
            align-items: center;
            border-bottom: 4px solid #1f2937;
            padding-bottom: 12px;
            text-align: center;
        }
        .logo {
            width: 58px;
            height: 58px;
            object-fit: contain;
        }
        .header h1 {
            font-size: 19px;
            line-height: 1.25;
            margin: 0;
            font-weight: 800;
            letter-spacing: .4px;
        }
        .header h2 {
            font-size: 24px;
            margin: 4px 0 0;
            color: #1d4ed8;
            letter-spacing: 2px;
            font-weight: 900;
        }
        .header p {
            margin: 2px 0 0;
            font-size: 12px;
            color: #4b5563;
        }
        .title {
            margin: 18px auto 22px;
            width: max-content;
            border: 1.5px solid #111827;
            border-radius: 999px;
            padding: 8px 28px;
            font-weight: 900;
            letter-spacing: .8px;
        }
        .result {
            text-align: center;
            padding: 18px;
            border-radius: 12px;
            border: 2px solid {{ $pendaftaran->status_pendaftaran === 'lulus' ? '#059669' : '#dc2626' }};
            background: {{ $pendaftaran->status_pendaftaran === 'lulus' ? '#ecfdf5' : '#fef2f2' }};
            margin-bottom: 22px;
        }
        .result .label {
            font-size: 12px;
            color: #4b5563;
            letter-spacing: 2px;
            font-weight: 800;
        }
        .result .status {
            font-size: 34px;
            font-weight: 900;
            color: {{ $pendaftaran->status_pendaftaran === 'lulus' ? '#047857' : '#b91c1c' }};
            margin-top: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        td {
            padding: 7px 0;
            vertical-align: top;
        }
        td.label {
            width: 32%;
            font-weight: 700;
        }
        td.sep {
            width: 14px;
            text-align: center;
        }
        .content {
            display: grid;
            grid-template-columns: 1fr 95px;
            gap: 22px;
            align-items: start;
        }
        .photo {
            width: 90px;
            height: 120px;
            border: 2px solid #6b7280;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
        }
        .message {
            margin-top: 24px;
            font-size: 13px;
            line-height: 1.7;
            text-align: justify;
        }
        .footer {
            margin-top: 42px;
            display: flex;
            justify-content: flex-end;
        }
        .signature {
            width: 220px;
            text-align: center;
            font-size: 12px;
        }
        .signature-space {
            height: 62px;
        }
        .note {
            position: absolute;
            left: 12mm;
            bottom: 10mm;
            font-size: 10px;
            color: #6b7280;
            font-style: italic;
        }
        .print-btn {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background: #059669;
            color: white;
            border: 0;
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
        }
        @media print {
            .print-btn { display: none; }
            .page { margin: 0 auto; }
        }
    </style>
</head>
<body>
    @php
        $isLulus = $pendaftaran->status_pendaftaran === 'lulus';
        $statusLabel = $isLulus ? 'LULUS' : 'TIDAK LULUS';
        $name = $pendaftaran->biodata->nama_lengkap ?? $pendaftaran->user->name;
        $foto = optional($pendaftaran->berkas)->file_foto;
    @endphp

    <button class="print-btn" onclick="window.print()">Cetak Kartu</button>

    <div class="page">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            <div>
                <h1>PANITIA PENERIMAAN MURID BARU<br>MADRASAH</h1>
                <h2>MAN 1 BOGOR</h2>
                <p>Tahun Pelajaran {{ now()->format('Y') }}/{{ now()->addYear()->format('Y') }}</p>
            </div>
            <div></div>
        </div>

        <div class="title">KARTU HASIL KELULUSAN</div>

        <div class="result">
            <div class="label">STATUS HASIL SELEKSI</div>
            <div class="status">{{ $statusLabel }}</div>
        </div>

        <div class="content">
            <table>
                <tr>
                    <td class="label">No Pendaftaran</td>
                    <td class="sep">:</td>
                    <td><strong>{{ $pendaftaran->no_pendaftaran }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="sep">:</td>
                    <td><strong>{{ $name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">NISN</td>
                    <td class="sep">:</td>
                    <td>{{ $pendaftaran->nisn ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Asal Sekolah</td>
                    <td class="sep">:</td>
                    <td>{{ $pendaftaran->biodata->nama_asal_sekolah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Jalur Pendaftaran</td>
                    <td class="sep">:</td>
                    <td>{{ $pendaftaran->jalur->nama_jalur ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Pilihan Kampus</td>
                    <td class="sep">:</td>
                    <td>{{ $pendaftaran->kampus ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Cetak</td>
                    <td class="sep">:</td>
                    <td>{{ now()->format('d M Y H:i') }} WIB</td>
                </tr>
            </table>

            @if($foto)
                <div class="photo" style="background-image: url('{{ Storage::url($foto) }}')"></div>
            @else
                <div class="photo">Pas Foto<br>3 x 4</div>
            @endif
        </div>

        <div class="message">
            @if($isLulus)
                Berdasarkan hasil seleksi Penerimaan Murid Baru MAN 1 Bogor, peserta dengan data tersebut di atas dinyatakan <strong>LULUS</strong>. Peserta wajib mengikuti arahan dan informasi lanjutan dari panitia.
            @else
                Berdasarkan hasil seleksi Penerimaan Murid Baru MAN 1 Bogor, peserta dengan data tersebut di atas dinyatakan <strong>TIDAK LULUS</strong>. Terima kasih telah mengikuti seluruh proses seleksi PPDB.
            @endif
        </div>

        <div class="footer">
            <div class="signature">
                <p>Panitia PPDB,</p>
                <div class="signature-space"></div>
                <p><strong>Wahyu Mulyadin, SP, MM</strong></p>
                <p>NIP. 196806221999031003</p>
            </div>
        </div>

        <div class="note">* Kartu ini dicetak otomatis melalui sistem PPDB.</div>
    </div>
</body>
</html>
