<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta Ujian - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
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
            margin: 16px auto 20px;
            width: max-content;
            border: 1.5px solid #111827;
            border-radius: 999px;
            padding: 8px 28px;
            font-weight: 900;
            letter-spacing: .8px;
        }
        .content {
            display: grid;
            grid-template-columns: 1fr 95px;
            gap: 22px;
            align-items: start;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        td {
            padding: 5px 0;
            vertical-align: top;
        }
        td.label {
            width: 36%;
            font-weight: 700;
        }
        td.sep {
            width: 14px;
            text-align: center;
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
        .boxed {
            display: inline-block;
            border: 1px solid #6b7280;
            border-radius: 3px;
            padding: 2px 8px;
            font-weight: 800;
        }
        .account {
            margin-top: 22px;
            padding-top: 14px;
            border-top: 1px dashed #9ca3af;
            width: 75%;
        }
        .footer {
            margin-top: 36px;
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
            margin-top: 28px;
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
        $kartu = $pendaftaran->kartuPesertaUjian;
        $jadwal = $kartu->jadwalUjian;
        $mapels = $pendaftaran->jalur->mapels->pluck('nama_mapel')->join(', ');
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

        <div class="title">KARTU PESERTA UJIAN</div>

        <div class="content">
            <table>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="sep">:</td>
                    <td><strong>{{ $pendaftaran->biodata->nama_lengkap ?? $pendaftaran->user->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Asal Sekolah</td>
                    <td class="sep">:</td>
                    <td>{{ $pendaftaran->biodata->nama_asal_sekolah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Jalur Pendaftaran</td>
                    <td class="sep">:</td>
                    <td>{{ strtoupper($pendaftaran->jalur->nama_jalur) }}</td>
                </tr>
                <tr>
                    <td class="label">Pilihan Kampus</td>
                    <td class="sep">:</td>
                    <td><strong>{{ strtoupper($pendaftaran->kampus) }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Ruangan Ujian</td>
                    <td class="sep">:</td>
                    <td><span class="boxed">{{ $kartu->ruangan->nama_ruangan }}</span></td>
                </tr>
                <tr>
                    <td class="label">Mata Pelajaran</td>
                    <td class="sep">:</td>
                    <td>{{ $mapels ?: '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Ujian</td>
                    <td class="sep">:</td>
                    <td>{{ $jadwal->tanggal_ujian->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu Ujian</td>
                    <td class="sep">:</td>
                    <td>{{ \Illuminate\Support\Str::of($jadwal->waktu_mulai)->substr(0, 5) }} - {{ \Illuminate\Support\Str::of($jadwal->waktu_selesai)->substr(0, 5) }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Jadwal Wawancara<br>dan BTQ</td>
                    <td class="sep">:</td>
                    <td>
                        @if($jadwal->tanggal_wawancara_btq)
                            {{ $jadwal->tanggal_wawancara_btq->format('d-m-Y') }}
                            @if($jadwal->waktu_wawancara_btq)
                                (Pukul {{ \Illuminate\Support\Str::of($jadwal->waktu_wawancara_btq)->substr(0, 5) }} WIB)
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Tempat Wawancara</td>
                    <td class="sep">:</td>
                    <td>{{ $jadwal->tempat_wawancara_btq ?? '-' }}</td>
                </tr>
            </table>

            @if($foto)
                <div class="photo" style="background-image: url('{{ Storage::url($foto) }}')"></div>
            @else
                <div class="photo">Pas Foto<br>3 x 4</div>
            @endif
        </div>

        <div class="account">
            <table>
                <tr>
                    <td class="label">Username Ujian</td>
                    <td class="sep">:</td>
                    <td><span class="boxed">{{ $kartu->username_ujian }}</span></td>
                </tr>
                <tr>
                    <td class="label">Password Ujian</td>
                    <td class="sep">:</td>
                    <td><span class="boxed">{{ $kartu->password_ujian }}</span></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="signature">
                <p>Panitia PMB,</p>
                <div class="signature-space"></div>
                <p><strong>Wahyu Mulyadin, SP, MM</strong></p>
                <p>NIP. 196806221999031003</p>
            </div>
        </div>

        <div class="note">* Bawa kartu ini saat pelaksanaan ujian</div>
    </div>
</body>
</html>
