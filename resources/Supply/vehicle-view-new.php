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
                            <h1>Insert New Inventory Vehicle</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                                <li class="breadcrumb-item active">Insert Vehicle inventory</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

          <?php if ((($_SESSION['page_admin']) == 'Unit_VCO') or (($_SESSION['page_admin']) == 'matt')) { ?>

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
                                            <h3 class="card-title">Add vehicle into <?php echo $unitName;?> inventory</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form action="vehicle-insert-new.php" method="POST">
                                          <div class="card-body">
                                            <div class="form-group">
                                              <label for="inputReg">Vehicle Registration</label>
                                              <input type="text"  id="inputReg" name="inputReg" value="" placeholder="Registration" class="form-control"required>
                                            </div>
                                            <div class="form-group">
                                              <label for="inputYear">Vehicle Year</label>
                                              <input type="text" class="form-control" id="inputYear" name="inputYear" value="" placeholder="Year" required>
                                            </div>
                                            <div class="form-group">
                                              <label for="inputMake">Vehicle Make</label>
                                              <input type="text" class="form-control" id="inputMake" name="inputMake" value="" placeholder="Make" required>
                                            </div>
                                            <div class="form-group">
                                              <label for="inputModel">Vehicle Model</label>
                                              <input type="text" class="form-control" id="inputModel" name="inputModel" value="" placeholder="Model" required>
                                            </div>
                                            <div class="form-group">
                                              <label for="inputMileage">Mileage</label>
                                              <input type="text" class="form-control" id="inputMileage" name="inputMileage" value="" placeholder="Mileage">
                                            </div>
                                            <div class="form-group">
                                              <label for="inputDriveType">Drive Type</label>
                                              <select class="form-control" id="inputDriveType" name="inputDriveType">
                                                <option value="NULL"></option>
                                                <option value="4">4x4</option>
                                                <option value="2">4x2</option>
                                              </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputDoorType">Door Type</label>
                                                <select class="form-control" id="inputDoorType" name="inputDoorType">
                                                  <option value="NULL"></option>
                                                  <option value="2">2 Door</option>
                                                  <option value="4">4 Door</option>
                                                </select>
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputStickers">Sticker Installed</label>
                                                  <select class="form-control" id="inputStickers" name="inputStickers">
                                                    <option value="NULL"></option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                  </select>
                                                </div>



                                                    <div class="form-group">
                                                      <label for="multiSelectEquipmentInstalled">Equipment Installed</label>
                                                      <select class="form-control" id="multiSelectEquipmentInstalled" name="multiSelectEquipmentInstalled[]" multiple="multiple" required size="10">
                                                          <option value="Overhead Lights">Overhead Lights</option>
                                                          <option value="Push Bar">Push Bar</option>
                                                          <option value="Loud Speaker">Loud Speaker</option>
                                                          <option value="Gun Rack">Gun Rack</option>
                                                          <option value="Camper Shell">Camper Shell</option>
                                                          <option value="things">things</option>
                                                          <option value="things2">things2</option>
                                                          <option value="things3">things3</option>

                                                      </select>
                                                    </div>


                                              <div class="form-row">
                                                    <div class="form-group">
                                                      <label for="itemDescriptionField">Vehicle Description</label>
                                                      <div class="col-md-8">
                                                      </div>
                                                      <textarea rows="3" cols="100%" name="itemDescriptionField" id="itemDescriptionField" class="form-control" placeholder="Vehicle Description" required></textarea>
                                                    </div>
                                              </div>



                                              <input align="center" class="btn btn-primary" type="submit" name="submit" id="submit" value="Add Vehicle Information">
                                          </form>
                                        </div>
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
            <!-- Content Header (Page header) -->

            <!-- REQUIRED SCRIPTS -->

            <!-- jQuery -->
            <script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>





</body>

</html>
<?php
}else{
  echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";
}
?>
