<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
date_default_timezone_set('America/Los_Angeles');

$unitName = $_SESSION['unitName'];

if (isset($_POST['submit'])) {

    $dodId = mysqli_real_escape_string($connection, $_POST['id']);
$findMember = mysqli_query($connection, "SELECT dodId FROM members where dodId = '$dodId'") or die(mysqli_error($connection));

/*
if (mysqli_num_rows($findMember) <1){

    $failuremsg = "Member is not in the system, please register.";

} else {

    $successmsg = "GOOD.";

   echo '<form class="form-inline my-2 my-lg-0" action="initialIssueList.php" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
            <button class="btn btn-primary my-2 my-sm-0" type="submit" value="Search">Search</button>

        </form>';

//redirect("initialIssueList.php?id=$dodId");

}*/
    //items that can not be changed: year, make, model, reg
    /*$inputReg = mysqli_real_escape_string($connection, $_POST['inputReg']);
    $inputYear = mysqli_real_escape_string($connection, $_POST['inputYear']);
    $inputMake = mysqli_real_escape_string($connection, $_POST['inputMake']);
    $inputModel = mysqli_real_escape_string($connection, $_POST['inputModel']);
    $inputDriveType = mysqli_real_escape_string($connection, $_POST['inputDriveType']);
    $inputDoorType = mysqli_real_escape_string($connection, $_POST['inputDoorType']);
    $inputStickers = mysqli_real_escape_string($connection, $_POST['inputStickers']);
    $inputDescription = mysqli_real_escape_string($connection, $_POST['itemDescriptionField']);


    $inputEquipmentMultiSelect = array();
    foreach ($_POST['multiSelectEquipmentInstalled'] as $inputEquipmentMultiSelect) {
        $inputEquipmentMultiSelects[] = mysqli_real_escape_string($connection, $inputEquipmentMultiSelect);
    }

    $inputEquipmentMultiSelectsJoined = join(', ', $inputEquipmentMultiSelects);



    $findDupes = "Select * from vehicles WHERE (registration = '$inputReg')";
    $resultsFindDupes = mysqli_query($connection, $findDupes);

    $resultsFindDupes = mysqli_num_rows($resultsFindDupes);

            if (!$resultsFindDupes == true) {

        $inputVehicleInformation = "INSERT INTO vehicles
                                (`id`, `registration`, `modelYear`, `model`, `make`, `driveType`,`DoorType`,
                                 `stickers`, `status`, `equipment`, `description`, `post`, `unitName`)
                                VALUES (id, '$inputReg','$inputYear','$inputModel','$inputMake','$inputDriveType','$inputDoorType',
                                '$inputStickers', NULL,'$inputEquipmentMultiSelectsJoined', '$inputDescription', NULL, '$unitName')";

        $resultInputVehicleInformation = mysqli_query($connection, $inputVehicleInformation) or die('Database Selection Failed' . mysqli_error($connection));
        if (($resultInputVehicleInformation) == true) {
            $successmsg = "Vehicle Information Successfully Updated.";

        } else {

            $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
        }
    }else{
        $failuremsg = "Information for $inputReg already exist in the system. - Please try again.";

    }*/
}






?>


<html lang="en">
<head>
    <title>Supply - Add Initial Issue</title>
</head>

<?php if((($_SESSION['page_admin']) == 'Unit_Supply') OR (($_SESSION['page_admin']) == 'matt')){ ?>
<h3 style="text-align: center"><?php //echo $section;?>Initial Issue</h3>
<body>
<div class="submitInitial" >
    <div class="container">
        <form class="submitInitialIssue" action="initialIssueList.php" method="GET">

            <br>
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
            <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>

            <div class="form-row">
                <!--DOD ID-->
                <div class="form-group col-md-3">
                    <label for="id">Member's DOD ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="" placeholder="DOD ID" required>
                </div>
            </div>

            <div class="form-row">
                <!--Gender-->
                <div class="form-group col-md-1">
                    <label for="inputGender">Gender</label>
                    <select class="form-control" id="inputGender" name="inputGender" title="inputGender" required>
                        <option value="">None</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>

                    </select>
                </div>
                <!--Height-->
                <div class="form-group col-md-2">
                    <label for="inputHeight">Height</label>
                    <input type="text" class="form-control" id="inputHeight" name="inputHeight" value="" placeholder="Height" required>
                </div>
                <!--Weight-->
                <div class="form-group col-md-2">
                    <label for="inputWeight">Weight</label>
                    <input type="text" class="form-control" id="inputWeight" name="inputWeight" value="" placeholder="Weight" required>
                </div>
            </div>


            <div class="form-row">

                <!--Top Size-->
                <div class="form-group col-md-2">
                    <label for="inputShirtSize">Shirt Size</label>
                    <select class="form-control" id="inputShirtSize" name="inputShirtSize" title="inputShirtSize" required>
                        <option value="">None</option>
                        <option value="XxS">XX-Small</option>
                        <option value="XS">X-Small</option>
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">X-Large</option>
                        <option value="XXL">XX-Large</option>
                        <option value="XXXL">XXX-Large</option>
                    </select>
                </div>
                <!--Bottom Size-->
                <div class="form-group col-md-2">
                    <label for="inputPantsSize">Pant Size</label>
                    <select class="form-control" id="inputPantsSize" name="inputPantsSize" title="inputPantsSize" required>
                        <option value="">None</option>
                        <?php
                        for ($i = 20; $i <51; $i++){
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <!--Boot Size-->
                <div class="form-group col-md-2">
                    <label for="inputShoeSize">Boot Size</label>
                    <select class="form-control" id="inputShoeSize" name="inputShoeSize" title="inputShoeSize" required>
                        <option value="">None</option>

                        <?php

                        for ($i = 5; $i <20; $i) {
                            $i = $i + .5;
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>

                    </select>
                </div>
                <!--Glove Size-->
                <div class="form-group col-md-2">
                    <label for="inputGloveSize">Glove Size</label>
                    <select class="form-control" id="inputGloveSize" name="inputGloveSize" title="inputGloveSize" required>
                        <option value="">None</option>
                        <option value="XS">X-Small</option>
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">X-Large</option>
                        <option value="XXL">XX-Large</option>
                    </select>
                </div>
                <!--Beret Size-->
                <div class="form-group col-md-2">
                    <label for="inputBeretSize">Beret Size</label>
                    <select class="form-control" id="inputBeretSize" name="inputBeretSize" title="inputBeretSize" required>
                        <option value="">None</option>
                        <?php

                        for ($i = 6.375; $i <9; $i) {
                            $i = $i + .125;
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>
            <input align="center" class="btn btn-primary" type="submit" name="submit" id="submit" value="Submit">
        </form>
    </div>
</div>
</body>

<footer>
    <?php }else {
        echo "<h3 style='text-align: center'>You do not have permission to view this page</h3>";
    } ?>

    <!-- indluces closing html tags for body and html-->
    <?php echo '<div align="center"><a href="supplyAdminPanel.php">Supply Administration Panel</a></div> ';
    include __DIR__ . '/../../footer.php'; ?>
