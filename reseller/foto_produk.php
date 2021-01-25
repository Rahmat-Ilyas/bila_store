<?php 
require('template/header.php');

$get_foto = mysqli_query($conn, "SELECT * FROM tb_media WHERE ext_type = 'Foto'");
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
              <h4>Data Foto Produk</h4>
            </div>
            <div class="card-body">
              <div class="row sortable-card ui-sortable" id="showData">

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
  });
</script>
<?php 
require('template/footer.php');
?>