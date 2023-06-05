<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];

$findMember = $mysqli->query("SELECT * From login l inner JOIN members m on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name");

while ($row = $findMember->fetch_assoc()) {

  $userID = $row['user_name'];
  $last = $row['lastName'];
  $first = $row['firstName'];
  $middle = $row['middleName'];
  $admin = $row['admin'];
  $unitName = $row['unitName'];
  $img = $row['image'];
  $imgDetail = $row['imageDetail'];
}

if (isset($_GET['id'])) {
  $id = $mysqli->real_escape_string($_GET['id']);
  $registration = $mysqli->real_escape_string($_GET['reg']);


  $updateVehicleInformation = $mysqli->query("SELECT * FROM `vehicles_daily` WHERE registration = '$registration'");

  while ($recallVehicle = mysqli_fetch_assoc($updateVehicleInformation)){

    $recallVehicleUpdatedBy = $recallVehicle['registration'];
    $recallVehicleYear = $recallVehicle['modelYear'];

  }

}


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
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="../../AdminLTE-master/dist/css/adminlte.min.css">

  <!-- Theme style -->
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <script>

  </script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!--Nav bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>
    <!--side bar-->
    <?php include "../Navigation/sidebar.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1403.625px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Supply Levels</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Supply Levels</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Supply Levels</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="equipment-insert-supply-levels.php" method="POST">
                  <div class="card-body">
                    <!-- hidden ID from query -->
                    <div class="form-group" hidden>
                      <label for="id">ID</label>
                      <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>" placeholder="ID">
                    </div>
                    <!-- Item/Stock Number -->
                    <div class="form-group">
                      <label for="inputNumber">Item/Stock Number</label>
                      <input type="text" class="form-control" id="inputNumber" name="inputNumber" value="" placeholder="Item Number/Stock Number" required>
                    </div>
                    <!-- Item Name -->
                    <div class="form-group">
                      <label for="inputItemName">Insert Supply Inventory</label>
                      <label for="inputItemName">Item Name</label>
                      <input type="text" class="form-control" id="inputItemName" name="inputItemName" value="" placeholder="Item Name" required>
                    </div>
                    <!-- Itme Model -->
                    <div class="form-group">
                      <label for="inputModel">Item Model</label>
                      <input type="text" class="form-control" id="inputModel" name="inputModel" value="" placeholder="Model" required>
                    </div>
                    <!-- Item Manufacturer -->
                    <div class="form-group">
                      <label for="inputManufacturer">Item Manufacturer</label>
                      <input type="text" class="form-control" id="inputManufacturer" name="inputManufacturer" value="" placeholder="Manufacturer" required>
                    </div>
                    <!-- Item Description -->
                    <div class="form-group">
                      <label for="itemDescriptionField">Item Description</label>
                      <textarea type="text" rows="3" class="form-control" id="itemDescriptionField" name="itemDescriptionField" placeholder="Item Description" required></textarea>
                    </div>
                    <!-- Order Cost -->
                    <div class="form-group">
                      <label for="inputItemCost">Order Cost</label>
                      <input type="text" class="form-control" id="inputItemCost" name="inputItemCost" value="" placeholder="Item Cost" required>
                    </div>
                    <!-- Date Receive -->
                    <div class="form-group">
                      <label for="inputDateReceived">Date Received</label>
                      <input type="date" class="form-control" id="inputDateReceived" name="inputDateReceived" value="" placeholder="MM-DD-YYYY" format required>
                    </div>
                    <!-- Quantity Received -->
                    <div class="form-group">

                      <label for="inputQuantity">Quantity Received</label>
                      <input type="text" class="form-control" id="inputQuantity" name="inputQuantity" value="" placeholder="Quantity" required>

                    </div>
                    <!-- Quantity Type -->
                    <div class="form-group">
                      <label for="inputQuantityType">Quantity Type</label>
                      <select class="form-control" id="inputQuantityType" name="inputQuantityType">
                        <option value="NULL"></option>
                        <option value="single">Single</option>
                        <option value="box">Box</option>
                      </select>
                    </div>
                    <!-- Issue Type -->
                    <div class="form-group">
                      <label for="inputIssueType">Issue Type</label>
                      <select class="form-control" id="inputIssueType" name="inputIssueType">
                        <option value="NULL"></option>
                        <option value="daily">Daily Operations</option>
                        <option value="operations">S3 Operations</option>
                        <option value="armory">Armory</option>
                        <option value="atfp">ATFP</option>
                        <option value="tdy">AEF Operations</option>
                        <option value="other">Something Else</option>
                      </select>
                    </div>

                    <!-- Issue Type -->
                    <div class="form-group">
                      <label for="inputInitialIssue">Issue Type</label>
                      <select class="form-control" id="inputInitialIssue" name="inputInitialIssue">
                        <option value=""></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
          
                      </select>
                    </div>

                  </div>





                  <!-- /.card-body -->
                  <!--  Submit to database-->
                  <div class="card-footer">
                    <button  align="center" class="btn btn-primary" type="submit" name="submit-insert-equipment-data" id="submit-insert-equipment-data" value="Update Vehicle Information">Submit Equipment Information</button>


                  </div>
                </form>
              </div>
              <!-- /.card -->

              <!--/.col (left) -->
              <!-- right column -->

            </div>

            <!--/.col (left)-->
            <!-- Col Right -->
            <div class="col-md-6">
              <!-- Form Element sizes -->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Current Inventory</h3>
                </div>
                <div class="card-body">

                  <?php include ('equipment-view-status-inventory.php');?>

                </form>

              </div>
            </div>


            <!-- /.card-body -->


          </form>
        </div>


    <!-- /.card-body -->


  </form>
</div>
<!-- /.card -->
</div>
<!--/.col (right) -->
<!-- /.row -->
</div><!-- /.container-fluid -->
</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- Content Header (Page header) -->

<!-- REQUIRED SCRIPTS -->
<script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../AdminLTE-master/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../AdminLTE-master/plugins/jszip/jszip.min.js"></script>
<script src="../../AdminLTE-master/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../AdminLTE-master/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../AdminLTE-master/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#inventory').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
  });

  $('#issues').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });

  $('#mileage').DataTable({
    "paging": true,



    "lengthChange": false,

    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
  });
});
</script>
</body>
</html>
