<?php 
require('template/header.php');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kategori</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php">Admin</a></div>
        <div class="breadcrumb-item">Kategori</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Kelola Kategori</h4>
            </div>
            <div class="card-body">
              <a href="#" class="btn btn-icon btn-primary mb-4" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-list"></i> Tambah Kategori</a>
              <div class="table-responsive row">
                <div class="col-sm-8">
                  <table class="table table-striped" id="dataTable">
                    <thead>                                 
                      <tr>
                        <th width="5">No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>        

                    </tbody>
                  </table>
                </div>
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
        <h5 class="modal-title">Tambahkan Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="formSubmit">
        <div class="modal-body px-5" style="margin-bottom: -20px;">
          <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" class="form-control" name="kategori" required autocomplete="off" placeholder="Masukkan Nama Kategori">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <input type="hidden" name="req" value="addDataKtgr">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="formEdit">
        <div class="modal-body px-5" style="margin-bottom: -20px;">
          <div class="form-group">
            <label>Nama Kategori</label>
            <input type="hidden" name="id" id="edt_id">
            <input type="text" class="form-control" id="edt_kategori" name="kategori" required autocomplete="off" placeholder="Masukkan Nama Kategori">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <input type="hidden" name="req" value="editKtgr">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
    $('#kategori').addClass('active');
    
    $('#modal-tambah').modal({
      backdrop: 'static',
      keyboard: false,
      show: false
    });

    // ADD DATA
    $('#formSubmit').submit(function(e) {
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : data,
        success : function(data) {
          viewData();
          swal({
            title: 'Berhasil ditambah',
            text: 'Data baru berhasil ditambah',
            icon: 'success'
          });
          $('#modal-tambah').modal('hide');
        }
      });
    });

    // EDIT KATEGORI
    $(document).on('click', '#btn-edit', function() {
      var id = $(this).attr('data-id');
      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : { req: 'getDataKtgr', id: id },
        success : function(data) {
          $('#edt_id').val(data.id);
          $('#edt_kategori').val(data.kategori);
        }
      });
    });

    $('#formEdit').submit(function(e) {
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url     : 'controller.php',
        method  : "POST",
        data    : data,
        success : function(data) {
          viewData();
          swal({
            title: 'Berhasil diupdate',
            text: 'Data baru berhasil diupdate',
            icon: 'success'
          });
          $('#modal-edit').modal('hide');
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
        data    : { req: 'deleteDataKtgr', id: id },
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
        data    : { req: 'viewDataKategori' },
        success : function(data) {
          dataTable.clear().draw();
          var no = 1;
          $.each(data, function(key, val) {
            dataTable.row.add([
              no,
              val.kategori,
              `<div class="text-center">
              <a href="#" id="btn-edit" class="btn btn-icon btn-sm btn-success" data-toggle="modal" data-target="#modal-edit" data-id="`+ val.id +`"><i class="fas fa-edit"></i> Edit</a>
              <a href="#" id="btn-hapus" class="btn btn-icon btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus" data-id="`+ val.id +`"><i class="fas fa-trash"></i> Hapus</a>
              </div>`,
              ]).draw(false);
            no = no + 1;
          });
        }
      });
    }

    $('.modal').on('hidden.bs.modal', function() {
      $('#formSubmit').trigger('reset');
    });

  });
</script>
<?php 
require('template/footer.php');
?>