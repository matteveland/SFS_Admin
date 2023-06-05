<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
isAdmin('/rhomepage.php');
date_default_timezone_set('America/Los_Angeles');

$returnTo = $_SERVER['HTTP_REFERER'];
$noData = $_SESSION['noData'];



$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);


$recallStandardVehicleInformation = $mysqli->query("SELECT equipmentType FROM vehicleEquipment where unitName = '$findUser->unitName'");
$standardEquipmentArray = $recallStandardVehicleInformation->fetch_array();
$equipArray = array();
$equipArray = explode(',', $standardEquipmentArray['equipmentType']);


$addEquipment = $mysqli->real_escape_string($_POST['addMasterEquipment']);
$addEquipmentArray = array();
$addEquipmentArray = explode(';', $addEquipment);


$removeEquipment = array();
$removeEquipmentArray = array();

//access add
$accessQuery = $mysqli->query("SELECT accessValues from specialAccess where unitName = '$findUser->unitName'");
$accessQueryArray = $accessQuery->fetch_array();
$accessArray = array();
$accessArray = explode(',', $accessQueryArray['accessValues']);

$addAccessArray = $mysqli->real_escape_string($_POST['addAccess']);


//access remove

if (!empty($_POST['equipmentRemove']) AND isset($_POST['remove'])){
  $subject = "Vehicle Information";
  $removeEquipment = implode(";", $_POST['equipmentRemove']);
  $removeEquipmentArray = explode(';', trim($removeEquipment));

  foreach($removeEquipmentArray as $key => $value) {


      $mysqli->real_escape_string($value);
  }

  foreach($equipArray as $key => $value) {


    if(in_array($value, $removeEquipmentArray)) {
      unset($equipArray[$key]);
    }
  }

  $newEquipmentArray = implode(",", $equipArray);

  $addEquimentVehicleInformation = $mysqli->query("UPDATE vehicleEquipment SET equipmentType = '$newEquipmentArray'where unitName = '$findUser->unitName'");

  if (!$addEquimentVehicleInformation) {
    $failuremsg = "Vehicle Equipment Information Was Not Updated - Please try again.";

    // code...
  }else{
    $successmsg = "Vehicle Equipment Information Successfully Updated.";
  }

}

if (!empty($_POST['addMasterEquipment']) AND isset($_POST['add'])){

  $subject = "Vehicle Information";

  $addEquipmentArray = explode(';', $addEquipment);
  for ($i=0; $i < count($addEquipmentArray); $i++) {
    $mysqli->real_escape_string($addEquipmentArray[$i]);
    array_push($equipArray, rtrim(ltrim("$addEquipmentArray[$i]")));
  }

  /*foreach($equipArray as $key => $value) {


      $mysqli->real_escape_string($value);
  }*/
  $newEquipmentArray = implode(",", $equipArray);

  //get all inputs from form and make an array with the data 1 to n.
  echo "UPDATE vehicleEquipment SET equipmentType = '$newEquipmentArray'where unitName = '$findUser->unitName'";

  $addEquimentVehicleInformation = $mysqli->query("UPDATE vehicleEquipment SET equipmentType = '$newEquipmentArray'where unitName = '$findUser->unitName'");




  if (!$addEquimentVehicleInformation) {
    $failuremsg = "Vehicle Equipment Information Was Not Updated - Please try again.";

    // code...
  }else{
    $successmsg = "Vehicle Equipment Information Successfully Updated.";
  }

}

if (empty($_POST['equipmentRemove']) AND isset($_POST['remove']) OR empty($_POST['addMasterEquipment']) AND isset($_POST['add'])){
  $subject = "Vehicle Information";

  $noupdate = "No change to Vehicle Equipment Information. No items added or removed.";

  // code...
}

if (!empty($_POST['addAccess']) AND isset($_POST['addAccessBtn'])) {
  $subject = "Access Information";
  // code...
  $addAccessArray = explode(';', $addAccessArray);
  //$newAccessArray= array();

  //trim data
  for ($i=0; $i < count($addAccessArray); $i++) {
        $mysqli->real_escape_string($addAccessArray[$i]);
    array_push($accessArray, rtrim(ltrim("$addAccessArray[$i]")));
  }

  $newAccessArray = implode(",", $accessArray);

  $addAccessUpdate = $mysqli->query("UPDATE specialAccess SET accessValues = '$newAccessArray' where unitName = '$findUser->unitName'");

  if (!$addAccessUpdate) {
    $failuremsg = "Access Information Was Not Updated - Please try again.";
    // code...
  }else{
    $successmsg = "Access Information Successfully Updated.";
  }

}

if (!empty($_POST['removeAccess']) AND isset($_POST['removeAccessBtn'])) {
  $subject = "Access Information";
  $defaultAccess = $mysqli->query("SELECT accessValues FROM specialAccess where unitName = 'Master Listing'");
  $defaultAccessArray = $defaultAccess->fetch_array();
  $defaultAccess = array();
  $defaultAccess = explode(',', $defaultAccessArray['accessValues']);


    foreach($defaultAccess as $key => $value) {


        $mysqli->real_escape_string($value);
    }



  //echo is_array($defaultAccess) ? 'defaultAccess array' : 'is not array';
  $newRemoveArray= array();//

  str_replace(",", ";", $_POST['removeAccess']);
  $removeAccessArray = implode(";", $_POST['removeAccess']);
  $removeAccessArray = explode(";", $removeAccessArray);

  for ($i=0; $i < count($removeAccessArray); $i++) {
      $mysqli->real_escape_string($removeAccessArray[$i]);

    trim("$removeAccessArray");
    array_push($newRemoveArray, "$removeAccessArray[$i]");
  }

  foreach ($newRemoveArray as $key => $value) {
    if (in_array($value, $defaultAccess)) {
      unset($newRemoveArray[$key]);
    }
  }
  var_dump($newRemoveArray);
  //_______remove permissions________
  foreach ($accessArray as $key => $value) {
    if (in_array($value, $newRemoveArray)) {
      unset($accessArray[$key]);
    }
  }

  $newAccessArray = implode(",", $accessArray);

  $removeAccessUpdate = $mysqli->query("UPDATE specialAccess SET accessValues = '$newAccessArray' where unitName = '$findUser->unitName'");

  echo "UPDATE specialAccess SET accessValues = '$newAccessArray' where unitName = '$findUser->unitName'";

  if (!$removeAccessUpdate) {
    $failuremsg = "Access Information Was Not Updated - Please try again.";

  }else{
    $successmsg = "Access Information Successfully Updated.";
  }

}

if ((empty($_POST['removeAccess']) AND isset($_POST['removeAccessBtn'])) OR (empty($_POST['addAccess']) AND isset($_POST['addAccessBtn'])))  {
  // code...
}
$subject = "Vehicle Information";

$noupdate = "No change to Vehicle Equipment Information. No items added or removed.";

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
            <h5 class="modal-title"><?php echo $subject; ?> Successfully Updated</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <p style="text-align: center"></p>

                <?php if(isset($noupdate)){ ?><div class="alert alert-secondary" role="alert" style="text-align: center"> <?php echo $noupdate; ?> </div><?php } ?>
                  <p style="text-align: center"></p>
                  <?php header("refresh:3;url=$returnTo");?>
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
