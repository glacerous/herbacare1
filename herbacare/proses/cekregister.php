<?php
include "koneksi.php";

$email = $_POST['email'];
$username = $_POST['username']; 
$password = $_POST['password'];


if (empty($email) || empty($_POST['password'])) {
    echo "<script>
        alert('Email dan Password tidak boleh kosong!');
        window.location.href = '../pages/register.php';
    </script>";
    exit;
}
$data = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
$cek = mysqli_fetch_assoc($data);

if ($cek) {
    echo "<script>
        alert('Email sudah terdaftar!');
        window.location.href = '../pages/login.php';
    </script>";
} else {
    mysqli_query($connect, "INSERT INTO users (email, username, password, role) VALUES ('$email', '$username', '$password', 'user')");
    echo "<script>
        alert('Registrasi berhasil!');
        window.location.href = '../pages/login.php';
    </script>";
}
?>
