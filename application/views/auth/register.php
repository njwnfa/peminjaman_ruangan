<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?= base_url('assets/images/pilates.png'); ?>" type="image/png">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen font-sans">

  <div class="flex h-screen w-full">
    <!-- Bagian Register -->
    <div class="flex flex-1 justify-center items-center p-10 bg-white">
      <div class="w-full max-w-sm text-center">

        <!-- Logo -->
        <img 
          src="<?= base_url('assets/images/pilates.png'); ?>" 
          alt="Logo Kampus" 
          class="mx-auto mb-4 w-20 h-20 object-contain"
        >

        <h2 class="mb-2 text-3xl font-bold text-indigo-600">Register</h2>
        <p class="mb-6 text-gray-600 text-sm">
          Buat akun baru untuk mengakses sistem peminjaman ruangan lab kampus.
        </p>

        <?php if ($this->session->flashdata('error')): ?>
          <p class="text-red-500 mb-4"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/register'); ?>" class="grid grid-cols-1 gap-4">
            
            <!-- Nama Lengkap -->
            <div class="text-left">
              <label class="block mb-2 text-sm font-semibold">Nama Lengkap</label>
              <input 
                  type="text" 
                  name="nama" 
                  placeholder="Masukan Nama Lengkap..." 
                  required 
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg 
                         focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
              >
            </div>

            <!-- Email -->
            <div class="text-left">
              <label class="block mb-2 text-sm font-semibold">Email</label>
              <input 
                type="email" 
                name="email" 
                placeholder="Masukan Email Anda..." 
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg 
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
              >
            </div>

            <!-- Password & Konfirmasi Password -->
            <div class="grid grid-cols-2 gap-4">
              <div class="text-left">
                <label class="block mb-2 text-sm font-semibold">Password</label>
                <input 
                  type="password" 
                  name="password" 
                  placeholder="Masukan Password..." 
                  required 
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg 
                         focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                >
              </div>
              <div class="text-left">
                <label class="block mb-2 text-sm font-semibold">Konfirmasi Password</label>
                <input 
                  type="password" 
                  name="password_confirm" 
                  placeholder="Ulangi Password..." 
                  required 
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg 
                         focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                >
                <!-- Indikator realtime -->
                <p id="passwordMessage" class="text-sm mt-1"></p>
              </div>
            </div>

            <!-- Tombol -->
            <button 
              type="submit" 
              id="registerBtn"
              disabled
              class="w-full py-3 bg-green-600 text-white rounded-lg font-semibold 
                     hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
              REGISTER
            </button>
        </form>


        <!-- Link ke Login -->
        <p class="mt-4 text-sm text-gray-600">
          Sudah punya akun?
          <a href="<?= site_url('auth/login'); ?>" 
             class="text-blue-600 font-semibold hover:underline">
            Login sekarang
          </a>
        </p>

        <!-- Tombol kembali ke Landing Page -->
        <div class="mt-5">
          <a href="<?= base_url(); ?>" 
            class="inline-block px-4 py-2 rounded-lg bg-gray-200 text-gray-800 
                   hover:bg-gray-300 transition">
            ← Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>

    <!-- Bagian Gambar -->
    <div class="flex-1 hidden md:block bg-cover bg-center rounded-r-2xl" 
      style="background-image: url('<?= base_url("assets/images/register-bg.jpg"); ?>');">
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const password = document.querySelector("input[name='password']");
    const confirm = document.querySelector("input[name='password_confirm']");
    const message = document.getElementById("passwordMessage");
    const registerBtn = document.getElementById("registerBtn");

    function checkPassword() {
        if (confirm.value.length === 0) {
        message.textContent = "";
        registerBtn.disabled = true;
        return;
        }
        if (password.value === confirm.value) {
        message.textContent = "Password cocok ✔";
        message.className = "text-sm mt-1 text-green-600";
        registerBtn.disabled = false;
        } else {
        message.textContent = "Password tidak sama ✖";
        message.className = "text-sm mt-1 text-red-600";
        registerBtn.disabled = true;
        }
    }

    password.addEventListener("keyup", checkPassword);
    confirm.addEventListener("keyup", checkPassword);

    <?php if ($this->session->flashdata('success')): ?>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?= $this->session->flashdata('success'); ?>',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?= site_url('auth/login'); ?>";
      }
    });
  <?php endif; ?>
  </script>
</body>
</html>
