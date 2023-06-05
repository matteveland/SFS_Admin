<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
//include __DIR__ . "../../../AdminLTE-master/pages/UI/modals.html";
date_default_timezone_set('America/Los_Angeles');
//parse_str($_SERVER['QUERY_STRING']);

if (isset($_POST['submit'])) {


    $email = urlencode($_POST['email']);
    $dodId = $mysqli->real_escape_string($_POST['dodId']);
    $last = $mysqli->real_escape_string($_POST['lastName']);
   // $email = openssl_encrypt($recallEmail, $cipherMethod, $emailKey, $options = 0, $recallIv);


    $queryLogin = $mysqli->query("Select * from login where (lastName = '$last' AND dodId = '$dodId')") or die (mysqli_error($mysqli));

        while ($row = $queryLogin->fetch_assoc()) {
        $recallUserName = $row['user_name'];
        $recallEmail = $row['emailAddress'];
        $recallIv = $row['iv'];
    }
        $recallEmail = openssl_decrypt($recallEmail, $cipherMethod, $emailKey, $options = 0, $recallIv);

    $queryLogin = $mysqli->query("Select * from login where (lastName = '$last' AND dodId = '$dodId' and iv = '$recallIv')") or die (mysqli_error($mysqli));

    if ($queryLogin->num_rows > 0) {

        echo "<p align='center'><a href='resetPassword.php'>Reset Password </p>";

        echo '<form action="login.php" method="POST">
                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Return to Login Page" />
              </form>';

    } else {
            echo '<div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>There is no account associated with your last name, email, and DOD ID</p>

                </div>
                <div class="modal-footer">
                    <a href="login.php"> <button type="button" class="btn btn-secondary">Login</button></a>
                    <a href="recover-password.html"><button type="button" class="btn btn-primary">Reset Password</button></a>

                </div>

            </div>
        </div>
    </div>
</div>';

        }



    //$resultCreate = mysqli_query($connection, $queryCreate);

} else {

    echo "Unable to retrieve account information.";
}
?>


<!DOCTYPE html>
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
                <div class="modal-body">
                    <p>Your user name is <?php echo "\"$recallUserName\""?></p>

                </div>
                <div class="modal-footer">
                    <a href="login.php"> <button type="button" class="btn btn-secondary">Login</button></a>
                    <a href="recover-password.html"><button type="button" class="btn btn-primary">Reset Password</button></a>

                </div>

            </div>
        </div>
    </div>
</div>


</body>
</html>

