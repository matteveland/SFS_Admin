<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];

$unitName = $_SESSION['unitName'];
$section = 'S4';

if (isset($_POST['submit'])) {
    $inputItemName = mysqli_real_escape_string($connection, $_POST['inputItemName']);
    $inputModelName = mysqli_real_escape_string($connection, $_POST['inputModel']);
    $inputStockNumber = mysqli_real_escape_string($connection, $_POST['inputNumber']);
    $inputManufacturer = mysqli_real_escape_string($connection, $_POST['inputManufacturer']);

    $inputItemCost = money_format('%.2n', mysqli_real_escape_string($connection, $_POST['inputItemCost']));
  //  $inputItemCost = mysqli_real_escape_string($connection, $_POST['inputItemCost']);
    $inputDateReceived = mysqli_real_escape_string($connection, $_POST['inputDateReceived']);
    $inputQuanNumber = mysqli_real_escape_string($connection, $_POST['inputQuanNumber']);
    $inputDescription = mysqli_real_escape_string($connection, $_POST['itemDescriptionField']);
    $inputQuantity = mysqli_real_escape_string($connection, $_POST['inputQuantity']);
    $inputIssueType = mysqli_real_escape_string($connection, $_POST['inputIssueType']);


    $findDupes = "Select * from supply_Receiving WHERE (itemName = 'inputItemName' AND stockNumber = '$inputStockNumber' AND modelName = '$inputModelName')";
    $resultsFindDupes = mysqli_query($connection, $findDupes);

    $resultsFindDupes = mysqli_num_rows($resultsFindDupes);

            if (!$resultsFindDupes == true) {
/*

            INSERT INTO `supply_Receiving`(`id`, `unitName`, `itemName`, `itemDescription`, `itemCost`,
                                            `itemQuantity`, `modelName`, `stockNumber`, `manufacturerName`, `dateReceived`,
                                            `issueType`)
                                    VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],
                                            [value-6],[value-7],[value-8],[value-9],[value-10],
                                            [value-11])
*/
        $inputEquipmentInformation = "INSERT INTO supply_Receiving (`id`, `unitName`, `itemName`, `itemDescription`, `itemCost`,
                                                                    `itemQuantity`, `quantityType`, `modelName`, `stockNumber`, `manufacturerName`, `dateReceived`,
                                                                    `issueType`)
                                VALUES (id, '$unitName','$inputItemName','$inputDescription','$inputItemCost','$inputQuanNumber', '$inputQuantity', '$inputModelName',
                                '$inputStockNumber', '$inputManufacturer', '$inputDateReceived', '$inputIssueType')";

        $resultInputEquipmentInformation = mysqli_query($connection, $inputEquipmentInformation) or die('Database Selection Failed' . mysqli_error($connection));
        if (($resultInputEquipmentInformation) == true) {
            $successmsg = "Equipment Information Successfully Updated.";

        } else {

            $failuremsg = "Equipment Information Was Not Updated - Please try again.";
        }
    }else{
        $failuremsg = "Information for $inputItemName already exist in the system. - Please try again.";

    }
}






?>


<html lang="en">
<head>
    <title>SupplyEquipment Panel</title>
</head>

<?php if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){ ?>
<h3 style="text-align: center"><?php //echo $section;?>Supply Equipment Panel</h3>
<body>
<div class="submitAddNewEquipment" >
    <div class="container">
        <form class="submitAddNewEquipment" method="POST">

            <br>
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
            <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>

            <br>
            <H3 align = 'center'>Add New Equipment</H3>
            <br>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputItemName">Item Name</label>
                    <input type="text" class="form-control" id="inputItemName" name="inputItemName" value="" placeholder="Item Name" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputModel">Item Model</label>
                    <input type="text" class="form-control" id="inputModel" name="inputModel" value="" placeholder="Model" required>
                </div>


                <div class="form-group col-md-3">

                </div>
                <div class="form-group col-md-3">

                </div>


            </div>

            <div class="form-row">


            </div>

            <div class="form-row">

                <div class="form-group col-md-3">

                </div>
                <div class="form-group col-md-3">

                </div>
                <div class="form-group col-md-3">

                </div>
                <div class="form-group col-md-3">

                </div>
            </div>

            <div class="form-row">


            </div>

            <input align="center" class="btn btn-primary" type="submit" name="submit" id="submit" value="Add Equipment Information">
        </form>
    </div>
</div>
</body>

<footer>
    <?php }else {
        echo "<h3 style='text-align: center'>You do not have permission to view this page</h3>";
    } ?>
