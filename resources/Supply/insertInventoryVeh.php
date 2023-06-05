<?php


date_default_timezone_set('America/Los_Angeles');
require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';
include('/Users/matteveland/code/data.env'); //include ('/var/services/home/sfs/data.env');
use PHPMailer\PHPMailer\PHPMailer;

$now = date('Y-m-d H:i:s');
$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p align='center'> Please login to an Admin or User account to view this page.</p>";
    echo "<p align='center'><a href='/UnitTraining/login_logout/login.php'>Login</a></p>";
    exit;
}

$userSearch = "SELECT * From login l
inner join members m
on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId
WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name";

$resultUserSearch = mysqli_query($connection, $userSearch);

while ($row = mysqli_fetch_assoc(($resultUserSearch))) {

    $recallFirstName = $row['firstName'];
    $recallLastName = $row['lastName'];
    $recallRank = $row['rank'];
}

$addedBy = $recallRank . ' ' . $recallLastName . ', ' . $recallFirstName;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//date_default_timezone_set('America/Los_Angeles');
require __DIR__ . '/../../adminpages/vendor/autoload.php';

$findPost = mysqli_query($connection, "Select * from post where unitName = '$unitName'");

$postLocation = $_POST['location'];
$postLocation = mysqli_escape_string($connection, $postLocation);

//Vehicle Mileage
$vehicleMileage = $_POST['inputVehicleMileage'];
$vehicleMileage = mysqli_escape_string($connection, $vehicleMileage);

//Duty Section
$dutySection = $_POST['dutySection'];
$dutySection = mysqli_real_escape_string($connection, $_POST['dutySection']);

//Current Status
$currentStatus = $_POST['currentStatus'];
$currentStatus = mysqli_escape_string($connection, $currentStatus);

//driver Name
$driverName = $_POST['driverName'];
$driverName = mysqli_real_escape_string($connection, $driverName);


//deadline Reason
$deadlineReason = $_POST['deadlineReason'];
$deadlineReason = mysqli_real_escape_string($connection, $deadlineReason);
//1800
$eighteenHundred = mysqli_real_escape_string($connection, $_POST['input1800']);
$eighteenHundredNotes = mysqli_real_escape_string($connection, $_POST['input1800Notes']);

//waiver
$waiverCard = mysqli_real_escape_string($connection, $_POST['inputWaiverCard']);
$waiverCardNotes = mysqli_real_escape_string($connection, $_POST['inputWaiverCardNotes']);

//91
$ninetyOne = mysqli_real_escape_string($connection, $_POST['input91']);
$ninetyOneNotes = mysqli_real_escape_string($connection, $_POST['input91Notes']);

//518
$fiveHundredEighteen = mysqli_real_escape_string($connection, $_POST['input518']);
$fiveHundredEighteenNotes = mysqli_real_escape_string($connection, $_POST['input518Notes']);

$selectVehicle = mysqli_real_escape_string($connection, $_POST['selectVehicle']);

$findVehicles = "SELECT * FROM vehicle_daily WHERE unitName = '$unitName'";
$resultsFindVehicles = mysqli_query($connection, $findVehicles);


/* //$emailSend = urldecode('YOUR.EMAIL@DOMAIN.COM@gmail.com');

 //Create a new PHPMailer instance
 $mail = new PHPMailer;
 //Tell PHPMailer to use SMTP
 $mail->isSMTP();
 //Enable SMTP debugging
 // 0 = off (for production use)
 // 1 = client messages
 // 2 = client and server messages
 $mail->SMTPDebug = 0;
 //Set the hostname of the mail server
 $mail->Host = 'smtp.gmail.com';
 //Set the SMTP port number - likely to be 25, 465 or 587
 $mail->Port = 587;
 //Whether to use SMTP authentication
 $mail->SMTPAuth = true;
 //Username to use for SMTP authentication
 $mail->Username = 'YOUR.EMAIL@DOMAIN.COM';
 //Password to use for SMTP authentication
 $mail->Password = $mailAuthorizationPassword;
 //Set who the message is to be sent from
 $mail->setFrom('YOUR.EMAIL@DOMAIN.COM', 'Daily Inventory Check');
 //Set an alternative reply-to address
 //$mail->addReplyTo('YOUR.EMAIL@DOMAIN.COM', 'System Admin');
 //Set who the message is to be sent to
 $mail->addAddress($emailSend);
 //Set the subject line
 $mail->Subject = 'Inventory Check';
 //Read an HTML message body from an external file, convert referenced images to embedded,
 //convert HTML into a basic plain-text alternative body
 //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
 //Replace the plain text body with one created manually

 $body = "";
 $mail->Body = $body;
 $mail->AltBody = strip_tags($body);
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
 if (!$mail->send()) {
     $failure = 'Email was not sent!';
 } else {

     $success = 'Email message was successfully sent to ' . $emailSend . '!';


 }*/


