<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site

$unitName = $_SESSION['unitName'];
$admin = $_SESSION['page_admin'];
$user =  $_SESSION['page_user'];
$unitName =  $_SESSION['unitName'];
$now = date('Y-m-d H:i:s');

$id = $mysqli->real_escape_string($_POST['id']);
$registration = $mysqli->real_escape_string($_POST['selectVehicle']);


//possible delete
if ((($_SESSION['page_admin']) == 'Unit_VCO') or (($_SESSION['page_admin']) == 'matt')) {

  if (isset($_GET['id'])) {

    $updateVehicleInformation = "SELECT * FROM `vehicles_mileage` WHERE id = '$id' AND registration = '$registration'";

    $resultUpdateVehicleInformation = $mysqli->query($updateVehicleInformation);

    while ($recallVehicle = mysqli_fetch_assoc($resultUpdateVehicleInformation)){


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
///end posible delete


$userSearch = "SELECT * From login l
inner join members m
on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId
WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name";

var_dump($userSearch);
$resultUserSearch = $mysqli->query($userSearch);

while ($row = $resultUserSearch->fetch_assoc()) {

  $recallFirstName = $row['firstName'];
  $recallLastName = $row['lastName'];
  $recallRank = $row['rank'];

}

if($_SESSION['page_admin'] == 'Unit_VCO'){

  $addedBy = 'VCO Admin';
}else{
  $addedBy = $recallRank . ' ' . $recallLastName . ', ' . $recallFirstName;
}


$findPost = $mysqli->query("Select * from post where unitName = '$unitName'");

$postLocation = $mysqli->real_escape_string($_POST['location']);

//Vehicle Mileage
$vehicleMileage = $mysqli->real_escape_string($_POST['inputVehicleMileage']);

//Duty Section
$dutySection =$mysqli->real_escape_string($_POST['dutySection']);

//Current Status
$currentStatus = $mysqli->real_escape_string($_POST['currentStatus']);

//driver Name
$driverName =$mysqli->real_escape_string($_POST['driverName']);

//deadline Reason
$deadlineReason =$mysqli->real_escape_string($_POST['deadlineReason']);
//1800
$eighteenHundred =$mysqli->real_escape_string($_POST['input1800']);
$eighteenHundredNotes =$mysqli->real_escape_string($_POST['input1800Notes']);

//waiver
$waiverCard =$mysqli->real_escape_string($_POST['inputWaiverCard']);
$waiverCardNotes =$mysqli->real_escape_string($_POST['inputWaiverCardNotes']);

//91
$ninetyOne =$mysqli->real_escape_string($_POST['input91']);
$ninetyOneNotes =$mysqli->real_escape_string($_POST['input91Notes']);

//518
$fiveHundredEighteen =$mysqli->real_escape_string($_POST['input518']);
$fiveHundredEighteenNotes =$mysqli->real_escape_string($_POST['input518Notes']);

$selectVehicle =$mysqli->real_escape_string($registration);

//$resultsFindVehilces = $mysqli->query("SELECT * FROM vehicles_daily where unitName = '$unitName' AND registration NOT LIKE '%DELETE_%'");



$findVehicles = $mysqli->query("SELECT * FROM vehicles_mileage WHERE (registration = '$selectVehicle' AND unitName = '$unitName' )") or die(mysqli_connect_errno());

$resultsFindVehicles = $findVehicles->fetch_assoc();

if (!isset($_POST['submitInventory'])) {

} else {


  if (($vehicleMileage <= $resultsFindVehicles['mileage'] == true) or ($resultsFindVehicles['mileage'] == '')) {

    $results5 = $resultsFindVehicles['mileage'];
    $failure = " $results5 Last mileage added for <b>$selectVehicle</b> is less that previously entered. Check mileage and re-enter. $vehicleMileage";
  } else {


    $updateVehicleInformation = "UPDATE `vehicles_mileage`
    SET `id`=id,`registration`='$registration',`location`='$postLocation',`mileage`='$vehicleMileage',
    `dutySection`='$dutySection',`AF1800`='$eighteenHundred',`waiverCard`='$waiverCard',`AF91`='$ninetyOne',
    `AF518`='$fiveHundredEighteen',`post`='$postLocation',`status`='$currentStatus',`deadlineReason`='$deadlineReason',
    `driverName`='$driverName',`lastUpdate`='$now',`updatedBy`='$addedBy',`unitName`='$unitName' where id = '$id'";




    $updateVehicleInfoSuccess = $mysqli->query($updateVehicleInformation) or die("Connection error: " . mysqli_connect_errno());

    $updateVehicleStatus = "update `vehicles_daily` SET `post` = '$postLocation', status = '$currentStatus', mileage = '$vehicleMileage' where registration = '$selectVehicle' AND unitName = '$unitName'";

    $updateVehicleStatus = $mysqli->query($updateVehicleStatus) or die("Connection error: " . mysqli_connect_errno());

    if (!$updateVehicleInfoSuccess or !$updateVehicleStatus) {
      $failure = 'Error, vehicle information was not added. Contact system admin.';
    } else {
      $success = 'Vehicle information successfully added for ' . $selectVehicle . '! '.$vehicleMileage.'';

      $location = "vehicle-view-data.php?reg=$registration&id=$id";

    //  echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';


    }
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
            <h5 class="modal-title">Vehicle Successfully Added into Inventory</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

            <?php if (isset($success)) { ?>
              <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
              </div><?php } ?>
              <?php if (isset($failure)) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $failure; ?> </div><?php } ?>
                  <?php if (isset($insertInsert)) { ?>
                    <div class="alert alert-success" role="alert">
                      <?php echo $insertInsert; ?>
                    </div><?php }?>
                    <?php if (isset($insertFailure)) { ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $insertFailure; ?>
                      </div><?php } ?>


                      <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                        <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                          <p style="text-align: center"></p>
                          <?php  header("refresh:3;url=$location");?>
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
