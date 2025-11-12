<?php if ($this->session->flashdata('success')): ?>
  <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">
    <?= $this->session->flashdata('success'); ?>
  </div>
<?php elseif ($this->session->flashdata('error')): ?>
  <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-center">
    <?= $this->session->flashdata('error'); ?>
  </div>
<?php endif; ?>

<div class="max-w-7xl mx-auto px-6 py-12">
  <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center">
    Daftar Ruangan
  </h2>

  <?php if (!empty($ruangan)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach($ruangan as $r): ?>
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden flex flex-col">
          
          <div class="h-40 w-full overflow-hidden">
            <img 
              src="<?= !empty($r->gambar) ? base_url('uploads/ruangan/' . $r->gambar) : 'https://via.placeholder.com/400x250?text=Ruangan' ?>" 
              alt="Ruangan <?= $r->nama_ruangan ?>" 
              class="w-full h-full object-cover hover:scale-105 transition-transform"
            />
          </div>

          <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
              <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-4">
                <?= $r->nama_ruangan; ?>
              </h3>
              
              <p class="flex items-center text-gray-600 dark:text-gray-300 text-sm mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-9a4 4 0 110-8 4 4 0 010 8zM7 7a4 4 0 118 0 4 4 0 01-8 0z" />
                </svg>
                <span class="font-semibold">Kapasitas:</span> <?= $r->kapasitas; ?> orang
              </p>

              <p class="flex items-center text-gray-600 dark:text-gray-300 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.983 2.705a1 1 0 011.034 0l2.122 1.226a1 1 0 01.444.858v2.448a7.962 7.962 0 012.57 1.484l2.011-.58a1 1 0 01.926.268l1.5 1.5a1 1 0 01.268.926l-.58 2.011a7.962 7.962 0 011.484 2.57h2.448a1 1 0 01.858.444l1.226 2.122a1 1 0 010 1.034l-1.226 2.122a1 1 0 01-.858.444h-2.448a7.962 7.962 0 01-1.484 2.57l.58 2.011a1 1 0 01-.268.926l-1.5 1.5a1 1 0 01-.926.268l-2.011-.58a7.962 7.962 0 01-2.57 1.484v2.448a1 1 0 01-.444.858l-2.122 1.226a1 1 0 01-1.034 0l-2.122-1.226a1 1 0 01-.444-.858v-2.448a7.962 7.962 0 01-2.57-1.484l-2.011.58a1 1 0 01-.926-.268l-1.5-1.5a1 1 0 01-.268-.926l.58-2.011a7.962 7.962 0 01-1.484-2.57H2.705a1 1 0 01-.444-.858l-1.226-2.122a1 1 0 010-1.034l1.226-2.122a1 1 0 01.444-.858h2.448a7.962 7.962 0 011.484-2.57l-.58-2.011a1 1 0 01.268-.926l1.5-1.5a1 1 0 01.926-.268l2.011.58a7.962 7.962 0 012.57-1.484V4.789a1 1 0 01.444-.858l2.122-1.226z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="font-semibold">Deskripsi:</span> <?= !empty($r->deskripsi) ? substr($r->deskripsi, 0, 50) . '...' : 'Tidak ada deskripsi'; ?> 
              </p>
            </div>

            <div class="mt-6">
              <?php if ($r->status == 'tersedia'): ?>
                <button 
                  onclick="openModal(<?= $r->id_ruangan ?>, '<?= $r->nama_ruangan ?>')" 
                  class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow">
                  Ajukan
                </button>
              <?php else: ?>
                <button 
                  class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed text-sm font-medium shadow" 
                  disabled>
                  Tidak Tersedia (Status: <?= $r->status ?>)
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="text-center text-gray-500 dark:text-gray-400 py-12">
      Tidak ada data ruangan.
    </div>
  <?php endif; ?>
</div>

<div id="modalPeminjaman" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  
  <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg w-full max-w-lg 
            max-h-[90vh] flex flex-col">
    
    <div class="p-6 overflow-y-auto">
      <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Form Peminjaman</h2>
      
      <form id="formPeminjaman" 
            action="<?= base_url('ruangan/store_peminjaman'); ?>" 
            method="POST" 
            class="space-y-4"
            onsubmit="return validateTanggal()">
            
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="id_ruangan" id="ruangan_id">
        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium">Ruangan</label>
          <input type="text" id="nama_ruangan" class="w-full p-2 border rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none" readonly>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium" for="keperluan">Keperluan / Acara <span class="text-red-500">*</span></label>
          <textarea name="keperluan" id="keperluan" rows="3" class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
        </div>
        
        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium" for="nama_dosen">Nama Dosen Penanggung Jawab <span class="text-red-500">*</span></label>
          <input type="text" name="nama_dosen" id="nama_dosen" class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium" for="tanggal_mulai">Tanggal Mulai <span class="text-red-500">*</span></label>
          <input type="date" name="tanggal_mulai_date" id="tanggal_mulai" class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium" for="jam_mulai">Jam Mulai <span class="text-red-500">*</span></label>
          <input type="time" name="jam_mulai_time" id="jam_mulai" class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium" for="tanggal_selesai">Tanggal Selesai <span class="text-red-500">*</span></label>
          <input type="date" name="tanggal_selesai_date" id="tanggal_selesai" class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 font-medium" for="jam_selesai">Jam Selesai <span class="text-red-500">*</span></label>
          <input type="time" name="jam_selesai_time" id="jam_selesai" class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        
      </form>
    </div>

    <div class="flex justify-end space-x-2 px-6 py-4 border-t bg-white dark:bg-gray-900 rounded-b-2xl">
      <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</button>
      <button type="submit" form="formPeminjaman" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Ajukan</button>
    </div>
  </div>
</div>


<script>
  function openModal(id, nama) {
    // Selalu reset form dulu agar data lama tidak muncul
    document.getElementById('formPeminjaman').reset(); 
    
    document.getElementById('ruangan_id').value = id;
    document.getElementById('nama_ruangan').value = nama;
    document.getElementById('modalPeminjaman').classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('modalPeminjaman').classList.add('hidden');
  }

  // Tutup modal kalau klik background
  document.getElementById('modalPeminjaman').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });

  // Validasi tanggal mulai & selesai
  function validateTanggal() {
    let tglMulai = document.getElementById("tanggal_mulai").value;
    let tglSelesai = document.getElementById("tanggal_selesai").value;
    let jamMulai = document.getElementById("jam_mulai").value;
    let jamSelesai = document.getElementById("jam_selesai").value;
    
    // ============= TAMBAHAN VALIDASI NAMA DOSEN =============
    let namaDosen = document.getElementById("nama_dosen").value;

    if (!namaDosen.trim()) {
        alert("Nama Dosen Penanggung Jawab harus diisi.");
        return false;
    }
    // ========================================================

    if (!tglMulai || !tglSelesai || !jamMulai || !jamSelesai) {
        alert("Semua kolom tanggal dan jam harus diisi.");
        return false;
    }

    let dateTimeMulai = new Date(tglMulai + ' ' + jamMulai);
    let dateTimeSelesai = new Date(tglSelesai + ' ' + jamSelesai);
    let today = new Date();
    
    today.setHours(0, 0, 0, 0); 
    
    if (new Date(tglMulai) < today) {
        alert("Tanggal mulai tidak boleh tanggal yang sudah lewat.");
        return false;
    }

    if (dateTimeSelesai <= dateTimeMulai) {
      alert("Waktu selesai harus lebih besar dari waktu mulai.");
      return false;
    }

    return true;
  }
</script>