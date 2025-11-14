<!DOCTYPE html>
<?php setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'Indonesian_indonesia'); ?>
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

  <div class="flex-1 flex flex-col">
    <?php $this->load->view('layouts/topbar'); ?>

    <main class="p-6">
      <div class="bg-white shadow rounded-xl p-6">
        
        <h1 class="text-2xl font-bold mb-4"><?= $title; ?></h1>

        <form action="<?= base_url('admin/rekap'); ?>" method="POST" class="flex items-center space-x-4 mb-4 p-4 bg-gray-50 rounded-lg">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" id="bulan" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>" <?= ($i == $filter_bulan) ? 'selected' : ''; ?>>
                           <?= strftime('%B', mktime(0, 0, 0, $i, 1)); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="tahun" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <?php foreach ($list_tahun as $tahun): ?>
                        <option value="<?= $tahun; ?>" <?= ($tahun == $filter_tahun) ? 'selected' : ''; ?>>
                            <?= $tahun; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="pt-5">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
            </div>
        </form>
        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-3 border text-center">#</th>
                <th class="px-4 py-3 border text-left">Peminjam</th>
                <th class="px-4 py-3 border text-left">Ruangan</th>
                <th class="px-4 py-3 border text-left">Dosen PJ</th>
                <th class="px-4 py-3 border text-left">Waktu Pengajuan</th>
                <th class="px-4 py-3 border text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($rekap)): ?>
                <?php $no=1; foreach($rekap as $r): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center"><?= $no++; ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($r->nama_peminjam); ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($r->nama_ruangan); ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($r->nama_dosen); ?></td>
                    <td class="px-4 py-2 border text-sm" id="tgl_selesai_<?= $r->id_peminjaman ?>">
                        <?= $r->tanggal_selesai; ?>
                    </td>
                    <td class="px-4 py-2 border text-center">
                      <?php if ($r->status == 'selesai'): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Selesai</span>
                      <?php elseif ($r->status == 'ditolak'): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  
                  <script>
                    document.getElementById('tgl_selesai_<?= $r->id_peminjaman ?>').innerText = 
                      dayjs('<?= $r->created_at ?>', 'YYYY-MM-DD HH:mm:ss').format('dddd, D MMMM YYYY (HH:mm)');
                  </script>
                  
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center py-6 text-gray-500">
                    Tidak ada data rekap untuk periode <?= strftime('%B', mktime(0, 0, 0, $filter_bulan, 1)); ?> <?= $filter_tahun; ?>.
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