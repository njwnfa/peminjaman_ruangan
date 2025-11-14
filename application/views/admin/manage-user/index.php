<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
          <button id="openAddModal" 
             class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fas fa-plus"></i> Tambah User
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

        <div class="flex justify-between mb-3">
          <input id="searchInput"
                type="text"
                placeholder="Cari user..."
                class="px-4 py-2 border rounded-lg w-1/3 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" />
        </div>


        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Dibuat</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php $no=1; foreach($users as $u): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center"><?= $no++; ?></td>
                    <td class="px-4 py-2 border"><?= $u->nama; ?></td>
                    <td class="px-4 py-2 border"><?= $u->email; ?></td>
                    <td class="px-4 py-2 border text-center">
                      <form action="<?= base_url('user/update_role/'.$u->id); ?>" method="post">
                        <select name="role" onchange="this.form.submit()" class="border rounded p-1 text-sm">
                          <option value="admin" <?= $u->role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                          <option value="user" <?= $u->role == 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                      </form>
                    </td>
                    <td class="px-4 py-2 border text-center">
                      <?= date('d M Y H:i', strtotime($u->created_at)); ?>
                    </td>
                    <td class="px-4 py-2 border text-center space-x-2">
                      <button onclick="confirmDelete(<?= $u->id; ?>)" 
                         class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                    Belum ada data user.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <div class="flex justify-between items-center mt-5">
            <span class="text-sm text-gray-600" id="infoText">Menampilkan 10 data per halaman</span>
            <div id="pagination" class="flex space-x-2"></div>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modal Tambah User -->
<div id="addUserModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
  <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
      <i class="fas fa-user-plus mr-2 text-blue-600"></i> Tambah Pengguna Baru
    </h2>
    <form action="<?= base_url('user/add'); ?>" method="post">
      <div class="mb-3">
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="nama" class="w-full border p-2 rounded" required>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>
      </div>
      <div class="mb-3">
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" class="w-full border p-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Role</label>
        <select name="role" class="w-full border p-2 rounded">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="flex justify-end space-x-2">
        <button type="button" id="closeAddModal" 
                class="px-4 py-2 border rounded hover:bg-gray-100">
          Batal
        </button>
        <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // === Modal Logic ===
  $('#openAddModal').on('click', function() {
    $('#addUserModal').removeClass('hidden');
  });
  $('#closeAddModal').on('click', function() {
    $('#addUserModal').addClass('hidden');
  });

  // === Konfirmasi Hapus ===
  function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus user ini?')) {
      window.location.href = '<?= base_url('user/delete/'); ?>' + id;
    }
  }

  const rows = document.querySelectorAll("tbody tr");
  const rowsPerPage = 10;
  let currentPage = 1;

  function displayRows() {
    const search = document.getElementById("searchInput").value.toLowerCase();
    let filtered = [];

    rows.forEach(row => {
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(search) ? "" : "none";
      if (text.includes(search)) filtered.push(row);
    });

    const totalPages = Math.ceil(filtered.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    filtered.forEach((row, index) => {
      row.style.display = (index >= start && index < end) ? "" : "none";
    });

    updateInfo(filtered.length);
    generatePagination(totalPages);
  }

  function updateInfo(totalFiltered) {
    const info = document.getElementById("infoText");
    info.innerText = `Menampilkan ${rowsPerPage} data per halaman (hasil: ${totalFiltered})`;
  }

  function generatePagination(total) {
    const container = document.getElementById("pagination");
    container.innerHTML = "";

    for (let i = 1; i <= total; i++) {
      const btn = document.createElement("button");
      btn.innerText = i;
      btn.className =
        "px-3 py-1 rounded-lg border shadow-sm transition " +
        (i === currentPage
          ? "bg-blue-600 text-white border-blue-700 shadow-md"
          : "bg-white hover:bg-gray-100 text-gray-700");

      btn.onclick = () => {
        currentPage = i;
        displayRows();
      };

      container.appendChild(btn);
    }
  }

  document.getElementById("searchInput").addEventListener("keyup", () => {
    currentPage = 1;
    displayRows();
  });

  displayRows();
</script>

</body>
</html>
