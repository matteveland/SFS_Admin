<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
parse_str($_SERVER['QUERY_STRING'], $query);
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

$unitName = $_SESSION['unitName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $siteTitle; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/AdminLTE-master/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!--Nav bar-->
  <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>

  <!-- Main Sidebar Container -->
  <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Member Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                            <li class="breadcrumb-item active">Member Update
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!--<div class="card-header">
                                <h3 class="card-title">Alarm Data Tables</h3>
                            </div>-->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <?php include "member-update.php";?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/AdminLTE-master/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./AdminLTE-master/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./AdminLTE-master/plugins/jszip/jszip.min.js"></script>
<script src="./AdminLTE-master/plugins/pdfmake/pdfmake.min.js"></script>
<script src="./AdminLTE-master/plugins/pdfmake/vfs_fonts.js"></script>
<script src="./AdminLTE-master/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./AdminLTE-master/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="./AdminLTE-master/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./AdminLTE-master/dist/js/demo.js"></script>
<!-- Page specific script -->

</body>
</html>
