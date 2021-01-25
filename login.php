<?php 
require('config.php');

if (isset($_SESSION['login_admin'])) header("location: admin/");
else if (isset($_SESSION['login_reseller'])) header("location: reseller/");

$password = null;
$username = null;
$err_user = false;
$err_pass = false;

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
  $get = mysqli_fetch_assoc($result);

  if ($get) {
    $get_password = $get['password'];
    $level = $get['level'];

    if (password_verify($password, $get_password)) {
      if ($level == 'admin') {
        $_SESSION['login_admin'] = $get_password;
        header("location: admin/");
        exit();
      } else if ($level == 'reseller') {
        $_SESSION['login_reseller'] = $get_password;
        header("location: reseller/");
        exit();
      }
    } else $err_pass = true;
  } else $err_user = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; BilaStore</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <!-- <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4></div>

              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" value="<?= $username ? $username : '' ?>" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your username
                    </div>
                    <?php if ($err_user == true) { ?>
                      <div class="text-danger">
                        Username tidak ditemukan
                      </div>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                   <label for="password" class="control-label">Password</label>
                   <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                   <div class="invalid-feedback">
                    please fill in your password
                  </div>
                  <?php if ($err_pass == true) { ?>
                    <div class="text-danger">
                      Password tidak sesuai
                    </div>
                  <?php } ?>
                </div>

                <div class="form-group">
                  <button type="submit" name="login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Login
                  </button>
                </div>
              </form>


            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- General JS Scripts -->
<script src="assets/modules/jquery.min.js"></script>
<script src="assets/modules/popper.js"></script>
<script src="assets/modules/tooltip.js"></script>
<script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="assets/modules/moment.min.js"></script>
<script src="assets/js/stisla.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<script src="assets/js/custom.js"></script>

</body>
</html>
