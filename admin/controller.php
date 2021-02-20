<?php 
require('../config.php');

if (isset($_POST['req'])) {
	header('Content-type: application/json');
	if($_POST['req'] == 'viewData') {
		$result = mysqli_query($conn, "SELECT * FROM tb_media ORDER BY id DESC");
		$data = [];
		foreach ($result as $dta) {
			$dta['tanggal'] = date('d F Y', strtotime($dta['tanggal']));
			$data[] = $dta;
		}
		echo json_encode($data);
	} else if($_POST['req'] == 'viewDataRev') {
		$result = mysqli_query($conn, "SELECT * FROM tb_media");
		$kategori = [];
		foreach ($result as $dta) {
			$kategori[] = $dta['kategori'];
		}

		$html = '';
		foreach (array_unique($kategori) as $kat) {
			$item = '';
			$jmlh = 1;
			$data = mysqli_query($conn, "SELECT * FROM tb_media WHERE kategori='$kat' ORDER BY id DESC");
			$more = mysqli_num_rows($data) - 7;
			foreach ($data as $dta) {
				if ($jmlh < 8) {
					if ($dta['ext_type'] == 'Foto') {
						$item .= '<div class="gallery-item" data-image="../front/img/produk/'.$dta['file_media'].'" data-title="'.$dta['label'].'" href="../front/img/produk/'.$dta['file_media'].'" title="'.$dta['label'].'" style="background-image: url(&quot;../front/img/produk/'.$dta['file_media'].'&quot;);"></div>';
					} else {
						$item .= '<div class="gallery-item" data-image="../assets/img/video-file.png" data-title="'.$dta['label'].'" href="../assets/img/video-file.png" title="'.$dta['label'].'" style="background-image: url(&quot;../assets/img/video-file.png&quot;);"></div>';
					}
				} else if ($jmlh == 8) {
					if ($dta['ext_type'] == 'Foto') {
						$item .= '<div class="gallery-item gallery-more" data-image="../front/img/produk/'.$dta['file_media'].'" data-title="'.$dta['label'].'" href="../front/img/produk/'.$dta['file_media'].'" title="'.$dta['label'].'" style="background-image: url(&quot;../front/img/produk/'.$dta['file_media'].'&quot;);"><div>+'.$more.'</div></div>';
					} else {
						$item .= '<div class="gallery-item gallery-more" data-image="../assets/img/video-file.png" data-title="'.$dta['label'].'" href="../assets/img/video-file.png" title="'.$dta['label'].'" style="background-image: url(&quot;../assets/img/video-file.png&quot;);"><div>+'.$more.'</div></div>';
					}
				} else {
					if ($dta['ext_type'] == 'Foto') {
						$item .= '<div class="gallery-item gallery-hide" data-image="../front/img/produk/'.$dta['file_media'].'" data-title="'.$dta['label'].'" href="../front/img/produk/'.$dta['file_media'].'" title="'.$dta['label'].'" style="background-image: url(&quot;../front/img/produk/'.$dta['file_media'].'&quot;);"></div>';
					} else {
						$item .= '<div class="gallery-item gallery-hide" data-image="../assets/img/video-file.png" data-title="'.$dta['label'].'" href="../assets/img/video-file.png" title="'.$dta['label'].'" style="background-image: url(&quot;../assets/img/video-file.png&quot;);"></div>';
					}
				}

				$jmlh = $jmlh + 1;
			}

			$html .= '<div class="col-12 col-md-6 col-lg-4"><div class="card card-primary border-right border-left border-bottom"><div class="card-header ui-sortable-handle"><h4>'.$kat.'</h4><div class="card-header-action"><a href="detail_media.php?view='.$kat.'" class="btn btn-primary">View Detail</a></div></div><div class="card-body"><div class="gallery">'.$item.'</div></div></div></div>';
		}

		echo json_encode($html);
	} else if($_POST['req'] == 'addData') {
		$label = $_POST['label'];
		$harga = $_POST['harga'];
		$kategori = $_POST['kategori'];
		$ext_type = $_POST['ext_type'];

		foreach ($ext_type as $i => $lab) {
			$no = $i + 1;
			$label_fix = $label.'-'.$no;
			// SET FOTO 
			$media = $_FILES['file_media']['name'][$i];
			$tanggal = date('Y-m-d H:i:s');
			$ext = pathinfo($media, PATHINFO_EXTENSION);
			$file_name = str_replace(' ', '-', $label_fix)."-".time().".".$ext;
			$file_tmp = $_FILES['file_media']['tmp_name'][$i];

    		// TAMBAH DATA 
			$query = "INSERT INTO tb_media VALUES (NULL, '$label_fix', '$harga', '$kategori', '$file_name', '$ext_type[$i]', '$tanggal')";
			mysqli_query($conn, $query);
			if (mysqli_affected_rows($conn) > 0) {
				move_uploaded_file($file_tmp, '../front/img/produk/'.$file_name);
			} else {
				var_dump(mysqli_error($conn));
			}
		}
		echo json_encode(false);
		// $label = $_POST['label'];
		// $harga = $_POST['harga'];
		// $kategori = $_POST['kategori'];
		// $ext_type = $_POST['ext_type'];

		// foreach ($label as $i => $lab) {
		// 	// SET FOTO 
		// 	$media = $_FILES['file_media']['name'][$i];
		// 	$tanggal = date('Y-m-d H:i:s');
		// 	$ext = pathinfo($media, PATHINFO_EXTENSION);
		// 	$file_name = str_replace(' ', '-', $label[$i])."-".time().".".$ext;
		// 	$file_tmp = $_FILES['file_media']['tmp_name'][$i];

  //   		// TAMBAH DATA 
		// 	$query = "INSERT INTO tb_media VALUES (NULL, '$label[$i]', '$harga[$i]', '$kategori', '$file_name', '$ext_type[$i]', '$tanggal')";
		// 	mysqli_query($conn, $query);
		// 	if (mysqli_affected_rows($conn) > 0) {
		// 		move_uploaded_file($file_tmp, '../front/img/produk/'.$file_name);
		// 	}
		// }
		// echo json_encode(true);
	} else if($_POST['req'] == 'addDatarev') {
		$label = $_POST['label'];
		$harga = $_POST['harga'];
		$kategori = $_POST['kategori'];
		$ext_type = $_POST['ext_type'];
		// SET FOTO 
		$media = $_FILES['file_media']['name'];
		$tanggal = date('Y-m-d H:i:s');
		$ext = pathinfo($media, PATHINFO_EXTENSION);
		$file_name = str_replace(' ', '-', $label)."-".time().".".$ext;
		$file_tmp = $_FILES['file_media']['tmp_name'];

    	// TAMBAH DATA 
		$query = "INSERT INTO tb_media VALUES (NULL, '$label', '$harga', '$kategori', '$file_name', '$ext_type', '$tanggal')";
		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			move_uploaded_file($file_tmp, '../front/img/produk/'.$file_name);
			echo json_encode(true);
		}
	} else if($_POST['req'] == 'updateData') {
		$id = $_POST['id'];
		$label = $_POST['label'];
		$harga = $_POST['harga'];
		$kategori = $_POST['kategori'];
		$file_old = $_POST['file_old'];
		// SET FOTO 
		$media = $_FILES['file_media']['name'];
		if ($media != '') {
			$ext = pathinfo($media, PATHINFO_EXTENSION);
			$file_name = str_replace(' ', '-', $label)."-".time().".".$ext;
			$file_tmp = $_FILES['file_media']['tmp_name'];
			move_uploaded_file($file_tmp, '../front/img/produk/'.$file_name);
			$target = "../front/img/produk/".$file_old;
			if (file_exists($target)) unlink($target);
			$ext_type = $_POST['ext_type'];
		} else {
			$file_name = $file_old;
			$ext_type = $_POST['old_ext'];
		}

    	// UPDATE DATA 
		$query = "UPDATE tb_media SET label='$label', harga='$harga', kategori='$kategori', file_media='$file_name', ext_type='$ext_type' WHERE id='$id'";

		if (mysqli_query($conn, $query)) {
			echo json_encode(true);
		}
	} else if($_POST['req'] == 'deleteData') {
		$id = $_POST['id'];
		$result = mysqli_query($conn, "SELECT * FROM tb_media WHERE id = '$id'");
		$get = mysqli_fetch_assoc($result);

		$query = "DELETE FROM tb_media WHERE id = '$id'";
		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			$target = "../front/img/produk/".$get['file_media'];
			if (file_exists($target)) unlink($target);
			echo json_encode(true);
		}
	} else if($_POST['req'] == 'setAdmin') {
		$username = $_POST['username'];
		if (isset($_POST['password'])) {
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$query = "UPDATE users SET username = '$username', password = '$password' WHERE level = 'admin'";
		} else {
			$query = "UPDATE users SET username = '$username' WHERE level = 'admin'";
		}

		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			echo json_encode($username);
		}

		echo mysqli_error($conn);
	} else if($_POST['req'] == 'setReseller') {
		$username = $_POST['username'];
		if (isset($_POST['password'])) {
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$query = "UPDATE users SET username = '$username', password = '$password' WHERE level = 'reseller'";
		} else {
			$query = "UPDATE users SET username = '$username' WHERE level = 'reseller'";
		}

		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			echo json_encode($username);
		}

		echo mysqli_error($conn);
	} else if($_POST['req'] == 'dataReseller') {
		$result = mysqli_query($conn, "SELECT * FROM reseller");
		$data = [];
		foreach ($result as $dta) {
			$alamat = 'Kec. '.$dta['kec'].', Kab. '.$dta['kab'].', '.$dta['alamat_lengkap'];
			$dta['alamat'] = $alamat;
			$data[] = $dta;
		}
		echo json_encode($data);
	} else if($_POST['req'] == 'deleteReseller') {
		$id = $_POST['id'];
		$query = "DELETE FROM reseller WHERE id = '$id'";
		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			echo json_encode(true);
		}
	} else if($_POST['req'] == 'getImage') {
		$id = $_POST['id'];
		$result = mysqli_query($conn, "SELECT * FROM tb_media WHERE id = '$id'");
		$get = mysqli_fetch_assoc($result);
		echo json_encode($get['file_media']);
	} else if($_POST['req'] == 'viewDataKategori') {
		$result = mysqli_query($conn, "SELECT * FROM tb_kategori ORDER BY id DESC");
		$data = [];
		foreach ($result as $dta) {
			$data[] = $dta;
		}
		echo json_encode($data);
	} else if($_POST['req'] == 'addDataKtgr') {
		$kategori = $_POST['kategori'];
		
		$query = "INSERT INTO tb_kategori VALUES (NULL, '$kategori')";
		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			echo json_encode(true);
		}
	} else if($_POST['req'] == 'deleteDataKtgr') {
		$id = $_POST['id'];
		$query = "DELETE FROM tb_kategori WHERE id = '$id'";
		mysqli_query($conn, $query);
		if (mysqli_affected_rows($conn) > 0) {
			echo json_encode(true);
		}
	} else if($_POST['req'] == 'getDataKtgr') {
		$id = $_POST['id'];
		$result = mysqli_query($conn, "SELECT * FROM tb_kategori WHERE id='$id'");
		$res = mysqli_fetch_assoc($result);
		$data = [
			'id' => $res['id'],
			'kategori' => $res['kategori']
		];
		echo json_encode($data);
	} else if($_POST['req'] == 'editKtgr') {
		$id = $_POST['id'];
		$kategori = $_POST['kategori'];
		$query = "UPDATE tb_kategori SET kategori='$kategori' WHERE id='$id'";
		if (mysqli_query($conn, $query)) {
			echo json_encode(true);
		}
	}
}
?>