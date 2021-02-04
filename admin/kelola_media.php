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
<div class="modal fade" role="dialog" id="modal-tambah">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambahkan Media</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </form>
    <form method="POST" id="formUpload">
      <div class="modal-body px-5" style="margin-bottom: -20px;">
        <div class="form-group">
          <label>Kategori</label>
          <select class="form-control" name="kategori" id="set-kategori" required="">
            <option value="">--Pilih Kategori--</option>
            <?php 
            $result = mysqli_query($conn, "SELECT * FROM tb_kategori");
            foreach ($result as $ktgr) { ?>
              <option value="<?= $ktgr['kategori'] ?>"><?= $ktgr['kategori'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label>File Media</label>
          <div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>
        </div>
        <div class="form-group">
          <div class="mt-3 row" style="margin-bottom: -15px;" id="viewProgress" hidden="">
            <span class="col-6">Mengapload...</span>
            <span class="col-6 text-right"><b><i id="progress">0%</i></b></span>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
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
    var formData = new FormData();
    var chek = 0;
    $(".dropzone-previews").dropzone({ 
      url: "controller.php",
      paramName: 'file[]',
      maxFilesize: 20,
      acceptedFiles: 'image/*, video/*',
      dictDefaultMessage: 'Klik untuk memilih file',
      // addRemoveLinks: true,
      dictRemoveFile: '<a href="#" class="btn btn-link btn-sm"><i class="fa fa-trash"></i> Hapus</a>',
      accept: function(file, done) {
        if (file) {
          console.log(file);
          Swal.fire({
            title: "Tambah Deskripsi Media",
            html: `<form id="thisalatKembali">
                    <div class="text-left">
                      <div class="form-group row justify-content-center">
                        <div class="col-sm-10">
                          <label>Nama Label</label>
                          <input id="swal-lable" type="text" class="form-control" required="" name="label" placeholder="Masukkan Nama Label.." autocomplete="off">
                        </div>
                        <div class="col-sm-10 mt-4">
                          <label>Keterangan Harga (Rp)</label>
                          <input id="swal-harga" type="number" class="form-control" required="" name="harga" placeholder="Keterangan Harga (Rp)..">
                        </div>
                      </div>
                    </div>
                  </form>`,
            confirmButtonText: 'Selesai&nbsp<i class="fa fa-check"></i>',
            focusConfirm: false,
            preConfirm: () => {
              var data = {};
              data.label = document.getElementById('swal-lable').value;
              data.harga = document.getElementById('swal-harga').value;
              return data;
            }
          }).then((result) => {
            if (!result.value || result.value.label == '' || result.value.harga == '') {
              Swal.fire({
                title: 'Inputan Kosong',
                text: 'Inputan tidak boleh kosong. Silahkan pilh kembali!',
                type: 'warning'
              });
              this.removeFile(file);
            } else {
              formData.append('file_media[]', file);
              formData.append('label[]', result.value.label);
              formData.append('harga[]', result.value.harga);
              if (file.type == 'image/jpeg' || file.type == 'image/png' || file.type == 'image/bmp') formData.append('ext_type[]', 'Foto');
              else formData.append('ext_type[]', 'Video');
              chek = chek + 1;
            }
          });
          done();
        }
      },
      error: function(file, error) {
        Swal.fire({
          title: 'Terjadi Kesalahan',
          text: error,
          type: 'error'
        });
        this.removeFile(file);
      }
    });

    $('#kelola_media').addClass('active');
    
    $('#modal-tambah').modal({
      backdrop: 'static',
      keyboard: false,
      show: false
    });

    // ADD DATA
    $('#formUpload').submit(function(e) {
      e.preventDefault();
      if (chek == 0) {
        Swal.fire({
          title: 'Belum Ada File!',
          text: 'Pastikan anda telah melampirkan file media',
          type: 'warning'
        });
        return
      }
      formData.append('req', 'addData');
      formData.append('kategori', $('#set-kategori').val());
      var data = formData;

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

          Swal.fire({
            title: 'Berhasil ditambah',
            text: 'Data baru berhasil ditambah',
            type: 'success'
          });

          Dropzone.forElement(".dropzone-previews").removeAllFiles(true);
          formData = new FormData();
          chek = 0;
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
          Swal.fire({
            title: 'Berhasil terhapus',
            text: 'Data media berhasil dihapus',
            type: 'success'
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