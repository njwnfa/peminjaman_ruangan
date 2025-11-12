<div class="max-w-6xl mx-auto mt-10 px-4" style="min-height: 100vh;">
  <h2 class="text-3xl font-bold text-indigo-600 mb-6 text-center">Status Pengajuan Ruangan</h2>

  <?php if($this->session->flashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      <?= $this->session->flashdata('success'); ?>
    </div>
  <?php elseif($this->session->flashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <?php if(empty($peminjaman)): ?>
    <div class="text-center text-gray-500 py-10">
      <p>Belum ada pengajuan ruangan yang dilakukan.</p>
      <a href="<?= base_url('ruangan/list_ruangan'); ?>" class="mt-4 inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Ajukan Sekarang</a>
    </div>
  <?php else: ?>
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow-lg">
      <table class="min-w-full border border-gray-200 dark:border-gray-700">
        <thead class="bg-indigo-600 text-white">
          <tr>
            <th class="px-4 py-3 text-left">Nama Ruangan</th>
            <th class="px-4 py-3 text-left">Tanggal</th>
            <th class="px-4 py-3 text-left">Dosen Pembimbing</th>
            <th class="px-4 py-3 text-center">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($peminjaman as $p): ?>
            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
              <td class="px-4 py-3 font-medium"><?= $p->nama_ruangan; ?></td>
              <td class="px-4 py-3">
                <?= date('d M Y', strtotime($p->tanggal_mulai)); ?> - 
                <?= date('d M Y', strtotime($p->tanggal_selesai)); ?>
              </td>
              <td class="px-4 py-3"><?= $p->nama_dosen; ?></td>
              <td class="px-4 py-3 text-center">
                <?php if($p->status == 'pending'): ?>
                  <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Menunggu</span>
                <?php elseif($p->status == 'disetujui'): ?>
                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Disetujui</span>
                <?php elseif($p->status == 'ditolak'): ?>
                  <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Ditolak</span>
                <?php else: ?>
                  <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold"><?= ucfirst($p->status); ?></span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<script>
  lucide.createIcons();
</script>
