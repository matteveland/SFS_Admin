<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$emailSend = require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/Admin/functions/emailSendAppointment.php';


//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$unitName = $_SESSION['unitName'];

//SMTP needs accurate times, and the PHP time zone MUST be set

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

if (isset($_POST['submit'])) {
  $allArray = array();

  $findMember = new FindMember();
  $findMember->find_member($findUser->dodId, $findUser->lastName, $unitName);

  $findMember->dodId;
  $findMember->iv;
  $absenceTpye = $mysqli->real_escape_string($_POST['absenceTpye']);
  $dodId = $mysqli->real_escape_string($_POST['dodId']);
  //$rank = $mysqli->real_escape_string($_POST['rank']);
  $firstName = $mysqli->real_escape_string($_POST['firstName']);
  $lastName = $mysqli->real_escape_string($_POST['lastName']);
  $installation = $mysqli->real_escape_string($_POST['installation']);
  $appointmentType = $mysqli->real_escape_string($_POST['appointmentType']);
  $location = $mysqli->real_escape_string($_POST['location']);
  $email = ($_POST['email']);
  $encodedEmail = urlencode($email);
  $email = $mysqli->real_escape_string($encodedEmail);
  $inputStartDate = $mysqli->real_escape_string($_POST['startdate']);
  $start = array();
  $start = explode("T", $inputStartDate);
  $startDate = $start[0];
  $startTime = $start[1];
  $startDateTotal = $inputStartDate;
  $inputEndDate = $mysqli->real_escape_string($_POST['enddate']);
  //$endTime = $mysqli->real_escape_string($_POST['endtime']);
  $end = array();
  $end = explode("T", $inputEndDate);
  $endDate = $end[0];
  $endTime = $end[1];
  $endDateTotal = $inputEndDate;
  $now = date('Y-m-d H:i:s');
  $notes = $mysqli->real_escape_string($_POST['notes']);
  $selfMade = $mysqli->real_escape_string($_POST['selfMade']);
  $overRide = $mysqli->real_escape_string($_POST['override']);
  $emailReminder = $mysqli->real_escape_string($_POST['emailReminder']);


  $delete = $mysqli->real_escape_string($_POST['delete']);
  $addedBy = $findMember->lastName . ', ' . $findMember->firstName;

  //print_r($recallApptID);
  $allArray = array($dodId, $rank, $firstName, $lastName, $installation, $appointmentType, $location, $encodedEmail, $startDateTotal, $endDateTotal, $override, $emailReminder, $selfMade, $notes);


  //email address are not being add because there is no need to keep them. thay are only being used in this instance to send emails. thats all.

  $insertAppointment = "INSERT INTO `appointmentRoster` (id, dodId, firstName, middleName, lastName, title, installation, location, startdate, appointmentTime, selfMade, dutySection, allDay, enddate, addedBy, dateAdded, notes, endTime, unitName, overRide) VALUES (id, '$dodId', '$firstName', '$middleName', '$lastName', '$appointmentType', '$installation', '$location', '$startDate', '$startTime', '$selfMade', '$dutySection', '', '$endDate', '$addedBy', '$now', '$note', '$endTime', '$unitName', '$overRide')";


  //find if dodId matches member
  $findDODID = $mysqli->query("SELECT lastName, firstName, dodId FROM members WHERE lastName = '$lastName' AND firstName = '$firstName' AND dodId = '$dodId'");


  if (!$findDODID->num_rows) {
    //find id dod matches return to page to have member input correct information
    // code...
    $dodMatch = false;

    //return failure message
    $dodDidNotMatch = "<div class='form-row'>Incorrect DOD ID for member. Please re-enter the correct information for this member.<a href='/resources/Admin/Appointments/appointment-view.php'>
    <input class='btn btn-primary' type='button' name='acknowledge' id='acknowledge' value='Acknowledge' style='float: right;'>
    </a>
    </div>";

    //override needed reutn submitted information
    $_SESSION['allArray'] = $allArray;
  } else { //dodid->numrows if

    //good informaiton
    //find if appointment already exist for person
    $findAppt = $mysqli->query("  SELECT * FROM appointmentRoster WHERE ((lastName ='$lastName' AND firstName = '$firstName') AND
    ((startdate = '$startDate' AND appointmentTime BETWEEN '$startTime' AND '$endTime')
    OR (enddate = '$endDate' AND appointmentTime BETWEEN '$startTime' AND '$endTime'))
    AND unitName = '$unitName')");


    echo "  SELECT * FROM appointmentRoster WHERE ((lastName ='$lastName' AND firstName = '$firstName') AND
    (startdate = '$startDate' AND appointmentTime BETWEEN '$startTime' AND '$endTime')
    and (enddate = '$endDate' AND appointmentTime BETWEEN '$startTime' AND '$endTime')
    AND unitName = '$unitName')";



    //If appointment exist, while look to display inforation. may not be needed
    while ($row = $findAppt->fetch_assoc()) {
      $recallApptID = $row['id'];
      //$recallRank = $row['rank'];
      //$recallLastName = $row['lastName'];
      //$recallFirstName = $row['firstName'];
      $recallTitleName = $row['title'];
      $recallStartDate = $row['startdate'];
      $recallStartTime = $row['appointmentTime'];
      $recallEndDate = $row['enddate'];
      $recallEndDateTime = $row['endTime'];
      $endDateExplode = explode(",", $recallEndDate);
    }

    if ($findAppt->num_rows) { ////find if appointment already exist for person

      if ($overRide == '') { //Override neede but not selected

        $override = true;

        //override needed reutn submitted information
        $_SESSION['allArray'] = $allArray;

        //return failure message
        $previousAppointmentWithOverride = "<div class='form-row'>Appointment is already scheduled for this time. Do you wish to override the previous appointment? This means you will have multiple appointment during the same time.
        </div>";
      } elseif ($overRide == 'Yes') { //override yes

        //was appointment successfully added ($insertAppointment)?
        $submitAppointmentOverRide = $mysqli->query($insertAppointment);

        //return success message
        if (!$submitAppointment) {

          //database did not insert information, returned submitted information
          $_SESSION['allArray'] = $allArray;

          //return failure message
          $returnedMessage = "<div class='form-row'>There was an error while submitting your appointment. Please try again.</div>";
        } else {
          $returnedMessageDataBase = "<div class='form-row'>Information inserted into database.</div>";
        }

        unset($_SESSION['allArray']);
      } else { //Nothing else needed for override.
      }
    } else {

      /*if(empty($emailReminder)){

      //email send reminder  = no
      $submitAppointment = $mysqli->query($insertAppointment);

      //return success message
      if (!$submitAppointment) {
      //database did not insert information, returned submitted information
      $_SESSION['allArray'] = $allArray;

      //return failure message
      $returnedMessage = "<div class='form-row'>There was an error while submitting your appointment. Please try again.</div>";

    }
    else{
    $returnedMessageDataBase = "<div class='form-row'>Appointment was succeesfully added. You requested no Email to be sent.</div>";
  }

}else*/

      if (($emailReminder == "Yes") and (empty($email))) {
        //email send reminder  = yes

        //Email address is empty
        //return submitted information
        //return failure message

        $emailRequested = true;

        //override needed reutn submitted information
        $_SESSION['allArray'] = $allArray;

        //return failure message
        $returnedMessageEmailSelectError = "<div class='form-row'>You selected an email reminder, but provided no email. Please add an email to appointment form or unselected <i>email reminder</i>.
  </div>";
      } elseif (($emailReminder == "Yes") and (isset($email))) {

        //was appointment successfully added ($insertAppointment)?
        $submitAppointment = $mysqli->query($insertAppointment);

        //return success message
        if (!$submitAppointment) {

          //database did not insert information, returned submitted information
          $_SESSION['allArray'] = $allArray;

          //return failure message
          $returnedMessage = "<div class='form-row'>There was an error while submitting your appointment. Please try again.</div>";
        } else {
          $returnedMessageDataBase = "<div class='form-row'>Information inserted into database.</div>";
        }

        sendAppointmentReminder($email, $firstName, $lastName, $emailPassword, $startTime, $startDate, $endTime, $endDate, $type, $installation, $building, $location);



        $emailFail = "<div class='form-row'>Email message was not sent!</div>";


        $emailSuccess = "Email message was successfully sent to " . strtolower(urldecode($email)) . "";

        if ($emailSend == true) {

          unset($_SESSION['allArray']);
        }
      } else {
        //was appointment successfully added ($insertAppointment)?
        $submitAppointment = $mysqli->query($insertAppointment);

        //return success message
        if (!$submitAppointment) {

          //database did not insert information, returned submitted information
          $_SESSION['allArray'] = $allArray;

          //return failure message
          $returnedMessage = "<div class='form-row'>There was an error while submitting your appointment. Please try again.</div>";
        }

        $returnedMessageDataBase = "<div class='form-row'>Appointment was submitted.</div>";
      }
      unset($_SESSION['allArray']);
    }
  }
}



