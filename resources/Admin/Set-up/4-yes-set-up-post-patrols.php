<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

$post_setup = $mysqli->real_escape_string($_POST['next']);

if (isset($post_setup) AND $post_setup == "no") {

  header("refresh:0;url=5-set-up-first-user.php");
  // code...
}


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
        <p class="login-box-msg">List your Post and Patrols</p>

        <form action="5-set-up-first-user.php" method="post">


          <div class="input-group mb-3">


            <div class="input-group-prepend">
              <span class="input-group-text"><i class="bi bi-plus"></i></i></span>
            </div>
            <input type="text" name="addPost_Patrols[]" id="addPost_Patrols[]" class="form-control" value="" placeholder="Add Post and Patrols ">
          </div><p>*Seperate Post or Patrols with a semi-colon ";"</p>


          <p>Example:</p>
          <div class="input-group mb-3">


            <div class="input-group-prepend">
              <span class="input-group-text"><i class="bi bi-plus"></i></i></span>
            </div>

            <input type="text" class="form-control"  placeholder="Whiskey 1; Whiskey 2" readonly>

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
