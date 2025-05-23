<?php
session_start();
include "../../proses/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php?pesan=belum_login");
    exit;
}

$keyword = '';
if (isset($_GET['search'])) {
    $keyword = mysqli_real_escape_string($connect, $_GET['search']);
    $query = mysqli_query($connect, "SELECT * FROM herbal WHERE nama LIKE '%$keyword%' OR penyakit LIKE '%$keyword%' OR manfaat LIKE '%$keyword%'");
} else {
    $query = mysqli_query($connect, "SELECT * FROM herbal");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Herbal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/herbalstyles.css?v=4">
    <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif;">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">HerbaCare</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="herbal.php">Herbal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
               <a class="nav-link" href="editrole.php">Edit Role</a>
           </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="../../proses/logout.php">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 header-bar">
        <h2>HERBAL</h2>
    </div>

    

    
    <form method="GET" class="mb-4">
  <div class="group">
    <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
      <g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g>
    </svg>
    <input type="search" name="search" class="input" placeholder="Cari herbal..." value="<?= htmlspecialchars($keyword) ?>">
  </div>
</form>
<a href="tambah_herbal.php" class="Btn">
        <div class="sign">+</div>
        <div class="btn-text">&nbsp;&nbsp;  Add</div>
      </a>

      <br>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <div class="col">
                    <div class="card card-herbal">
                        <a href="detail_herbal.php?id=<?= $row['id'] ?>" style="text-decoration: none; color: inherit;">
                            
                        <img src="../../uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="gambar herbal" style="max-height: 200px; object-fit: cover;">

                        
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($row['nama']) ?></h5>
                            <p><strong>Penyakit terkait: </strong> <?= htmlspecialchars($row['penyakit']) ?></p>
                            <p class="text-muted"><?= nl2br(htmlspecialchars($row['manfaat'])) ?></p>
                            <div class="card-button">
                              <a href="edit_herbal.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                              <a href="hapus_herbal.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                      </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-warning text-center w-100" role="alert">
                    Tidak ada data herbal ditemukan.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