///<a href='/resources/Appointments/appointments-delete.php?ID=".$recallApptID."&last=".$findMember->lastName."'>
/*
if($recalldodId == $dodId) {

$encryptedEmail = openssl_encrypt($email, $cipherMethod, $recalldodId, $options=0, $recallMembersIV);

$appointmentSQL = "INSERT INTO `appointmentRoster` (id, dodId, rank, email, firstName, middleName, lastName, title, installation, location, startdate, appointmentTime, selfMade, dutySection, allDay, enddate, addedBy, dateAdded, notes, endTime, unitName, overRide)
VALUES (id, '$dodId', '$rank', '$encryptedEmail', '$firstName', '$middleName', '$lastName', '$type', '$installation', '$location', '$startDate', '$startTime', '$selfMade', '$dutySection', '', '$endDate', '$addedBy', '$now', '$note', '$endTime', '$unitName', '$overRide')
";

//echo "dodid matches!";

}else{

$findAppointmentMember = "Select * from members where dodId = $dodId";
$resultsFindAppoitnmentMember = mysqli_query($connection,$findAppointmentMember);

while ($row = mysqli_fetch_assoc($resultsFindAppoitnmentMember)) {
$recallIV = $row['iv'];

}
if($recallIV == true){
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));

$insertIVForMemberUpdate = "UPDATE members SET iv = '$iv' WHERE dodId = '$dodId'";

$resultInsertIVForMemberUpdate = mysqli_query($connection, $insertIVForMemberUpdate);

}

$encryptedEmail = openssl_encrypt($email, $cipherMethod, $recalldodId, $options=0, $recallMembersIV);

$appointmentSQL = "INSERT INTO `appointmentRoster` (id, dodId, rank, email, firstName, middleName, lastName, title, installation, location, startdate, appointmentTime, selfMade, dutySection, allDay, enddate, addedBy, dateAdded, notes, endTime, unitName, overRide)
VALUES (id, '$dodId', '$rank', '$encryptedEmail', '$firstName', '$middleName', '$lastName', '$type', '$installation', '$location', '$startDate', '$startTime', '$selfMade', '$dutySection', '', '$endDate', '$addedBy', '$now', '$note', '$endTime', '$unitName', '$overRide')
";

}


//Admin overriding or double booking an appointment NO email
if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['overRide'])) {

if (isset($_POST['overRide'])) {
$resultAppointment = mysqli_query($connection, $appointmentSQL);
$successmsgOverride = "$rank $recallFirstName $recallLastName has been scheduled for $type on $startDate at $startTime to $endTime. (Admin approved override)";


} elseif (!isset($_POST['overRide'])) {
//$error1 = "$recallRank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate.";

$errormsgOverride = "$recallRank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (Admin, must Override or Delete 1)";

}
}


else{}


/* //Admin overriding or double booking an appointment with email
if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['overRide'])) {

if (isset($_POST['overRide']) && isset($_POST['sendEmail'])) {
$resultAppointment = mysqli_query($connection, $appointmentSQL);
$successmsgOverride = "$rank $recallFirstName $recallLastName has been scheduled for $type on $startDate at $startTime to $endTime. (Admin approved override)";


} elseif (!isset($_POST['overRide'])) {
//$error1 = "$recallRank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate.";

$errormsgOverride = "$recallRank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (Admin, must Override or Delete 1)";

}
}


else{}*/


