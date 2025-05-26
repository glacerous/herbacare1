<?php
session_start();
include "../../proses/koneksi.php";

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'verified')) {
    header("Location: ../login.php");
    exit;
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID user tidak valid.";
    exit;
}

$id = intval($_GET['id']);
$user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id = $id"));

if (!$user) {
    echo "User tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile <?= htmlspecialchars($user['username']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/detail_herbalstyles.css?v=2">
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
        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
               <a class="nav-link" href="editrole.php">Edit Role</a>
           </li>
          <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="../../proses/logout.php">Log out</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
    <a href="javascript:history.back()" class="buttonkembali">← Kembali</a>
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <?php if (!empty($user['profile_pic'])): ?>
                <img src="../../uploads/<?= htmlspecialchars($user['profile_pic']) ?>" alt="Foto Profil" class="rounded-circle mb-3" style="width: 150px;">
            <?php else: ?>
                <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="his user has no profile picture">
            <?php endif; ?>
            
            <h2 class="card-title"><?= htmlspecialchars($user['username']) ?></h2>
            <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
            
            <?php if (!empty($user['bio'])): ?>
                <hr>
                <p><strong>Bio:</strong><br><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
