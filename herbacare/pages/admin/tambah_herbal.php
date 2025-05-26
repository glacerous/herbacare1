<?php
session_start();
include "../../proses/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:../login.php?pesan=belum_login");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $manfaat = $_POST['manfaat'];
    $cara_penggunaan = $_POST['cara_penggunaan'];
    $penyakit = $_POST['penyakit'];

    
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $upload_dir = "../../uploads/";

    // if ada gambar, upload
    if (!empty($gambar)) {
        move_uploaded_file($tmp_name, $upload_dir . $gambar);
    }

    $query = "INSERT INTO herbal (nama, manfaat, cara_penggunaan, penyakit, gambar) 
              VALUES ('$nama', '$manfaat', '$cara_penggunaan', '$penyakit', '$gambar')";

    if (mysqli_query($connect, $query)) {
        header("location: herbal.php");
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Herbal</title>
    <link rel="stylesheet" href="../../css/tambahobatstyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../css/styleshome.css?v=3">
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
            <a class="nav-link" href="herbal.php">Herbal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
               <a class="nav-link href="editrole.php">Edit Role</a>
           </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="../../proses/logout.php">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container py-5">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header bg-success text-white text-center">
            <h4>Tambah Data Herbal</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Obat</label>
                    <input type="text" class="form-control" name="nama" id="nama" required>
                </div>
                <div class="mb-3">
                    <label for="manfaat" class="form-label">Manfaat</label>
                    <textarea class="form-control" name="manfaat" id="manfaat" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="cara_penggunaan" class="form-label">Cara Penggunaan</label>
                    <textarea class="form-control" name="cara_penggunaan" id="cara_penggunaan" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="penyakit" class="form-label">Penyakit terkait</label>
                    <input type="text" class="form-control" name="penyakit" id="penyakit">
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (opsional)</label>
                    <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="herbal.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