/*
//Admin deleting an appointment
if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['delete'])) {


if (mysqli_num_rows($resultFindAppt) > 0) {

$resultAppointment = mysqli_query($connection, $deleteApptSql);
$successmsgDelete = "$recallRank $recallFirstName $recallLastName has been deleted for $type on $startDate at $startTime to $endTime. (Admin deletion approved)";

} else{

$errormsgDelete = "$rank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (User account logged in or Admin needs to override or delete 1)";

}

}else{}


//member adding appointment with email reminder
if(isset($_POST['firstName']) && isset($_POST['lastName']) && !isset($_POST['delete']) && !isset($_POST['overRide']) && (isset($_POST['emailReminder']))) {

if (mysqli_num_rows($resultFindAppt) > 0) {

$errormsgUser = "$rank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (User account logged in or Admin needs to override or delete2)";

} else {
$resultAppointment = mysqli_query($connection, $appointmentSQL);

//$successmsg = "Appointment Successfully Added.";
$successmsgUser = "$rank $firstName $lastName has been scheduled for $type on $startDate at $startTime to $endTime. (User, no override/no delete needed)";


$emailSend = urldecode($encodedEmail);



//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
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
$mail->setFrom('YOUR.EMAIL@DOMAIN.COM', 'Appointment Reminder');
//Set an alternative reply-to address
//$mail->addReplyTo('YOUR.EMAIL@DOMAIN.COM', 'System Admin');
//Set who the message is to be sent to
$mail->addAddress($emailSend, ".$firstName $lastName.");
//Set the subject line
$mail->Subject = 'Scheduled Appointment Reminder';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually

$body = "<p>This is an auto generated email reminder for ".$rank." ".$firstName." ".$lastName."<br>
You have succeesfully added an appointment to the Appointment Roster for: <br>
".$startTime." on ".$startDate." for ".$type." on ".$installation." at building ".$location.".<br>

Your appointment is appointment is scheduled to end at ".$endTime." on the ".$endDate.".<br>

Thank you,<br>
SFS Administrator </p>";
$mail->Body = $body;
$mail->AltBody = strip_tags($body);
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
if (!$mail->send()) {
$emailFailure = 'Email was not sent!';
} else {
$emailSuccess = 'Email message was successfully sent to '.$emailSend.'!';
}


}

// mail($email,$type,$startDate,[$headers],[$parameters]);
}
//member with no email reminder
if(isset($_POST['firstName']) && isset($_POST['lastName']) && !isset($_POST['delete']) && !isset($_POST['overRide']) && !isset($_POST['emailReminder'])) {

if (mysqli_num_rows($resultFindAppt) > 0) {

$errormsgUser = "$rank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (User account logged in or Admin needs to override or delete2)";

} else {
$resultAppointment = mysqli_query($connection, $appointmentSQL) or die (mysqli_error($connection));

//$successmsg = "Appointment Successfully Added.";
$successmsgUser = "$rank $firstName $lastName has been scheduled for $type on $startDate at $startTime to $endTime. (User, no override/no delete needed)";

}
}
*/

