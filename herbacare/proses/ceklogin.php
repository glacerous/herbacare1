<?php
session_start();
include "koneksi.php"; 


$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "<script>
        alert('Username dan Password tidak boleh kosong!');
        window.location.href = '../pages/login.php';
    </script>";
    exit;
}

$data = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($connect));
$user = mysqli_fetch_assoc($data);

if ($user && $password == $user['password']) {
    $_SESSION['user_id'] = $user['id'];

    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        echo "<script>
            alert('Login Berhasil sebagai Admin');
            window.location.href = '../pages/admin/dashboard.php';
        </script>";
    } else if ($user['role'] == 'user') {
        echo "<script>
            alert('Login Berhasil sebagai User');
            window.location.href = '../pages/user/dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Role tidak dikenali!');
            window.location.href = '../pages/login.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Login Gagal! Username atau Password salah.');
        window.location.href = '../pages/login.php';
    </script>";
}
?>
