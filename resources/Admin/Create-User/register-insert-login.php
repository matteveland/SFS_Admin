<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
//isUserLogged_in();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

parse_str($_SERVER['QUERY_STRING'], $query);
//$unitName = $_SESSION['unitName'];

//include ('/var/services/home/sfs/data.env');
date_default_timezone_set('America/Los_Angeles');


/*
if(!isset($_SESSION['page_admin'])){
//Does not exist. Redirect user back to page-one.php
header('Location: home.php');
exit;
}*/
//Check to see if session variable exists.

$lastName = $mysqli->real_escape_string($_POST['lastName']);
$firstName =  $mysqli->real_escape_string($_POST['firstName']);
$middleName =  $mysqli->real_escape_string($_POST['middleName']);
$unitName =  $mysqli->real_escape_string($_POST['unitNameDropDown']);

$findDoDId = "SELECT * FROM members WHERE ((lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName') AND unitName = '$unitName') ";

$resultFindDoDId =  $mysqli->query($findDoDId) or die(mysqli_connect_errno());

while ($row = $resultFindDoDId->fetch_assoc()) {

  $recallresultFindDoDID = $row['dodId'];

}

//echo $recallresultFindDoDID;


// If the values are posted, insert them into the database.
if (isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] != $_POST['verifyPassword'])) {

  echo "<script type=\"text/javascript\">
  alert(\"Passwords do not match.\");

  </script>";

}elseif(isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] == $_POST['verifyPassword'])) {



  $email = ($_POST['email']);
  $encodedEmail=urlencode($email);
  $email =  $mysqli->real_escape_string($encodedEmail);
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_ENV['cipherMethod']));
  $encryptedEmail = openssl_encrypt($email, $_ENV['cipherMethod'], $_ENV['emailKey'], $options=0, $iv);
  $username =  $mysqli->real_escape_string($_POST['username']);
  $password = $mysqli->real_escape_string($_POST['password']);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $TAFMSD =  $mysqli->real_escape_string($_POST['TAFMSD']);
  $secretQuestion =  $mysqli->real_escape_string($_POST['secretQuestion']);
  $secretAnswer =  $mysqli->real_escape_string($_POST['secretAnswer']);
  $secretBoth = array($secretQuestion, $secretAnswer);
  $secretBoth = implode(',', $secretBoth);

  // ADMIN query section
  $queryMembersAdmin = "Select members.lastName, members.middleName, members.firstName, members.admin from members
  where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName' AND members.admin = 'Yes' AND unitName = '$unitName')
  ";

  $resultVerifyAdmin =  $mysqli->query($queryMembersAdmin) or die(mysqli_connect_errno());

  $queryDupesAdmin = "Select login.lastName, login.firstName, login.middleName, login.emailAddress, login.user_name
  from login
  WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName') AND login.user_name = FALSE)";

  $resultDupesAdmin =  $mysqli->query($queryDupesAdmin)or die(mysqli_connect_errno());

  $queryCreateAdmin = "INSERT INTO `login` (user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId) VALUES ('$username', '$hash', '$encryptedEmail', '$lastName', '$firstName', '$middleName', '$TAFMSD', 'Yes', '$unitName', '$secretBoth', '')";
  $queryUpdateAdmin = "UPDATE `login` SET dodId = '$recallresultFindDoDID' WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName'))";


  // USER query section
  $queryMembersUser = "Select members.lastName, members.middleName, members.firstName, members.admin
  from members
  where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName' AND (members.admin = 'No' OR members.admin = '' OR members.admin = NULL))
  ";

  //$queryMember user retuns so results on echo with no members matching within database.


  $resultVerifyUser =  $mysqli->query($queryMembersUser) or die(mysqli_connect_errno());

  $queryDupesUser = "Select login.lastName, login.firstName, login.middleName, login.emailAddress, login.user_name
  from login WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName'))";

  $resultDupesUser =  $mysqli->query($queryDupesUser)or die(mysqli_connect_errno());

  $queryCreateUser = "INSERT INTO `login` (id, user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId)
  VALUES (id, '$username', '$hash', '$encryptedEmail', '$lastName', '$firstName', '$middleName','$TAFMSD', 'No', '$unitName', '$secretBoth', '$recallresultFindDoDID')";

  $findDupeUserName = "select username FROM login where username = '$username'";

  if ($findDupeUserName > 0){

    $subject = "Failure to add member";
    $failuremsg = "Member's name is already in database. (Duplication Error)";
  /*  echo"<script type='text/javascript'>
    alert('User Name already taken.');</script>";
    trigger_error("User Name already taken");*/
    exit();
}


echo "Select members.lastName, members.middleName, members.firstName, members.admin
from members
where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName' AND (members.admin = 'No' OR members.admin = '' OR members.admin = NULL))
";




  if ($resultDupesAdmin->num_rows) {

    $subject = "Failure to add member";
    $failuremsg = "Member's name is already in database. (Duplication Error)";
    /*echo "<script type=\"text/javascript\">
    alert(\"Member's name is already in database. (Duplication Error)\");</script>";*/
    trigger_error("You are already registered.");


  }elseif($resultDupesUser->num_rows) {

    $subject = "Failure to add member";
    $failuremsg = "Member's name is already in database. (Duplication Error)";
    /*echo "<script type=\"text/javascript\">
    alert(\"Member's name is already in database. (Duplication Error)\");</script>";*/
    trigger_error("You are already registered.");

  }elseif($resultVerifyAdmin->num_rows == 0) {

    $subject = "Member Successfully Registered";

    $resultCreateAdmin =  $mysqli->query($queryCreateAdmin) or die(mysqli_connect_errno());
    $resultUpdateAdmin =  $mysqli->query($queryUpdateAdmin)or die(mysqli_connect_errno());
    $successmsg = "Administration Account Created Successfully.";
    trigger_error("$successmsg1");

  }elseif($resultVerifyUser->num_rows == 0) {
    $resultCreateUser =  $mysqli->query($queryCreateUser) or die(mysqli_connect_errno());

    if (!$resultCreateUser){
      $subject = "Failure to add member";

      $failuremsg = "Account Not Created.";
      trigger_error("f$ailuremsg2");

    }else{

      $subject = "Member Successfully Registered";

      $successmsg = "Account Created Successfully.";
      trigger_error("$successmsg2");

    }
  }else{
    $subject = "Failure to add member";
    $failuremsg = "Account Not Created.";
    trigger_error("$failuremsg");

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
            <h5 class="modal-title"><?php echo $subject; ?></h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <p style="text-align: center"></p>
                <?php  header("refresh:3;url=register-view-login.php");?>
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
