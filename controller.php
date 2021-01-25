<?php
require('config.php');

if (isset($_POST['req'])) {
    header('Content-type: application/json');
    if($_POST['req'] == 'addReseller') {
        $nama = $_POST['nama'];
        $no_telepon = $_POST['no_telepon'];
        $kab = $_POST['kab'];
        $kec = $_POST['kec'];
        $alamat_lengkap = $_POST['alamat_lengkap'];
        
        if(substr($no_telepon, 0, 1) == '0') {
            $nomor = substr($no_telepon, 1, strlen($no_telepon));
            $nomor = '+62'.$nomor;
        }
        else $nomor = $no_telepon; 

        // TAMBAH DATA 
        $query = "INSERT INTO reseller VALUES (NULL, '$nama', '$nomor', '$kab', '$kec', '$alamat_lengkap')";
        mysqli_query($conn, $query);
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(true);
        }
    }
}
?>