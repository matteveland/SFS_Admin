<?php


include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
header("refresh:3;url=login.php");
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SFS Admin | Homepage</title>

     <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">
</head>

<body class="">
    <div class="wrapper">

      <!--Nav bar-->
      <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>

      <!-- Main Sidebar Container -->
      <?php // Not used in the logout page. include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    <!-- Small boxes (Stat box) -->

                    <div class="row">

                        <div class="col">
                            <!-- small box -->
                            <div class="">
                                <div class="inner">
                                    <?php

                                    if (isset($_SESSION['page_admin'])) {
                                        echo "<h3 align='center'>" . $_SESSION['page_admin'] . " from " . $_SESSION['unitName'] . " has been logged out</h3>";
                                    } elseif (isset($_SESSION['page_user'])) {
                                        echo "<h3 align='center'>" . $_SESSION['page_user'] . " from " . $_SESSION['unitName'] . " has been successfully logged out</h3>";
                                    } else {
                                    }
                                    $_SESSION = array();
                                    session_destroy();
                                    ?>

                                </div>

                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>
</body>

</html>
