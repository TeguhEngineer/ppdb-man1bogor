<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Kelulusan Seleksi - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: "Times New Roman", Times, serif;
            color: #000;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 185mm;
            min-height: 270mm;
            margin: 8mm auto;
            background: #fff;
            padding: 10mm 12mm 8mm;
            box-sizing: border-box;
            position: relative;
            box-shadow: 0 0 8px rgba(0,0,0,.08);
        }
        .topline {
            display: flex;
            justify-content: space-between;
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #111827;
            margin-bottom: 10px;
        }
        .kop {
            display: grid;
            grid-template-columns: 70px 1fr 70px;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            text-align: center;
        }
        .logo {
            width: 56px;
            height: 56px;
            object-fit: contain;
        }
        .kop h1 {
            font-size: 19px;
            line-height: 1.35;
            margin: 0;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .kop h2 {
            font-size: 22px;
            margin: 4px 0 0;
            font-weight: 700;
        }
        .kop p {
            margin: 4px 0 0;
            font-size: 13px;
            font-style: italic;
        }
        .title {
            text-align: center;
            margin-top: 18px;
            margin-bottom: 18px;
        }
        .title h3 {
            font-size: 16px;
            margin: 0;
            text-decoration: underline;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .title p {
            font-size: 13px;
            margin: 6px 0 0;
        }
        .content {
            font-size: 14px;
            line-height: 1.35;
        }
        .identity {
            margin: 12px 0 14px 35px;
            border-collapse: collapse;
            width: calc(100% - 35px);
        }
        .identity td {
            padding: 3px 0;
            vertical-align: top;
        }
        .identity .label { width: 145px; }
        .identity .sep { width: 14px; }
        .statement {
            text-align: justify;
            margin: 10px 0;
        }
        .status-box {
            width: max-content;
            margin: 16px auto;
            border: 2px solid #000;
            padding: 9px 18px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .2px;
        }
        .agenda {
            border: 1.5px dashed #555;
            margin: 12px 34px;
            padding: 10px 14px;
        }
        .agenda table {
            width: 100%;
            border-collapse: collapse;
        }
        .agenda td {
            padding: 4px 0;
            vertical-align: top;
        }
        .agenda .label {
            width: 120px;
            font-weight: 700;
        }
        .agenda .sep { width: 14px; }
        .signature-wrap {
            margin-top: 28px;
            display: flex;
            justify-content: flex-end;
        }
        .signature {
            width: 210px;
            text-align: center;
            font-size: 14px;
        }
        .signature-space {
            height: 58px;
        }
        .signature strong {
            text-decoration: underline;
        }
        .digital {
            position: absolute;
            left: 12mm;
            right: 12mm;
            bottom: 18mm;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 8px;
            font-family: Arial, sans-serif;
        }
        .qr {
            width: 64px;
            height: 64px;
            border: 1px solid #111827;
            object-fit: cover;
        }
        .digital-title {
            font-size: 10px;
            font-weight: 800;
            color: #111827;
        }
        .digital-text {
            font-size: 9px;
            color: #4b5563;
            line-height: 1.35;
            max-width: 390px;
        }
        .copyright {
            position: absolute;
            left: 12mm;
            right: 12mm;
            bottom: 6mm;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #9ca3af;
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
            font-family: Arial, sans-serif;
        }
        @media print {
            body { background: #fff; }
            .print-btn { display: none; }
            .page {
                margin: 0 auto;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    @php
        $dataPribadi = $pendaftaran->dataPribadi;
        $isLulus = $pendaftaran->status_pendaftaran === 'lulus';
        $statusLabel = $isLulus ? 'LULUS / DITERIMA' : 'TIDAK LULUS / TIDAK DITERIMA';
        $nama = strtoupper($dataPribadi->nama_lengkap ?? $pendaftaran->user->name);
        $nik = $dataPribadi->nik ?? '-';
        $nisnNik = trim(($pendaftaran->nisn ?? '-') . ' / ' . $nik);
        $asalSekolah = strtoupper($dataPribadi->nama_asal_sekolah ?? '-');
        $jalur = $pendaftaran->jalur->nama_jalur ?? '-';
        $tahunAwal = now()->year;
        $tahunAkhir = $tahunAwal + 1;
        $romanMonths = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $nomorSurat = str_pad((string) $pendaftaran->id, 2, '0', STR_PAD_LEFT) . '/PAN-PMBM/' . $romanMonths[now()->month] . '/' . now()->year;
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $tanggalCetak = now()->day . ' ' . $bulan[now()->month] . ' ' . now()->year;
        $verificationUrl = route('hasil-kelulusan.cetak');
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=' . urlencode($verificationUrl);
        $agendaTanggal = 'Menunggu pengumuman panitia';
        $agendaWaktu = 'Menunggu pengumuman panitia';
        $agendaTempat = $pendaftaran->kampus ?: 'MAN 1 Bogor';
        $agendaKeperluan = 'Rapat Sosialisasi Program MAN 1 Bogor';
    @endphp

    <button class="print-btn" onclick="window.print()">Cetak Surat</button>

    <div class="page">
        <div class="topline">
            <span>{{ now()->format('n/j/y, h:i A') }}</span>
            <span>PPDB Premium | MAN 1 BOGOR</span>
        </div>

        <div class="kop">
            <img src="{{ asset('logo.png') }}" alt="Logo MAN 1 Bogor" class="logo">
            <div>
                <h1>PANITIA PENERIMAAN MURID BARU MADRASAH</h1>
                <h2>MAN 1 BOGOR</h2>
                <p>Jl. Kayu Manis No.10 Cirimekar, Cibinong, Kabupaten Bogor</p>
            </div>
            <div></div>
        </div>

        <div class="title">
            <h3>SURAT KETERANGAN KELULUSAN SELEKSI</h3>
            <p>Nomor: {{ $nomorSurat }}</p>
        </div>

        <div class="content">
            <p>Dengan ini menerangkan bahwa:</p>

            <table class="identity">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="sep">:</td>
                    <td><strong>{{ $nama }}</strong></td>
                </tr>
                <tr>
                    <td class="label">NISN / NIK</td>
                    <td class="sep">:</td>
                    <td>{{ $nisnNik }}</td>
                </tr>
                <tr>
                    <td class="label">Asal Sekolah</td>
                    <td class="sep">:</td>
                    <td>{{ $asalSekolah }}</td>
                </tr>
                <tr>
                    <td class="label">Jalur Pendaftaran</td>
                    <td class="sep">:</td>
                    <td>{{ $jalur }}</td>
                </tr>
            </table>

            <p class="statement">
                Berdasarkan hasil seleksi Penerimaan Murid Baru Madrasah (PMBM) Tahun Pelajaran
                {{ $tahunAwal }}/{{ $tahunAkhir }}, nama tersebut di atas dinyatakan:
            </p>

            <div class="status-box">{{ $statusLabel }}</div>

            @if($isLulus)
                <p class="statement">
                    Berkaitan dengan kelulusan tersebut, Bapak/Ibu Orang Tua/Wali Calon Murid Baru diperkenankan
                    untuk menghadiri kegiatan <strong>Rapat Sosialisasi Program MAN 1 Bogor</strong> yang akan diselenggarakan pada:
                </p>

                <div class="agenda">
                    <table>
                        <tr>
                            <td class="label">Hari, Tanggal</td>
                            <td class="sep">:</td>
                            <td><strong>{{ $agendaTanggal }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Waktu</td>
                            <td class="sep">:</td>
                            <td><strong>{{ $agendaWaktu }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Tempat</td>
                            <td class="sep">:</td>
                            <td>{{ $agendaTempat }}</td>
                        </tr>
                        <tr>
                            <td class="label">Keperluan</td>
                            <td class="sep">:</td>
                            <td>{{ $agendaKeperluan }}</td>
                        </tr>
                    </table>
                </div>
            @else
                <p class="statement">
                    Terima kasih telah mengikuti proses seleksi Penerimaan Murid Baru Madrasah (PMBM)
                    MAN 1 Bogor Tahun Pelajaran {{ $tahunAwal }}/{{ $tahunAkhir }}.
                </p>
            @endif

            <p class="statement">
                Demikian surat keterangan ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.
            </p>

            <div class="signature-wrap">
                <div class="signature">
                    <p>Bogor, {{ $tanggalCetak }}<br>Ketua Panitia,</p>
                    <div class="signature-space"></div>
                    <p><strong>WAHYU MULYADIN, SP, MM</strong><br>NIP. 196806221999031003</p>
                </div>
            </div>
        </div>

        <div class="digital">
            <img class="qr" src="{{ $qrUrl }}" alt="QR Verifikasi Digital">
            <div>
                <div class="digital-title">VERIFIKASI DIGITAL:</div>
                <div class="digital-text">
                    Dokumen ini diterbitkan secara resmi oleh sistem PPDB MAN 1 BOGOR.
                    Keaslian surat dapat divalidasi dengan memindai QR Code atau membuka tautan:
                    {{ $verificationUrl }}
                </div>
            </div>
        </div>

        <div class="copyright">
            &copy; {{ now()->year }} <strong>MAN 1 BOGOR</strong> . All Rights Reserved.
        </div>
    </div>
</body>
</html>
