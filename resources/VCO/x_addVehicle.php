<?php


date_default_timezone_set('America/Los_Angeles');
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include __DIR__.'/../../navigation.php';

//$config = parse_ini_file('/Users/mattheweveland/Desktop/config.ini', true);

//use PHPMailer\PHPMailer\PHPMailer;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
require __DIR__ . '/../../adminpages/vendor/autoload.php';

if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> Please login to an Admin or User account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/UnitTraining/login_logout/splashpage.php'>Login</a></p>";
    exit;
}

if (isset($_SESSION['page_user'])) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> You must be have an Admin account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/sfs/index.html'>Home Page</p>";
    exit;
}

$unitName = $_SESSION['unitName'];
$section = 'S4';

if (isset($_POST['submit'])) {

    //items that can not be changed: year, make, model, reg
    $inputReg = mysqli_real_escape_string($connection, $_POST['inputReg']);
    $inputYear = mysqli_real_escape_string($connection, $_POST['inputYear']);
    $inputMake = mysqli_real_escape_string($connection, $_POST['inputMake']);
    $inputModel = mysqli_real_escape_string($connection, $_POST['inputModel']);
    $inputDriveType = mysqli_real_escape_string($connection, $_POST['inputDriveType']);
    $inputDoorType = mysqli_real_escape_string($connection, $_POST['inputDoorType']);
    $inputStickers = mysqli_real_escape_string($connection, $_POST['inputStickers']);
    $inputDescription = mysqli_real_escape_string($connection, $_POST['itemDescriptionField']);

    $inputMileage = mysqli_real_escape_string($connection, $_POST['inputMileage']);

    $inputEquipmentMultiSelect = array();
    foreach ($_POST['multiSelectEquipmentInstalled'] as $inputEquipmentMultiSelect) {
        $inputEquipmentMultiSelects[] = mysqli_real_escape_string($connection, $inputEquipmentMultiSelect);
    }

    $inputEquipmentMultiSelectsJoined = join(', ', $inputEquipmentMultiSelects);

    $findDupes = "Select * from vehicles_daily WHERE (registration = '$inputReg')";
    $resultsFindDupes = mysqli_query($connection, $findDupes);

    $resultsFindDupes = mysqli_num_rows($resultsFindDupes);

            if (!$resultsFindDupes == true) {

        $inputVehicleInformation = "INSERT INTO vehicles_daily
                                (`id`, `registration`, `modelYear`, `model`, `make`, `driveType`,`DoorType`,
                                 `stickers`, `status`, `equipment`, `description`, `post`, `mileage`, `unitName`)
                                VALUES (id, '$inputReg','$inputYear','$inputModel','$inputMake','$inputDriveType','$inputDoorType',
                                '$inputStickers', NULL,'$inputEquipmentMultiSelectsJoined', '$inputDescription', NULL,'$inputMileage', '$unitName')";

        $resultInputVehicleInformation = mysqli_query($connection, $inputVehicleInformation) or die('Database Selection Failed' . mysqli_error($connection));

                $inputVehicleMileageInformation = "INSERT INTO vehicles_mileage
                                (`id`, `registration`, `mileage`, `unitName`)
                                VALUES (id, '$inputReg','$inputMileage', '$unitName')";

                $resultInputVehicleMileageInformation = mysqli_query($connection, $inputVehicleMileageInformation) or die('Database Selection Failed' . mysqli_error($connection));
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
    <title>VCO Add Vehicle Panel</title>
</head>

<?php if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){ ?>
<h3 style="text-align: center"><?php //echo $section;?>VCO Add Vehicle Panel</h3>
<body>
<div class="submitAddNewVehicle" >
    <div class="container">
        <form class="submitAddNewVehicle" method="POST">

            <br>
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
            <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>

            <br>
            <H3 align = 'center'>Add New Vehicle</H3>
            <br>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputReg">Vehicle Registration</label>
                    <input type="text" class="form-control" id="inputReg" name="inputReg" value="" placeholder="Registration" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputYear">Vehicle Year</label>
                    <input type="text" class="form-control" id="inputYear" name="inputYear" value="" placeholder="Year" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputMake">Vehicle Make</label>
                    <input type="text" class="form-control" id="inputMake" name="inputMake" value="" placeholder="Make" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputModel">Vehicle Model</label>
                    <input type="text" class="form-control" id="inputModel" name="inputModel" value="" placeholder="Model" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="inputMileage">Mileage</label>
                <input type="text" class="form-control" id="inputMileage" name="inputMileage" value="" placeholder="Mileage">
            </div>
            </div>




            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputDriveType">Drive Type</label>
                    <select class="form-control" id="inputDriveType" name="inputDriveType">
                        <option value="NULL"></option>
                        <option value="4">4x4</option>
                        <option value="2">4x2</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputDoorType">Door Type</label>
                    <select class="form-control" id="inputDoorType" name="inputDoorType">
                        <option value="NULL"></option>
                        <option value="2">2 Door</option>
                        <option value="4">4 Door</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputStickers">Sticker Installed</label>
                    <select class="form-control" id="inputStickers" name="inputStickers">
                        <option value="NULL"></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
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
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="itemDescriptionField">Vehicle Description</label>
                    <textarea rows="3" cols="50" name="itemDescriptionField" id="itemDescriptionField" class="form-control" placeholder="Vehicle Description" required></textarea>
                </div>
            </div>



            <input align="center" class="btn btn-primary" type="submit" name="submit" id="submit" value="Add Vehicle Information">
        </form>
    </div>
</div>
</body>


<footer>
    <?php }else {
        echo "<h3 style='text-align: center'>You do not have permisson to view this page</h3>";
    } ?>

    <!-- indluces closing html tags for body and html-->
    <?php echo '<div align="center"><a class="btn btn-secondary my-2 my-sm-0" href="vcoAdminPanel.php">VCO Administration Panel</a></div> ';
    include __DIR__ . '/../../footer.php'; ?>
