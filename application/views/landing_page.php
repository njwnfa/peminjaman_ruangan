<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Peminjaman Ruangan Lab Kampus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    window.tailwind = window.tailwind || {};
    window.tailwind.config = { darkMode: 'class' };

    (function () {
      const saved = localStorage.getItem('theme');
      const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const shouldDark = saved ? saved === 'dark' : systemDark;
      if (shouldDark) document.documentElement.classList.add('dark');
    })();
  </script>
  <script>
    function toggleTheme() {
      const root = document.documentElement;
      const isDark = root.classList.toggle('dark');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
      const btn = document.getElementById('themeToggle');
      if (btn) btn.setAttribute('aria-pressed', String(isDark));
    }
  </script>

  <!-- Lucide Icons CDN -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-gray-950 dark:text-gray-100">

  <!-- Navbar -->
  <nav class="bg-white dark:bg-gray-900 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-indigo-600">Pilates</h1>

      <div class="hidden md:flex items-center space-x-4 font-medium">
        <a href="#fitur" class="hover:text-indigo-600 transition">Fitur</a>
        <a href="#cara-kerja" class="hover:text-indigo-600 transition">Cara Kerja</a>
        <a href="#kontak" class="hover:text-indigo-600 transition">Kontak</a>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= base_url('auth/login') ?>"
           class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Login</a>

        <!-- Toggle Dark Mode -->
        <button id="themeToggle"
                class="inline-flex items-center justify-center px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                onclick="toggleTheme()" aria-label="Toggle tema" aria-pressed="false">
          <!-- Moon (light mode) -->
          <svg class="h-5 w-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
          </svg>
          <!-- Sun (dark mode) -->
          <svg class="h-5 w-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M12 3v2m0 14v2m9-9h-2M5 12H3m14.95 6.95l-1.41-1.41M7.46 7.46L6.05 6.05m12.9 0l-1.41 1.41M7.46 16.54l-1.41 1.41"/>
            <circle cx="12" cy="12" r="4" stroke-width="1.5" />
          </svg>
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="max-w-7xl mx-auto px-6 py-16 md:py-24 grid md:grid-cols-2 gap-12 items-center">
    <div class="text-center md:text-left">
      <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-gray-900 dark:text-gray-100">
        Peminjaman <span class="text-indigo-600">Ruangan Lab</span> Kampus Jadi Lebih Mudah
      </h2>
      <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
        Sistem terpadu untuk mahasiswa & dosen dalam mengelola peminjaman laboratorium kampus secara online.
      </p>

      <!-- Form Pencarian -->
      <!-- <form class="mt-8 bg-white dark:bg-gray-900 shadow-md rounded-xl p-4 md:flex md:space-x-4 space-y-4 md:space-y-0">
        <input type="date" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
        <input type="time" class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
        <select class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
          <option class="bg-white dark:bg-gray-900">Pilih Ruangan</option>
          <option class="bg-white dark:bg-gray-900">Lab Komputer</option>
          <option class="bg-white dark:bg-gray-900">Lab Kimia</option>
          <option class="bg-white dark:bg-gray-900">Lab Elektro</option>
        </select>
        <button type="submit" class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Cari</button>
      </form> -->
    </div>

    <div>
      <img src="https://images.unsplash.com/photo-1576669801838-1b1c52121e6a?q=80&w=1053&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Laboratorium Kampus" class="rounded-2xl shadow-lg w-full">
    </div>
  </section>

  <!-- Fitur -->
  <section id="fitur" class="bg-white dark:bg-gray-900 py-16">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-3xl font-bold text-center mb-12">Fitur Sistem</h3>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-6 shadow-lg rounded-xl bg-gray-50 dark:bg-gray-800 text-center hover:-translate-y-2 hover:shadow-xl transition">
          <img src="https://images.unsplash.com/photo-1530099486328-e021101a494a?q=80&w=1247&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Mudah" class="mx-auto mb-4 rounded-lg">
          <h4 class="font-semibold text-xl mb-3 text-indigo-600">Mudah Diakses</h4>
          <p>Mahasiswa & dosen dapat mengajukan peminjaman kapan saja secara online.</p>
        </div>
        <div class="p-6 shadow-lg rounded-xl bg-gray-50 dark:bg-gray-800 text-center hover:-translate-y-2 hover:shadow-xl transition">
          <img src="https://plus.unsplash.com/premium_photo-1705178702953-a3048924f209?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Jadwal" class="mx-auto mb-4 rounded-lg">
          <h4 class="font-semibold text-xl mb-3 text-indigo-600">Jadwal Transparan</h4>
          <p>Semua jadwal penggunaan lab dapat dipantau secara real-time.</p>
        </div>
        <div class="p-6 shadow-lg rounded-xl bg-gray-50 dark:bg-gray-800 text-center hover:-translate-y-2 hover:shadow-xl transition">
          <img src="https://images.unsplash.com/photo-1519406596751-0a3ccc4937fe?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Efisien" class="mx-auto mb-4 rounded-lg">
          <h4 class="font-semibold text-xl mb-3 text-indigo-600">Efisien</h4>
          <p>Proses peminjaman lebih cepat, tanpa ribet mengurus dokumen manual.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Cara Kerja -->
  <section id="cara-kerja" class="py-16 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-5xl mx-auto px-6 text-center">
      <h3 class="text-3xl font-bold mb-12">Alur Peminjaman</h3>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 hover:shadow-xl transition flex flex-col items-center">
          <i data-lucide="search" class="w-12 h-12 text-indigo-600 mb-4"></i>
          <h4 class="text-xl font-semibold text-indigo-600">1. Cari Ruangan</h4>
          <p class="mt-2">Pilih ruangan lab yang tersedia sesuai kebutuhan.</p>
        </div>
        <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 hover:shadow-xl transition flex flex-col items-center">
          <i data-lucide="clipboard-list" class="w-12 h-12 text-indigo-600 mb-4"></i>
          <h4 class="text-xl font-semibold text-indigo-600">2. Ajukan</h4>
          <p class="mt-2">Ajukan peminjaman melalui sistem dengan form online.</p>
        </div>
        <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 hover:shadow-xl transition flex flex-col items-center">
          <i data-lucide="check-circle" class="w-12 h-12 text-indigo-600 mb-4"></i>
          <h4 class="text-xl font-semibold text-indigo-600">3. Konfirmasi</h4>
          <p class="mt-2">Tunggu persetujuan admin/dosen penanggung jawab.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-center">
    <h3 class="text-3xl md:text-4xl font-bold">Butuh Ruangan Lab?</h3>
    <p class="mt-4">Ajukan peminjaman sekarang secara cepat & praktis</p>
    <a href="#" class="mt-6 inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition">Ajukan Sekarang</a>
  </section>

  <!-- Footer -->
  <footer id="kontak" class="bg-gray-900 dark:bg-black text-gray-300 dark:text-gray-400 py-10">
    <div class="max-w-7xl mx-auto px-6 text-center space-y-3">
      <p class="text-lg font-semibold">Pilates</p>
      <p>Email: pilates@gmail.com | Telp: (021) 123-456</p>
      <p class="text-sm">&copy; <?= date('Y') ?> Pilates. Semua Hak Dilindungi.</p>
    </div>
  </footer>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
