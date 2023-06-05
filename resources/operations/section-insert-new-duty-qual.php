<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

$unitName = $_SESSION['unitName'];


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
  <title><?php echo $siteTitle; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../AdminLTE-master/dist/css/adminlte.min.css">

  <!-- Theme style -->
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>



  <script>
  $(function() {
    $('#dim_inputTime').hide();
    $('#occurrence').change(function() {
      if ($('#occurrence').val() == 'now') {
        $('#dim_inputTime').hide();
      } else {
        $('#dim_inputTime').show();
      }
    });
  });

  $(function() {
    $('#dim_inputDate').hide();
    $('#occurrence').change(function() {
      if ($('#occurrence').val() == 'now') {
        $('#dim_inputDate').hide();
      } else {
        $('#dim_inputDate').show();
      }
    });
  });

  $(function() {
    $('#manualSubmit').hide();
    $('#occurrence').change(function() {
      if ($('#occurrence').val() == 'now') {
        $('#manualSubmit').hide();
        $('#inputSubmit').show();
      } else if ($('#occurrence').val() == 'other') {
        $('#manualSubmit').show();
        $('#inputSubmit').hide();
      } else {
        $('#inputSubmit').show();
        $('#manualSubmit').hide();
      }
    });
  });
  </script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Main content -->
    <div class="container-fluid">
      <section class="content">
        <div class="container-fluid">
          <div class="col-md-8">
            <div class="row">
              <!-- left column -->
              <div class="col-md-10">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Submit Member DPE Information</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="insert-dpe-position.php" id="insert-dpe-position" name="insert-dpe-position" method="post">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="lastName">Last Name</label>
                          <input type="text" name="lastName" id="lastName" class="form-control" value="" placeholder="Last Name">
                      </div>
                      <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" value="" placeholder="First Name">
                      </div>

                      <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/positionSelect.php'; ?>

                      <div class="form-group" id="startDate">
                        <label for="startDate" style="text-align: left">Start Date</label><br>
                        <input type="date" name="startDate" id="startDate" class="form-control" value="">

                      </div>
                      <div class="form-group" id="endDate">
                        <label for="endDate" style="text-align: left">End Date</label><br>
                        <input type="date" name="endDate" id="endDate" class="form-control" value="">

                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" name="inputSubmit" id="inputSubmit" class="btn btn-primary">Submit</button>
                      <button type="submit" name="manualSubmit" id="manualSubmit" class="btn btn-secondary">Submit</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->

                <!--/.col (left) -->
                <!-- right column -->

              </div>
              <!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Footer -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
  <!-- jQuery -->

</body>
</html>
