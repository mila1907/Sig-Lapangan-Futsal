<?php
session_start();
require "functions.php";

$loggedIn = isset($_SESSION['role']);

if ($loggedIn) {

  $id_user = $_SESSION["id_user"];

  // Melakukan query hanya jika $_SESSION["id_user"] sudah terdefinisi
  $profil = query("SELECT * FROM user_212279 WHERE 212279_id_user = '$id_user'")[0];
}

$lapangan = query("SELECT * FROM lapangan_212279");

if (isset($_POST["simpan"])) {
  if (edit($_POST) > 0) {
    echo "<script>
          alert('Berhasil Diubah');
          </script>";
  } else {
    echo "<script>
          alert('Gagal Diubah');
          </script>";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SIG Lapangan Futsal</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logoo.png" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Beranda<br></a></li>
          <li><a href="user/lapangan.php">Lapangan</a></li>
          <?php if ($loggedIn) : ?>
            <li class="nav-item">
              <a class="nav-link" href="user/pesanan.php">Pesanan</a>
            </li>
          <?php endif; ?>
          <li><a href="user/promo.php">Maps</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <?php if ($loggedIn) : ?>
        <!-- Jika sudah login, tampilkan tombol profil -->
        <a class="btn-getstarted" data-bs-toggle="modal" data-bs-target="#profilModal">
          <i class="bi bi-person"></i> Profil
        </a>
      <?php else : ?>
        <!-- Jika belum login, tampilkan tombol login -->
        <a href="login.php" class="btn-getstarted" type="submit">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </a>
      <?php endif; ?>


    </div>
  </header>

  <!-- Modal Profil -->
  <div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profilModalLabel">Profil Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="row">
              <div class="col-4 my-5">
                <img src="img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col-8">
                <h5 class="mb-3"><?= $profil["212279_nama_lengkap"]; ?></h5>
                <p><?= $profil["212279_jenis_kelamin"]; ?></p>
                <p><?= $profil["212279_email"]; ?></p>
                <p><?= $profil["212279_no_handphone"]; ?></p>
                <p><?= $profil["212279_alamat"]; ?></p>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
                <a href="" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-inti">Edit Profil</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Profil -->

  <!-- Edit profil -->
  <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog edit modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfilModalLabel">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="fotoLama" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_foto"]; ?>">
          <div class="modal-body">
            <div class="row justify-content-center align-items-center">
              <div class="mb-3">
                <img src="img/<?= $profil["212279_foto"]; ?>" alt="Foto Profil" class="img-fluid ">
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                  <input type="text" name="212279_nama_lengkap" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_nama_lengkap"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if ($profil['212279_jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($profil['212279_jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col">
              <div class="mb-3">
                  <label for="212279_no_handphone" class="form-label">No Telp</label>
                  <input type="number" name="212279_no_handphone" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_no_handphone"]; ?>">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_email"]; ?>">
                </div>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">alamat</label>
                <input type="text" name="212279_alamat" class="form-control" id="exampleInputPassword1" value="<?= $profil["212279_alamat"]; ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Foto : </label>
                <input type="file" name="212279_foto" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-inti" name="simpan" id="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Edit Modal -->

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="assets/img/bolaa.webp" alt="" data-aos="fade-in">

      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">Lapangan Tersedia<br>Semangat Main Tak Terbatas!!! <span class="text-"> <br>Ayoo Booking Lapangan Futsal Sekarang </span> <br> Dan Rasakan Serunya Bermain Bersama Teman-Teman</h2>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="user/lapangan.php" class="btn-get-started">Booking Sekarang <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2 my-auto" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/bolaku.jpg" width="800" height="500" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>SIG Lapangan Futsal</h3>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Dengan Web GIS penyewaan lapangan futsal, temukan lapangan dalam satu platform. Cek lokasi dan booking tanpa ribet.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Main futsal tak perlu ribet! Sewa lapangan kami dan nikmati waktu bermain dengan kualitas lapangan yang mendukung performa.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Sewa lapangan futsal ddengan mudah, nyaman, dan cepat! Tempat terbaik untuk measakan adrenelin pertandingan atau sekedar bermain santai.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Siapkan tim, kami siapkan lapangan! Lapangan futsal terbaik untuk latihan, turnamen, atau pertandingan persahabatan.</span></li>
            </ul
          </div>


        </div>

      </div>

    </section><!-- /About Section -->

      <div class="container">

        <div class="row gy-4">
          <?php foreach ($lapangan as $row) : ?>

            <div class="col-6 col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
              <div class="course-item">
                <img src="img/<?= $row["212279_foto"]; ?>" class="img-fluid" alt="...">
                <div class="course-content">
                  <p class="category">Lapangan</p>
                </div>
                <div class="p-3 text-content">
                  <h3><a href="course-details.html"><?= $row["212279_nama"]; ?></a></h3>
                  <p class="description"><?= $row["212279_keterangan"]; ?></p>
                </div>
              </div>
            </div>

          <?php endforeach; ?>

        </div>

      </div>

    </section><!-- /Courses Section -->

  </main>

  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-6 col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
           
        </div>

        <div class=" col-6 col-lg-4 col-md-6 footer-links">
          <h4>Navigasi</h4>
          <div class="row">
            <div class="col-6 col-lg-4">
              <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Lapangan</a></li>
                <li><a href="#">Maps</a></li>
              </ul>
            </div>
          </div>
        </div>


        <div class="col-6 col-lg-4 col-md-6 footer-links">
          <h4>Syarat & Ketentuan</h4>
          <ul>
            <li><a href="#">Lihat Syarat & Ketentuan</a></li>
          </ul>
        </div>

      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>