$body = "<p>Vehicle information has been submitted for the following vehicle:  <B>" . $selectVehicle . " </B> for <B>" . $now . "</B> <br>
                   Vehicle Mileage: <B> " . $vehicleMileage . "</B><br>
                   AF Form 1800: " . $eighteenHundred . " - " . $eighteenHundredNotes . "<br>
                   Waiver Card: " . $waiverCard . " - " . $waiverCardNotes . "<br>
                   AF Form 91: " . $ninetyOne . " - " . $ninetyOneNotes . "<br>
                   DD Form 518: " . $fiveHundredEighteen . " - " . $fiveHundredEighteenNotes . "<br>
                   Submitted by:   " . $addedBy . "</p>";



if (!isset($_POST['submitInventory'])) {
} else {
    $findVehicles = "SELECT * FROM vehicles_mileage WHERE (registration = '$selectVehicle' AND unitName = '$unitName')";
    $resultsFindVehicles = mysqli_query($connection, $findVehicles);
    $resultsFindVehicles = mysqli_fetch_assoc($resultsFindVehicles);

    if (($vehicleMileage <= $resultsFindVehicles['mileage'] == true) or ($resultsFindVehicles['mileage'] == '')) {
        $failure = "Last mileage added for <b>$selectVehicle</b> is less that previously entered. Check mileage and re-enter.";
    } else {

        $insertVehicleInfo = "INSERT INTO `vehicles_mileage` (`id`, `registration`, `location`, `mileage`, `dutySection`,
                            `AF1800`, `waiverCard`, `AF91`, `AF518`, `post`, `status`, `deadlineReason`, `driverName`,
                            `lastUpdate`, `updatedBy`, `unitName`)
                             VALUES (id, '$selectVehicle','$postLocation','$vehicleMileage','$dutySection',
                             '$eighteenHundred','$waiverCard', '$ninetyOne','$fiveHundredEighteen', '$postLocation', '$currentStatus', '$deadlineReason', '$driverName',
                             '$now', '$addedBy', '$unitName')";

        $insertVehicleInfoSuccess = mysqli_query($connection, $insertVehicleInfo);

        $updateVehicleStatus = "update `vehicles_daily` SET `post` = '$postLocation', status = '$currentStatus', mileage = '$vehicleMileage' where registration = '$selectVehicle' AND unitName = '$unitName'";

        $updateVehicleStatus = mysqli_query($connection, $updateVehicleStatus);

        if (!$insertVehicleInfoSuccess or !$updateVehicleStatus) {
            $failure = 'Error, vehicle information was not added. Contact system admin.';
        } else {
            $success = 'Vehicle information successfully added for ' . $selectVehicle . '!';
        }
    }
}
?>
<html lang="en">

<head>
    <title></title>
</head>

