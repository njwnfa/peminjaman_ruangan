<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Peminjaman Ruangan Lab Kampus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="<?= base_url('assets/images/pilates.png'); ?>" type="image/png">

  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    window.tailwind = window.tailwind || {};
    window.tailwind.config = { darkMode: 'class' };

    (function () {
      const saved = localStorage.getItem('theme');
      const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const shouldDark = saved ? saved === 'dark' : systemDark;
      if (shouldDark) document.documentElement.classList.add('dark');
    })();
  </script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- GSAP -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-gray-950 dark:text-gray-100 overflow-x-hidden">

  <!-- Navbar -->
  <nav class="bg-white dark:bg-gray-900 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-indigo-600">Pilates</h1>

      <div class="hidden md:flex items-center space-x-6 font-medium">
        <a href="#fitur" class="hover:text-indigo-600 transition">Fitur</a>
        <a href="#cara-kerja" class="hover:text-indigo-600 transition">Cara Kerja</a>
        <a href="#testimoni" class="hover:text-indigo-600 transition">Testimoni</a>
        <a href="#faq" class="hover:text-indigo-600 transition">FAQ</a>
        <a href="#kontak" class="hover:text-indigo-600 transition">Kontak</a>

        <?php if($this->session->userdata('logged_in')): ?>
          <!-- Menu tambahan hanya muncul kalau sudah login -->
          <a href="<?= base_url('ruangan/list_ruangan') ?>" class="hover:text-indigo-600 transition">Daftar Ruangan</a>
        <?php endif; ?>
      </div>

      <!-- Login / User Dropdown -->
      <div class="flex items-center gap-3 relative">
        <?php if($this->session->userdata('logged_in')): ?>
          <!-- Dropdown User -->
          <div class="relative">
            <button onclick="toggleDropdown()" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
              <i data-lucide="user" class="w-6 h-6"></i>
            </button>
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2">
              <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <p class="font-semibold text-gray-800 dark:text-gray-200">
                  <?= $this->session->userdata('nama'); ?>
                </p>
              </div>
              <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
            </div>
          </div>
        <?php else: ?>
          <!-- Tombol login kalau belum login -->
          <a href="<?= base_url('auth/login') ?>" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Login</a>
        <?php endif; ?>

        <!-- Toggle Dark Mode -->
        <button id="themeToggle" onclick="toggleTheme()" class="inline-flex items-center justify-center px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
          <i data-lucide="moon" class="h-5 w-5 block dark:hidden"></i>
          <i data-lucide="sun" class="h-5 w-5 hidden dark:block"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero dengan background animasi -->
  <section class="relative max-w-7xl mx-auto px-6 py-20 md:py-28 grid md:grid-cols-2 gap-12 items-center overflow-hidden">
    
    <!-- Canvas Background -->
    <canvas id="bgCanvas" class="absolute inset-0 w-full h-full z-0"></canvas>
    
    <div class="relative z-10 space-y-6 text-center md:text-left">
      <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-gray-900 dark:text-gray-100 hero-title">
        Peminjaman <span class="text-indigo-600">Ruangan Lab</span> Kampus Jadi Lebih Mudah
      </h2>
      <p class="text-lg text-gray-600 dark:text-gray-300 hero-sub">
        Sistem terpadu untuk mahasiswa & dosen dalam mengelola peminjaman laboratorium kampus secara online.
      </p>
      <a href="#fitur" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">Jelajahi Fitur</a>
    </div>

    <div class="relative z-10 hero-img">
      <img src="<?= base_url('assets/images/bg-home.svg'); ?>" alt="Laboratorium Kampus" class="rounded-2xl">
    </div>
  </section>


  <!-- Statistik -->
  <section class="bg-gradient-to-r from-indigo-600 to-blue-500 py-16 text-white">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 text-center">
      <div>
        <h3 class="text-4xl font-bold counter" data-target="1200">0</h3>
        <p>Ruangan Dipesan</p>
      </div>
      <div>
        <h3 class="text-4xl font-bold counter" data-target="850">0</h3>
        <p>Mahasiswa Aktif</p>
      </div>
      <div>
        <h3 class="text-4xl font-bold counter" data-target="150">0</h3>
        <p>Dosen Terlibat</p>
      </div>
    </div>
  </section>

  <!-- Fitur -->
  <section id="fitur" class="bg-white dark:bg-gray-900 py-20">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-3xl font-bold text-center mb-12">Fitur Sistem</h3>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="p-6 shadow-lg rounded-xl bg-gray-50 dark:bg-gray-800 text-center feature-card">
          <i data-lucide="globe" class="w-12 h-12 text-indigo-600 mx-auto mb-4"></i>
          <h4 class="font-semibold text-xl mb-3">Mudah Diakses</h4>
          <p>Mahasiswa & dosen dapat mengajukan peminjaman kapan saja secara online.</p>
        </div>
        <div class="p-6 shadow-lg rounded-xl bg-gray-50 dark:bg-gray-800 text-center feature-card">
          <i data-lucide="calendar-days" class="w-12 h-12 text-indigo-600 mx-auto mb-4"></i>
          <h4 class="font-semibold text-xl mb-3">Jadwal Transparan</h4>
          <p>Semua jadwal penggunaan lab dapat dipantau secara real-time.</p>
        </div>
        <div class="p-6 shadow-lg rounded-xl bg-gray-50 dark:bg-gray-800 text-center feature-card">
          <i data-lucide="zap" class="w-12 h-12 text-indigo-600 mx-auto mb-4"></i>
          <h4 class="font-semibold text-xl mb-3">Efisien</h4>
          <p>Proses peminjaman lebih cepat, tanpa ribet mengurus dokumen manual.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Cara Kerja -->
  <section id="cara-kerja" class="py-20 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-3xl font-bold text-center mb-12">Cara Kerja Sistem</h3>

      <div class="grid md:grid-cols-4 gap-8">
        <!-- Step 1 -->
        <div class="step-card text-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
          <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-indigo-600 text-white text-xl font-bold mb-4">1</div>
          <h4 class="font-semibold text-lg mb-2">Login ke Sistem</h4>
          <p class="text-gray-600 dark:text-gray-300">Mahasiswa atau dosen login menggunakan akun kampus.</p>
        </div>

        <!-- Step 2 -->
        <div class="step-card text-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
          <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-indigo-600 text-white text-xl font-bold mb-4">2</div>
          <h4 class="font-semibold text-lg mb-2">Pilih Ruangan & Jadwal</h4>
          <p class="text-gray-600 dark:text-gray-300">Cari ruangan lab yang tersedia sesuai kebutuhan.</p>
        </div>

        <!-- Step 3 -->
        <div class="step-card text-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
          <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-indigo-600 text-white text-xl font-bold mb-4">3</div>
          <h4 class="font-semibold text-lg mb-2">Ajukan Peminjaman</h4>
          <p class="text-gray-600 dark:text-gray-300">Ajukan peminjaman dengan detail kegiatan yang jelas.</p>
        </div>

        <!-- Step 4 -->
        <div class="step-card text-center p-6 bg-white dark:bg-gray-900 rounded-xl shadow">
          <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-indigo-600 text-white text-xl font-bold mb-4">4</div>
          <h4 class="font-semibold text-lg mb-2">Konfirmasi & Gunakan</h4>
          <p class="text-gray-600 dark:text-gray-300">Setelah disetujui, gunakan ruangan sesuai jadwal yang dipilih.</p>
        </div>
      </div>
    </div>
  </section>


  <!-- Testimoni -->
  <section id="testimoni" class="py-20 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h3 class="text-4xl font-bold mb-16 text-gray-800 dark:text-white">
        Apa Kata Mereka?
      </h3>

      <div class="grid md:grid-cols-3 gap-10">
        <!-- Card 1 -->
        <div class="p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
          <div class="flex flex-col items-center">
            <img src="https://i.pravatar.cc/100?img=3" alt="Budi" class="w-20 h-20 rounded-full border-4 border-indigo-500 shadow-md mb-4">
            <p class="text-gray-600 dark:text-gray-300 italic">"Sistem ini memudahkan kami mengatur pemakaian lab tanpa perlu bolak-balik ke administrasi."</p>
            <h4 class="mt-6 font-semibold text-indigo-600">Budi</h4>
            <span class="text-sm text-gray-500 dark:text-gray-400">Mahasiswa</span>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
          <div class="flex flex-col items-center">
            <img src="https://i.pravatar.cc/100?img=5" alt="Dina" class="w-20 h-20 rounded-full border-4 border-indigo-500 shadow-md mb-4">
            <p class="text-gray-600 dark:text-gray-300 italic">"Saya bisa langsung cek jadwal lab yang kosong, lebih cepat dan transparan."</p>
            <h4 class="mt-6 font-semibold text-indigo-600">Dina</h4>
            <span class="text-sm text-gray-500 dark:text-gray-400">Dosen</span>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
          <div class="flex flex-col items-center">
            <img src="https://i.pravatar.cc/100?img=7" alt="Andi" class="w-20 h-20 rounded-full border-4 border-indigo-500 shadow-md mb-4">
            <p class="text-gray-600 dark:text-gray-300 italic">"User interface-nya modern, gampang dipakai, dan sangat membantu proses belajar."</p>
            <h4 class="mt-6 font-semibold text-indigo-600">Andi</h4>
            <span class="text-sm text-gray-500 dark:text-gray-400">Mahasiswa</span>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- FAQ -->
  <section id="faq" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-6">
      <h3 class="text-3xl font-bold text-center mb-12">Pertanyaan Umum</h3>
      <div class="space-y-6">
        <details class="bg-gray-50 dark:bg-gray-800 p-5 rounded-lg shadow">
          <summary class="cursor-pointer font-semibold">Apakah semua mahasiswa bisa meminjam lab?</summary>
          <p class="mt-2 text-gray-600 dark:text-gray-300">Ya, semua mahasiswa aktif dengan akun kampus bisa menggunakan sistem ini.</p>
        </details>
        <details class="bg-gray-50 dark:bg-gray-800 p-5 rounded-lg shadow">
          <summary class="cursor-pointer font-semibold">Bagaimana jika jadwal bentrok?</summary>
          <p class="mt-2 text-gray-600 dark:text-gray-300">Sistem akan otomatis menolak permintaan jika ruangan sudah terpakai pada waktu yang sama.</p>
        </details>
        <details class="bg-gray-50 dark:bg-gray-800 p-5 rounded-lg shadow">
          <summary class="cursor-pointer font-semibold">Apakah ada notifikasi pengingat?</summary>
          <p class="mt-2 text-gray-600 dark:text-gray-300">Ya, sistem mengirim notifikasi melalui telegram.</p>
        </details>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-center">
    <h3 class="text-3xl md:text-4xl font-bold">Butuh Ruangan Lab?</h3>
    <p class="mt-4">Ajukan peminjaman sekarang secara cepat & praktis</p>
    <a href="<?= $this->session->userdata('logged_in') 
              ? base_url('ruangan/list_ruangan') 
              : base_url('auth/login'); ?>" 
      class="mt-6 inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition">
      Ajukan Sekarang
    </a>
  </section>

  <!-- Footer -->
  <footer id="kontak" class="bg-gray-900 dark:bg-black text-gray-400 py-10">
    <div class="max-w-7xl mx-auto px-6 text-center space-y-3">
      <p class="text-lg font-semibold text-white">Pilates</p>
      <p>Email: pilates@gmail.com | Telp: (021) 123-456</p>
      <p class="text-sm">&copy; <?= date('Y') ?> Pilates. Semua Hak Dilindungi.</p>
    </div>
  </footer>

  <!-- Floating Button Back to Top -->
  <button id="backToTop" onclick="scrollToTop()" 
    class="hidden fixed bottom-6 right-6 bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-700 transition">
    <i data-lucide="arrow-up" class="w-6 h-6"></i>
  </button>

  <script>
    lucide.createIcons();

    function toggleTheme() {
      const root = document.documentElement;
      const isDark = root.classList.toggle('dark');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    // GSAP Animations
    gsap.registerPlugin(ScrollTrigger);

    gsap.from(".hero-title", { y: 50, opacity: 0, duration: 1 });
    gsap.from(".hero-sub", { y: 30, opacity: 0, duration: 1, delay: 0.3 });
    gsap.from(".hero-img", { scale: 0.8, opacity: 0, duration: 1, delay: 0.6 });

    gsap.utils.toArray(".feature-card").forEach((card, i) => {
      gsap.from(card, {
        scrollTrigger: { trigger: card, start: "top 80%" },
        y: 50, opacity: 0, duration: 0.8, delay: i * 0.2
      });
    });

    gsap.utils.toArray(".testimonial").forEach((card, i) => {
      gsap.from(card, {
        scrollTrigger: { trigger: card, start: "top 85%" },
        scale: 0.9, opacity: 0, duration: 0.8, delay: i * 0.2
      });
    });

    // Counter animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
      let target = +counter.getAttribute('data-target');
      let count = 0;
      const updateCount = () => {
        let speed = target / 200;
        if (count < target) {
          count += speed;
          counter.innerText = Math.ceil(count);
          requestAnimationFrame(updateCount);
        } else {
          counter.innerText = target;
        }
      };
      ScrollTrigger.create({
        trigger: counter,
        start: "top 85%",
        onEnter: updateCount
      });
    });

    const canvas = document.getElementById("bgCanvas");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let particles = [];
    const colors = ["#6366F1", "#3B82F6", "#60A5FA", "#A5B4FC"];
    const mouse = { x: null, y: null, radius: 100 };

    class Particle {
      constructor(x, y, radius, color) {
        this.x = x;
        this.y = y;
        this.radius = radius;
        this.color = color;
        this.speed = Math.random() * 1 + 0.5;
        this.drift = (Math.random() - 0.5) * 0.5;
        this.baseX = x;
        this.baseY = y;
      }

      draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.globalAlpha = 0.7;
        ctx.fill();
      }

      update() {
        // gerak bubble normal (naik ke atas)
        this.y -= this.speed;
        this.x += this.drift;

        // kalau partikel keluar layar → reset ulang
        if (this.y + this.radius < 0) {
          this.y = canvas.height + this.radius;
          this.x = Math.random() * canvas.width;
        }

        // interaksi dengan mouse
        let dx = mouse.x - this.x;
        let dy = mouse.y - this.y;
        let distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < mouse.radius) {
          this.x -= dx / 10;
          this.y -= dy / 10;
        }

        this.draw();
      }
    }

    function initParticles() {
      particles = [];
      for (let i = 0; i < 50; i++) {
        let radius = Math.random() * 5 + 3;
        let x = Math.random() * canvas.width;
        let y = Math.random() * canvas.height;
        let color = colors[Math.floor(Math.random() * colors.length)];
        particles.push(new Particle(x, y, radius, color));
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach(p => p.update());
      requestAnimationFrame(animate);
    }

    // Mouse event
    window.addEventListener("mousemove", e => {
      mouse.x = e.x;
      mouse.y = e.y;
    });

    window.addEventListener("resize", () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      initParticles();
    });

    // Init
    initParticles();
    animate();

    // Animasi Cara Kerja
    gsap.utils.toArray("#cara-kerja .step-card").forEach((card, i) => {
      gsap.from(card, {
        scrollTrigger: { trigger: card, start: "top 85%" },
        y: 60, opacity: 0, duration: 0.8, delay: i * 0.2
      });
    });

    const backToTopBtn = document.getElementById("backToTop");

    window.addEventListener("scroll", () => {
      if (window.scrollY > 300) {
        backToTopBtn.classList.remove("hidden");
      } else {
        backToTopBtn.classList.add("hidden");
      }
    });

    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    }

    // Re-render icon lucide biar muncul di button
    lucide.createIcons();

    function toggleDropdown() {
      document.getElementById("userDropdown").classList.toggle("hidden");
    }

    // klik luar area -> close dropdown
    window.addEventListener("click", function(e) {
      const dropdown = document.getElementById("userDropdown");
      const button = document.querySelector("button[onclick='toggleDropdown()']");
      if (!button.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add("hidden");
      }
    });

  </script>
</body>
</html>