?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../AdminLTE-master/dist/css/adminlte.min.css">

  <!-- Theme style -->
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>



</head>

<body>
  <div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <!--  <h5 class="modal-title">Warning</h5>-->
            <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          </div>
          <div class="modal-body">
            <?php if ($override == true) { ?><div class="alert alert-warning" role="alert" name="override" style="text-align: left"> <?php echo $previousAppointmentWithOverride; ?> <a href='appointment-view.php'></a></div><?php } ?>

            <?php if (isset($dodMatch)) { ?><div class="alert alert-warning" role="alert" name="dodMatch" style="text-align: left"> <?php echo $returnedMessage; ?> <a href='appointment-view.php'></a></div><?php } ?>

            <?php if (isset($submitAppointment)) { ?><div class="alert alert-success" role="alert" name="insertAppointment" style="text-align: left"> <?php echo $returnedMessageDataBase; ?></div><?php } ?>


            <?php if (!isset($submitAppointment)) { ?><div class="alert alert-success" role="alert" name="appointmentError" style="text-align: left"> <?php echo $returnedMessage; ?> <a href='appointment-view.php'></a></div><?php } ?>


            <?php if ($emailRequested == true) { ?><div class="alert alert-success" name="emailReminderMSG" role="alert" style="text-align: left"> <?php echo $returnedMessageEmailSelectError; ?></div><?php } ?>

            <?php




            if ($emailSend == false) {

              echo '<div class="alert alert-danger" role="alert" name="emailFailureSendMSG" style="text-align: center"> ' . $emailFailure . ' </div><p style="text-align: center"></p>';
            }
            if (isset($emailSend) and ($emailSend == '1')) {


              echo '<div class="alert alert-success" role="alert" name="emailSuccessSendMSG" style="text-align: center"> ' . $emailSuccess . ' </div><p style="text-align: center"></p>';
            } else {
            }

            ?>

            <!--
                          //////
                          ///// If SMTPDebug is set to 2, headers for redirect will not work for appointment-insert.php
                          ////-->
            <?php header("refresh:5;url=appointment-view.php"); ?>
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
<script>
  $(document).ready(function() {
    $('#myModal').modal('show');

  });
</script>



<style>
  .bs-example {
    margin: 20px;
  }
</style>

</html>