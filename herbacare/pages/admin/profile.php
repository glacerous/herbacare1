<?php
session_start();
include '../../proses/koneksi.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'verified')) {
    header("Location: ../login.php");
    exit;
}


$username = $_SESSION['username'];
$query = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $username_baru = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $bio = mysqli_real_escape_string($connect, $_POST['bio']);

    // Upload pfp
    $profile_pic = $user['profile_pic']; // gunakan foto lama jika tidak upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profile_pic']['tmp_name'];
        $nama_file = time() . '_' . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($tmp_name, "../../uploads/" . $nama_file);
        $profile_pic = $nama_file;
    }

    $update = mysqli_query($connect, "
        UPDATE users 
        SET username='$username_baru', password='$password', bio='$bio', profile_pic='$profile_pic'
        WHERE username='$username'
    ");

    if ($update) {
        $_SESSION['username'] = $username_baru;
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="herbal.php">Herbal</a></li>
        <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
               <a class="nav-link " href="editrole.php">Edit Role</a>
           </li>
          <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="../../proses/logout.php">Log out</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4 header-bar">
        <h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROFILE</h2>
    </div>
  <form method="post" enctype="multipart/form-data" class="profile-form mx-auto" style="max-width: 500px;">
    
    <div class="mb-3 text-center">
      <?php if (!empty($user['profile_pic'])): ?>
        <img src="../../uploads/<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile Picture" style="max-width: 150px;" class="rounded-circle mb-2">
      <?php else: ?>
        <img src="https://via.placeholder.com/150" class="rounded-circle mb-2" alt="Default">
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label class="form-label">Profile Picture</label>
      <input type="file" name="profile_pic" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($user['username']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required value="<?= htmlspecialchars($user['password']) ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Bio</label>
      <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
    </div>

    <button type="submit" name="update" class="button">Update profile</button>
</div>

</body>
</html>
