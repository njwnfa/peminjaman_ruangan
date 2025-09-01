<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?= base_url('assets/images/pilates.png'); ?>" type="image/png">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen font-sans">

  <div class="flex h-screen w-full">
    <!-- Bagian Login -->
    <div class="flex flex-1 justify-center items-center p-10 bg-white">
      <div class="w-full max-w-sm text-center">
        
        <!-- Logo -->
        <img 
          src="<?= base_url('assets/images/pilates.png'); ?>" 
          alt="Logo Kampus" 
          class="mx-auto mb-4 w-20 h-20 object-contain"
        >

        <h2 class="mb-2 text-3xl font-bold text-indigo-600">Login</h2>
        <p class="mb-6 text-gray-600 text-sm">
          Selamat datang di sistem peminjaman ruangan lab kampus.<br>
          Silakan masuk untuk melanjutkan.
        </p>

        <?php if ($this->session->flashdata('error')): ?>
          <p class="text-red-500 mb-4"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/login'); ?>">
          <div class="mb-4 text-left">
            <label class="block mb-2 text-sm font-semibold">Email</label>
            <input 
              type="email" 
              name="email" 
              placeholder="Masukan Email Anda..." 
              required 
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
            >
          </div>
          <div class="mb-4 text-left">
            <label class="block mb-2 text-sm font-semibold">Password</label>
            <input 
              type="password" 
              name="password" 
              placeholder="Masukan Password Anda..." 
              required 
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
            >
          </div>
          <button 
            type="submit" 
            class="w-full py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition"
          >
            LOGIN
          </button>
        </form>

        <!-- Link ke Register -->
        <p class="mt-4 text-sm text-gray-600">
          Belum punya akun?
          <a href="<?= site_url('auth/register'); ?>" class="text-blue-600 font-semibold hover:underline">
            Daftar sekarang
          </a>
        </p>

        <!-- Tombol kembali ke Landing Page -->
        <div class="mt-5">
          <a href="<?= base_url(); ?>" 
            class="inline-block px-4 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
            ← Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>

    <!-- Bagian Gambar -->
    <div class="flex-1 hidden md:block bg-cover bg-center rounded-r-2xl" 
      style="background-image: url('<?= base_url("assets/images/login-bg.jpg"); ?>');">
    </div>
  </div>

</body>
</html>
