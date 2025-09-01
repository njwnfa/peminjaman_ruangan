  <!-- Konten -->
  <div class="max-w-7xl mx-auto px-6 py-12">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center">Daftar Ruangan</h2>

    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-2xl shadow-lg">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-sm">
            <th class="px-6 py-4">#</th>
            <th class="px-6 py-4">Nama Ruangan</th>
            <th class="px-6 py-4">Kapasitas</th>
            <th class="px-6 py-4">Fasilitas</th>
            <th class="px-6 py-4">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-gray-600 dark:text-gray-300 text-sm">
          <?php if (!empty($ruangan)): ?>
            <?php $no=1; foreach($ruangan as $r): ?>
              <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="px-6 py-4"><?= $no++; ?></td>
                <td class="px-6 py-4 font-semibold"><?= $r->nama_ruangan; ?></td>
                <td class="px-6 py-4"><?= $r->kapasitas; ?> orang</td>
                <td class="px-6 py-4"><?= $r->fasilitas; ?></td>
                <td class="px-6 py-4">
                  <a href="<?= base_url('ruangan/ajukan/'.$r->id); ?>" 
                     class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow">
                     Ajukan
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                Tidak ada data ruangan.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function toggleTheme() {
      const root = document.documentElement;
      const isDark = root.classList.toggle('dark');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    function toggleDropdown() {
      document.getElementById("userDropdown").classList.toggle("hidden");
    }

    window.addEventListener("click", function(e) {
      const dropdown = document.getElementById("userDropdown");
      const button = document.querySelector("button[onclick='toggleDropdown()']");
      if (dropdown && button && !button.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add("hidden");
      }
    });
  </script>
</body>
</html>
