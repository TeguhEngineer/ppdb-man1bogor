<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-24">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PPDB MAN 1 BOGOR - Sistem Penerimaan Peserta Didik Baru</title>
  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50 selection:bg-main selection:text-white">

  <!-- Navigation -->
  <nav
    class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <div class="flex items-center gap-2">
          <img src="/logo.png" alt="Logo MAN 1 BOGOR" class="h-10 w-auto object-contain drop-shadow-sm">
          <span class="font-bold text-xl tracking-tight text-main line-clamp-1">PPDB <span class="text-secondary">MAN 1
              BOGOR</span></span>
        </div>

        <!-- Desktop Links -->
        <div class="hidden lg:flex items-center space-x-8 font-medium">
          <a href="#beranda" class="text-gray-600 hover:text-main transition">Beranda</a>
          <a href="#informasi-pendaftaran" class="text-gray-600 hover:text-main transition">Informasi Pendaftaran</a>
          <a href="#faq" class="text-gray-600 hover:text-main transition">FAQ</a>
          <a href="#kontak" class="text-gray-600 hover:text-main transition">Kontak</a>
        </div>

        <div class="flex items-center gap-4">
          <!-- Desktop Auth Buttons -->
          <a href="/login" class="hidden md:block text-gray-600 font-medium hover:text-main transition">Masuk</a>
          <a href="#jalur-pendaftaran-section"
            class="hidden md:block bg-main hover:bg-main/90 text-white px-6 py-2.5 rounded-full font-medium transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Daftar</a>

          <!-- Mobile Menu button -->
          <button id="mobile-menu-btn" class="lg:hidden text-main hover:text-gray-900 focus:outline-none p-1">
            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu"
      class="hidden lg:hidden bg-white border-t border-gray-100 shadow-xl max-h-[80vh] overflow-y-auto">
      <div class="flex flex-col px-4 py-4 space-y-4 font-medium">
        <a href="#beranda"
          class="mobile-link text-gray-600 hover:text-main transition py-2 border-b border-gray-50">Beranda</a>
        <a href="#informasi-pendaftaran"
          class="mobile-link text-gray-600 hover:text-main transition py-2 border-b border-gray-50">Informasi & Alur</a>
        <a href="#faq" class="mobile-link text-gray-600 hover:text-main transition py-2 border-b border-gray-50">FAQ</a>
        <a href="#kontak"
          class="mobile-link text-gray-600 hover:text-main transition py-2 border-b border-gray-50">Kontak</a>

        <div class="flex flex-col gap-3 pt-3">
          <a href="/login"
            class="text-center w-full bg-gray-100 text-gray-700 hover:bg-gray-200 px-6 py-3 rounded-xl font-medium transition">Masuk</a>
          <a href="#jalur-pendaftaran-section"
            class="mobile-link text-center w-full bg-main hover:bg-[#1a500b] text-white px-6 py-3 rounded-xl font-medium transition shadow-md">Daftar
            Sekarang</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Scripts -->
  <script>
    // Tab Logic
    function switchTab(tabId) {
      // Hide all contents
      document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
      });

      // Remove active state from all buttons
      document.querySelectorAll('#jalur-pendaftaran-section .tab-btn').forEach(el => {
        el.classList.remove('bg-main', 'text-white', 'shadow-md');
        el.classList.add('bg-white', 'md:bg-transparent', 'text-gray-600');
      });

      // Show selected content
      document.getElementById('tab-content-' + tabId).classList.remove('hidden');

      // Add active state to selected button
      const activeBtn = document.getElementById('tab-btn-' + tabId);
      activeBtn.classList.remove('bg-white', 'md:bg-transparent', 'text-gray-600');
      activeBtn.classList.add('bg-main', 'text-white', 'shadow-md');
    }

    // Mobile Menu Logic
    document.addEventListener('DOMContentLoaded', function () {
      const btn = document.getElementById('mobile-menu-btn');
      const menu = document.getElementById('mobile-menu');
      const links = document.querySelectorAll('.mobile-link');

      btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });

      links.forEach(link => {
        link.addEventListener('click', () => {
          menu.classList.add('hidden');
        });
      });
    });
  </script>

  <!-- Hero Banner Section -->
  <section id="beranda" class="mt-20 w-full bg-white flex justify-center border-b border-gray-50">
    <img src="/poster-ppdb.jpeg" alt="Hero Poster PPDB MAN 1 Bogor" class="w-full h-auto max-h-[85vh] object-contain">
  </section>

  <!-- Welcome / Intro Section -->
  <section class="py-16 md:py-24 bg-white relative">
    <div class="absolute inset-0 opacity-5"
      style="background-image: radial-gradient(#22690f 1px, transparent 1px); background-size: 30px 30px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
      <div class="text-center max-w-4xl mx-auto mb-10">

        <!-- Sambutan -->
        <h2 class="text-2xl md:text-4xl font-extrabold text-main mb-6">Selamat datang di Portal Layanan PPDB <br> MAN 1
          BOGOR</h2>

        <div
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-secondary/10 text-main font-bold text-sm mb-6 border border-secondary/30">
          <span class="w-2.5 h-2.5 rounded-full bg-secondary animate-pulse"></span>
          Pendaftaran Tahun Ajaran 2026/2027
        </div>

        <p class="text-lg md:text-xl text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto font-medium">
          Wujudkan pendidikan berkualitas melalui sistem pendaftaran yang modern, transparan, dan akuntabel.
          Bergabunglah bersama MAN 1 BOGOR untuk membangun masa depan gemilang.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-5 justify-center">
          <a href="/register"
            class="bg-main hover:bg-[#1a500b] text-white px-8 py-4 rounded-full font-bold text-lg transition shadow-xl shadow-main/40 flex items-center justify-center gap-2">
            Mulai Pendaftaran
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- Informasi & Alur Section -->
  <section id="informasi-pendaftaran" class="pb-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi Pendaftaran</h2>
        <div class="w-16 h-1 bg-secondary mx-auto rounded"></div>
      </div>


      <!-- Sub 2: Alur Pendaftaran -->
      <div class="mb-24">
        <div class="grid md:grid-cols-4 gap-6 text-center text-sm relative">
          <div class="hidden md:block absolute top-6 left-1/8 right-1/8 w-3/4 h-0.5 bg-gray-200 -z-10 ml-[12.5%]"></div>
          <div>
            <div
              class="w-12 h-12 mx-auto bg-white border-2 border-main text-main rounded-full flex items-center justify-center font-bold text-lg mb-4">
              1</div>
            <h4 class="font-bold text-gray-900">Daftar Akun</h4>
            <p class="text-gray-500 mt-1">Gunakan email aktif</p>
          </div>
          <div>
            <div
              class="w-12 h-12 mx-auto bg-white border-2 border-main text-main rounded-full flex items-center justify-center font-bold text-lg mb-4">
              2</div>
            <h4 class="font-bold text-gray-900">Isi Data & Berkas</h4>
            <p class="text-gray-500 mt-1">Lengkapi biodata lengkap</p>
          </div>
          <div>
            <div
              class="w-12 h-12 mx-auto bg-white border-2 border-main text-main rounded-full flex items-center justify-center font-bold text-lg mb-4">
              3</div>
            <h4 class="font-bold text-gray-900">Verifikasi & Tes</h4>
            <p class="text-gray-500 mt-1">Sesuai jadwal berlaku</p>
          </div>
          <div>
            <div
              class="w-12 h-12 mx-auto bg-main text-white rounded-full flex items-center justify-center font-bold text-lg mb-4 shadow-lg shadow-main/30">
              4</div>
            <h4 class="font-bold text-gray-900">Pengumuman</h4>
            <p class="text-gray-500 mt-1">Cek kelulusan di dasbor</p>
          </div>
        </div>
      </div>

      <!-- Sub 3: Jalur Pendaftaran -->
      <div id="jalur-pendaftaran-section">
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-10">Pilihan Jalur Pendaftaran</h3>

        <!-- Tab Navigation -->
        <div
          class="flex flex-col sm:flex-row justify-center gap-2 mb-10 md:bg-gray-100 p-2 rounded-2xl max-w-3xl mx-auto">
          <button onclick="switchTab('reguler')" id="tab-btn-reguler"
            class="tab-btn active bg-main text-white shadow-md px-6 py-3 rounded-xl font-bold transition-all duration-200 w-full sm:w-1/3 text-center">
            Jalur Reguler
          </button>
          <button onclick="switchTab('prestasi')" id="tab-btn-prestasi"
            class="tab-btn bg-white md:bg-transparent text-gray-600 hover:text-main border md:border-none border-gray-200 px-6 py-3 rounded-xl font-bold transition-all duration-200 w-full sm:w-1/3 text-center relative">
            Jalur Prestasi <span
              class="absolute top-2 right-2 w-2.5 h-2.5 bg-secondary rounded-full animate-pulse"></span>
          </button>
          <button onclick="switchTab('afirmasi')" id="tab-btn-afirmasi"
            class="tab-btn bg-white md:bg-transparent text-gray-600 hover:text-main border md:border-none border-gray-200 px-6 py-3 rounded-xl font-bold transition-all duration-200 w-full sm:w-1/3 text-center">
            Jalur Afirmasi
          </button>
        </div>

        <!-- Tab Content Container -->
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

          <!-- REGULER TAB -->
          <div id="tab-content-reguler" class="tab-content flex flex-col">
            <div class="h-48 md:h-64 w-full bg-gray-200 relative overflow-hidden">
              <img src="/poster-ppdb.jpeg" alt="Poster PPDB Reguler"
                class="absolute inset-0 w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
              <div class="absolute bottom-6 left-6 md:left-10 text-white">
                <h4 class="font-extrabold text-3xl mb-1 drop-shadow-md">Jalur Reguler</h4>
                <p class="text-gray-200 font-medium">Berdasarkan wilayah terdekat / Zonasi Umum.</p>
              </div>
            </div>
            <div class="p-6 md:p-10 flex flex-col">
              <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                  <h5
                    class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Persyaratan Wajib</h5>
                  <ul class="text-sm text-gray-700 space-y-3 font-medium">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-main shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Wajib memiliki Kartu Keluarga (KK) & Akta Lahir.</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-main shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Usia maksimal 21 tahun per 1 Juli 2026.</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-main shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Diwajibkan mengikuti Ujian Tes Tertulis.</li>
                  </ul>
                </div>
                <div>
                  <h5
                    class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Jadwal & Informasi Penting</h5>
                  <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Masa Pendaftaran Online:</p>
                    <p class="text-sm font-bold text-gray-900 mb-4">1 - 30 April 2026</p>

                    <p class="text-xs text-gray-500 mb-1">Jadwal Ujian & Status Daftar Ulang:</p>
                    <p class="text-sm font-bold text-main mb-3">Diumumkan via Akun Peserta</p>

                    <p class="text-xs text-gray-400">Pastikan sering memantau <span
                        class="font-bold text-gray-600">Dashboard Akun</span> Anda untuk melihat pengumuman kelulusan.
                    </p>
                  </div>
                </div>
              </div>
              <a href="/register?jalur=reguler"
                class="w-full text-center bg-gray-900 border-2 border-gray-900 text-white hover:bg-main hover:border-main transition-all duration-300 py-4 rounded-xl font-bold shadow-lg">Daftar
                Jalur Reguler</a>
            </div>
          </div>

          <!-- PRESTASI TAB -->
          <div id="tab-content-prestasi" class="tab-content flex flex-col hidden">
            <div class="h-48 md:h-64 w-full bg-gray-200 relative overflow-hidden">
              <img src="/poster-ppdb.jpeg" alt="Poster PPDB Prestasi"
                class="absolute inset-0 w-full h-full object-cover">
              <div class="absolute inset-0 bg-main/40 mix-blend-multiply"></div>
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
              <div class="absolute bottom-6 left-6 md:left-10 text-white">
                <div class="uppercase text-xs font-bold bg-secondary text-main px-2 py-1 inline-block rounded mb-2">
                  Jalur Favorit</div>
                <h4 class="font-extrabold text-3xl mb-1 drop-shadow-md">Jalur Prestasi</h4>
                <p class="text-gray-200 font-medium">Akademik dan Non-Akademik Tingkat Kabupaten/Provinsi.</p>
              </div>
            </div>
            <div class="p-6 md:p-10 flex flex-col">
              <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                  <h5
                    class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Persyaratan Khusus</h5>
                  <ul class="text-sm text-gray-700 space-y-3 font-medium">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-secondary shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Memiliki nilai rata-rata Raport Minimal 85.</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-secondary shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Wajib melampirkan Sertifikat/Piagam Kejuaraan (Minimal Juara 3 Kabupaten).</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-secondary shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Wajib Kartu Keluarga (KK) & Akta Lahir.</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-secondary shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Seleksi via Portofolio (Bebas Tes Tulis).</li>
                  </ul>
                </div>
                <div>
                  <h5
                    class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Jadwal & Informasi Penting</h5>
                  <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Masa Pendaftaran Online:</p>
                    <p class="text-sm font-bold text-gray-900 mb-4">1 - 31 Maret 2026</p>

                    <p class="text-xs text-gray-500 mb-1">Cek Lulus & Info Wawancara:</p>
                    <p class="text-sm font-bold text-main mb-3">Diumumkan via Akun Peserta</p>

                    <p class="text-xs text-gray-400">Pendaftar jalur ini dimohon rajin mengecek <span
                        class="font-bold text-gray-600">Dashboard</span>, karena jadwal wawancara dapat berubah
                      sewaktu-waktu.</p>
                  </div>
                </div>
              </div>
              <a href="/register?jalur=prestasi"
                class="w-full text-center bg-secondary text-main hover:bg-[#e0b605] py-4 rounded-xl font-bold shadow-lg transition-all duration-300">Daftar
                Jalur Prestasi</a>
            </div>
          </div>

          <!-- AFIRMASI TAB -->
          <div id="tab-content-afirmasi" class="tab-content flex flex-col hidden">
            <div class="h-48 md:h-64 w-full bg-gray-200 relative overflow-hidden">
              <img src="/poster-ppdb.jpeg" alt="Poster PPDB Afirmasi"
                class="absolute inset-0 w-full h-full object-cover">
              <div class="absolute inset-0 bg-blue-900/30 mix-blend-multiply"></div>
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
              <div class="absolute bottom-6 left-6 md:left-10 text-white">
                <h4 class="font-extrabold text-3xl mb-1 drop-shadow-md">Jalur Afirmasi</h4>
                <p class="text-gray-200 font-medium">Diperuntukkan bagi peserta dari keluarga ekonomi tidak mampu.</p>
              </div>
            </div>
            <div class="p-6 md:p-10 flex flex-col">
              <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                  <h5
                    class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Persyaratan Tambahan</h5>
                  <ul class="text-sm text-gray-700 space-y-3 font-medium">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Wajib KK & Akta Lahir.</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Mengunggah Surat Keterangan Tidak Mampu (SKTM) Asli.</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Mengunggah Kartu KIP / PKH (Bila Ada).</li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg> Bersedia menerima survey langsung oleh panitia ke lokasi domisili.</li>
                  </ul>
                </div>
                <div>
                  <h5
                    class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Jadwal & Informasi Penting</h5>
                  <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Masa Pendaftaran Online:</p>
                    <p class="text-sm font-bold text-gray-900 mb-4">1 - 31 Maret 2026</p>

                    <p class="text-xs text-gray-500 mb-1">Proses Survey & Status:</p>
                    <p class="text-sm font-bold text-main mb-3">Diumumkan via Akun Peserta</p>

                    <p class="text-xs text-gray-400">Notifikasi detail mengenai jadwal survey faktual akan dikirim ke
                      <span class="font-bold text-gray-600">Dashboard Akun</span>.
                    </p>
                  </div>
                </div>
              </div>
              <a href="/register?jalur=afirmasi"
                class="w-full text-center bg-blue-600 border-2 border-blue-600 text-white hover:bg-blue-700 transition py-4 rounded-xl font-bold shadow-lg">Daftar
                Jalur Afirmasi</a>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-24 bg-white border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan Umum (FAQ)</h2>
        <div class="w-16 h-1 bg-secondary mx-auto rounded"></div>
      </div>

      <div class="space-y-4">
        <!-- FAQ Item -->
        <div class="border border-gray-100 rounded-xl p-6 bg-gray-50">
          <h4 class="font-bold text-gray-900 mb-2">Apakah saya bisa memilih lebih dari 1 jalur?</h4>
          <p class="text-gray-600 text-sm">Tidak, setiap peserta hanya diperbolehkan memilih 1 (satu) jalur pendaftaran.
            Pastikan Anda memilih jalur yang paling sesuai dengan kondisi Anda.</p>
        </div>
        <div class="border border-gray-100 rounded-xl p-6 bg-gray-50">
          <h4 class="font-bold text-gray-900 mb-2">Bagaimana jika salah input data raport?</h4>
          <p class="text-gray-600 text-sm">Anda masih dapat mengubah data selama status Anda belum 'Diverifikasi' oleh
            Panitia. Jika sudah diverifikasi, harap hubungi Kontak Panitia.</p>
        </div>
        <div class="border border-gray-100 rounded-xl p-6 bg-gray-50">
          <h4 class="font-bold text-gray-900 mb-2">Kapan ujian atau tes wawancara dilaksanakan?</h4>
          <p class="text-gray-600 text-sm">Jadwal akan muncul di Dashboard Anda masing-masing setelah berkas & biodata
            Anda disetujui (diverifikasi) oleh panitia.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Kontak Section -->
  <section id="kontak" class="py-24 bg-main text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl font-bold mb-4">Butuh Bantuan? Hubungi Panitia</h2>
      <p class="text-white/80 mb-12 max-w-xl mx-auto">Jika Anda mengalami kendala saat proses pendaftaran, silakan
        hubungi salah satu kontak resmi panitia PPDB kami.</p>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto">
        <!-- Panitia 1 -->
        <a href="https://wa.me/6281111111111" target="_blank"
          class="flex items-center gap-4 bg-white/10 hover:bg-white/20 border border-white/10 p-5 rounded-xl transition duration-300 transform hover:-translate-y-1">
          <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center shrink-0 shadow-lg">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
          </div>
          <div class="text-left">
            <h3 class="font-bold text-secondary text-lg leading-tight">Panitia 1</h3>
            <p class="text-white/60 text-xs mt-1">Admin Info Jalur</p>
          </div>
        </a>

        <!-- Panitia 2 -->
        <a href="https://wa.me/6282222222222" target="_blank"
          class="flex items-center gap-4 bg-white/10 hover:bg-white/20 border border-white/10 p-5 rounded-xl transition duration-300 transform hover:-translate-y-1">
          <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center shrink-0 shadow-lg">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
          </div>
          <div class="text-left">
            <h3 class="font-bold text-secondary text-lg leading-tight">Panitia 2</h3>
            <p class="text-white/60 text-xs mt-1">Admin Berkas/Syarat</p>
          </div>
        </a>

        <!-- Panitia 3 -->
        <a href="https://wa.me/6283333333333" target="_blank"
          class="flex items-center gap-4 bg-white/10 hover:bg-white/20 border border-white/10 p-5 rounded-xl transition duration-300 transform hover:-translate-y-1">
          <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center shrink-0 shadow-lg">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
          </div>
          <div class="text-left">
            <h3 class="font-bold text-secondary text-lg leading-tight">Panitia 3</h3>
            <p class="text-white/60 text-xs mt-1">Admin Raport & Tes</p>
          </div>
        </a>

        <!-- Panitia 4 -->
        <a href="https://wa.me/6284444444444" target="_blank"
          class="flex items-center gap-4 bg-white/10 hover:bg-white/20 border border-white/10 p-5 rounded-xl transition duration-300 transform hover:-translate-y-1">
          <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center shrink-0 shadow-lg">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
          </div>
          <div class="text-left">
            <h3 class="font-bold text-secondary text-lg leading-tight">Panitia 4</h3>
            <p class="text-white/60 text-xs mt-1">Admin Umum & Teknis</p>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 border-t border-gray-800 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">
        <!-- Brand Info -->
        <div>
          <div class="flex items-center gap-2 mb-6">
            <img src="/logo.png" alt="Logo MAN 1 BOGOR" class="h-10 w-auto object-contain drop-shadow-sm">
            <span class="font-bold text-xl tracking-tight text-white">PPDB <span class="text-secondary">MAN 1
                BOGOR</span></span>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed">
            Portal Layanan PPDB Terpadu MAN 1 BOGOR: Mengedepankan transparansi, akuntabilitas, dan kemudahan akses
            menuju pendidikan berkualitas.
          </p>
        </div>

        <!-- Address -->
        <div>
          <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Alamat Kampus</h4>
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-secondary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <div>
              <p class="text-gray-400 text-sm leading-relaxed mb-2">
                Jl. Lingkungan Kayu Manis No. 30, Desa Cirimekar, Kecamatan Cibinong, Kabupaten Bogor. Kode Pos 16917
              </p>
            </div>
          </div>
        </div>

        <!-- Contact & Email -->
        <div>
          <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Hubungi Kami</h4>
          <div class="space-y-4">
            <a href="mailto:info@man1bogor.sch.id"
              class="flex items-center gap-3 text-gray-400 text-sm hover:text-white transition">
              <svg class="w-5 h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
              </svg>
              <span>info@man1bogor.sch.id</span>
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-400 text-sm hover:text-white transition">
              <svg class="w-5 h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                </path>
              </svg>
              <span>(021) 876-0000</span>
            </a>
          </div>
        </div>
      </div>

      <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-800">
        <p class="text-sm text-gray-500">
          &copy; 2026 PPDB MAN 1 BOGOR System. All rights reserved.
        </p>
      </div>
    </div>
  </footer>

</body>

</html>