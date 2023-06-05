<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');

//find time for insert/update information
$now = date('Y-m-d H:i:s');

//get user_name/unit_name from cookies
$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

//find user who is updating information for the page.
$userSearch = $mysqli->query("SELECT * From login l inner join members m on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name");

while ($row = $userSearch->fetch_assoc()) {

  $recallFirstName = $row['firstName'];
  $recallLastName = $row['lastName'];
  $recallRank = $row['rank'];

}
print_r($userSearch);

//look for VCO login or edit otherwide find user logged in
if($_SESSION['page_admin'] == 'Unit_VCO'){

  $addedBy = 'VCO Admin';
}else{
  $addedBy = $recallRank . ' ' . $recallLastName . ', ' . $recallFirstName;
}
echo $addedBy;

//end find user information

$id= $mysqli->real_escape_string($_POST['id']);
$reg = $mysqli->real_escape_string($_POST['inputRegistration']);

$recallVehicleInformation = "";
$resultRecallVehicleInformation = $mysqli->query("SELECT * FROM vehicles_daily WHERE registration = '$reg'");

while ($recallVehicle = $resultRecallVehicleInformation->fetch_assoc()) {

  $recallEquipmentInstalled = $recallVehicle['equipment'];
  $recallEquipmentInstalled = explode(', ', $recallEquipmentInstalled);
  sort($recallEquipmentInstalled);
}

if (!isset($_POST['submit-update-vehicle-data'])) {

} else {
  if (isset($_POST['submit-update-vehicle-data'])) {

    //items that can not be changed: year, make, model, reg
    $inputStickers = $mysqli->real_escape_string($_POST['inputStickers']);
    $inputDescription = $mysqli->real_escape_string($_POST['inputDescription']);
    $inputEquipmentMultiSelect = array();

    $inputVehicleInformation = "UPDATE vehicles_daily set `stickers` = '$inputStickers', `description` = '$inputDescription'
    WHERE (registration = '$reg')";

    $resultInputVehicleInformation = $mysqli->query($inputVehicleInformation) or die(mysqli_errno());

    if (($resultInputVehicleInformation) == true) {
      $successmsg = "Vehicle Information Successfully Updated.";

    } else {

      $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
    }
  }
}




//Add equipment to vehicle
if (isset($_POST['add'])) {

  //items that can not be changed: year, make, model, reg
  $equipmentInstalledUpdateAdd = $_POST['equipmentAdd'];
  $equipmentInstalledUpdateAddArray = join(', ', $_POST['equipmentAdd']);
  $combineArray = $equipmentInstalledUpdateAddArray . ', ' . join(', ', $recallEquipmentInstalled);

  $updateVehicleInformation = "UPDATE vehicles_daily SET equipment = '$combineArray', updatedBy = '$addedBy', lastUpdate = '$now' WHERE (registration = '$reg')";

  $resultUpdateVehicleInformation = $mysqli->query($updateVehicleInformation);

  if (($resultUpdateVehicleInformation) == true) {
    $successmsg = "Vehicle Information Successfully Updated.";

  } else {
    $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
  }
}

//Remove equipment from vehicle
if (isset($_POST['remove'])) {

  //items that can not be changed: year, make, model, re
  $equipmentInstalledUpdateRemove = $_POST['equipmentRemove'];
  $newEquipmentListArray = array_diff($recallEquipmentInstalled, $equipmentInstalledUpdateRemove);
  //  print_r($equipmentInstalledUpdateRemove);
  $equipmentInstalledUpdateRemoveArray = join(', ', $newEquipmentListArray);
  $updateVehicleInformation = "UPDATE vehicles_daily SET equipment = '$equipmentInstalledUpdateRemoveArray', updatedBy = '$addedBy', lastUpdate = '$now' WHERE (registration = '$reg')";
  $resultUpdateVehicleInformation = $mysqli->query($updateVehicleInformation);

  if (($resultUpdateVehicleInformation) == true) {
    $successmsg = "Vehicle Information Successfully Updated.";
  } else {
    $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
  }
}

?>


<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<body>
  <div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Insert Vehicle Data</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <p style="text-align: center"></p>
                <?php  header("refresh:5;url=/resources/VCO/vehicle-view-data.php?reg=$reg&id=$id");?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="bs-example">
        <div id="myModal" class="modal fade" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Logging In</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>You will be rerouted to the SFSAdmin homepage</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
    </html>

    <script>
    $(document).ready(function(){
      $("#myModal").modal('show');
    });
    </script>
    <style>
    .bs-example{
      margin: 20px;
    }
    </style>




    <!-- indluces closing html tags for body and html-->
    <!-- place below last </div> tag -- indluces closing html tags for body and html-->
