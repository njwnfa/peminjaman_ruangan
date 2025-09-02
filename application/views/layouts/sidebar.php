<!-- Sidebar -->
<aside class="w-64 bg-white border-r shadow-lg hidden lg:block">
  <div class="flex items-center gap-3 px-6 py-4 border-b">
    <img src="https://dummyimage.com/40x40/000/fff&text=AD" class="rounded-full" alt="logo">
    <span class="font-semibold text-gray-700">Pilates</span>
  </div>
  <nav class="px-4 py-6 space-y-2">
    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg <?= ($active=='dashboard'?'bg-blue-600 text-white':'text-gray-700 hover:bg-gray-100') ?>">
      <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg <?= ($active=='kasir'?'bg-blue-600 text-white':'text-gray-700 hover:bg-gray-100') ?>">
      <i class="fas fa-user"></i> Users
    </a>
    <a href="<?= base_url('admin/ruangan'); ?>" 
      class="flex items-center gap-3 px-4 py-2 rounded-lg <?= ($active=='ruangan'?'bg-blue-600 text-white':'text-gray-700 hover:bg-gray-100') ?>">
      <i class="fas fa-door-open"></i> Ruangan
    </a>

    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg <?= ($active=='kas'?'bg-blue-600 text-white':'text-gray-700 hover:bg-gray-100') ?>">
      <i class="fas fa-chart-line"></i> Rekap Bulanan
    </a>
  </nav>
</aside>
