<?php 
require('template/header.php');

$get_foto = mysqli_query($conn, "SELECT * FROM tb_media WHERE ext_type = 'Video'");
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Download Video</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php">Reseller</a></div>
        <div class="breadcrumb-item">Download Video</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Video</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <?php foreach ($get_foto as $dta) { ?>
                  <div class="col-md-3 mb-4">
                    <video style="height: 150px; width: 100%; margin-bottom: -6px;" class="bg-dark" controls><source src="../front/img/produk/<?= $dta['file_media'] ?>" type="">
                    </video>
                    <a href="../front/img/produk/<?= $dta['file_media'] ?>" download="<?= $dta['file_media'] ?>" class="btn btn-primary btn-block" style="border-radius: 0px;"><b><i class="fas fa-download"></i> Download Video</b></a>
                  </div>
                <?php } ?>
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
    $('#data_video').addClass('active');
  });
</script>
<?php 
require('template/footer.php');
?>