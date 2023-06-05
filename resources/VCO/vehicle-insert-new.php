<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
isAdmin('/resources/VCO/vehicle-report.php');
date_default_timezone_set('America/Los_Angeles');

$unitName = $_SESSION['unitName'];
$section = 'S4';

if (isset($_POST['submit'])) {

    //items that can not be changed: year, make, model, reg
    $inputReg = $mysqli->real_escape_string($_POST['inputReg']);
    $inputYear = $mysqli->real_escape_string($_POST['inputYear']);
    $inputMake = $mysqli->real_escape_string($_POST['inputMake']);
    $inputModel = $mysqli->real_escape_string($_POST['inputModel']);
    $inputDriveType = $mysqli->real_escape_string($_POST['inputDriveType']);
    $inputDoorType = $mysqli->real_escape_string($_POST['inputDoorType']);
    $inputStickers = $mysqli->real_escape_string($_POST['inputStickers']);
    $inputDescription = $mysqli->real_escape_string($_POST['itemDescriptionField']);

    $inputMileage = $mysqli->real_escape_string($_POST['inputMileage']);

    $inputEquipmentMultiSelect = array();
    foreach ($_POST['multiSelectEquipmentInstalled'] as $inputEquipmentMultiSelect) {
        $inputEquipmentMultiSelects[] = $mysqli->real_escape_string($inputEquipmentMultiSelect);
    }

    $inputEquipmentMultiSelectsJoined = join(', ', $inputEquipmentMultiSelects);

    $findDupes = "Select * from vehicles_daily WHERE (registration = '$inputReg')";
    $resultsFindDupes = $mysqli->query($findDupes);


            if ($resultsFindDupes->num_rows < 1) {

        $inputVehicleInformation = "INSERT INTO vehicles_daily
                                (`id`, `registration`, `modelYear`, `model`, `make`, `driveType`,`DoorType`,
                                 `stickers`, `status`, `equipment`, `description`, `post`, `mileage`, `unitName`)
                                VALUES (id, '$inputReg','$inputYear','$inputModel','$inputMake','$inputDriveType','$inputDoorType',
                                '$inputStickers', NULL,'$inputEquipmentMultiSelectsJoined', '$inputDescription', NULL,'$inputMileage', '$unitName')";

        $resultInputVehicleInformation = $mysqli->query($inputVehicleInformation) or die('Database Selection Failed' . $mysqli->mysqli_errno());

                $inputVehicleMileageInformation = "INSERT INTO vehicles_mileage
                                (`id`, `registration`, `mileage`, `unitName`)
                                VALUES (id, '$inputReg','$inputMileage', '$unitName')";

                $resultInputVehicleMileageInformation = $mysqli->query($inputVehicleMileageInformation) or die('Database Selection Failed' . $mysqli->mysqli_errno());
        if (($resultInputVehicleInformation) == true) {
            $successmsg = "Vehicle Information Successfully Updated.";

        } else {

            $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
        }
    }else{
        $failuremsg = "Information for $inputReg already exist in the system. - Please try again.";

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
                    <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                    <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
               <p style="text-align: center"></p>
                    <?php  header("refresh:3;url=vehicle-view-new.php");?>
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
