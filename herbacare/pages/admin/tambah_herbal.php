<?php
session_start();
include "../../proses/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php?pesan=belum_login");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $manfaat = $_POST['manfaat'];
    $cara_penggunaan = $_POST['cara_penggunaan'];
    $penyakit = $_POST['penyakit'];

    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $upload_dir = "../../uploads/";

    // Jika ada gambar, upload
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
</head>
<body class="bg-light">

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
                    <label for="penyakit" class="form-label">Penyakit yang Dapat Diobati</label>
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
