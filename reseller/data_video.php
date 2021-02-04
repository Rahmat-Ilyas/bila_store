<?php 
require('template/header.php');

$result = mysqli_query($conn, "SELECT * FROM tb_media WHERE ext_type = 'Video'");
$kategori = [];
foreach ($result as $dta) {
  $kategori[] = $dta['kategori'];
}
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
              <div id="accordion">
                <?php  $i=1; foreach (array_unique($kategori) as $kat) { 
                  if ($i == 1) {
                    $show = 'show';
                    $arial = 'true';
                  }
                  else {
                    $show = '';
                    $arial = 'false';
                  } ?>
                  <div class="accordion">
                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#<?= $i ?>" aria-expanded="<?= $arial ?>">
                      <h4>Vide Produk (<?= $kat ?>)</h4>
                    </div>
                    <div class="accordion-body collapse <?= $show ?>" id="<?= $i ?>" data-parent="#accordion">
                      <div class="row">
                        <?php 
                        $get_data = mysqli_query($conn, "SELECT * FROM tb_media WHERE kategori = '$kat' AND ext_type='Video'"); 
                        foreach ($get_data as $dta) { ?>
                          <div class="col-md-3 mb-4">
                            <div class="videoArea">
                              <video style="height: 170px; width: 100%; margin-bottom: -8px;" class="bg-dark" id="videoPlay" title="<?= $dta['label'] ?>"><source src="../front/img/produk/<?= $dta['file_media'] ?>" type="">
                              </video>
                              <div style="position: absolute; top: 20%; left: 40%;">
                                <button class="btn btn-lg btn-primary controlVideo" style="border-radius: 60%; height: 60px;"><i class="fa fa-play fa-lg"></i></button>
                              </div>
                              <style type="text/css">
                                @media (min-width: 768px) {
                                  #setukuran {
                                    position: absolute; bottom: 25%; left: 10%; z-index: 1;
                                  }
                                }
                                @media (max-width: 768px) {
                                  #setukuran {
                                    position: absolute; bottom: 35%; left: 10%; z-index: 1;
                                  }
                                }
                              </style>
                            </div>
                            <div class="shadow" id="setukuran" style="">
                              <h2 class="mb-0 text-white" style="text-shadow: 1px 1px #6c757d; font-size: 16px;"><?= $dta['label'] ?></h2>
                              <span class="text-white mt-0"><b>Harga: Rp. <?= $dta['harga'] ?></b></span>
                            </div>
                            <a href="../front/img/produk/<?= $dta['file_media'] ?>" download="<?= $dta['file_media'] ?>" class="btn btn-primary btn-block" style="border-radius: 0px;"><b><i class="fas fa-download"></i> Download Video</b></a>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php $i=$i+1; } ?>
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

      $('.controlVideo').click(function(e) {
        e.preventDefault();
        var video = $(this).parents('.videoArea').find('video')[0];
        $('.controlVideo').find('.fa').removeClass('fa-pause').addClass('fa-play');
        if (video.paused) {
          video.play();
          $(this).find('.fa').removeClass('fa-play').addClass('fa-pause');

          var allVideo = $('.videoArea').find('video');
          $.each(allVideo, function(index, vid) {
            if (video != vid) vid.pause();
          });
          $('.controlVideo').fadeIn();
          $(this).fadeOut('slow');
        } else {
          video.pause();
          $(this).find('.fa').removeClass('fa-pause').addClass('fa-play');
        }
      });

      $('.videoArea').mouseleave(function(e) {
        var video = $(this).find('video')[0];
        if (!video.paused) {
          $(this).find('.controlVideo').fadeOut('slow');
        }
      });

      $('.videoArea').mouseenter(function(e) {
        $(this).find('.controlVideo').show();
      });

      $('.videoArea').click(function(e) {
        $(this).find('.controlVideo').toggle();
        var video = $(this).find('video')[0];
        if (video.paused) {
          $(this).find('.controlVideo').show();
        }
      });

      $('video').on('ended', function() {
        $('.controlVideo').fadeIn().find('.fa').removeClass('fa-pause').addClass('fa-play');
      });
    });
  </script>
  <?php 
  require('template/footer.php');
  ?>