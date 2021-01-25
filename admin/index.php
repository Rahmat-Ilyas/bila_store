<?php
require('template/header.php');

$get_total_media = mysqli_query($conn, "SELECT * FROM tb_media");
if ($get_total_media) $total_media = mysqli_num_rows($get_total_media);

$get_total_reseller = mysqli_query($conn, "SELECT * FROM reseller");
if ($get_total_reseller) $total_reseller = mysqli_num_rows($get_total_reseller);

$get_total_kategori = mysqli_query($conn, "SELECT * FROM tb_kategori");
if ($get_total_kategori) $total_kategori = mysqli_num_rows($get_total_kategori);
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Admin</a></div>
        <div class="breadcrumb-item">Dashboard</div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <a href="kelola_media.php">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-camera"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Foto & Video</h4>
              </div>
              <div class="card-body"><?= $total_media ?></div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="kategori.php">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-list"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Lisat Kategori</h4>
              </div>
              <div class="card-body"><?= $total_kategori ?></div>
            </div>
          </div>
        </a>
      </div> 
      <div class="col-md-4">
        <a href="reseler_mendaftar.php">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Reseller yang Mendaftar</h4>
              </div>
              <div class="card-body"><?= $total_reseller ?></div>
            </div>
          </div>
        </a>
      </div>                 
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 mb-4">
          <div class="hero bg-primary text-white">
            <div class="hero-inner">
              <h2>Selamat Datang Administrator</h2>
              <p class="lead">Selamat datang di Halaman Reporter. Semoga harimu menyenagkan.</p>
              <div class="mt-4">
                <a href="#" class="btn btn-outline-white btn-lg btn-icon icon-left" data-toggle="modal" data-target="#modal-admin"><i class="far fa-user"></i> Setup Account</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    $('#dashboard').addClass('active');
  });
</script>
<?php 
require('template/footer.php');
?>