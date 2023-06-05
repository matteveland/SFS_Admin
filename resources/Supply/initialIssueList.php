<?php


date_default_timezone_set('America/Los_Angeles');
require_once __DIR__.'/../../dbconfig/connect.php';
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
$dodId = mysqli_real_escape_string($connection, $_GET['id']);
print_r($dodId);


$findMember = mysqli_query($connection, "SELECT dodId FROM members where dodId = '$dodId'") or die($connection);





if (isset($_POST['submit'])) {


    $itemDesc = array();
    $itemDesc = array(array('Gortex','1'), array('Gloves','2'));

    if ($_POST['inputItemID'] == $itemDesc[0][1]){

        $item = "gortex";
    }elseif ($_POST['inputItemID'] == $itemDesc[1][1]){
       $item = "Gloves";
    }else{

        $failuremsg = "error";




    }


    $itemNumber = 1;


   // $dodId = mysqli_real_escape_string($connection, $_POST['inputDodId']);

if(!$item) {
    $failuremsg = "error";

} else{

    $insertItemIssue = "INSERT INTO `supply_Issue` (id, dodId, unitName, itemName, itemDescription, itemCost, itemQuantity) values (id, '1256916548', '432 SFS', '$item', 'Cold weather gear', '100', '1')";
    $insertIssueItems = mysqli_query($connection, $insertItemIssue) or die('Database Selection Failed' . mysqli_error($connection));



}
if (!$insertIssueItems) {
    $failuremsg = "item was not added to gear issues. error";
}else{
    $successmsg = "Item Successfully Added";

    echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
}

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



$findItemsIssued = mysqli_query($connection, "SELECT supply_Issue.itemName, itemDescription, COUNT(itemCost) AS Cost, COUNT(itemQuantity) AS Count  FROM supply_Issue where dodId = '$dodId' GROUP BY supply_Issue.itemName") or die('Database Selection Failed' . mysqli_error($connection));


?>


<html lang="en">
<head>
    <title>Supply - Add Initial Issue List</title>
</head>

<?php if((($_SESSION['page_admin']) == 'Unit_Supply') OR (($_SESSION['page_admin']) == 'matt')){ ?>
<h3 style="text-align: center"><?php //echo $section;?>Initial Issue List</h3>
<body>
<div class="submitInitialIssue" >
    <div class="container">
        <form class="submitInitialIssue" method="POST">

            <br>
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
            <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>

            <div class="form-row">
                <!--DOD ID-->
                <div class="form-group col-md-3">

                    <?php echo $dodId; ?>
                </div>
            </div>


                <div class="form-group col-md-2">
                    <label for="inputItemID">Item ID</label>
                    <input type="text" class="form-control" id="inputItemID" name="inputItemID" value="" placeholder="Item ID Number" required>
                </div>

            <input align="center" class="btn btn-primary" type="submit" name="submit" id="submit" value="Submit">
        </form>
    </div>

    <?php
    //$result1 = mysqli_query($connection, $sqlSFMQ) or die(mysqli_error($connection));

    echo "<h3 align='center'>Issued Gear</h3>";

    if (mysqli_num_rows($findItemsIssued) > 0) {
//($row = mysqli_fetch_array($result) > 1)

// output data of each row
        echo "<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Item Name</th>");
        print("<th>Item Description</th>");
        print("<th>item Cost</th>");
        print("<th>Single Item issued</th>");


        while ($row = mysqli_fetch_assoc($findItemsIssued)) {

            //echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngType"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";
            echo "<tr class='nth-child' align='center'>
                                <td class='nth-child'>" . $row['itemName'] . "</td>
                                <td>" . $row['itemDescription'] . "</td>
                                <td>" . $row['itemCost'] . "</td>
                                <td>" . $row['Count'] . "</td>";


        }
    } else {
        echo "<p align='center'>No Training Due</p>";
    }
    echo "</table>";



    ?>
</div>
</body>

<footer>
    <?php }else {
        echo "<h3 style='text-align: center'>You do not have permission to view this page</h3>";
    } ?>

    <!-- indluces closing html tags for body and html-->
    <?php echo '<div align="center"><a href="supplyAdminPanel.php">Supply Administration Panel</a></div> ';
    include __DIR__ . '/../../footer.php'; ?>
