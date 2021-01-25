<?php
require('template/header.php');

$get_foto = mysqli_query($conn, "SELECT * FROM tb_media WHERE ext_type = 'Foto'");
if ($get_foto) $foto = mysqli_num_rows($get_foto);

$get_video = mysqli_query($conn, "SELECT * FROM tb_media WHERE ext_type = 'Video'");
if ($get_video) $video = mysqli_num_rows($get_video);
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Reseller</a></div>
        <div class="breadcrumb-item">Dashboard</div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <a href="foto_produk.php">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-file-image"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Foto</h4>
              </div>
              <div class="card-body"><?= $foto ?></div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-6">
        <a href="data_video.php">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-file-video"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Video</h4>
              </div>
              <div class="card-body"><?= $video ?></div>
            </div>
          </div>
        </a>               
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