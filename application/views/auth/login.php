<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body>
  <div class="container">
    <!-- Bagian Login -->
    <div class="login-section">
      <div class="login-box">
        <h2>LOGIN</h2>

        <?php if ($this->session->flashdata('error')): ?>
          <p style="color:red;"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/login'); ?>">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukan Nama Anda..." required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukan Password Anda..." required>
          </div>
          <button type="submit" class="btn">LOGIN</button>
        </form>

        <!-- Tombol kembali ke Landing Page -->
        <div style="margin-top: 15px; text-align: center;">
          <a href="<?= base_url(); ?>" class="btn-back">← Kembali ke Beranda</a>
        </div>
      </div>
    </div>

    <!-- Bagian Gambar -->
    <div class="image-section"></div>
  </div>

  <style>
    .btn-back {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 16px;
      border-radius: 6px;
      background: #e5e7eb;
      color: #111827;
      text-decoration: none;
      transition: 0.2s;
    }
    .btn-back:hover {
      background: #d1d5db;
    }
  </style>
</body>
</html>
