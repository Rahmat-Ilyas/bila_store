<?php 
require('template/header.php');

$kategori = $_GET['view'];
$get_data = mysqli_query($conn, "SELECT * FROM tb_media WHERE kategori = '$kategori' AND ext_type='Foto'");
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Download Foto Produk</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php">Reseller</a></div>
        <div class="breadcrumb-item">Download Foto Produk</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Produk Perkategori (<?= $_GET['view'] ?>)</h4>
            </div>
            <div class="card-body">
              <a href="foto_produk.php" class="btn btn-primary mb-3"><i class="fa fa-reply"></i> Lihat Lainnya</a>
              <hr>
              <div class="gallery">
                <div class="row">
                  <?php foreach ($get_data as $dta) { ?>
                    <div class="col-md-3">
                      <article class="article">
                        <div class="article-header">
                          <div class="gallery-item" data-image="../front/img/produk/<?= $dta['file_media'] ?>" data-title="<?= $dta['label'] ?>" style="height: 100%; width: 100%;">
                          </div>
                          <div class="article-title shadow">
                            <h2 class="mb-0" style="text-shadow: 1px 1px #6c757d;"><a href="javascript:void(0);"><?= $dta['label'] ?></a></h2>
                            <span class="text-white mt-0"><b>Harga: Rp. <?= $dta['harga'] ?></b></span>
                          </div>
                        </div>
                        <a href="../front/img/produk/<?= $dta['file_media'] ?>" download="<?= $dta['file_media'] ?>" class="btn btn-primary btn-block" style="border-radius: 0px;"><b><i class="fas fa-download"></i> Download Foto</b></a>
                      </article>
                    </div>
                  <?php } 
                  if (mysqli_num_rows($get_data) <= 0) { ?>
                    <div class="col-md-12 text-center mt-2">
                      <h4><i>Tidak ada data/kategori tidak sesuai</i></h4>
                    </div>
                  <?php } ?>
                </div>
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
    $('#foto_produk').addClass('active');
  });
</script>
<?php 
require('template/footer.php');
?>