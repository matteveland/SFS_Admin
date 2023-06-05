<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in(); //verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');



require(__DIR__ . "/../../vendor/phpmailer/phpmailer/src/PHPMailer.php");
require(__DIR__ . "/../../vendor/phpmailer/phpmailer/src/SMTP.php");
require(__DIR__ . "/../../vendor/phpmailer/phpmailer/src/Exception.php");

$now = date('Y-m-d H:i:s');
$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

$userSearch = $mysqli->query("SELECT * From login l
inner join members m
on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId
WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name") or die(mysqli_errno($mysqli));


while ($row = $userSearch->fetch_assoc()) {

    $recallFirstName = $row['firstName'];
    $recallLastName = $row['lastName'];
    $recallRank = $row['rank'];
}

$addedBy = $recallRank . ' ' . $recallLastName . ', ' . $recallFirstName;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//date_default_timezone_set('America/Los_Angeles');
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$selectVehicle = $mysqli->real_escape_string($_POST['selectVehicle']);
//Duty Section
$dutySection = $mysqli->real_escape_string($_POST['dutySection']);
$postLocation = $mysqli->real_escape_string($_POST['location']); //Good
//Current Status
$currentStatus = $mysqli->real_escape_string($_POST['currentStatus']);
//driver Name
$driverName = $mysqli->real_escape_string($_POST['driverName']);
//Vehicle Mileage
$vehicleMileage = $mysqli->real_escape_string($_POST['inputVehicleMileage']); //Good
//deadline Reason
$deadlineReason = $mysqli->real_escape_string($_POST['deadlineReason']);


//1800
$eighteenHundred = $mysqli->real_escape_string($_POST['input1800']);
$eighteenHundredNotes = $mysqli->real_escape_string($_POST['input1800Notes']);
$reportMissing1800 = $mysqli->real_escape_string($_POST['reportMissing1800']);

if ($eighteenHundred != "Current") {
    $eighteenHundredNotes = "$eighteenHundredNotes -- reported to VCO = $reportMissing1800";
} else {
    $eighteenHundredNotes = $eighteenHundredNotes;
}

//waiver
$waiverCard = $mysqli->real_escape_string($_POST['inputWaiverCard']);
$waiverCardNotes = $mysqli->real_escape_string($_POST['inputWaiverCardNotes']);
$reportMissingWaiverCard = $mysqli->real_escape_string($_POST['reportMissingWaiverCard']);


if ($waiverCard != "Current") {
    $waiverCardNotes = "$waiverCardNotes -- Waiver Card missing reported to VCO = $reportMissingWaiverCard";
} else {
    $waiverCardNotes = $waiverCardNotes;
}


//91
$ninetyOne = $mysqli->real_escape_string($_POST['input91']);
//518
$fiveHundredEighteen = $mysqli->real_escape_string($_POST['input518']);

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
                   AF Form 91: " . $ninetyOne . "<br>
                   DD Form 518: " . $fiveHundredEighteen . "<br>
                   Submitted by:   " . $addedBy . "</p>";


if (!isset($_POST['submitInventory'])) {
} else {
    $findVehicles = $mysqli->query("SELECT mileage FROM vehicles_mileage WHERE (registration = '$selectVehicle' AND unitName = '$unitName') ORDER BY mileage DESC LIMIT 1") or die("Database Selection Failed" . mysqli_connect_error());
    //$resultsFindVehicles = mysqli_query($connection, $findVehicles) or die("Database Selection Failed" . mysqli_connect_error());
    $resultsFindVehicles = $findVehicles->fetch_assoc();


    if (($vehicleMileage <= $resultsFindVehicles['mileage'] === true) or ($resultsFindVehicles['mileage'] === '')) {

        $results = $resultsFindVehicles['mileage'];
        $failuremsg = "Last entered mileage = $results. Last mileage added for <b>$selectVehicle</b> is less that previously entered. Check mileage and re-enter";
    } else {

        $insertVehicleInfo = "INSERT INTO `vehicles_mileage` (`id`, `registration`, `location`, `mileage`, `dutySection`,
        `AF1800`, `1800Notes`, `waiverCard`, `waiverNotes`, `AF91`, `AF518`, `post`, `status`, `deadlineReason`, `driverName`,
        `lastUpdate`, `updatedBy`, `unitName`)
         VALUES (id, '$selectVehicle','$postLocation','$vehicleMileage','$dutySection',
         '$eighteenHundred', '$eighteenHundredNotes', '$waiverCard', '$waiverCardNotes', '$ninetyOne','$fiveHundredEighteen', '$postLocation', '$currentStatus', '$deadlineReason', '$driverName',
         '$now', '$addedBy', '$unitName')" or die("Database Selection Failed");

        $updateVehicleStatus = "update `vehicles_daily` SET `post` = '$postLocation', status = '$currentStatus', mileage = '$vehicleMileage' where registration = '$selectVehicle' AND unitName = '$unitName'"  or die("Database Selection Failed" . mysqli_connect_error());

        $insertVehicleInfo = $mysqli->query($insertVehicleInfo);
        $updateVehicleStatus = $mysqli->query($updateVehicleStatus);

        if (!$insertVehicleInfo) {
            $failuremsg = 'Error, vehicle information was not added. Contact system admin.';
        } else {
            $successmsg = 'Vehicle information successfully added for ' . $selectVehicle . '!';
        }

        if (!$updateVehicleStatus) {
            $failuremsg = 'Error, vehicle information was not added. Contact system admin.';
        } else {
            $successmsg = 'Vehicle information successfully added for ' . $selectVehicle . '!';
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
                        <h5 class="modal-title">Insert Vehicle Data</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($successmsg)) { ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                        <?php if (isset($failuremsg)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                        <p style="text-align: center"></p>
                        <?php header("refresh:5;url=vehicle-report.php"); ?>
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
    $(document).ready(function() {
        $("#myModal").modal('show');
    });
</script>
<style>
    .bs-example {
        margin: 20px;
    }
</style>




<!-- indluces closing html tags for body and html-->
<!-- place below last </div> tag -- indluces closing html tags for body and html-->