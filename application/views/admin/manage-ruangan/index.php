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
          <button onclick="openModal('modalAdd')" 
             class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
            <i class="fas fa-plus"></i> Tambah Ruangan
          </button>
        </div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="p-3 mb-4 bg-green-100 text-green-700 rounded-lg">
            <?= $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Nama Ruangan</th>
                <th class="px-4 py-2 border">Kapasitas</th>
                <th class="px-4 py-2 border">Fasilitas</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach($list_ruangan as $r): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2 border text-center"><?= $no++; ?></td>
                  <td class="px-4 py-2 border"><?= $r->nama_ruangan; ?></td>
                  <td class="px-4 py-2 border text-center"><?= $r->kapasitas; ?></td>
                  <td class="px-4 py-2 border"><?= $r->fasilitas; ?></td>
                  <td class="px-4 py-2 border text-center">
                    <span class="px-2 py-1 rounded text-white <?= $r->status == 'tersedia' ? 'bg-green-500' : 'bg-red-500'; ?>">
                      <?= ucfirst($r->status); ?>
                    </span>
                  </td>
                  <td class="px-4 py-2 border text-center space-x-2">
                    <button onclick='openEdit(<?= json_encode($r); ?>)' 
                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                      <i class="fas fa-edit"></i>
                    </button>
                    <a href="<?= base_url('ruangan/hapus/'.$r->id); ?>" 
                       onclick="return confirm('Yakin ingin menghapus ruangan ini?');"
                       class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modal Tambah -->
<div id="modalAdd" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white p-6 rounded-xl shadow-lg w-1/3">
    <h2 class="text-xl font-bold mb-4">Tambah Ruangan</h2>
    <form action="<?= base_url('ruangan/store'); ?>" method="post">
      <div class="mb-3">
        <label>Nama Ruangan</label>
        <input type="text" name="nama_ruangan" class="w-full border rounded p-2" required>
      </div>
      <div class="mb-3">
        <label>Kapasitas</label>
        <input type="number" name="kapasitas" class="w-full border rounded p-2" required>
      </div>
      <div class="mb-3">
        <label>Fasilitas</label>
        <textarea name="fasilitas" class="w-full border rounded p-2"></textarea>
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="status" class="w-full border rounded p-2">
          <option value="tersedia">Tersedia</option>
          <option value="tidak tersedia">Tidak Tersedia</option>
        </select>
      </div>
      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closeModal('modalAdd')" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white p-6 rounded-xl shadow-lg w-1/3">
    <h2 class="text-xl font-bold mb-4">Edit Ruangan</h2>
    <form id="formEdit" method="post">
      <input type="hidden" name="id" id="edit_id">
      <div class="mb-3">
        <label>Nama Ruangan</label>
        <input type="text" name="nama_ruangan" id="edit_nama" class="w-full border rounded p-2" required>
      </div>
      <div class="mb-3">
        <label>Kapasitas</label>
        <input type="number" name="kapasitas" id="edit_kapasitas" class="w-full border rounded p-2" required>
      </div>
      <div class="mb-3">
        <label>Fasilitas</label>
        <textarea name="fasilitas" id="edit_fasilitas" class="w-full border rounded p-2"></textarea>
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="status" id="edit_status" class="w-full border rounded p-2">
          <option value="tersedia">Tersedia</option>
          <option value="tidak tersedia">Tidak Tersedia</option>
        </select>
      </div>
      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id){
  document.getElementById(id).classList.remove('hidden');
  document.getElementById(id).classList.add('flex');
}
function closeModal(id){
  document.getElementById(id).classList.add('hidden');
  document.getElementById(id).classList.remove('flex');
}
function openEdit(data){
  openModal('modalEdit');
  document.getElementById('edit_id').value = data.id;
  document.getElementById('edit_nama').value = data.nama_ruangan;
  document.getElementById('edit_kapasitas').value = data.kapasitas;
  document.getElementById('edit_fasilitas').value = data.fasilitas;
  document.getElementById('edit_status').value = data.status;
  document.getElementById('formEdit').action = "<?= base_url('ruangan/update/'); ?>" + data.id;
}
</script>

</body>
</html>
