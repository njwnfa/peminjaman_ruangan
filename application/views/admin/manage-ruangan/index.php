<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php $this->load->view('layouts/sidebar'); ?>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <!-- Topbar -->
    <?php $this->load->view('layouts/topbar'); ?>

    <main class="p-6">
      <div class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-2xl font-bold"><?= $title; ?></h1>
          <button onclick="openModal()" 
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
            <i class="fas fa-plus"></i> Tambah Ruangan
          </button>
        </div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="p-3 mb-4 bg-green-100 text-green-700 rounded-lg">
            <?= $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="p-3 mb-4 bg-red-100 text-red-700 rounded-lg">
            <?= $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 border text-center">#</th>
                <th class="px-4 py-2 border">Nama Ruangan</th>
                <th class="px-4 py-2 border">Kapasitas</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border text-center">Gambar</th>
                <th class="px-4 py-2 border text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($ruangan)): ?>
                <?php $no=1; foreach($ruangan as $r): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center"><?= $no++; ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($r->nama_ruangan); ?></td>
                    <td class="px-4 py-2 border text-center"><?= $r->kapasitas; ?></td>
                    <td class="px-4 py-2 border text-center">
                      <?php if ($r->status == 'tersedia'): ?>
                        <span class="px-2 py-1 text-sm rounded bg-green-200 text-green-800">Tersedia</span>
                      <?php else: ?>
                        <span class="px-2 py-1 text-sm rounded bg-red-200 text-red-800">Dipinjam</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 border text-center">
                      <?php if ($r->gambar): ?>
                        <img src="<?= base_url('uploads/ruangan/'.$r->gambar); ?>" 
                             alt="gambar" class="w-16 h-16 object-cover rounded">
                      <?php else: ?>
                        <span class="text-gray-400 italic">Tidak ada</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 border text-center space-x-2">
                      <button onclick="editModal(<?= $r->id_ruangan; ?>, '<?= $r->nama_ruangan; ?>', <?= $r->kapasitas; ?>, '<?= $r->status; ?>')" 
                              class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        <i class="fas fa-edit"></i>
                      </button>

                      <a href="<?= base_url('admin/ruangan/delete/'.$r->id_ruangan); ?>" 
                        onclick="return confirm('Yakin ingin menghapus ruangan ini?')" 
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>

                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data ruangan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modal Tambah/Edit -->
<div id="ruanganModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
    <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Ruangan</h2>
    <form id="ruanganForm" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/ruangan/add'); ?>">
      <input type="hidden" name="id" id="ruanganId">

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ruangan</label>
        <input type="text" name="nama_ruangan" id="nama_ruangan" class="w-full border rounded-lg px-3 py-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
        <input type="number" name="kapasitas" id="kapasitas" class="w-full border rounded-lg px-3 py-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" id="status" class="w-full border rounded-lg px-3 py-2">
          <option value="tersedia">Tersedia</option>
          <option value="dipinjam">Dipinjam</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
        <input type="file" name="gambar" id="gambar" class="w-full border rounded-lg px-3 py-2">
      </div>

      <div class="flex justify-end mt-4 space-x-2">
        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('ruanganModal').classList.remove('hidden');
    document.getElementById('ruanganForm').action = '<?= base_url("admin/ruangan/add"); ?>';
    document.getElementById('modalTitle').innerText = 'Tambah Ruangan';
    document.getElementById('ruanganId').value = '';
    document.getElementById('nama_ruangan').value = '';
    document.getElementById('kapasitas').value = '';
    document.getElementById('status').value = 'tersedia';
  }

  function editModal(id, nama, kapasitas, status) {
    document.getElementById('ruanganModal').classList.remove('hidden');
    document.getElementById('ruanganForm').action = '<?= base_url("admin/ruangan/update/"); ?>' + id;
    document.getElementById('modalTitle').innerText = 'Edit Ruangan';
    document.getElementById('ruanganId').value = id;
    document.getElementById('nama_ruangan').value = nama;
    document.getElementById('kapasitas').value = kapasitas;
    document.getElementById('status').value = status;
  }

  function closeModal() {
    document.getElementById('ruanganModal').classList.add('hidden');
  }
</script>

</body>
</html>
