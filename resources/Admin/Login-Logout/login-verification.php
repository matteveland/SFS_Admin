<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
//include __DIR__ . "../../../AdminLTE-master/pages/UI/modals.html";
date_default_timezone_set('America/Los_Angeles');?>
<!DOCTYPE html>
<?php
$now = date('Y-m-d');
//Start the Session
$address = $_SERVER['REMOTE_ADDR'];

if ((isset($_POST['submit'])) and (isset($_POST['password'])) and (isset($_POST['userName'])) AND (isset($_POST['unitNameDropDown']))) {
    //3.1.1 Assigning posted values to variables.

    $username = $mysqli->real_escape_string($_POST['userName']);
    $password = $mysqli->real_escape_string($_POST['password']);
   $unitName = $mysqli->real_escape_string($_POST['unitNameDropDown']);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $passwordVerify = password_verify($password, $hash);

//3.1.2 Checking the values are existing in the database or not

    $resultsAdmin = $mysqli->query("SELECT * FROM `login` WHERE (BINARY user_name='$username') AND admin = 'Yes' AND unitName = '$unitName'");

    while ($row = $resultsAdmin->fetch_assoc()) {

        $userID = $row['user_name'];
        $last = $row['lastName'];
        $first = $row['firstName'];
        $middle = $row['middleName'];
        $hashedPassword = $row['password'];
        $admin = $row['admin'];
        $unitName = $row['unitName'];

    }

    $resultsUser = $mysqli->query("SELECT * FROM `login` WHERE (BINARY user_name='$username') AND admin = 'No' AND unitName = '$unitName'");
   // $resultQueryUser = mysqli_query($connection, $queryUser);

    while ($row = $resultsUser->fetch_assoc()) {

        $userID = $row['user_name'];
        $last = $row['lastName'];
        $first = $row['firstName'];
        $middle = $row['middleName'];
        $hashedPassword = $row['password'];
        $admin = $row['admin'];
        $unitName = $row['unitName'];

    }

    if (password_verify($password, $hashedPassword)) {

        $findSection = $mysqli->query("SELECT dutySection FROM members where lastName = '$last' AND middleName = '$middle' AND firstName = '$first' AND unitName = '$unitName'");

        while ($row = $findSection->fetch_assoc()) {

            $dutySection = $row['dutySection'];

        }

        //Admin
        $count = $resultsAdmin->num_rows;

        //User
        $countUser = $resultsUser->num_rows;

//3.1.2 If the posted values are equal to the database values, then session will be created for the user.

        if ($count == 1) {
            session_start();
            $_SESSION['page_admin'] = $username; //admin
            $_SESSION['unitName'] = $unitName;
            $_SESSION['dutySection'] = $dutySection;

        } elseif ($countUser == 1) {
            session_start();
            $_SESSION['page_user'] = $username; //User
            $_SESSION['unitName'] = $unitName;
            $_SESSION['dutySection'] = $dutySection;
        }
    } else {
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        $fmsg = "Invalid Login Credentials.";
    }
}

//3.1.4 if the user is logged in Greets the user with message
if (isset($_SESSION['page_admin']) OR isset($_SESSION['page_user'])) {

   // setcookie($username, $unitName, time() + (86400 * 7), '/SFSAdmin-v2.0/', 'sfsadmin.com', true, true);
    $nameArray = array();
    $nameArray = array($last, $first);
    $nameArray = implode(', ', $nameArray);

    $trackLastLogin = $mysqli->query("INSERT INTO `tracking` (`id`, `dateLastLogin`, `membersName`, `username`, `address`, `unitName`) VALUES (id,'$now', '$nameArray', '$username', '$address', '$unitName')");

            echo '<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                    <p>You will be rerouted to the SFSAdmin homepage</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>';


    header("refresh:3;url=../../../homepage.php");


}else {

    echo '<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                    <p>User Name or Password did not match. Redirecting to login page</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>';
    header("refresh:5;url=login.php");
}


   // include_once __DIR__ . "/../../../resources/Navigation/footer.php"; ?>

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
