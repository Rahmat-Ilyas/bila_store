<?php 
require('../config.php');

if (isset($_POST['req'])) {
	header('Content-type: application/json');
	if($_POST['req'] == 'viewDataRev') {
		$result = mysqli_query($conn, "SELECT * FROM tb_media");
		$kategori = [];
		foreach ($result as $dta) {
			$kategori[] = $dta['kategori'];
		}

		$html = '';
		foreach (array_unique($kategori) as $kat) {
			$item = '';
			$jmlh = 1;
			$data = mysqli_query($conn, "SELECT * FROM tb_media WHERE kategori='$kat' AND ext_type='Foto' ORDER BY id DESC");
			$more = mysqli_num_rows($data) - 7;
			foreach ($data as $dta) {
				if ($jmlh < 8) {
					$item .= '<div class="gallery-item" data-image="../front/img/produk/'.$dta['file_media'].'" data-title="'.$dta['label'].'" href="../front/img/produk/'.$dta['file_media'].'" title="'.$dta['label'].'" style="background-image: url(&quot;../front/img/produk/'.$dta['file_media'].'&quot;);"></div>';
				} else if ($jmlh == 8) {
					$item .= '<div class="gallery-item gallery-more" data-image="../front/img/produk/'.$dta['file_media'].'" data-title="'.$dta['label'].'" href="../front/img/produk/'.$dta['file_media'].'" title="'.$dta['label'].'" style="background-image: url(&quot;../front/img/produk/'.$dta['file_media'].'&quot;);"><div>+'.$more.'</div></div>';
				} else {
					$item .= '<div class="gallery-item gallery-hide" data-image="../front/img/produk/'.$dta['file_media'].'" data-title="'.$dta['label'].'" href="../front/img/produk/'.$dta['file_media'].'" title="'.$dta['label'].'" style="background-image: url(&quot;../front/img/produk/'.$dta['file_media'].'&quot;);"></div>';
				}

				$jmlh = $jmlh + 1;
			}

			$html .= '<div class="col-12 col-md-6 col-lg-4"><div class="card card-primary border-right border-left border-bottom"><div class="card-header ui-sortable-handle"><h4>'.$kat.'</h4><div class="card-header-action"><a href="detail_media.php?view='.$kat.'" class="btn btn-primary">View Detail</a></div></div><div class="card-body"><div class="gallery">'.$item.'</div></div></div></div>';
		}

		echo json_encode($html);
	}
}
?>