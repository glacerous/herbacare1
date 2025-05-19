<?php
session_start();
include "../../proses/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:login.php?pesan=belum_login");
    exit;
}

$id = $_GET['id'] ?? '';
if ($id == '') {
    header("location:herbal.php");
    exit;
}

// Ambil data lama
$query = mysqli_query($connect, "SELECT * FROM herbal WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $manfaat = $_POST['manfaat'];
    $cara_penggunaan = $_POST['cara_penggunaan'];
    $penyakit = $_POST['penyakit'];

    // Upload gambar baru jika ada
    $gambar = $data['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../../uploads/" . $gambar);
    }

    $queryUpdate = "UPDATE herbal SET 
        nama='$nama', 
        manfaat='$manfaat', 
        cara_penggunaan='$cara_penggunaan', 
        penyakit='$penyakit', 
        gambar='$gambar' 
        WHERE id=$id";

    if (mysqli_query($connect, $queryUpdate)) {
        header("location: herbal.php");
    } else {
        echo "Gagal mengedit data: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Herbal</title>
    <link rel="stylesheet" href="../../css/tambahobatstyles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Edit Data Herbal</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Manfaat</label>
                    <textarea class="form-control" name="manfaat" required><?= $data['manfaat'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cara Penggunaan</label>
                    <textarea class="form-control" name="cara_penggunaan" required><?= $data['cara_penggunaan'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penyakit</label>
                    <input type="text" class="form-control" name="penyakit" value="<?= $data['penyakit'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar (kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" class="form-control" name="gambar" accept="image/*">
                    <?php if ($data['gambar']) : ?>
                        <img src="../../uploads/<?= $data['gambar'] ?>" alt="Gambar Herbal" class="img-thumbnail mt-2" width="150">
                    <?php endif; ?>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="herbal.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
