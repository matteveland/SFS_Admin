<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();

//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
//include('/Users/matteveland/code/data.env');
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

//require(__DIR__."/../../vendor/phpmailer/phpmailer/src/PHPMailer.php");
//require(__DIR__."/../../vendor/phpmailer/phpmailer/src/SMTP.php");
//require(__DIR__."/../../vendor/phpmailer/phpmailer/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('America/Los_Angeles');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$workOrder = $mysqli->real_escape_string($_POST['inputWorkOrderType']);
//$weather = $mysqli->real_escape_string($_POST['inputWeather']);
$findings = $mysqli->real_escape_string($_POST['inputFindings']);
$sensorKind = $mysqli->real_escape_string($_POST['inputSensorKind']);
$accountName = $mysqli->real_escape_string($_POST['inputAccountName']);
$accessPoint = $mysqli->real_escape_string($_POST['inputAccessPoint']);
$dutySection = $mysqli->real_escape_string($_POST['selectSection']);
$description = $mysqli->real_escape_string($_POST['inputDescriptionField']);
$alarmLocationType = $mysqli->real_escape_string($_POST['inputLocationSelect']);
$buildingNumber = $mysqli->real_escape_string($_POST['inputBuildingName']);
$roomNumber = $mysqli->real_escape_string($_POST['inputRoomNumber']);
$fossZone = $mysqli->real_escape_string($_POST['fossZone']);

$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_ENV['cipherMethod']));
$encryptedAlarmDescription = openssl_encrypt($description, $_ENV['cipherMethod'], $_ENV['essDescriptionKey'], $options = 0, $iv);

$status = 'open';
$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

$getAdminName = $mysqli->query("SELECT * FROM login WHERE (user_name = '$admin' OR user_name = '$user')") or die(mysqli_error($mysqli));

while ($row = $getAdminName->fetch_assoc()) {

  $recallLast = $row['lastName'];
  $recallFirst = $row['firstName'];
}

$addedBy = $recallLast . ', ' . $recallFirst;

$buildingArrayPriority1 = array();
$roomNumberArrayPriority1 = array();
$accountArrayPriority1 = array('6651', '6641', '6604', '6645', '3309', '6648', '3010', '6644', '3016', '6657');

$buildingArrayPriority2 = array();
$roomNumberArrayPriority2 = array();
$accountArrayPriority2 = array('6657', '3063', '3043', '3007', '3001', '3002', '3003', '3004', '3022', '3024', '3046', '3063', '3043', '3007', '3001', '3002', '3003', '3004', '3002', '3024', '3046','5010', '5002', '3019', '6658', '3015', '3031', '3014', '3018', '3017', '3053', '3056', '3011', '3020', '3021', '3023', '3057', '6003', '3027', '3058', '3048', '3049', '3028', '3029', '3030', '6001', '6005', '3032', '3033', '3034', '3009', '3037', '3038', '3039', '6002', '3044', '3045', '3047', '3050', '3052', '3051','3012', '3040', '3060', '3061', '3054', '3055', '3006', '3042', '3013', '6653', '6652', '6655', '6656');

$buildingArrayPriority3 = array();
$roomNumberArrayPriority3 = array();
$accountArrayPriority3 = array('6601', '6602', '6603', '6604', '6605', '6606', '6607', '6608', '6609', '6610', '6611', '6612', '6613', '6614', '6615', '6616', '6617', '6618', '6619');

$recipients = array(
  'WHO YOU WANT TO SEND TO' => 'Person One',
  // 'SECOND EMAIL@DOMAIN.COM' => 'TITLE OF PERSON',
  // ..
);


//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->IsSMTP();
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
$mail->setFrom('YOUR.EMAIL@DOMAIN.COM', '781A initiation'); #TITLE OF EMAIL
//Set an alternative reply-to address
$mail->addReplyTo('YOUR.EMAIL@DOMAIN.COM', 'System Admin'); #TITLE OF EMAIL
//Set who the message is to be sent to

