<?php
session_start();
include "../../proses/koneksi.php";

// Cek ID
if (!isset($_GET['id'])) {
    header("Location: herbal.php");
    exit;
}
$id = intval($_GET['id']);

// Ambil data herbal
$herbal = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM herbal WHERE id = $id"));
if (!$herbal) {
    echo "Data herbal tidak ditemukan.";
    exit;
}

// Tambah komentar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_POST['isi'])) {
    $isi = mysqli_real_escape_string($connect, $_POST['isi']);
    $user_id = $_SESSION['user_id'];
    mysqli_query($connect, "INSERT INTO komentar_herbal (herbal_id, user_id, isi) VALUES ($id, $user_id, '$isi')");
    header("Location: detail_herbal.php?id=$id");
    exit;
}

// Ambil komentar
$komentar_query = mysqli_query($connect, "
    SELECT k.*, u.username 
    FROM komentar_herbal k
    JOIN users u ON k.user_id = u.id
    WHERE k.herbal_id = $id
    ORDER BY k.waktu DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Herbal - <?= htmlspecialchars($herbal['nama']) ?></title>
    <link rel="stylesheet" href="../../css/detail_herbalstyles.css?v=<?= time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../css/styleshome.css?v=4">
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
            <a class="nav-link" href="dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="herbal.php">Herbal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../proses/logout.php">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<body class="bg-light">
    <div class="container py-5">
        <a href="herbal.php" class="btn btn-secondary mb-4">← Kembali ke Daftar Herbal</a>

        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-info"><?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <?php if (!empty($herbal['gambar'])): ?>
                <img src="../../uploads/<?= htmlspecialchars($herbal['gambar']) ?>" 
     alt="Gambar Herbal" 
     class="img-fluid rounded mb-3 d-block mx-auto" 
     style="max-width: 400px; height: auto;">
            <?php endif; ?>
            <div class="card-body">
                <h2 class="card-title"><?= htmlspecialchars($herbal['nama']) ?></h2>
                <p><strong>Penyakit Terkait:</strong><br><?= nl2br(htmlspecialchars($herbal['manfaat'])) ?></p>
                <p><strong>Cara Penggunaan:</strong><br><?= nl2br(htmlspecialchars($herbal['cara_penggunaan'])) ?></p>
            </div>
        </div>

        <div class="card mb-5">
            <div class="card-body">
                <h4 class="card-title">Komentar</h4>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="" method="POST" class="mb-4">
                        <div class="mb-3">
                            <textarea name="isi" class="form-control" rows="3" placeholder="Tulis komentar..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                <?php else: ?>
                    <p>Silakan <a href="../login.php">login</a> untuk memberikan komentar.</p>
                <?php endif; ?>

                <?php if (mysqli_num_rows($komentar_query) > 0): ?>
                    <?php while ($k = mysqli_fetch_assoc($komentar_query)): ?>
                        <div class="komentar-box mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong><?= htmlspecialchars($k['username']) ?></strong>
                                    <small class="text-muted"> | <?= $k['waktu'] ?></small>
                                </div>
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $k['user_id']): ?>
                                    <form action="hapus_komentar.php" method="POST" onsubmit="return confirm('Hapus komentar ini?')" style="margin: 0;">
                                        <input type="hidden" name="id_komentar" value="<?= $k['id'] ?>">
                                        <input type="hidden" name="herbal_id" value="<?= $id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($k['isi'])) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted">Belum ada komentar.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>