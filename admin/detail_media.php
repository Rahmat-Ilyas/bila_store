<?php 
require('template/header.php');

$kategori = $_GET['view'];
$get_data = mysqli_query($conn, "SELECT * FROM tb_media WHERE kategori = '$kategori'");
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kelolah Gambar & Video</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php">Admin</a></div>
        <div class="breadcrumb-item">Kelolah Gambar & Video</div>
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
              <a href="kelola_media.php" class="btn btn-primary mb-3"><i class="fa fa-reply"></i> Lihat Lainnya</a>
              <hr>
              <div class="gallery">
                <div class="row">
                  <?php foreach ($get_data as $dta) { 
                    if ($dta['ext_type'] == 'Foto') { ?>
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
                          <div class="row px-3">
                            <div class="col-md-6 p-0 border">
                              <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-edit<?= $dta['id'] ?>"><i class="fa fa-edit"></i> Edit</a>
                            </div>
                            <div class="col-md-6 p-0 border">
                              <a href="#" id="btn-hapus" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-hapus" data-id="<?= $dta['id'] ?>"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                          </div>
                        </article>
                      </div>
                    <?php } else { ?>
                      <div class="col-md-3 mb-4">
                        <div class="videoArea">
                          <video style="height: 170px; width: 100%; margin-bottom: -6px;" class="bg-dark" id="videoPlay" title="<?= $dta['label'] ?>"><source src="../front/img/produk/<?= $dta['file_media'] ?>" type="">
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
                        <div class="row px-3">
                          <div class="col-md-6 p-0 border">
                            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-edit<?= $dta['id'] ?>"><i class="fa fa-edit"></i> Edit</a>
                          </div>
                          <div class="col-md-6 p-0 border">
                            <a href="#" id="btn-hapus" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-hapus" data-id="<?= $dta['id'] ?>"><i class="fas fa-trash"></i> Hapus</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
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

<?php foreach ($get_data as $dta) { ?>
  <!-- MODAL EDIT -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modal-edit<?= $dta['id'] ?>">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Media</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" class="formUpdate" form-id="<?= $dta['id'] ?>">
          <div class="modal-body px-5" style="margin-bottom: -20px;">
            <div class="form-group">
              <label>Nama Label</label>
              <input type="text" class="form-control" name="label" required autocomplete="off" placeholder="Masukkan Nama Label" value="<?= $dta['label'] ?>">
            </div>
            <div class="form-group">
              <label>Kategori</label>
              <select class="form-control" name="kategori" required="">
                <option value="">--Pilih Kategori--</option>
                <?php 
                $result = mysqli_query($conn, "SELECT * FROM tb_kategori");
                foreach ($result as $ktgr) { ?>
                  <option value="<?= $ktgr['kategori'] ?>" <?php if ($ktgr['kategori'] == $dta['kategori']) echo "selected"; ?>><?= $ktgr['kategori'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Keterangan Harga (Rp)</label>
              <input type="number" class="form-control" name="harga" required autocomplete="off" placeholder="Keterangan Harga (Rp)" value="<?= $dta['harga'] ?>">
            </div>
            <div class="form-group">
              <label>File Media</label>
              <style type="text/css">
                .customlabel {
                  cursor: pointer;
                  display: block;
                  width: 100%;
                  height: calc(2.25rem + 2px);
                  padding: .375rem .75rem;
                  font-size: 1rem;
                  line-height: 1.5;
                  color: #495057;
                  background-color: #fff;
                  background-clip: padding-box;
                  border: 1px solid #ced4da;
                  border-radius: .25rem;
                  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                }

                .customlabel > img {
                  height: 100%;
                }
              </style>
              <label class="customlabel" for="file_media<?= $dta['id'] ?>">
                <?php if ($dta['ext_type'] == 'Foto') { ?>
                  <img class="thumnil-media<?= $dta['id'] ?>" src="../front/img/produk/<?= $dta['file_media'] ?>" >
                <?php } else { ?>
                  <img class="thumnil-media<?= $dta['id'] ?>" src="../assets/img/video-file.png" >
                <?php } ?>
                <span class="name-file<?= $dta['id'] ?>"><?= $dta['file_media'] ?></span>
              </label>
              <input type="file" class="form-control file_media" id="file_media<?= $dta['id'] ?>" hidden="" name="file_media" data-id="<?= $dta['id'] ?>">
              <div class="text-danger cek-media<?= $dta['id'] ?>" hidden=""></div>

              <div class="mt-3 row" style="margin-bottom: -15px;" id="viewProgress<?= $dta['id'] ?>" hidden="">
                <span class="col-6">Mengapload...</span>
                <span class="col-6 text-right"><b><i id="progress<?= $dta['id'] ?>">0%</i></b></span>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <input type="hidden" name="id" value="<?= $dta['id'] ?>">
            <input type="hidden" name="file_old" value="<?= $dta['file_media'] ?>">
            <input type="hidden" name="ext_type" id="ext_type<?= $dta['id'] ?>">
            <input type="hidden" name="old_ext" value="<?= $dta['ext_type'] ?>">
            <input type="hidden" name="req" value="updateData">
            <button type="submit" id="upload<?= $dta['id'] ?>" class="btn btn-primary">Update</button>
            <button type="button" id="batal<?= $dta['id'] ?>" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>

<!-- MODAL HAPUS -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Yakin ingin menghapus?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        Klik "Hapus" untuk melanjutkan menghapus media ini
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-danger btn-shadow" id="btn-delete">Hapus</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#kelola_media').addClass('active');

    $('.modal').modal({
      backdrop: 'static',
      keyboard: false,
      show: false
    });

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

    // DELETE FILE 
    $(document).on('click', '#btn-hapus', function(e) {
      var id = $(this).attr('data-id');
      $('#btn-delete').attr('data-id', id);
    });

    $(document).on('click', '#btn-delete', function() {
      var id = $(this).attr('data-id');

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : { req: 'deleteData', id: id },
        success : function(data) {
          $('#modal-hapus').modal('hide');
          swal({
            title: 'Berhasil terhapus',
            text: 'Data media berhasil dihapus',
            icon: 'success'
          }).then(function() {
            location.href = 'detail_media.php?view=<?= $_GET["view"] ?>';
          });
        }
      });
    });

    // FILE MEDIA VALIDASI
    $('.file_media').change(function() {
      var media = $(this).prop('files')[0];
      var dtId = $(this).attr('data-id');
      var check = 0;

      var ext = ['image/jpeg', 'image/png', 'image/bmp', 'video/3gpp', 'video/mp4', 'video/x-matroska', 'video/x-msvideo', 'video/quicktime'];

      $.each(ext, function(key, val) {
        if (media.type == val) check = check + 1;

        if (media.type == 'image/jpeg' || media.type == 'image/png' || media.type == 'image/bmp') $('#ext_type'+dtId).val('Foto');
        else $('#ext_type'+dtId).val('Video');
      });

      if (check == 1) {
        $('.cek-media'+dtId).attr('hidden', '');

        if ($('#ext_type'+dtId).val() == 'Foto') {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('.thumnil-media'+dtId).attr('src', e.target.result);
          }
          reader.readAsDataURL(this.files[0]);
        }
        else if ($('#ext_type'+dtId).val() == 'Video') 
          $('.thumnil-media'+dtId).attr('src', '../assets/img/video-file.png');

        $('.name-file'+dtId).text(media.name);
      } else {
        $('.cek-media'+dtId).removeAttr('hidden');
        $('.cek-media'+dtId).text('Format file tidak dibolehkan, pilih file lain');
        $(this).val('');
        return;
      }

      if (media.size > 20000000) {
        $('.cek-media'+dtId).removeAttr('hidden');
        $('.cek-media'+dtId).text('Ukuran file minimal 20 Mb, pilih file lain');
        $(this).val('');
      }
    });

    // UPDATE DATA
    $('.formUpdate').submit(function(e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);
      var frId = $(this).attr('form-id');

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : data,
        xhr     : function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;

              $('#viewProgress'+frId).removeAttr('hidden');
              $('#upload'+frId).attr('disabled', '');
              $('#batal'+frId).attr('disabled', '');

              var progress = Math.round(percentComplete * 100);
              $('#progress'+frId).text(progress + '%');
            }
          }, false);
          return xhr;
        },
        contentType : false,
        processData: false,
        success : function(data) {
          $('#viewProgress'+frId).attr('hidden', '');
          $('#upload'+frId).removeAttr('disabled');
          $('#batal'+frId).removeAttr('disabled');
          $('#progress').text('0%');

          swal({
            title: 'Berhasil diupdate',
            text: 'Data baru berhasil diupdate',
            icon: 'success'
          }).then(function() {
            location.href = 'detail_media.php?view=<?= $_GET["view"] ?>';
          });;
        }
      });
    });
  });
</script>
<?php 
require('template/footer.php');
?>