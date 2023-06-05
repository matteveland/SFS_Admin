<?php


require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../resources/Admin/Login-Logout/verifyLogin.php'; //verify login to account before access is given to site
include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');

require(__DIR__ . "/../../vendor/phpmailer/phpmailer/src/PHPMailer.php");
require(__DIR__ . "/../../vendor/phpmailer/phpmailer/src/SMTP.php");
require(__DIR__ . "/../../vendor/phpmailer/phpmailer/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('America/Los_Angeles');
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$dateAdded = $mysqli->real_escape_string($_POST['inputDate']);
$date = strtotime($dateAdded);
$time = $mysqli->real_escape_string($_POST['inputTime']);

$time = "$time:00";

$link = "https://api.darksky.net/forecast/____depricated API____," . $dateAdded . "T" . $time . "?timezone=America/Los_Angles?units=si&exclude=minutely,hourly,daily,alerts,flags";
$json = file_get_contents($link);
$data = json_decode($json);

$darkSkyMain = $data->currently->summary;
$darkSkyWindSpeed = $data->currently->windSpeed;
$darkSkyTemp = $data->currently->temperature;
$darkSkyWindGustSpeed = $data->currently->windGust;
$darkSkyWindDirection = $data->currently->windBearing;
$darkSkyWindDirection = "$darkSkyWindDirection degrees";
$darkSkyWindSpeed = "$darkSkyWindSpeed mph";
$darkSkyTemp = "$darkSkyTemp F";
$darkSkyArray = array($darkSkyMain, $darkSkyTemp, $darkSkyWindSpeed, $darkSkyWindDirection);
$darkSkyArray = implode(', ', $darkSkyArray);

$workOrder = $mysqli->real_escape_string($_POST['inputWorkOrderType']);
//$weather = $mysqli->real_escape_string($_POST['inputWeather']);
$findings = $mysqli->real_escape_string($_POST['inputFindings']);
$sensorKind = $mysqli->real_escape_string($_POST['inputSensorKind']);
$accountName = $mysqli->real_escape_string($_POST['inputAccountName']);
$dutySection = $mysqli->real_escape_string($_POST['inputDutySectionSelect']);
$description = $mysqli->real_escape_string($_POST['inputDescriptionField']);
$alarmLocationType = $mysqli->real_escape_string($_POST['inputLocationSelect']);
$buildingNumber = $mysqli->real_escape_string($_POST['inputBuildingName']);
$roomNumber = $mysqli->real_escape_string($_POST['inputRoomNumber']);
$fossZone = $mysqli->real_escape_string($_POST['fossZone']);

$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
$description = openssl_encrypt($description, $cipherMethod, $essDescriptionKey, $options = 0, $iv);

$status = 'open';
$now = "$dateAdded $time";
$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

$getAdminName = $mysqli->query("SELECT * FROM login WHERE (user_name = '$admin' OR user_name = '$user')");

//$resultsAdmin = mysqli_query($connection, $getAdminName);

while ($row = $getAdminName->fetch_assoc()) {

    $recallLast = $row['lastName'];
    $recallFirst = $row['firstName'];
}

$addedBy = $recallLast . ', ' . $recallFirst; //for adding inserting member into the ESS information for reach back

///building listings
$buildingArrayPriority1 = array('64', '1052', '1005', '718', '1000', '1008');
$roomNumberArrayPriority1 = array('125', '', '0', '104', '218');
$accountArrayPriority1 = array('6651', '6641', '6604', '6645', '3309', '6648', '3010', '6644', '3016');

$buildingArrayPriority2 = array('1055', '1130', '138', '3922', '3912', '3910', '3914', '3929', 'IGLOOS', '3925');
$roomNumberArrayPriority2 = array('126', '', '0');
$accountArrayPriority2 = array('6657', '3063', '3043', '3007', '3001', '3002', '3003', '3004', '3022', '3024', '3046');

$buildingArrayPriority3 = array('1055', '1130', '138', '3922', '3912', '3910', '3914', '3929', 'IGLOOS', '3925');
$roomNumberArrayPriority3 = array('126', '', '0');
$accountArrayPriority3 = array('6657', '3063', '3043', '3007', '3001', '3002', '3003', '3004', '3022', '3024', '3046');


$recipients = array(
    'YOUR.EMAIL@DOMAIN.COM@gmail.com' => 'Person One',
    //'YOUR.EMAIL@DOMAIN.COM' => 'ESS NCO',
    // ..
);


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
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = 'YOUR.EMAIL@DOMAIN.COM';
//Password to use for SMTP authentication
$mail->Password = $mailAuthorizationPassword;
//Set who the message is to be sent from
$mail->setFrom('YOUR.EMAIL@DOMAIN.COM', '781A initiation');
//Set an alternative reply-to address
$mail->addReplyTo('YOUR.EMAIL@DOMAIN.COM', 'System Admin');
//Set who the message is to be sent to

foreach ($recipients as $email => $name) {
    $mail->addAddress($email, $name);
}

$mail->addAddress($emailSend, ".$addedBy");
//Set the subject line
$mail->Subject = "Initiate 781A for $accountName and sensor type $sensorKind";
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually

$body = "<p>This is an auto generated email<br>

for <b>" . $accountName . "</b>  has received enough alarms to generate a 781 on alarm point and sensor type <b>" . $sensorKind . ".</b>
                    The alarm Work order status has been updated to reflect this initiation. If you have any questions regarding this alarm work order please contact, " . $addedBy . ".
                    <br>
                    Thank you,<br>
                    SFS Administrator </p>";
$mail->Body = $body;
$mail->AltBody = strip_tags($body);


//insert initial work order
$workOrderSQL = $mysqli->query("INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
                          VALUES (id, '$now', '$workOrder', '$addedBy', '$darkSkyArray', '$findings', '$sensorKind', '$accountName', '$dutySection', '$description', '$unitName', '$status', '', '','', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'Y', '$iv')") or die(mysqli_errno($mysqli));


if (isset($_POST['submit'])) {

    //find current 340s
    $findPlusThree340s = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName'") or die(mysqli_errno($mysqli));
    //$resultFindPlusThree340s = mysqli_query($connection, $findPlusThree340s);

    //find current 781
    $findCurrent781A = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '781A' and accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName' ") or die(mysqli_errno($mysqli));
    //$resultFindCurrent781A = mysqli_query($connection, $findCurrent781A);

    //insert 340s
    if ($findCurrent781A->num_rows >= 1) {

        $workorderAlreadyCreated = "781A has all ready been created for this alarm account/point/type.";

        //exit();

    } elseif ($findPlusThree340s->num_rows >= 2) {

        $create781A = "INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, iv)
                          VALUES (id, '$now', '781A', '$addedBy', '$darkSkyArray', '$findings', '$sensorKind', '$accountName', '$dutySection', '$description', '$unitName', 'submitted', '', '','', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', '$iv')";
        $resultCreate781As = mysqli_query($connection, $create781A);

        $Delete340 = "DELETE FROM `alarmData` WHERE alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY)";
        $resultDelete340 = mysqli_query($connection, $Delete340);

        $successmsg = "This alarm account and sensor type has exceeded the number of 340s, a 781A has been initiated for it. ESS has been notified.";

        //who notifications should be for...ESS/Contractor/CoC


        if ((in_array($buildingNumber, $buildingArrayPriority1) == true) && (in_array($roomNumber, $roomNumberArrayPriority1) == true) && (in_array($accountName, $accountArrayPriority1) == true)) {
            $notifyESSContractor = "<s>This 781A is a <b>Priority 1</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 2 hours. <br><br></b></s> <h3 style=align='center'>Initiate QRC #18</h3>";
        } elseif ((in_array($buildingNumber, $buildingArrayPriority2) == true) && (in_array($roomNumber, $roomNumberArrayPriority2) == true) && (in_array($accountName, $accountArrayPriority2) == true)) {
            $notifyESSContractor = "<s>This 781A is a <b>Priority 2</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";
        } elseif ((in_array($buildingNumber, $buildingArrayPriority2) == true) && (in_array($roomNumber, $roomNumberArrayPriority2) == true) && (in_array($accountName, $accountArrayPriority2) == true)) {
            $notifyESSContractor = "<s>This 781A is a <b>Priority 3</b> work order. Email notification is sufficient. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";
        } else {
        }

        if (!$mail->send()) {
            $emailFailure = 'Email was not sent! (1)';
        } else {
            $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (1)';
        }
    } else {
        if ($workOrder == "781A") {
            $resultWorkOrderSQL = mysqli_query($connection, $workOrderSQL) or die(mysqli_error($connection));


            if (!$mail->send()) {
                $emailFailure = 'Email was not sent! (2)';
            } else {
                $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (2)';
            }

            $successmsg = "This alarm had no 340's, but required maintenance. A 781A has been initiated for it. ESS has been notified.";

            //who notifications should be for...ESS/Contractor/CoC
            if ($accountName = "223" and $sensorKind == ("BMS" or "FOSS" or "PIR") and $buildingNumber == "123") {
                // $notifyESSContractor = "This 781A is a <b>Priority 1</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 2 hours</b>";

            } elseif ($accountName = "199" and $sensorKind == ("BMS" or "FOSS" or "PIR") and $buildingNumber == "789") {
                //$notifyESSContractor = "This 781A is a <b>Priority 2</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 4 hours</b>";

            } else {
                // $notifyESSContractor = "This 781A is a <b>Priority 3</b> work order. Email notification is sufficient. <b>Response by Alarm Contractor(s) is required within 4 hours</b>";
            }
        } else {

            $resultWorkOrderSQL = mysqli_query($connection, $workOrderSQL) or die(mysqli_error($connection));

            if (!$resultWorkOrderSQL) {
                $failuremsg = "Alarm Data was not added - Please try again. (3)";
            } else {
                $successmsg = "Alarm Data Successfully. (3)";
            }
        }
    }
} else {
    // echo "error";
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
                        <h5 class="modal-title">Insert Alarm Data Status</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($successmsg)) { ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                        <?php if (isset($failuremsg)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                        <?php if (isset($emailFailure)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $emailFailure; ?> </div><?php } ?>
                        <?php if (isset($emailSuccess)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $emailSuccess; ?> </div><?php } ?>
                        <?php if (isset($notifyESSContractor)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $notifyESSContractor; ?> </div><?php } ?>
                        <p style="text-align: center"></p>
                        <?php header("refresh:5;url=alarm-report.php"); ?>
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