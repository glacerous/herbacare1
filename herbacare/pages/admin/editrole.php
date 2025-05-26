<?php
session_start();
include "../../proses/koneksi.php";

if (!isset($_SESSION['username'])) {
    header("location:../login.php?pesan=belum_login");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("ACCESS DENIED.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['role'])) {
    $id = intval($_POST['id']);
    $role = in_array($_POST['role'], ['user', 'admin', 'verified']) ? $_POST['role'] : 'user';

    $query = mysqli_query($connect, "UPDATE users SET role='$role' WHERE id=$id");

    if (!$query) {
        $msg = "Gagal update role: " . mysqli_error($connect);
    }
}

$result = mysqli_query($connect, "SELECT id, username, role FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Role User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../css/editrolestyles.css?v=2">
</head>
<body style="font-family: 'Poppins', sans-serif;">
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid"> 
    <a class="navbar-brand fw-bold" href="#">HerbaCare</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="herbal.php">Herbal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="editrole.php">Edit Role</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../proses/logout.php">Log out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4 header-bar">
        <h2> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EDIT USERS</h2>
    </div>
  <?php if (isset($msg)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <table class="table table-bordered">
      <thead>
          <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Role Sekarang</th>
              <th>Ubah Role</th>
          </tr>
      </thead>
      <tbody>
      <?php while ($user = mysqli_fetch_assoc($result)): ?>
          <tr>
              <td><?= $user['id'] ?></td>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= $user['role'] ?></td>
              <td>
                  <form method="POST" class="d-flex">
                      <input type="hidden" name="id" value="<?= $user['id'] ?>">
                      <select name="role" class="form-select me-2">
                          <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                          <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                          <option value="verified" <?= $user['role'] === 'verified' ? 'selected' : '' ?>>Verified</option>
                      </select>
                      <button type="submit" class="btn btn-primary btn-sm">Update</button>
                  </form>
              </td>
          </tr>
      <?php endwhile; ?>
      </tbody>
  </table>
</div>
