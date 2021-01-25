<?php 
require('template/header.php');
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
              <h4>Data Gambar & Video</h4>
            </div>
            <div class="card-body">
              <a href="#" class="btn btn-icon btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-camera"></i> Tambah Media</a>
              <hr>
              <div class="row sortable-card ui-sortable" id="showData">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambahkan Media</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="formUpload">
        <div class="modal-body px-5" style="margin-bottom: -20px;">
          <div class="form-group">
            <label>Nama Label</label>
            <input type="text" class="form-control" name="label" required autocomplete="off" placeholder="Masukkan Nama Label">
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select class="form-control" name="kategori" required="">
              <option value="">--Pilih Kategori--</option>
              <?php 
              $result = mysqli_query($conn, "SELECT * FROM tb_kategori");
              foreach ($result as $ktgr) { ?>
                <option value="<?= $ktgr['kategori'] ?>"><?= $ktgr['kategori'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Keterangan Harga (Rp)</label>
            <input type="number" class="form-control" name="harga" required autocomplete="off" placeholder="Keterangan Harga (Rp)">
          </div>
          <div class="form-group">
            <label>File Media</label>
            <input type="file" class="form-control" id="file_media" name="file_media" required>
            <div class="text-danger cek-media" hidden=""></div>

            <div class="mt-3 row" style="margin-bottom: -15px;" id="viewProgress" hidden="">
              <span class="col-6">Mengapload...</span>
              <span class="col-6 text-right"><b><i id="progress">0%</i></b></span>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <input type="hidden" name="ext_type" id="ext_type">
          <input type="hidden" name="req" value="addData">
          <button type="submit" id="upload" class="btn btn-primary">Upload</button>
          <button type="button" id="batal" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#kelola_media').addClass('active');
    
    $('#modal-tambah').modal({
      backdrop: 'static',
      keyboard: false,
      show: false
    });

    // ADD DATA
    $('#formUpload').submit(function(e) {
      e.preventDefault();
      var data = new FormData($('#formUpload')[0]);

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : data,
        xhr     : function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;

              $('#viewProgress').removeAttr('hidden');
              $('#upload').attr('disabled', '');
              $('#batal').attr('disabled', '');

              var progress = Math.round(percentComplete * 100);
              $('#progress').text(progress + '%');
            }
          }, false);
          return xhr;
        },
        contentType : false,
        processData: false,
        success : function(data) {
          viewData();
          $('#viewProgress').attr('hidden', '');
          $('#upload').removeAttr('disabled');
          $('#batal').removeAttr('disabled');
          $('#progress').text('0%');

          swal({
            title: 'Berhasil ditambah',
            text: 'Data baru berhasil ditambah',
            icon: 'success'
          });

          $('#modal-tambah').modal('hide');
        }
      });
    });

    // DELETE FILE 
    $(document).on('click', '#btn-hapus', function() {
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
          viewData();
          $('#modal-hapus').modal('hide');
          swal({
            title: 'Berhasil terhapus',
            text: 'Data media berhasil dihapus',
            icon: 'success'
          });
        }
      });
    });

    // VIEW DATA
    viewData();
    function viewData() {
      var dataTable = $('#dataTable').DataTable();

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : { req: 'viewDataRev' },
        success : function(data) {
          $('#showData').html(data);
          $('#showData').find('.gallery').Chocolat({
            className: 'gallery',
            imageSelector: '.gallery-item',
          });
        }
      });
    }

    // FILE MEDIA VALIDASI
    $('#file_media').change(function() {
      var media = $('#file_media').prop('files')[0];
      var check = 0;

      var ext = ['image/jpeg', 'image/png', 'image/bmp', 'video/3gpp', 'video/mp4', 'video/x-matroska', 'video/x-msvideo', 'video/quicktime'];

      $.each(ext, function(key, val) {
        if (media.type == val) check = check + 1;

        if (media.type == 'image/jpeg' || media.type == 'image/png' || media.type == 'image/bmp') $('#ext_type').val('Foto');
        else $('#ext_type').val('Video');
      });

      if (check == 1) {
        $('.cek-media').attr('hidden', '');
      } else {
        $('.cek-media').removeAttr('hidden');
        $('.cek-media').text('Format file tidak dibolehkan, pilih file lain');
        $(this).val('');
        return;
      }

      if (media.size > 20000000) {
        $('.cek-media').removeAttr('hidden');
        $('.cek-media').text('Ukuran file minimal 5 Mb, pilih file lain');
        $(this).val('');
      }
    });

    $('.modal').on('hidden.bs.modal', function() {
      $('#formUpload').trigger('reset');
    });

    $(document).on('click', '#view-image', function() {
      var id = $(this).attr('data-id');
      $('#setImage').attr('src', '');

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : { req: 'getImage', id: id },
        success : function(data) {
          console.log(data);
          $('#setImage').attr('src', '../front/img/produk/'+data);
        }
      });
    });

  });
</script>
<?php 
require('template/footer.php');
?>