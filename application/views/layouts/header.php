<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title><?= isset($title) ? $title : 'Peminjaman Lab'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="<?= base_url('assets/images/pilates.png'); ?>" type="image/png">

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
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-950 dark:text-gray-100 overflow-x-hidden">

  <!-- Navbar -->
  <nav class="bg-white dark:bg-gray-900 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-indigo-600">Pilates</h1>

      <div class="hidden md:flex items-center space-x-6 font-medium">
        <a href="<?= base_url('#fitur') ?>" class="hover:text-indigo-600 transition">Fitur</a>
        <a href="<?= base_url('#cara-kerja') ?>" class="hover:text-indigo-600 transition">Cara Kerja</a>
        <a href="<?= base_url('#testimoni') ?>" class="hover:text-indigo-600 transition">Testimoni</a>
        <a href="<?= base_url('#faq') ?>" class="hover:text-indigo-600 transition">FAQ</a>
        <a href="<?= base_url('#kontak') ?>" class="hover:text-indigo-600 transition">Kontak</a>

        <?php if($this->session->userdata('logged_in')): ?>
          <!-- Menu tambahan hanya muncul kalau sudah login -->
          <a href="<?= base_url('ruangan') ?>" class="hover:text-indigo-600 transition">Daftar Ruangan</a>
          <a href="<?= base_url('ruangan/status') ?>" class="hover:text-indigo-600 transition">Status Pengajuan</a>
        <?php endif; ?>
      </div>

      <!-- Login / User Dropdown -->
      <div class="flex items-center gap-3 relative">
        <?php if($this->session->userdata('logged_in')): ?>
          <!-- Dropdown User -->
          <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
              <i data-lucide="user" class="w-6 h-6"></i>
            </button>
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2">
              <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <p class="font-semibold text-gray-800 dark:text-gray-200">
                  <?= $this->session->userdata('nama'); ?>
                </p>
              </div>
              <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
            </div>
          </div>
        <?php else: ?>
          <!-- Tombol login kalau belum login -->
          <a href="<?= base_url('auth/login') ?>" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Login</a>
        <?php endif; ?>

        <!-- Toggle Dark Mode -->
        <button id="themeToggle" onclick="toggleTheme()" class="inline-flex items-center justify-center px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
          <i data-lucide="moon" class="h-5 w-5 block dark:hidden"></i>
          <i data-lucide="sun" class="h-5 w-5 hidden dark:block"></i>
        </button>
      </div>
    </div>
  </nav>

  <script>
    // Toggle dropdown user
    function toggleDropdown() {
      const dropdown = document.getElementById('userDropdown');
      dropdown.classList.toggle('hidden');
    }

    // Tutup dropdown saat klik di luar
    window.addEventListener('click', function(e) {
      const dropdown = document.getElementById('userDropdown');
      const button = e.target.closest('button[onclick="toggleDropdown()"]');
      if (!button && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });

    // Toggle dark mode
    function toggleTheme() {
      const html = document.documentElement;
      const isDark = html.classList.toggle('dark');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
      lucide.createIcons(); // redraw icon karena sun/moon berubah
    }

    // Inisialisasi icon saat halaman load
    lucide.createIcons();
  </script>

</body>