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
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Nama Lengkap</th>
                <th class="px-4 py-2 border">NIM</th>
                <th class="px-4 py-2 border">Prodi</th>
                <th class="px-4 py-2 border">Dosen</th>
                <th class="px-4 py-2 border">Ruangan</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($peminjaman)): ?>
                <?php $no=1; foreach($peminjaman as $p): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center"><?= $no++; ?></td>
                    <td class="px-4 py-2 border"><?= $p->nama_lengkap; ?></td>
                    <td class="px-4 py-2 border"><?= $p->nim; ?></td>
                    <td class="px-4 py-2 border"><?= $p->prodi; ?></td>
                    <td class="px-4 py-2 border"><?= $p->nama_dosen; ?></td>
                    <td class="px-4 py-2 border font-semibold"><?= $p->nama_ruangan; ?></td>
                    <td class="px-4 py-2 border">
                      <?= $p->tanggal_mulai; ?> s/d <?= $p->tanggal_selesai; ?>
                    </td>
                    <td class="px-4 py-2 border text-center">
                      <?php if ($p->status == 'pending'): ?>
                        <span class="px-2 py-1 rounded text-white bg-yellow-500">Pending</span>
                      <?php elseif ($p->status == 'disetujui'): ?>
                        <span class="px-2 py-1 rounded text-white bg-green-500">Disetujui</span>
                      <?php else: ?>
                        <span class="px-2 py-1 rounded text-white bg-red-500">Ditolak</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 border text-center space-x-2">
                      <a href="<?= base_url('admin/peminjaman/setujui/'.$p->id); ?>" 
                         class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                        <i class="fas fa-check"></i>
                      </a>
                      <a href="<?= base_url('admin/peminjaman/tolak/'.$p->id); ?>" 
                         class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                        <i class="fas fa-times"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="px-6 py-6 text-center text-gray-500">
                    Belum ada pengajuan peminjaman.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

</body>
</html>
