<?php
session_start();
include "../../proses/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $id_komentar = intval($_POST['id_komentar']);
    $herbal_id = intval($_POST['herbal_id']);
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'] ?? 'user';

    // if admin bisa hapus komen siapa aja, jika bukan admin cm bisa hapus komen sendiri
    if ($role === 'admin' || $role === 'verified') {
        $hapus = mysqli_query($connect, "DELETE FROM komentar_herbal WHERE id = $id_komentar");
        $_SESSION['pesan'] = $hapus ? "Komentar berhasil dihapus oleh admin." : "Gagal menghapus komentar.";
    } else {
        $cek = mysqli_query($connect, "SELECT * FROM komentar_herbal WHERE id = $id_komentar AND user_id = $user_id");
        if (mysqli_num_rows($cek) > 0) {
            $hapus = mysqli_query($connect, "DELETE FROM komentar_herbal WHERE id = $id_komentar");
            $_SESSION['pesan'] = $hapus ? "Komentar berhasil dihapus." : "Gagal menghapus komentar.";
        } else {
            $_SESSION['pesan'] = "Akses ditolak: Anda tidak berhak menghapus komentar ini.";
        }
    }
//redirect
    header("Location: detail_herbal.php?id=$herbal_id");
    exit;
} else {
    echo "Akses tidak sah.";
}
