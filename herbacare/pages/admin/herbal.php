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
    <link rel="stylesheet" href="../../css/herbalstyles.css">
    <style>
        .card-herbal {
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            border: none;
            border-radius: 15px;
        }
        .card-herbal:hover {
            transform: scale(1.03);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .action-buttons a {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">HerbaCare</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="herbal.php">Herbal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../proses/logout.php">Log out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🌿 Data Herbal</h2>
        <a href="tambah_herbal.php" class="btn btn-success">+ Tambah Herbal</a>
    </div>

    <form method="GET" class="search-bar input-group mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari herbal berdasarkan nama, penyakit, atau manfaat" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <div class="col">
                    <div class="card card-herbal">
                        <img src="../../uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="gambar herbal">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($row['nama']) ?></h5>
                            <p><strong>Kategori:</strong> <?= htmlspecialchars($row['penyakit']) ?></p>
                            <p class="text-muted"><?= nl2br(htmlspecialchars($row['manfaat'])) ?></p>
                            <div class="action-buttons d-grid">
                                <a href="edit_herbal.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
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