<body>


    <div class="member_update">
        <div class="container" align="center">
            <form method="POST" enctype="multipart/form-data">

                <?php if (isset($success)) { ?>
                    <div class="alert alert-success" role="alert"> <?php echo $success; ?> </div><?php } ?>
                <?php if (isset($failure)) { ?>
                    <div class="alert alert-danger" role="alert"> <?php echo $failure; ?> </div><?php } ?>
                <?php if (isset($insertInsert)) { ?>
                    <div class="alert alert-success" role="alert"> <?php echo $insertInsert; ?> </div><?php } ?>
                <?php if (isset($insertFailure)) { ?>
                    <div class="alert alert-danger" role="alert"> <?php echo $insertFailure; ?> </div><?php } ?>

                <h2 class="">Vehicle Information Submission</h2>

                <!-- Select Vehicle "selectVehicle"-->
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="selectVehicle">Vehicle</label>
                        <select class="form-control" id="selectVehicle" name="selectVehicle" title="selectVehicle" autofocus required>
                            <option value="">Select Vehicle</option>
                            <?php

                            $recallStandardVehicleInformation = "SELECT registration FROM vehicles_daily WHERE unitName = '432 SFS'";
                            $recallStandardVehicleInformation = mysqli_query($connection, $recallStandardVehicleInformation);
                            $recallStandardVehicleInformationArray = array();
                            $recallStandardVehicleInformationArray = mysqli_fetch_all($recallStandardVehicleInformation);
                            $count = count($recallStandardVehicleInformationArray);
                            for ($i = 0; $i < $count; ++$i) {
                                echo '<option value=' . $recallStandardVehicleInformationArray[$i][0] . '>' . $recallStandardVehicleInformationArray[$i][0] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Select section "dutySection"-->
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="dutySection">section</label>
                        <select class="form-control" id="dutySection" name="dutySection" title="dutySection" required autofocus>
                            <option value="">Select section</option>
                            <?php
                            $sections = array();
                            $sections = array("Alpha", "Bravo", 'Charlie', 'Delta', 'Echo', 'Foxtrot');


                            $count = count($sections);

                            for ($i = 0; $i < $count; ++$i) {
                                echo '<option value=' . $sections[$i] . '>' . $sections[$i] . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="location">Post Assigned</label>
                        <select class="form-control" title="location" id="location" name="location" autofocus required>
                            <option value="">Select Post/Patrol</option>
                            <?php

                            //find post for unit
                            $findPost = "SELECT `post/patrol` from post where unitName = '$unitName'";
                            $resultsFindPost = mysqli_query($connection, $findPost);
                            $resultsFindPostAssoc = mysqli_fetch_assoc($resultsFindPost);
                            $vehicleArray = array();
                            $vehicleArray = explode(', ', $resultsFindPostAssoc['post/patrol']);

                            //display post within selection for vehicle inventory
                            for ($i = 0; $i < count($vehicleArray); $i++) {
                                echo '<label for="location[]"></label>

                            <option value="' . $vehicleArray[$i] . '"<br>' . $vehicleArray[$i] . '<br></option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="currentStatus">Current Status</label>
                        <select class="form-control" title="currentStatus" id="currentStatus" name="currentStatus" autofocus required>
                            <option value="">Current Status</option>
                            <option value="Operational">Operational</option>
                            <option value="Deadlined">Deadlined</option>
                            <option value="Stand-By">Stand-By</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3" id="dim_driverName">
                        <label for="driverName" style="text-align: left">Driver Name</label><br>
                        <input type="text" name="driverName" id="driverName" class="form-control" value="" placeholder="Rank Last, First">

                    </div>


                    <div class="form-group col-md-3" id="dim_deadline">
                        <label for="deadlineReason" style="text-align: left">Deadline Reason</label><br>
                        <input type="text" name="deadlineReason" id="deadlineReason" class="form-control" value="" placeholder="Reason for Deadline">

                    </div>

                </div>

                <!-- Select Post "location"-->
                <div class="form-row">

                </div>

                <!-- Select Mileage "inputVehicleMileage" -->
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputVehicleMileage">Vehicle Mileage</label>
                        <input type="text" name="inputVehicleMileage" id="inputVehicleMileage" class="form-control" value="" placeholder="" required>
                    </div>
                </div>

                <!--AF Form 1800 "input1800" && "waiverCard)-->
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="input1800">AF Form 1800</label>
                        <select class="form-control" id="input1800" name="input1800" title="input1800" required>
                            <option value="">Select Option</option>
                            <option value="Current">Current</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input1800Notes">AF Form 1800 Notes</label>
                        <input type="text" name="input1800Notes" id="input1800Notes" class="form-control" value="" placeholder="">
                    </div>


                    <!--Waiver Card-->
                    <div class="form-group col-md-2">
                        <label for="inputWaiverCard">Waiver Card</label>
                        <select class="form-control" id="inputWaiverCard" name="inputWaiverCard" title="inputWaiverCard" required>
                            <option value="">Select Option</option>
                            <option value="N/A">None Assigned</option>
                            <option value="Current">Current</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputWaiverCardNotes">Waiver Card Notes</label>
                        <input type="text" name="inputWaiverCardNotes" id="inputWaiverCardNotes" class="form-control" value="" placeholder="">
                    </div>
                </div>

                <!--Form 91 "input91" && "input91Notes" / "input1800Notes" ? "input518"-->
                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="input91">AF Form 91</label>
                        <select class="form-control" id="input91" name="input91" title="input91" required>
                            <option value="">Select Option</option>
                            <option value="Current">On Hand</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input91Notes">AF Form 91 Notes</label>
                        <input type="text" name="input91Notes" id="input91Notes" class="form-control" value="" placeholder="">
                    </div>

                    <!--DD Form 518-->
                    <div class="form-group col-md-2">
                        <label for="input518">DD Form 518</label>
                        <select class="form-control" id="input518" name="input518" title="input518" required>
                            <option value="">Select Option</option>
                            <option value="Current">On-Hand</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input518Notes">DD Form 518 Notes</label>
                        <input type="text" name="input518Notes" id="input518Notes" class="form-control" value="" placeholder="">
                    </div>
                </div>


                <div>

                    <input class="btn btn-md btn-primary" type="submit" id="submitInventory" name="submitInventory" value="Submit Vehicle Information" style="alignment: center">

                </div>

            </form>
        </div>
    </div>

    <script>
        $(function() {

        });
        $(function() {
            $('#dim_driverName').show();
            $('#currentStatus').change(function() {
                if ($('#currentStatus').val() == 'Stand-By') {
                    $('#dim_driverName').hide();
                } else {
                    $('#dim_driverName').show();
                }
            });
        });

        $(function() {
            $('#dim_deadline').hide();
            $('#currentStatus').change(function() {
                if ($('#currentStatus').val() == 'Deadlined') {
                    $('#dim_deadline').show();
                } else {
                    $('#dim_deadline').hide();
                }
            });

        });
    </script>




    <?php
    //<!-- includes closing html tags for body and html-->
    include __DIR__ . '/../../footer.php'; ?>