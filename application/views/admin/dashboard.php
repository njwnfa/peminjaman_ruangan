<?php $active = 'dashboard'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url('assets/images/pilates.png'); ?>" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php $this->load->view('layouts/sidebar', ['active' => $active]); ?>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <!-- Topbar -->
    <?php $this->load->view('layouts/topbar', ['active' => $active]); ?>

    <!-- Isi Dashboard -->
    <main class="p-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card 1 -->
        <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
          <div>
            <h6 class="text-sm text-gray-500">DATA USER</h6>
            <h5 class="text-xl font-bold">0</h5>
            <a href="#" class="text-blue-600 text-sm hover:underline">Lihat Detail &gt;</a>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-600 text-white">
            <i class="fas fa-user"></i>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
          <div>
            <h6 class="text-sm text-gray-500">DATA RUANGAN</h6>
            <h5 class="text-xl font-bold">0</h5>
            <a href="#" class="text-blue-600 text-sm hover:underline">Lihat Detail &gt;</a>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-600 text-white">
            <i class="fas fa-door-open"></i>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow rounded-xl p-5 flex items-center justify-between">
          <div>
            <h6 class="text-sm text-gray-500">REKAP BULANAN</h6>
            <h5 class="text-xl font-bold">0</h5>
            <a href="#" class="text-blue-600 text-sm hover:underline">Lihat Detail &gt;</a>
          </div>
          <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-500 text-white">
            <i class="fas fa-chart-line"></i>
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

</body>
</html>
