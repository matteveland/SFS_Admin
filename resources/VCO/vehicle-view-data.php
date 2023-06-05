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
    $recallVehicleMake = $recallVehicle['make'];
    $recallVehicleModel = $recallVehicle['model'];
    $recallVehicleDriveType = $recallVehicle['driveType'];
    $recallVehicleDoorType = $recallVehicle['DoorType'];
    $recallVehicleStickers = $recallVehicle['stickers'];
    $recallVehicleMileage = $recallVehicle['mileage'];
    $recallReg = $recallVehicle['registration'];
    $recallYear = $recallVehicle['modelYear'];
    $recallMake = $recallVehicle['make'];
    $recallModel = $recallVehicle['model'];
    $recallDriveType = $recallVehicle['driveType'];
    $recallDoors = $recallVehicle['DoorType'];
    $recallStickers = $recallVehicle['stickers'];
    $recallEquipmentInstalled = $recallVehicle['equipment'];
    $recallEquipmentInstalled = explode(', ', $recallEquipmentInstalled);
    sort($recallEquipmentInstalled);
    $recallDescription = $recallVehicle['description'];
    $recallPost = $recallVehicle['post'];
    $recallStatus = $recallVehicle['status'];
  }

}

$recallStandardVehicleInformation = $mysqli->query("SELECT equipmentType FROM vehicleEquipment where unitName = '$unitName'");
$recallStandardVehicleInformationArray = $recallStandardVehicleInformation->fetch_array();

$equipArray = array();
$equipArray = explode(',', $recallStandardVehicleInformationArray['equipmentType']);

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
              <h1>Vehicle Data</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Insert Vehicle Data</li>
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
                  <h3 class="card-title">Update Vehicle Information</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->


                <form action="vehicle-update-data.php" method="POST">
                  <div class="card-body">
                    <div class="form-group" hidden>
                      <label for="id">ID</label>
                      <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>" placeholder="ID">
                    </div>
                    <div class="form-group">
                      <label for="inputRegistration">Vehicle Registration</label>
                      <br>
                      <input type="text" class="form-control" id="inputRegistration" name="inputRegistration" value="<?php echo $recallReg; ?>" placeholder="Registration" readonly>
                    </div>
                    <div class="form-group">
                      <label for="inputYear">Vehicle Year</label>
                      <br>
                      <?php echo $recallYear; ?>
                    </div>
                    <div class="form-group">
                      <label for="inputMake">Vehicle Make</label>
                      <br>
                      <?php echo "$recallMake"; ?>
                    </div>
                    <div class="form-group">
                      <label for="inputModel">Vehicle Model</label>
                      <br>
                      <?php echo "$recallModel"; ?>
                    </div>


                    <div class="form-group">
                      <label for="inputDescription">Description</label>
                      <textarea class="form-control" rows="6"
                      name="inputDescription"><?php echo $recallDescription; ?></textarea>
                    </div>

                    <div class="form-group">
                      <label for="inputMileage">Last Reported Mileage</label>
                      <input type="text" class="form-control" id="inputMileage" name="inputMileage" value="<?php echo $recallVehicleMileage; ?>" placeholder="Mileage" readonly>
                    </div>
                    <div class="form-group">
                      <label for="inputDriveType">Drive Type</label>
                      <select class="form-control" id="inputDriveType" name="inputDriveType" title="inputDriveType"required>
                        <option value="2" <?php if ($recallVehicleDriveType == "2") echo "selected"; ?> >4 x 2</option>
                        <option value="4" <?php if ($recallVehicleDriveType == "4") echo "selected"; ?> >4 x 4</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputDoorType">Door Type</label>
                      <select class="form-control" id="inputDoorType" name="inputDoorType" title="inputDoorType"required>
                        <option value="2" <?php if ($recallVehicleDoorType == "2") echo "selected"; ?> >2 Door</option>
                        <option value="4" <?php if ($recallVehicleDoorType == "4") echo "selected"; ?> >4 Door</option>
                      </select>

                    </div>
                    <div class="form-group">
                      <label for="inputStickers">Sticker Installed</label>
                      <select class="form-control" id="inputStickers" name="inputStickers" title="inputStickers"required>
                        <option value=""></option>
                        <option value="0" <?php if ($recallVehicleStickers == "0") echo "selected"; ?> >No</option>
                        <option value="1" <?php if ($recallVehicleStickers == "1") echo "selected"; ?> >Yes</option>
                      </select>
                    </div>


                    <!-- Select Equipment installed -->

                    <div class="form-group">
                      <label for="multiSelectEquipmentRemoved"><b>Installed Equipment</b></label><br>

                      <?php
                      for ($i = 0; $i < count($equipArray); $i++) {
                        if (in_array($equipArray[$i], $recallEquipmentInstalled)) {
                          echo '<label for="equipmentRemove"></label>
                          <input style="alignment:left" type="checkbox" id="equipmentRemove[]" name="equipmentRemove[]" value="' . $equipArray[$i] . '">' . $equipArray[$i] . '<br>';
                        }
                      }
                      ?>

                    </div>
                    <div>

                      <input class="btn btn-md btn-outline-danger" type="submit" name="remove" id="remove"
                      value="Remove Equipment" style="alignment: center">

                    </div>


                    <br>

                    <!-- Select Equipment NOT installed -->

                    <div class="form-group" style="text-align: left">
                      <b><label for="equipmentAdd">Not Installed Equipment</label></b><br>


                      <?php
                      for ($i = 0; $i < count($equipArray); $i++) {

                        if (!in_array($equipArray[$i], $recallEquipmentInstalled)) {
                          echo '<label for="equipmentAdd[]"></label>
                          <input style="alignment:left" type="checkbox" id="equipmentAdd[]" name="equipmentAdd[]" value="' . $equipArray[$i] . '"> ' . $equipArray[$i] . '<br>';
                        }

                      }
                      ?>

                    </div>
                    <div>
                      <input class="btn btn-md btn-outline-secondary" type="submit" name="add" id="add"
                      value="Add Equipment" style="alignment: center">


                    </div>

                  </div>

                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button  align="center" class="btn btn-primary" type="submit" name="submit-update-vehicle-data" id="submit-update-vehicle-data" value="Update Vehicle Information">Update Vehicle Information</button>

                  </div>
                </form>
              </div>
              <!-- /.card -->

              <!--/.col (left) -->
              <!-- right column -->

            </div>

            <!--/.col (left)-->
            <!-- right column -->
            <div class="col-md-6">
              <!-- Form Element sizes -->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Vehicle Information</h3>
                </div>
                <div class="card-body">

                  <?php $_SESSION['registration'] = $registration;
                  $_SESSION['id'] = $id;

                  include ('vehicle-view-last-reported-deadline.php');?>

                  <?php include ('vehicle-view-last-reported-issues.php');?>
                  <?php include ('vehicle-view-last-reported-mileage.php');?>

                </form>

              </div>
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

  $('#deadlined').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
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
