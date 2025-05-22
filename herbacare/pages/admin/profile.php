<?php
session_start();
include '../../proses/koneksi.php'; // Pastikan path sesuai

// Ambil username dari session
$username = $_SESSION['username'];

// Ambil data user dari database
$query = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($query);

// Proses update profil
if (isset($_POST['update'])) {
    $username_baru = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    $update = mysqli_query($connect, "UPDATE users SET password='$password', username='$username_baru' WHERE username='$username'");

    if ($update) {
        $_SESSION['username'] = $username_baru; // Update session jika username berubah
        echo "<script>alert('Profil berhasil diupdate!');window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal update profil!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../css/profilestyles.css?v=2">
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
            <a class="nav-link " href="dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="herbal.php">Herbal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../proses/logout.php">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 header-bar">
        <h2> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROFILE</h2>
    </div>
    <form method="post" class="profile-form">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" name="username" id="username"
                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" name="password" id="password"
                   value="<?php echo htmlspecialchars($user['password']); ?>" required>
        </div>
        <button type="submit" name="update" class="button">Update profile</button>
    </form>
</div>
</body>
</html>