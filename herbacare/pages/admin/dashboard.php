<?php
session_start();
$email = $_SESSION['username'];
if (empty($email)) {
    header("location:login.php?pesan=belum_login");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HerbaCare - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../../css/styleshome.css?v=2">
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
            <a class="nav-link active" href="dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="herbal.php">Herbal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../proses/logout.php">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <main class="hero-section">
  <div class="top-left-note">Did you know that many of today’s pharmaceuticals are based on compounds originally found in plants? Nature has always been humanity’s first pharmacy — and it still holds incredible potential for our health and wellness.</div>
<div class="bottom-left-note">In a world that moves fast, it's easy to lose touch with what your body truly needs. At HerbaCare, we invite you to slow down — and listen..</div>

<div class="bottom-left-note2">Join a growing community of people choosing nature-first remedies. Trust your body. Trust the earth. Trust HerbaCare.</div>

  <div class="hero-center">
    <br><br>
    <h1>WELLNESS
      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BEGINS 
      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WITH A  
      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LEAF
    </h1>
    
  </div>
  
  <div class="herb-image">
    <img src="../../assets/herbmockup.png" alt="Herbal mockup">
  </div>
</main>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
