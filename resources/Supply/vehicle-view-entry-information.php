<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site

parse_str($_SERVER['QUERY_STRING'], $query);

$unitName = $_SESSION['unitName'];
$admin = $_SESSION['page_admin'];
$user =  $_SESSION['page_user'];
$unitName =  $_SESSION['unitName'];

if ((($_SESSION['page_admin']) == 'Unit_VCO') or (($_SESSION['page_admin']) == 'matt')) {

  if (isset($_GET['id'])) {
    $id = $mysqli->real_escape_string($_GET['id']);
    $registration = $mysqli->real_escape_string($_GET['reg']);


    $resultUpdateVehicleInformation = $mysqli->query("SELECT * FROM `vehicles_mileage` WHERE id = '$id' and registration = '$registration'");

    while ($recallVehicle = $resultUpdateVehicleInformation->fetch_assoc()){


      $recallVehicleUpdatedBy = $recallVehicle['registration'];
      $recallVehicleDutySection = $recallVehicle['dutySection'];
      $recallVehicleLastUpdate = $recallVehicle['location'];
      $recallVehiclePost = $recallVehicle['post'];
      $recallVehicleStatus = $recallVehicle['status'];
      $recallVehicleMileage = $recallVehicle['mileage'];
      $recallVehicleDriverName = $recallVehicle['driverName'];
      $recallVehicleDeadlineReason = $recallVehicle['deadlineReason'];
      $recallVehicle1800 = $recallVehicle['AF1800'];
      $recallVehicleWaiver = $recallVehicle['waiverCard'];
      $recallVehicle91 = $recallVehicle['AF91'];
      $recallVehicle518 = $recallVehicle['AF518'];
    }

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
              <h1>Vehicle Data</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Edit Vehicle Entry Informatoin</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

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
                      <h3 class="card-title">Edit Vehicle Entry Informatoin</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="vehicle-update-entry-information.php" method="post">
                      <div class="card-body">
                        <div class="form-group" hidden>
                          <label for="id">ID</label>
                          <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>" placeholder="ID">
                        </div>

                        <!-- Select Vehicle "selectVehicle"-->
                        <div class="form-group">
                          <label for="selectVehicle">Vehicle</label>
                          <select class="form-control" id="selectVehicle" name="selectVehicle" title="selectVehicle" autofocus required>
                            <option value="">Select Vehicle</option>
                            <option value="<?php echo $registration; ?>" selected ><?php echo "$registration"; ?></option>

                          </select>
                        </div>
                        <!-- Select section "dutySection"-->
                        <div class="form-group">
                          <label for="dutySection">section</label>
                          <select class="form-control" id="dutySection" name="dutySection" title="dutySection" required autofocus>
                            <option value="">Select section</option>

                            <?php
                            $sections = array();
                            $sections = array("Alpha", "Bravo", 'Charlie', 'Delta', 'Echo', 'Foxtrot');

                            $count = count($sections);

                            for ($i = 0; $i < $count; ++$i) {

                              if ($recallVehicleDutySection == $sections[$i]){
                                echo '<option value=' . $recallVehicleDutySection . ' selected >' . $recallVehicleDutySection . '</option>';
                              }else{
                                echo '<option value=' . $sections[$i] . '>' . $sections[$i] . '</option>';
                              }

                            }

                            ?>
                          </select>

                        </div>
                        <!-- Select "Posting"-->
                        <div class="form-group">
                          <label for="location">Post Assigned</label>
                          <select class="form-control" title="location" id="location" name="location" autofocus required>
                            <option value="">Select Post/Patrol</option>
                            <?php

                            //find post for unit
                            $resultsFindPost = $mysqli->query("SELECT `post/patrol` from post where unitName = '$unitName'");
                            $resultsFindPostAssoc = $resultsFindPost->fetch_assoc();
                            $postVehicleArray = array();
                            $postVehicleArray = explode(', ', $resultsFindPostAssoc['post/patrol']);

                            //display post within selection for vehicle inventory
                          for ($i = 0; $i < count($postVehicleArray); $i++) {


                              if ($recallVehiclePost == $postVehicleArray[$i]){
                                echo '<option value=' . $recallVehiclePost . ' selected >' . $recallVehiclePost . '</option>';
                              }else{
                                echo '<option value=' . $postVehicleArray[$i] . '>' . $postVehicleArray[$i] . '</option>';
                              }

                            }

                            ?>
                          </select>
                        </div>
                        <!-- Select "Current Status"-->
                        <div class="form-group">
                          <label for="currentStatus">Current Status</label>
                          <select class="form-control" title="currentStatus" id="currentStatus" name="currentStatus" autofocus required>
                            <option value="">Current Status</option>
                            <option value="Operational" <?php if ($recallVehicleStatus == "Operational") echo "selected"; ?> >Operational</option>
                            <option value="Deadlined" <?php if ($recallVehicleStatus == "Deadlined") echo "selected"; ?> >Deadlined</option>
                            <option value="Stand-By" <?php if ($recallVehicleStatus == "Stand-By") echo "selected"; ?> >Stand-By</option>
                            <option value="Maintenance" <?php if ($recallVehicleStatus == "Maintenance") echo "selected"; ?>>Vehicle Maintenance</option>
                          </select>

                        </div>
                        <!-- Select "Driver Name"-->
                        <div class="form-group" id="dim_driverName">
                          <label for="driverName" style="text-align: left">Driver Name</label>
                          <input type="text" name="driverName" id="driverName" class="form-control" value="<?php echo $recallVehicleDriverName;?>"
                          placeholder="Rank Last, First">
                        </div>
                        <div class="form-group" id="dim_deadline">
                          <label for="deadlineReason" style="text-align: left">Deadline Reason</label><br>
                          <input type="text" name="deadlineReason" id="deadlineReason" class="form-control" value="<?php echo $recallVehicleDeadlineReason;?>"
                          placeholder="Reason for Deadline">

                        </div>
                        <!-- Select Mileage "inputVehicleMileage" -->
                        <div class="form-group">
                          <label for="inputVehicleMileage">Vehicle Mileage</label>
                          <input type="text" name="inputVehicleMileage" id="inputVehicleMileage" class="form-control" value="<?php echo $recallVehicleMileage;?>" placeholder="" required>
                        </div>
                        <!--AF Form 1800 "input1800" && "waiverCard)-->
                        <div class="form-group">
                            <label for="input1800">AF Form 1800</label>
                            <select class="form-control" id="input1800" name="input1800" title="input1800" required>
                                <option value="">Select Option</option>
                                <option value="Current" <?php if ($recallVehicle1800 == "Current") echo "selected"; ?> >Current</option>
                                <option value="Missing" <?php if ($recallVehicle1800 == "Missing") echo "selected"; ?> >Missing</option>

                            </select>
                        </div>
                        <div class="form-group" id="dim_reportMissing1800">
                            <label for="reportMissing1800" style="text-align: left"><text style="color:red">Reported to VCO</text></label><br>
                            <select class="form-control" id="reportMissing1800" name="reportMissing1800" title="inputWaiverCard">
                                <option value="">Select Option</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>
                        </div>
                        <div class="form-group">
                          <label for="input1800Notes">AF Form 1800 Notes</label>
                          <input type="text" name="input1800Notes" id="input1800Notes" class="form-control" value="" placeholder="">
                        </div>

                        <div class="form-group">
                          <label for="inputWaiverCard">Waiver Card</label>
                          <select class="form-control" id="inputWaiverCard" name="inputWaiverCard" title="inputWaiverCard" required>
                            <option value="">Select Option</option>
                            <option value="N/A">None Assigned</option>
                            <option value="Current" <?php if ($recallVehicleWaiver == "Current") echo "selected"; ?> >On Hand</option>
                            <option value="Missing" <?php if ($recallVehicleWaiver == "Missing") echo "selected"; ?> >Missing</option>
                          </select>
                        </div>
                        <div class="form-group" id="dim_reportMissingWaiverCard">
                          <label for="reportMissingWaiverCard" style="text-align: left"><text style="color:red">Reported to VCO</text></label><br>
                          <select class="form-control" id="reportMissingWaiverCard" name="reportMissingWaiverCard" title="reportMissingWaiverCard">
                            <option value="">Select Option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>

                          </select>
                        </div>

                        <div class="form-group">
                          <label for="inputWaiverCardNotes">Wavier Notes</label>
                          <input type="text" name="inputWaiverCardNotes" id="inputWaiverCardNotes" class="form-control" value="" placeholder="">
                        </div>

                        <div class="form-group">
                          <label for="input91">AF Form 91</label>
                          <select class="form-control" id="input91" name="input91" title="input91" required>
                            <option value="">Select Option</option>
                            <option value="Current" <?php if ($recallVehicle91 == "Current") echo "selected"; ?> >On Hand</option>
                            <option value="Missing" <?php if ($recallVehicle91 == "Missing") echo "selected"; ?> >Missing</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="input91Notes">AF Form 91 Notes</label>
                          <input type="text" name="input91Notes" id="input91Notes" class="form-control" value=""
                          placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="input518">DD Form 518</label>
                          <select class="form-control" id="input518" name="input518" title="input518" required>
                            <option value="">Select Option</option>
                            <   <option value="Current" <?php if ($recallVehicle518 == "Current") echo "selected"; ?> >On Hand</option>
                            <option value="Missing" <?php if ($recallVehicle518 == "Missing") echo "selected"; ?> >Missing</option>

                          </select>
                        </div>
                        <div class="form-group">
                          <label for="input518Notes">DD Form 518 Notes</label>
                          <input type="text" name="input518Notes" id="input518Notes" class="form-control" value=""
                          placeholder="">
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                          <button  class="btn btn-primary" type="submit" id="submitInventory" name="submitInventory" value="Submit Vehicle Information">Submit</button>

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
        <!-- Content Header (Page header) -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>


        <script>
        $(function() {
          $('#dim_driverName').show();
          $('#currentStatus').change(function() {
            if ($('#currentStatus').val() == 'Maintenance') {
              $('#dim_driverName').hide();
            } else if ($('#currentStatus').val() == 'Stand-By') {
              $('#dim_driverName').hide();
            } else {
              $('#dim_driverName').show();
            }
          });
        });

        $(function() {
          $('#dim_deadline').hide();
          $('#currentStatus').change(function() {
            if ($('#currentStatus').val() == 'Deadlined') {
              $('#dim_deadline').show();
            } else {
              $('#dim_deadline').hide();
            }
          });

        });

        $(function() {
          $('#dim_reportMissing1800').hide();
          $('#input1800').change(function() {
            if ($('#input1800').val() == 'Current') {
              $('#dim_reportMissing1800').hide();
            } else {
              $('#dim_reportMissing1800').show();
            }
          });
        });


        $(function() {
          $('#dim_reportMissingWaiverCard').hide();
          $('#inputWaiverCard').change(function() {
            if ($('#inputWaiverCard').val() == 'Current') {
              $('#dim_reportMissingWaiverCard').hide();
            } else if ($('#inputWaiverCard').val() == 'N/A') {
              $('#dim_reportMissingWaiverCard').show();
            } else {
              $('#dim_reportMissingWaiverCard').show();
            }
          });
        });
        </script>



      </body>

      </html>
