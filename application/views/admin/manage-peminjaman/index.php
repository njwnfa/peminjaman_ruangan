<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/customParseFormat.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/id.js"></script>
  <script>
    dayjs.extend(dayjs.plugin.customParseFormat);
    dayjs.locale('id');
  </script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
  <?php $this->load->view('layouts/sidebar'); ?>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <!-- Topbar -->
    <?php $this->load->view('layouts/topbar'); ?>

    <main class="p-6">
      <div class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-2xl font-bold"><?= $title; ?></h1>
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
                placeholder="Cari peminjam..." 
                class="px-3 py-2 border rounded-lg w-1/3 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
        </div>

        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-3 border text-center">#</th>
                <th class="px-4 py-3 border text-left">Peminjam</th>
                <th class="px-4 py-3 border text-left">Ruangan</th>
                <th class="px-4 py-3 border text-left">Dosen PJ</th>
                <th class="px-4 py-3 border text-left">Waktu Mulai</th>
                <th class="px-4 py-3 border text-left">Waktu Selesai</th>
                <th class="px-4 py-3 border text-center">Status</th>
                <th class="px-4 py-3 border text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($peminjaman)): ?>
                <?php $no=1; foreach($peminjaman as $p): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center"><?= $no++; ?></td>
                    
                    <td class="px-4 py-2 border"><?= htmlspecialchars($p->nama_peminjam ?? 'User Dihapus'); ?></td>
                    
                    <td class="px-4 py-2 border"><?= htmlspecialchars($p->nama_ruangan ?? 'Ruangan Dihapus'); ?></td>
                    
                    <td class="px-4 py-2 border"><?= htmlspecialchars($p->nama_dosen); ?></td>
                    
                    <td class="px-4 py-2 border text-sm" id="tgl_mulai_<?= $p->id_peminjaman ?>">
                        <?= $p->tanggal_mulai; ?>
                    </td>
                    <td class="px-4 py-2 border text-sm" id="tgl_selesai_<?= $p->id_peminjaman ?>">
                        <?= $p->tanggal_selesai; ?>
                    </td>
                    
                    <td class="px-4 py-2 border text-center">
                      <?php if ($p->status == 'menunggu'): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                      <?php elseif ($p->status == 'disetujui'): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                      <?php elseif ($p->status == 'ditolak'): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                      <?php else: // Selesai ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Selesai</span>
                      <?php endif; ?>
                    </td>
                    
                    <td class="px-4 py-2 border text-center">
                        <?php if ($p->status == 'menunggu'): ?>
                          <div class="flex justify-center space-x-2">
                            <a href="<?= base_url('admin/peminjaman/approve/'.$p->id_peminjaman); ?>" 
                               onclick="return confirm('Yakin ingin MENYETUJUI peminjaman ini?')" 
                               class="px-3 py-1 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">
                               <i class="fas fa-check"></i> Setujui
                            </a>
                            <button onclick="openRejectModal(<?= $p->id_peminjaman; ?>)" 
                               class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                               <i class="fas fa-times"></i> Tolak
                            </button>
                          </div>
                        
                        <?php elseif ($p->status == 'disetujui'): ?>
                          <a href="<?= base_url('admin/peminjaman/finish/'.$p->id_peminjaman); ?>" 
                             onclick="return confirm('Yakin ingin MENYELESAIKAN peminjaman ini? Status ruangan akan dikembalikan.')" 
                             class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">
                             <i class="fas fa-flag-checkered"></i> Selesai
                          </a>
                        
                        <?php else: ?>
                          <span class="text-gray-400 italic text-sm">-</span>
                        <?php endif; ?>
                      </td>

                  </tr>
                  
                  <script>
                    document.getElementById('tgl_mulai_<?= $p->id_peminjaman ?>').innerText = 
                      dayjs('<?= $p->tanggal_mulai ?>', 'YYYY-MM-DD HH:mm:ss').format('dddd, D MMMM YYYY (HH:mm)');
                    document.getElementById('tgl_selesai_<?= $p->id_peminjaman ?>').innerText = 
                      dayjs('<?= $p->tanggal_selesai ?>', 'YYYY-MM-DD HH:mm:ss').format('dddd, D MMMM YYYY (HH:mm)');
                  </script>
                  
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center py-6 text-gray-500">Belum ada data peminjaman.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <div class="flex justify-between items-center mt-5">
            <span id="infoText" class="text-sm text-gray-600">
              Menampilkan 10 data per halaman
            </span>

            <div id="pagination" class="flex space-x-2"></div>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
    <h2 class="text-xl font-bold mb-4">Tolak Peminjaman</h2>
    <form id="rejectForm" method="POST">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      
      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan (Wajib)</label>
        <textarea name="catatan_admin" id="catatan_admin" class="w-full border rounded-lg px-3 py-2" rows="4" required></textarea>
      </div>

      <div class="flex justify-end mt-4 space-x-2">
        <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Tolak Pengajuan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openRejectModal(id) {
    // Set action form dinamis
    document.getElementById('rejectForm').action = '<?= base_url("admin/peminjaman/reject/"); ?>' + id;
    // Reset textarea
    document.getElementById('catatan_admin').value = '';
    // Tampilkan modal
    document.getElementById('rejectModal').classList.remove('hidden');
  }

  function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
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
    info.innerText = `Menampilkan ${rowsPerPage} data per halaman (hasil cocok: ${totalFiltered})`;
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