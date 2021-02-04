<?php 
require('../config.php');

if (!isset($_SESSION['login_admin'])) {
  header("location: ../login.php");
}

$result_admin = mysqli_query($conn, "SELECT * FROM users WHERE level = 'admin'");
$get_admin = mysqli_fetch_assoc($result_admin);
$username_admin = $get_admin['username'];

$result_reseller = mysqli_query($conn, "SELECT * FROM users WHERE level = 'reseller'");
$get_reseller = mysqli_fetch_assoc($result_reseller);
$username_reseller = $get_reseller['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin - BilaStore</title>
  <link href="../front/img/tes1.png" rel="icon">

  <link rel="stylesheet" href="../assets/modules/dropzone/min/basic.min.css">
  <link rel="stylesheet" href="../assets/modules/dropzone/min/dropzone.min.css">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">
  <link href="../front/vendor/icofont/icofont.min.css" rel="stylesheet">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/modules/chocolat/dist/css/chocolat.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>      
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <script src="../assets/modules/jquery.min.js"></script>
  <!-- /END GA --></head>

  <body class="layout-3">
    <div id="app">
      <div class="main-wrapper container">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
          <a href="index.html" class="navbar-brand sidebar-gone-hide">BilaStore</a>
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
          <form class="form-inline ml-auto">
            <ul class="navbar-nav">
            </ul>
          </form>
          <ul class="navbar-nav navbar-right">
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Administrator</div></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item has-icon" data-toggle="modal" data-target="#modal-admin">
                  <i class="fas fa-user"></i> Account Admin
                </a>
                <a href="#" class="dropdown-item has-icon" data-toggle="modal" data-target="#modal-reseller">
                  <i class="fas fa-users"></i> Account Reseller
                </a>
                <div class="dropdown-divider"></div>
                <a href="../logout.php" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <nav class="navbar navbar-secondary navbar-expand-lg">
          <div class="container">
            <ul class="navbar-nav">
              <li class="nav-item" id="dashboard">
                <a href="index.php" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
              </li>
              <li class="nav-item" id="kelola_media">
                <a href="kelola_media.php" class="nav-link"><i class="fas fa-camera"></i><span>Kelolah Gambar & Video</span></a>
              </li>
              <li class="nav-item" id="kategori">
                <a href="kategori.php" class="nav-link"><i class="fas fa-list"></i><span>Kategori</span></a>
              </li>
              <li class="nav-item" id="reseler_mendaftar">
                <a href="reseler_mendaftar.php" class="nav-link"><i class="fas fa-users"></i><span>Reseller Mendftar</span></a>
              </li>
            </ul>
          </div>
        </nav>