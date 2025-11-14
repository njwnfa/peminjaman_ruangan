<!-- Topbar -->
<header class="no-print flex items-center justify-between bg-white px-6 py-3 border-b shadow-sm">
  <div class="flex items-center gap-3">
    <!-- Tombol menu mobile -->
    <button class="lg:hidden text-gray-700"><i class="fas fa-bars"></i></button>
    <div>
      <small class="text-gray-500">Pages / <?= ucfirst($active) ?></small>
      <h5 class="text-lg font-semibold"><?= ucfirst($active) ?></h5>
    </div>
  </div>

  <!-- Profil / Logout -->
  <div class="flex items-center gap-4">
    <span class="font-medium"><?= $this->session->userdata('nama') ?? 'Admin' ?></span>
    <a href="<?= base_url('auth/logout')?>" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</header>
