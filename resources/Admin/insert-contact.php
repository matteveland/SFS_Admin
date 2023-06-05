<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';


//require $_SERVER['DOCUMENT_ROOT'].'/vendor/phpmailer/phpmailer/src/PHPMailer.php';
//require $_SERVER['DOCUMENT_ROOT'].'/vendor/phpmailer/phpmailer/src/SMTP.php';
//require $_SERVER['DOCUMENT_ROOT'].'/vendor/phpmailer/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('America/Los_Angeles');
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$lastName = $mysqli->real_escape_string($_POST['lastName']);
$firstName = $mysqli->real_escape_string($_POST['firstName']);
$rank = $mysqli->real_escape_string($_POST['rank']);
$suggestion = $mysqli->real_escape_string($_POST['suggestionField']);

$email = ($_POST['email']);

$encodedEmail = urlencode($email);

$email = $mysqli->real_escape_string($encodedEmail);

$sfsEmail = 'YOUR.EMAIL@DOMAIN.COM';

$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

$getUserName = $mysqli->query("SELECT lastName, firstName FROM login WHERE (user_name = '$user' or user_name = '$admin')");

while ($row = $getUserName->fetch_assoc()) {

    $recallAdmin_UserLastRecall = $row['lastName'];
    $recallAdmin_UserFirstRecall = $row['firstName'];
}

$emailSend = urldecode($encodedEmail);

$submittedBy = $unitName . ' - ' . $rank . ' ' . $recallAdmin_UserLastRecall . ', ' . $recallAdmin_UserFirstRecall . ', ' . $emailSend;


//member adding appointment
if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['inputSubmit'])) {

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
    $mail->Port = 587;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = 'YOUR.EMAIL@DOMAIN.COM';
    //Password to use for SMTP authentication
    $mail->Password = $_ENV['mailAuthorizationPassword'];
    //Set who the message is to be sent from
    $mail->setFrom('YOUR.EMAIL@DOMAIN.COM', 'Suggestion Page');
    //Set an alternative reply-to address
    //$mail->addReplyTo('YOUR.EMAIL@DOMAIN.COM', 'System Admin');
    //Set who the message is to be sent to
    $mail->addAddress('YOUR.EMAIL@DOMAIN.COM', 'Suggestion Page');
    //Set the subject line
    $mail->Subject = 'Suggestion Page';
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
    //Replace the plain text body with one created manually

    $body = "<p>A suggestion has been mailed by:  " . $submittedBy . " <br>
<br>
        " . $suggestion . "</p>";

    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    if (!$mail->send()) {
        $emailFailure = 'Email was not sent!';
    } else {
        $emailSuccess = 'Email message was successfully sent to web admin!';
    }


    // mail($email,$type,$startDate,[$headers],[$parameters]);
} else {
    $failuremsg = 'First Name and Last Name are required.';
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
                        <h5 class="modal-title">Contact Form</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($successmsg)) { ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                        <?php if (isset($failuremsg)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                        <?php if (isset($emailFailure)) { ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $emailFailure; ?> </div><?php } ?>
                        <?php if (isset($emailSuccess)) { ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $emailSuccess; ?> </div><?php } ?>
                        <p style="text-align: center"></p>
                        <?php header("refresh:5;url=contact.php"); ?>
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