<?php 
require('template/header.php');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Reseller Mendftar</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="index.php">Admin</a></div>
        <div class="breadcrumb-item">Reseller Mendftar</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Data Reseller Mendftar</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="dataTable">
                  <thead>                                 
                    <tr>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>WhatsApp</th>
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
  </section>
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
        Klik "Hapus" untuk melanjutkan menghapus data ini
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
    $('#reseler_mendaftar').addClass('active');

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
        data    : { req: 'deleteReseller', id: id },
        success : function(data) {
          viewData();
          $('#modal-hapus').modal('hide');
          swal({
            title: 'Berhasil terhapus',
            text: 'Data reseler pendaftar berhasil dihapus',
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
        data    : { req: 'dataReseller' },
        success : function(data) {
          dataTable.clear().draw();
          $.each(data, function(key, val) {
            dataTable.row.add([
              val.nama,
              val.alamat,
              `<i class="icofont-whatsapp" style="color: #128c7e;"></i> <a target="_blank" href="https://wa.me/`+ val.no_telepon +`">`+ val.no_telepon +`</a>`,
              `<a href="#" id="btn-hapus" class="btn btn-icon btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus" data-id="`+ val.id +`"><i class="fas fa-trash"></i> Hapus Data</a>`,
              ]).draw(false);
          });
        }
      });
    }

  });
</script>
<?php 
require('template/footer.php');
?>