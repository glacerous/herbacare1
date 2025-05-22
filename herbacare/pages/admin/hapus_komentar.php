<?php
session_start();
include "../../proses/koneksi.php";

// Pastikan metode adalah POST dan user sudah login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $id_komentar = intval($_POST['id_komentar']);
    $herbal_id = intval($_POST['herbal_id']);
    $user_id = $_SESSION['user_id'];

    // Validasi: hanya pemilik komentar yang boleh menghapus
    $cek = mysqli_query($connect, "SELECT * FROM komentar_herbal WHERE id = $id_komentar AND user_id = $user_id");
    
    if (mysqli_num_rows($cek) > 0) {
        // Hapus komentar
        $hapus = mysqli_query($connect, "DELETE FROM komentar_herbal WHERE id = $id_komentar");
        if ($hapus) {
            $_SESSION['pesan'] = "Komentar berhasil dihapus.";
        } else {
            $_SESSION['pesan'] = "Gagal menghapus komentar.";
        }
    } else {
        $_SESSION['pesan'] = "Akses ditolak: Anda tidak berhak menghapus komentar ini.";
    }

    // Redirect kembali ke detail herbal
    header("Location: detail_herbal.php?id=$herbal_id");
    exit;
} else {
    echo "Akses tidak sah.";
}
