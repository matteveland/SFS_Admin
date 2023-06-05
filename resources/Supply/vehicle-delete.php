<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];

if (!isset($_SESSION['page_admin'])) {
    //Does not exist. Redirect user back to page-one.php
    header('Location:../../../Admin/homepage.php');
    exit;
}

if (isset($_GET['registration'])) {

    $registration = $mysqli->real_escape_string($_GET['registration']);

    $findReg = $mysqli->query("SELECT registration FROM vehicles_daily WHERE registration = '$registration'");

        if ($findReg->num_rows >=1) {

        $removeVehicle = "UPDATE `vehicles_daily` SET registration =' DELETE_$registration' WHERE registration = '$registration'";
        $removeVehicleImg = "UPDATE `vehicles_img` SET registration =' DELETE_$registration' WHERE registration = '$registration'";
        $removeVehicleMileage = "UPDATE `vehicles_mileage` SET registration =' DELETE_$registration' WHERE registration = '$registration'";

        $resultRemoveVehicle = $mysqli->query($removeVehicle);
        $resultRemoveVehicleImg = $mysqli->query($removeVehicleImg);
        $resultRemoveVehicleMileage = $mysqli->query($removeVehicleMileage);

        //$result = true;

        if (!$result = ($resultRemoveVehicle && $resultRemoveVehicleImg && $resultRemoveVehicleMileage)) {
            $failuremsg = "Error in removing vehicle. Contact the system administrator.";
        } else {
            $successmsg = "Vehicle was successfully deleted from all databases.";
        }
    }else{

        $failuremsg = "The Vehicle you are attempting to remove is not within your unit's inventory.";

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
                        <h5 class="modal-title">Delete Vehicle Message</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($successmsg)) { ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                        <?php if (isset($failuremsg)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                        <p style="text-align: center"></p>
                        <?php header("refresh:3;url=vehicle-status.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#myModal").modal('show');
        });
    </script>
    <style>
        .bs-example {
            margin: 20px;
        }
    </style>
