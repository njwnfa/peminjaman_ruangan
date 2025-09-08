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
                <button 
                  onclick="openModal(<?= $r->id ?>, '<?= $r->nama_ruangan ?>')" 
                  class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow">
                  Ajukan
                </button>
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

<!-- Modal -->
<div id="modalPeminjaman" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg w-full max-w-lg">
    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Form Peminjaman</h2>
    
    <form action="<?= base_url('ruangan/store_peminjaman'); ?>" 
        method="POST" 
        class="space-y-4" 
        onsubmit="return validateTanggal()">
    <input type="hidden" name="ruangan_id" id="ruangan_id">

    <div>
      <label class="block text-gray-700 dark:text-gray-300">Ruangan</label>
      <input type="text" id="nama_ruangan" class="w-full p-2 border rounded-lg bg-gray-100 dark:bg-gray-800" readonly>
    </div>

    <div>
      <label class="block text-gray-700 dark:text-gray-300">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" class="w-full p-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block text-gray-700 dark:text-gray-300">NIM</label>
      <input type="text" name="nim" class="w-full p-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block text-gray-700 dark:text-gray-300">Prodi</label>
      <input type="text" name="prodi" class="w-full p-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block text-gray-700 dark:text-gray-300">Nama Dosen</label>
      <input type="text" name="nama_dosen" class="w-full p-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
      <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full p-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
      <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full p-2 border rounded-lg" required>
    </div>

    <div class="flex justify-end space-x-2">
      <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</button>
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Ajukan</button>
    </div>
  </form>

  </div>
</div>

<script>
  function openModal(id, nama) {
    document.getElementById('ruangan_id').value = id;
    document.getElementById('nama_ruangan').value = nama;
    document.getElementById('modalPeminjaman').classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('modalPeminjaman').classList.add('hidden');
  }

  // Tutup modal kalau klik background
  document.getElementById('modalPeminjaman').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });

  // Validasi tanggal mulai & selesai
  function validateTanggal() {
    const mulai = document.getElementById("tanggal_mulai").value;
    const selesai = document.getElementById("tanggal_selesai").value;

    if (mulai && selesai && selesai < mulai) {
      alert("⚠️ Tanggal selesai tidak boleh lebih kecil dari tanggal mulai!");
      return false; // cegah submit
    }
    return true;
  }
</script>

