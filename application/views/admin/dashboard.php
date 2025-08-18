<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Sidebar */
    .sidebar {
      min-height: 100vh;
      background: linear-gradient(180deg, #1e3c72, #2a5298);
      color: #fff;
      box-shadow: 2px 0 8px rgba(0,0,0,0.15);
    }

    .sidebar h5 {
      font-weight: bold;
      padding: 1rem 0;
      color: #f8f9fa;
    }

    .sidebar .nav-link {
      color: #cfd8e3;
      font-weight: 500;
      border-radius: 8px;
      margin: 4px 8px;
      transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover, 
    .sidebar .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
    }

    .sidebar .btn-danger {
      margin-top: 1rem;
      border-radius: 8px;
    }

    /* Content */
    main {
      padding: 2rem;
    }

    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 18px rgba(0,0,0,0.12);
    }

    .card h5 {
      font-weight: 600;
    }

    .border-bottom {
      border-color: #e0e6ed !important;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <nav class="col-md-2 d-none d-md-block sidebar">
      <div class="position-sticky pt-3 text-center">
        <h5>⚡ Admin Panel</h5>
        <ul class="nav flex-column text-start px-2">
          <li class="nav-item">
            <a class="nav-link active" href="#">📊 Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">👤 Data User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">🏢 Data Ruangan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">📅 Peminjaman</a>
          </li>
        </ul>
        <a href="#" class="btn btn-danger w-100">Logout</a>
      </div>
    </nav>

    <!-- Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10">
      <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
        <h1 class="h3 fw-bold text-dark">Selamat Datang, <span class="text-primary"><?= $username; ?></span> 👋</h1>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card text-bg-primary p-3">
            <div class="card-body">
              <h5 class="card-title">👤 Data User</h5>
              <p class="card-text">Kelola akun admin & user.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-bg-success p-3">
            <div class="card-body">
              <h5 class="card-title">🏢 Data Ruangan</h5>
              <p class="card-text">Kelola data ruangan yang tersedia.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-bg-warning p-3">
            <div class="card-body">
              <h5 class="card-title">📅 Peminjaman</h5>
              <p class="card-text">Lihat & kelola peminjaman.</p>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>
</body>
</html>
