<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site

parse_str($_SERVER['QUERY_STRING'], $query);
//$unitName = $_SESSION['unitName'];

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);



permissionsToEdit('Zeus', $findUser->lastName, $findUser->dodId, $findUser->unitName, '/homepage.php');



//find vehicle equipment listing
$recallStandardVehicleInformation = $mysqli->query("SELECT equipmentType FROM vehicleEquipment where unitName = '$findUser->unitName'");
$standardEquipmentArray = $recallStandardVehicleInformation->fetch_array();
$equipArray = array();
$equipArray = explode(',', $standardEquipmentArray['equipmentType']);

//find access listing
//Master Listing
$recallAccessInformation = $mysqli->query("SELECT accessValues FROM specialAccess where unitName = '$findUser->unitName'");


//Unit recall
$recallAccessInformation = $mysqli->query("SELECT accessValues FROM specialAccess where unitName = '$findUser->unitName'");

$defaultAccess = $mysqli->query("SELECT accessValues FROM specialAccess where unitName = 'Master Listing'");

$defaultAccess = $defaultAccess->fetch_array();

$defaultAccess = explode(',', $defaultAccess['accessValues']);



$standardAccessArray = $recallAccessInformation->fetch_array();
$accessArray = array();
$accessArray = explode(',', $standardAccessArray['accessValues']);

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
  <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'];?>/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/AdminLTE-master/dist/css/adminlte.min.css">



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
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1403.625px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Unit Master Information</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Unit Master Information</li>
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
                      <h3 class="card-title">Vehicle Administration</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <!--Vehicle infomration update section-->
                    <form action="admin-insert-master-access.php" method="post">
                      <div class="card-body">

                        <?php //include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/sectionSelect.php';?>

                        <!-- Select Equipment installed -->
                        <div class="form-group">
                          <label for="multiSelectEquipmentRemoved"><b>Master Equipment List</b></label><br>
                          <?php


                          if ($recallStandardVehicleInformation->num_rows == 0) {


                            echo "Unit has no Master Vehicle Equipment Listing. Contact website support.";



                          }else{
                            for ($i = 0; $i < count($equipArray); $i++) {
                              echo '<label for="equipmentRemove"></label>
                              <input style="alignment:left" type="checkbox" id="equipmentRemove[]" name="equipmentRemove[]" value="' . $equipArray[$i] . '">' . $equipArray[$i] . '<br>';
                            }
                          }
                          ?>
                        </div>

                        <!-- Select Equipment NOT installed -->

                        <?php if ($recallStandardVehicleInformation->num_rows >=1) {


                          echo '
                          <div class="form-group">
                          <button class="btn btn-md btn-danger" type="submit" id="remove" name="remove" value="Remove Equipment" style="alignment: center">Remove Equipment</button>
                          </div>
                          <br>

                          <div class="form-group">
                          <b><label for="equipmentAdd">Add to Current Master Equipment List</label></b>
                          <input type="text"  class="form-control" name="addMasterEquipment" value="">
                          <br>
                          <div class="form-group">
                          <button class="btn btn-md btn-primary" type="submit" id="add" name="add" value="Add Equipment" style="alignment: center">Add Equipment</button>
                          </div>
                          <p>Multiple items can be added. items must be seperated by a ";" (semicolon).
                          <br>
                          Example:  <input type="text"  class="form-control" name="" value="" placeholder="overhead lights; stickers; toolbox" readonly>
                          </p>
                          </div>

                          ';
                        }else {




                        }
                        ?>


                        <!-- /.card-body
                        <div class="card-footer">
                        <button  class="btn btn-primary" type="submit" id="submitInventory" name="submitInventory" value="Submit Vehicle Information">Submit</button>
                      -->
                    </div>
                  </form>
                </div>
                <!-- general form elements -->






                <!---============================== access information ----------------->
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Access Administration</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->

                  <!--Vehicle infomration update section-->
                  <form action="admin-insert-master-access.php" method="post">
                    <div class="card-body">

                      <?php //include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/sectionSelect.php';?>

                      <!-- Select Equipment installed -->
                      <div class="form-group">
                        <label for="multiSelectRemoveAccess"><b>Master Access List</b></label><br>

                        <?php

                        if ($recallAccessInformation->num_rows <= 0) {

                          $_SESSION['noPermissions'] = true;
                          echo "Unit has no Master Access Permission. Contact website support.";




                        }else{


                          foreach ($accessArray as $key => $value) {
                            if (in_array($value, $defaultAccess)) {
                              echo '<label for="removeAccess"></label>
                              <text style="alignment:left"  id="removeAccess[]" name="removeAccess[]"> ' . $value . ' *<br>';
                            }
                            elseif (!in_array($value, $defaultAccess)) {
                              echo '<label for="removeAccess"></label>
                              <input style="alignment:left" type="checkbox" id="removeAccess[]" name="removeAccess[]" value="' . $value . '"> ' . $value . '<br>';

                            }
                          }

                        }



                        if ($recallAccessInformation->num_rows >=1) {

                          echo '       <br>   <div class="form-group">
                          <button class="btn btn-md btn-danger" type="submit" id="removeAccessBtn" name="removeAccessBtn" value="Remove Access" style="alignment: center">Remove Access Type</button>
                          </div>
                          <br>

                          <!-- Select Equipment NOT installed -->
                          <div class="form-group">
                          <b><label for="accessAdd">Add to Current Access Type</label></b>
                          <input type="text"  class="form-control" name="addAccess" value="">
                          <br>

                          <div class="form-group">
                          <button class="btn btn-md btn-primary" type="submit" id="addAccessBtn" name="addAccessBtn" value="Add Access" style="alignment: center">Add Access</button>
                          </div>
                          <p>Multiple items can be added. items must be seperated by a ";" (semicolon).
                          <br>
                          Example:  <input type="text"  class="form-control" name="" value="" placeholder="ESS; VCO; Fitness" readonly>
                          </p>
                          <p>* Default access options cannot be removed</p>
                          </div>

                          ';




                        }



                        /*for ($i = 0; $i < count($accessArray); $i++) {
                        echo '<label for="removeAccess"></label>
                        <input style="alignment:left" type="checkbox" id="removeAccess[]" name="removeAccess[]" value="' . $accessArray[$i] . '"> ' . $accessArray[$i] . '<br>';
                      }*/
                      ?>
                    </div>



                    <!-- /.card-body
                    <div class="card-footer">
                    <button  class="btn btn-primary" type="submit" id="submitInventory" name="submitInventory" value="Submit Vehicle Information">Submit</button>
                  -->
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
<script src="../../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../AdminLTE-master/dist/js/adminlte.min.js"></script>

</body>

</html>
