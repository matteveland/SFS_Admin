<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
session_start();
$returnTo = $_SERVER['HTTP_REFERER'];

$unitName_setup = $mysqli->real_escape_string($_POST['unitName']);

$unitName_setup = trim($unitName_setup);
$unitName_setup = strtoupper($unitName_setup);

$unitLookUp = $mysqli->query("SELECT * FROM `UnitSections` WHERE unitName ='$unitName_setup'");

if ($unitLookUp->num_rows) {
  echo "Unable to create an account for you unit. Your unit is aleady has access to SFSAdmin.com";
  // code...

  exit;

}else {
  // code...
//  echo "able to add :)";
}

$_SESSION['unitName_setup'] = $unitName_setup;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php $siteTitle ?></title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>SFS</b>Admin</a>
      </div>
      <div class="card-body">

        <p class="login-box-msg">There are default sections included in SFSAdmin. If you have special sections add those now.
          </p>
          <p>If you have no special section(s), leave box empty.</p>

        <form action="3-set-up-post-patrols.php" method="post">


          <div class="input-group mb-3">


            <div class="input-group-prepend">
              <span class="input-group-text"><i class="bi bi-plus"></i></i></span>
            </div>
            <input type="text" name="specialUnitSection[]" id="specialUnitSection[]" class="form-control" value="" placeholder="Special Unit Sections">
          </div>
          <p>*Seperate mulitple sections with a semi-colon ";".</p>
          <div class="input-group mb-3">
            <p>Default Sections:</p>
          </div>
          <div class="input-group mb-6">
            <ul>
              <li>S1</li>
              <li>S2</li>
              <li>S3</li>
              <ul>
                <li>S3OA</li>
                <li>S3OB</li>
                <li>S3OC</li>
                <li>S3OD</li>
                <li>S3OAE</li>
                <li>S3OF</li>
                <li>S3OK</li>
                <li>S3T</li>
              </ul>

              <li>S4</li>
              <li>S5</li>
              <li>SFMQ</li>
              <li>CC</li>
              <li>CCF</li>
              <li>SFM</li>
            </ul>



          </div>


          <div class="row">
            <div class="col-8">
              <div >

              </div>
            </div>
            <!-- /.col -->

            <div class="col-4">
              <button type="submit" name="next" id="next" class="btn btn-primary btn-block">Next</button>
            </div>
            <!-- /.col -->
          </div>


        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../../AdminLTE-master/dist/js/adminlte.min.js"></script>
</body>
</html>