foreach($recipients as $email => $name)
{
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

for <b>" . $accountName . "</b> has received enough alarms to generate a 781 on alarm point and sensor type <b>" . $sensorKind . ".</b>
The alarm Work order status has been updated to reflect this initiation. If you have any questions regarding this alarm work order please contact, " . $addedBy . ".
<br>
Thank you,<br>
SFS Administrator </p>";
$mail->Body = $body;
$mail->AltBody = strip_tags($body);



//
///
///
///
/// BEFORE YOU GO FIXING THINGS, EMAIL DOES NOT WORK ON LOCALHOST SHRUG
///
///
///
///
///
///
///

if (isset($_POST['inputSubmit'])) {

  //
  //time occurring now submit when occurred
  //
  $json = file_get_contents("http://api.openweathermap.org/data/2.5/weather?id=5506040&units=imperial&APPID="your api key"");
  $data = json_decode($json);
  $weatherMain = $data->weather[0]->main;
  $weatherDescription = $data->weather[0]->description;
  $weatherTemp = $data->main->temp;
  $weatherWindSpeed = $data->wind->speed;
  $weatherWindDirection = $data->wind->deg;
  $weatherWindDirection = "$weatherWindDirection degrees";
  $weatherWindSpeed = "$weatherWindSpeed mph";
  $weatherTemp = "$weatherTemp F";
  $weatherArray = array($weatherMain, $weatherDescription, $weatherTemp, $weatherWindSpeed, $weatherWindDirection);
  $weatherArray = implode(', ', $weatherArray);
  $now = date('Y-m-d H:i:s');


  //insert initial work order
  $workOrderSQL = "INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accessPoint, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
  VALUES (id, '$now', '$workOrder', '$addedBy', '$weatherArray', '$findings', '$sensorKind', '$accessPoint', '$accountName', '$dutySection', '$encryptedAlarmDescription', '$unitName', '$status', '', '', '', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'N', '$iv')";



  if (($alarmLocationType == 'Interior') == true) {

  //Interior alarms
  //find current 340s
  $findPlusThree340s = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind' AND accessPoint = '$accessPoint' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = 'N' OR accountedFor = '') AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName'") or die(mysqli_error($mysqli));

  //find current 781
  $findCurrent781A =$mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '781A' and accountName = '$accountName' AND sensorKind = '$sensorKind' AND accessPoint = '$accessPoint' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = 'N' OR accountedFor = 'Y') AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName' ") or die(mysqli_error($mysqli));

  //insert 340s
  if ($findCurrent781A->num_rows >= 1) {

  $workorderAlreadyCreated = "781A has all ready been created for this alarm account/point/type. Interior";

} elseif ($findPlusThree340s->num_rows >= 2) {

  $create781A = $mysqli->query("INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accessPoint, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
  VALUES (id, '$now', '781A', '$addedBy', '$weatherArray', '$findings', '$sensorKind', '$accessPoint', '$accountName', '$dutySection', '$encryptedAlarmDescription', '$unitName', 'submitted', '', '','', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'Y', '$iv')") or die(mysqli_error($mysqli));


  $update340AlarmStatus = $mysqli->query("UPDATE alarmData SET accountedFor = 'Y'
    WHERE alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind'
    AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber'
    AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_error($mysqli));


    $successmsg = "This alarm account and sensor type has exceeded the number of 340s, a 781A has been initiated for it. ESS has been notified. Interior";

    //who notifications should be for...ESS/Contractor/CoC
    if (in_array($accountName, $accountArrayPriority1) == true) {
      $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 1</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 2 hours. <br><br></b></s> <h3 style=align='center'>Initiate QRC #18</h3>";

    } elseif (in_array($accountName, $accountArrayPriority2) == true) {
      $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 2</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";

    } elseif (in_array($accountName, $accountArrayPriority3) == true) {
      $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b> <s>This 781A is a <b>Priority 3</b> work order. Email notification is sufficient. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";
    } else { }

    if (!$mail->send()) {
      $emailFailure = 'Email was not sent! (1) Interior';
    } else {
      $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (1) Interior';
    }

  } else {
    if ($workOrder == "781A") {

      $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));
      if (!$mail->send()) {
        $emailFailure = 'Email was not sent! (2) Interior';
      } else {
        $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (2) Interior';
      }

      $successmsg = "This alarm had no 340's, but required maintenance. A 781A has been initiated for it. ESS has been notified. Interior";

    } else {

      $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));

      if (!$resultWorkOrderSQL) {
        $failuremsg = "Alarm Data was not added - Please try again. (3) Interior";
      } else {
        $successmsg = "Alarm Data Successfully. (3) Interior";

      }

    }

  }

}
elseif(($alarmLocationType == 'Exterior') == true){

  //exterior find alarm
  //find current 340s
  $findPlusThree340s = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind' AND accessPoint = '$accessPoint' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = '' OR accountedFor = 'N') AND (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName'") or die(mysqli_error($mysqli));

  //find current 781
  $findCurrent781A = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '781A' and accountName = '$accountName' AND sensorKind = '$sensorKind' AND accessPoint = '$accessPoint' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = 'N' OR accountedFor = 'Y') AND (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName' ") or die(mysqli_error($mysqli));

  //insert 340s
  if ($findCurrent781A->num_rows >= 1) {

    $workorderAlreadyCreated = "781A has all ready been created for this alarm account/point/type. Exterior";

  } elseif ($findPlusThree340s->num_rows >= 2) {

    $create781A = $mysqli->query("INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accessPoint, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
    VALUES (id, '$now', '781A', '$addedBy', '$weatherArray', '$findings', '$sensorKind', '$accessPoint', '$accountName', '$dutySection', '$encryptedAlarmDescription', '$unitName', 'submitted', '', '','', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'Y', '$iv')") or die(mysqli_error($mysqli));


    $update340AlarmStatus = $mysqli->query("UPDATE alarmData SET accountedFor = 'Y'
      WHERE alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind'
      AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber'
      AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_error($mysqli));

      $successmsg = "This alarm account and sensor type has exceeded the number of 340s, a 781A has been initiated for it. ESS has been notified. Exterior";

      //who notifications should be for...ESS/Contractor/CoC
      if(in_array($accountName, $accountArrayPriority1) == true) {
        $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 1</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 2 hours. <br><br></b></s> <h3 style=align='center'>Initiate QRC #18</h3>";

      } elseif(in_array($accountName, $accountArrayPriority2) == true) {
        $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 2</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";

      } elseif(in_array($accountName, $accountArrayPriority3) == true) {
        $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b> <s>This 781A is a <b>Priority 3</b> work order. Email notification is sufficient. <b>Response by Alarm Contractor(s) is required within 24 hours</b></s>";
      } else { }

      if (!$mail->send()) {
        $emailFailure = 'Email was not sent! (1) Exterior';
      } else {
        $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (1) Exterior';
      }

    } else {
      if ($workOrder == "781A") {

        $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));
        if (!$mail->send()) {
          $emailFailure = 'Email was not sent! (2) Exterior';
        } else {
          $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (2) Exterior';
        }

        $successmsg = "This alarm had no 340's, but required maintenance. A 781A has been initiated for it. ESS has been notified. Interior";

      } else {

        $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));

        if (!$resultWorkOrderSQL) {
          $failuremsg = "Alarm Data was not added - Please try again. (3) Exterior";
        } else {
          $successmsg = "Alarm Data Successfully. (3) Exterior";

        }

      }

    }

  }else{

  }
}if (isset($_POST['manualSubmit'])) {



  //
  //manual get weather
  //
  $dateAdded = $mysqli->real_escape_string($_POST['dim_inputDate']);
  $date = strtotime($dateAdded);
  $time = $mysqli->real_escape_string($_POST['dim_inputTime']);
  $time = "$time:00";
  $link = "https://api.darksky.net/forecast/c___DEPRICATED_API____/36.57,-115.6706," . $dateAdded . "T" . $time . "?timezone=America/Los_Angles?units=si&exclude=minutely,hourly,daily,alerts,flags";
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
  $now = "$dateAdded $time";

  //insert initial work order
  $workOrderSQL = "INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
  VALUES (id, '$now', '$workOrder', '$addedBy', '$weatherArray', '$findings', '$sensorKind', '$accountName', '$dutySection', '$encryptedAlarmDescription', '$unitName', '$status', '', '', '', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'N', '$iv')";


  if (($alarmLocationType == 'Interior') == true) {

  //Interior alarms
  //find current 340s
  $findPlusThree340s = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = 'N' OR accountedFor = '') AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName'") or die(mysqli_error($mysqli));

  //find current 781
  $findCurrent781A =$mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '781A' and accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = 'N' OR accountedFor = 'Y') AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName' ") or die(mysqli_error($mysqli));

  //insert 340s
  if ($findCurrent781A->num_rows >= 1) {

  $workorderAlreadyCreated = "781A has all ready been created for this alarm account/point/type. Interior";

} elseif ($findPlusThree340s->num_rows >= 2) {

  $create781A = $mysqli->query("INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
  VALUES (id, '$now', '781A', '$addedBy', '$weatherArray', '$findings', '$sensorKind', '$accountName', '$dutySection', '$encryptedAlarmDescription', '$unitName', 'submitted', '', '','', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'Y', '$iv')") or die(mysqli_error($mysqli));


  $update340AlarmStatus = $mysqli->query("UPDATE alarmData SET accountedFor = 'Y'
    WHERE alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind'
    AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber'
    AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_error($mysqli));


    $successmsg = "This alarm account and sensor type has exceeded the number of 340s, a 781A has been initiated for it. ESS has been notified. Interior";

    //who notifications should be for...ESS/Contractor/CoC
    if (in_array($accountName, $accountArrayPriority1) == true) {
      $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 1</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 2 hours. <br><br></b></s> <h3 style=align='center'>Initiate QRC #18</h3>";

    } elseif (in_array($accountName, $accountArrayPriority2) == true) {
      $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 2</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";

    } elseif (in_array($accountName, $accountArrayPriority3) == true) {
      $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b> <s>This 781A is a <b>Priority 3</b> work order. Email notification is sufficient. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";
    } else { }

    if (!$mail->send()) {
      $emailFailure = 'Email was not sent! (1) Interior';
    } else {
      $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (1) Interior';
    }

  } else {
    if ($workOrder == "781A") {

      $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));
      if (!$mail->send()) {
        $emailFailure = 'Email was not sent! (2) Interior';
      } else {
        $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (2) Interior';
      }

      $successmsg = "This alarm had no 340's, but required maintenance. A 781A has been initiated for it. ESS has been notified. Interior";

    } else {

      $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));

      if (!$resultWorkOrderSQL) {
        $failuremsg = "Alarm Data was not added - Please try again. (3) Interior";
      } else {
        $successmsg = "Alarm Data Successfully. (3) Interior";

      }

    }

  }

}
elseif(($alarmLocationType == 'Exterior') == true){

  //exterior find alarm
  //find current 340s
  $findPlusThree340s = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = '' OR accountedFor = 'N') AND (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName'") or die(mysqli_error($mysqli));

  //find current 781
  $findCurrent781A = $mysqli->query("SELECT * FROM alarmData where alarmTypeSubmit = '781A' and accountName = '$accountName' AND sensorKind = '$sensorKind' AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber' AND (accountedFor = 'N' OR accountedFor = 'Y') AND (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY) AND unitName= '$unitName' ") or die(mysqli_error($mysqli));

  //insert 340s
  if ($findCurrent781A->num_rows >= 1) {

    $workorderAlreadyCreated = "781A has all ready been created for this alarm account/point/type. Exterior";

  } elseif ($findPlusThree340s->num_rows >= 2) {

    $create781A = $mysqli->query("INSERT INTO `alarmData` (id, reportedTime, alarmTypeSubmit, submittedBy, weather, findings, sensorKind, accountName, dutySection, alarmDescription, unitName, status, correctedBy, dateCorrected, inspectedBy, notes, alarmLocationType, buildingNumber, fossZone, roomNumber, accountedFor, iv)
    VALUES (id, '$now', '781A', '$addedBy', '$weatherArray', '$findings', '$sensorKind', '$accountName', '$dutySection', '$encryptedAlarmDescription', '$unitName', 'submitted', '', '','', '', '$alarmLocationType', '$buildingNumber', '$fossZone', '$roomNumber', 'Y', '$iv')") or die(mysqli_error($mysqli));


    $update340AlarmStatus = $mysqli->query("UPDATE alarmData SET accountedFor = 'Y'
      WHERE alarmTypeSubmit = '340' AND accountName = '$accountName' AND sensorKind = '$sensorKind'
      AND alarmLocationType = '$alarmLocationType' And buildingNumber = '$buildingNumber' AND roomNumber = '$roomNumber'
      AND (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_error($mysqli));

      $successmsg = "This alarm account and sensor type has exceeded the number of 340s, a 781A has been initiated for it. ESS has been notified. Exterior";

      //who notifications should be for...ESS/Contractor/CoC
      if(in_array($accountName, $accountArrayPriority1) == true) {
        $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 1</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 2 hours. <br><br></b></s> <h3 style=align='center'>Initiate QRC #18</h3>";

      } elseif(in_array($accountName, $accountArrayPriority2) == true) {
        $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b><s>This 781A is a <b>Priority 2</b> work order. Please contact ESS, Alarm Contractor(s), and your Chain of Command. <b>Response by Alarm Contractor(s) is required within 4 hours</b></s>";

      } elseif(in_array($accountName, $accountArrayPriority3) == true) {
        $notifyESSContractor = "<b>IGNORE Message. Conducting Testing. </b> <s>This 781A is a <b>Priority 3</b> work order. Email notification is sufficient. <b>Response by Alarm Contractor(s) is required within 24 hours</b></s>";
      } else { }

      if (!$mail->send()) {
        $emailFailure = 'Email was not sent! (1) Exterior';
      } else {
        $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (1) Exterior';
      }

    } else {
      if ($workOrder == "781A") {

        $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));
        if (!$mail->send()) {
          $emailFailure = 'Email was not sent! (2) Exterior';
        } else {
          $emailSuccess = 'Email message was successfully sent to ' . $unitName . ' ESS Administration! (2) Exterior';
        }

        $successmsg = "This alarm had no 340's, but required maintenance. A 781A has been initiated for it. ESS has been notified. Interior";

      } else {

        $resultWorkOrderSQL = $mysqli->query($workOrderSQL) or die(mysqli_errno($mysqli));

        if (!$resultWorkOrderSQL) {
          $failuremsg = "Alarm Data was not added - Please try again. (3) Exterior";
        } else {
          $successmsg = "Alarm Data Successfully. (3) Exterior";

        }

      }

    }

  }else{

  }
}else {
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
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <?php if(isset($emailFailure)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $emailFailure; ?> </div><?php } ?>
                  <?php if(isset($emailSuccess)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $emailSuccess; ?> </div><?php } ?>
                    <?php if(isset($notifyESSContractor)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $notifyESSContractor; ?> </div><?php } ?>
                      <p style="text-align: center"></p>
                      <?php header("refresh:3;url=alarm-report.php");?>
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
