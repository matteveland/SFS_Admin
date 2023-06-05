<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
require ('/Users/matteveland/code/data.env');
if (isset($_POST['submit'])) {

   // $email = ($_POST['email']);
  //  $encodedEmail = urlencode($email);
  //  $email = $mysqli->real_escape_string($encodedEmail);
    $userName = $mysqli->real_escape_string($_POST['userName']);
    $last = $mysqli->real_escape_string($_POST['lastName']);
    $first = $mysqli->real_escape_string($_POST['firstName']);
    $middle = $mysqli->real_escape_string($_POST['middleName']);
   // $dodId = $mysqli->real_escape_string($_POST['dodId']);
    $TAFMSD = $mysqli->real_escape_string($_POST['TAFMSD']);
    //$unitName = $mysqli->real_escape_string($_POST['unitNameDropDown']);
    $secretQuestion = $mysqli->real_escape_string($_POST['secretQuestion']);
    $secretAnswer = $mysqli->real_escape_string($_POST['secretAnswer']);
    $secret = array($secretQuestion, $secretAnswer);
    $secretArray = implode(',', $secret);
    $newpassword = $mysqli->real_escape_string($_POST['password']);
    $passwordVerify = $mysqli->real_escape_string($_POST['newPasswordVerify']);

    $queryAllTrue = $mysqli->query("SELECT * FROM `login` WHERE (user_name='$userName' AND lastName = '$last' AND firstName = '$first' AND middleName = '$middle' AND enterDate = '$TAFMSD')") or die (mysqli_errno($mysqli));

    //$resultQueryAllTrue = mysqli_query($connection, $queryAllTrue) or die(mysqli_error($connection));

    while ($row = $queryAllTrue->fetch_assoc()) {

        $secretResults = $row['secret'];
       // $emailResults = $row['email'];

        $secretResultsQuestion = $secretResults[0];
        $secretResultsAnswer = $secretResults[1];

    }

    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
  //  $encryptedEmail = openssl_encrypt($email, $cipherMethod, $emailKey, $options=0, $iv);


   // $emailDecrypted = openssl_decrypt($emailResults, $cipherMethod, $emailKey, 0, $iv);

    if (($secretArray == $secretResults)) {

        if ($newpassword === $passwordVerify) {

            if ($queryAllTrue) {

                $passwordHashed = password_hash($passwordVerify, PASSWORD_DEFAULT);

                $updatePassword = $mysqli->query("UPDATE `login` SET `password` = '$passwordHashed' WHERE (`user_name` = '$userName' AND lastName = '$last' AND firstName = '$first' AND middleName = '$middle' AND enterDate = '$TAFMSD' and secret = '$secretArray')") or die(mysqli_errno($mysqli));

                //$resultUpdatePassword = mysqli_query($connection, $updatePassword) or die(mysqli_error($connection));

                $successmsg = "Password was successfully updated/changed.";

            } else {
                $errorMessage = "The information supplied does not match the records in the database.";
            }
        } else {
            echo "Passwords did not match";
        }
    } else {

        if (($secretResults == $secretArray)) {

            if ($secretResultsQuestion == '1') {

                $recoveryQuestionMismatch = "Your recovery question does not match what you supplied when registering your account.<br> Please select: What is your favorite color? and try again. ";

            } elseif ($secretResultsQuestion == '2') {
                $recoveryQuestionMismatch = "Your recovery question does not match what you supplied when registering your account.<br> Please select: Make of your first car? and try again. ";

            } elseif ($secretResultsQuestion == '3') {
                $recoveryQuestionMismatch = "Your recovery question does not match what you supplied when registering your account.<br> Please select: Favorite sport? and try again. ";

            } elseif ($secretResultsQuestion == '4') {
                $recoveryQuestionMismatch = "Your recovery question does not match what you supplied when registering your account.<br> Please select: Best location your have visited? and try again. ";

            } elseif ($secretResultsQuestion == '5') {
                $recoveryQuestionMismatch = "Your recovery question does not match what you supplied when registering your account.<br> Please select: Are sharks fish? and try again. ";


            } else {

                $failuremsg = "Your personal information does not match the database. Please contact system admin 1";

            }
        } else {
            $failuremsg = "You have no recovery question. Please contact system admin 2";

        }

    }

}

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 4 Modal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</head>
<body>

<div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logging In</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

<?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
<?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
<?php if(isset($errorMessage)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $errorMessage; ?> </div><?php } ?>
<?php if(isset($recoveryQuestionMismatch)){ ?><div class="alert alert-secondary" role="alert" style="text-align: center"> <?php echo $recoveryQuestionMismatch; ?> </div><?php } ?>

                    <p style="text-align: center">Redirecting to login page</p>
                    <?php  header("refresh:2;url=login.php");?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>