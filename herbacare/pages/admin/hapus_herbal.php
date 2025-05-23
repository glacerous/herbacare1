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

// hapus gambar jika ada
$query = mysqli_query($connect, "SELECT gambar FROM herbal WHERE id = $id");
$data = mysqli_fetch_assoc($query);
if ($data && !empty($data['gambar'])) {
    $gambarPath = "../../uploads/" . $data['gambar'];
    if (file_exists($gambarPath)) {
        unlink($gambarPath);
    }
}

// hapus komentar yg terkait dulu
mysqli_query($connect, "DELETE FROM komentar_herbal WHERE herbal_id = $id");
// baru hapus data
$hapus = mysqli_query($connect, "DELETE FROM herbal WHERE id = $id");

if ($hapus) {
    header("location: herbal.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($connect);
}
?>
