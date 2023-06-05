<?php
//phpmailer things
use PHPMailer\PHPMailer\PHPMailer;

function sendAppointmentReminder($email, $firstName, $lastName, $emailPassword, $startTime, $startDate, $endTime, $endDate, $type, $installation, $building, $location)
{


  //  $emailPassword = $emailPassword;
  $emailPassword = $_ENV['mailAuthorizationPassword'];


  $emailSend = urldecode($email);
  $mail = new PHPMailer();
  //Create a new PHPMailer instance
  //Tell PHPMailer to use SMTP
  $mail->isSMTP();
  //Enable SMTP debugging
  // 0 = off (for production use)
  // 1 = client messages
  // 2 = client and server messages

  //////
  ///// If SMTPDebug is set to 2, headers for redirect will not work for appointment-insert.php
  ////
  $mail->SMTPDebug = 0;
  //Set the hostname of the mail server
  $mail->Host = 'smtp.gmail.com';
  //Set the SMTP port number - likely to be 25, 465 or 587
  $mail->SMTPSecure = 'tls';
  //$mail->Port = 587;
  //Whether to use SMTP authentication
  $mail->SMTPAuth = true;
  //Username to use for SMTP authentication
  $mail->Username = 'YOUR.EMAIL@DOMAIN.COM';
  //Password to use for SMTP authentication
  $mail->Password = $emailPassword;
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

  $body = "<p>This is an auto generated email reminder for " . $rank . " " . $firstName . " " . $lastName . "<br>
  You have succeesfully added an appointment to the Appointment Roster for: <br>
  " . $startTime . " on " . $startDate . " for " . $type . " on " . $installation . " at building " . $location . ".<br>

  Your appointment is appointment is scheduled to end at " . $endTime . " on the " . $endDate . ".<br>

  Thank you,<br>
  SFS Administrator </p>";
  $mail->Body = $body;
  $mail->AltBody = strip_tags($body);
  //Attach an image file
  //$mail->addAttachment('images/phpmailer_mini.png');
  //send the message, check for errors
  if (!$mail->send()) {

    $emailSend = false;
  } elseif ($mail->send()) {

    $emailSend = '1';
  } else {
    $emailSend = NULL;
  }
}
