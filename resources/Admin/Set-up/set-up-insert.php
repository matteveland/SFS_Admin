<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
date_default_timezone_set('America/Los_Angeles');

$unitName = $_SESSION['unitName_setup'];
var_dump($unitName);

echo "<br>";
echo "\$_SESSION['section_setup']"; var_dump($_SESSION['section_setup']);
echo "<br>";
echo "\$_SESSION['post_patrolSetup']"; var_dump($_SESSION['post_patrolSetup']);



$lastName = $mysqli->real_escape_string($_POST['lastName']);
$firstName =  $mysqli->real_escape_string($_POST['firstName']);
$middleName =  $mysqli->real_escape_string($_POST['middleName']);
//$unitName =  $mysqli->real_escape_string($_POST['unitNameDropDown']);

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
  //$emailDecrypted = openssl_decrypt($encryptedEmail, $_ENV['cipherMethod'], $_ENV['emailKey'], 0, $iv);

  //print_r($emailDecrypted);

  //$dodId =  $mysqli->real_escape_string($_POST['dodId']);
  $username =  $mysqli->real_escape_string($_POST['username']);
  $password = $mysqli->real_escape_string($_POST['password']);
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $TAFMSD =  $mysqli->real_escape_string($_POST['TAFMSD']);

  $secretQuestion =  $mysqli->real_escape_string($_POST['secretQuestion']);
  $secretAnswer =  $mysqli->real_escape_string($_POST['secretAnswer']);

  $secretBoth = array($secretQuestion, $secretAnswer);
  $secretBoth = implode(',', $secretBoth);

  //$dutySection = $_POST['dutySection'];



  // ADMIN query section

  $queryMembersAdmin = "Select members.lastName, members.middleName, members.firstName, members.admin
  from members
  where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName' AND members.admin = 'Yes' AND unitName = '$unitName')
  ";

  $resultVerifyAdmin =  $mysqli->query($queryMembersAdmin) or die(mysqli_connect_errno());

  $queryDupesAdmin = "Select login.lastName, login.firstName, login.middleName, login.emailAddress, login.user_name
  from login
  WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName') AND login.user_name = FALSE)";

  $resultDupesAdmin =  $mysqli->query($queryDupesAdmin)or die(mysqli_connect_errno());

  $queryCreateAdmin = "INSERT INTO `login` (user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId) VALUES ('$username', '$hash', '$encryptedEmail', '$lastName', '$firstName', '$middleName', '$TAFMSD', 'Yes', '$unitName', '$secretBoth', '')";
  $queryUpdateAdmin = "UPDATE `login` SET dodId = '$recallresultFindDoDID' WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName'))";

  //$queryUpdateUser = "UPDATE `login` SET dodId = '$recallresultFindDoDID' WHERE ((lastName = '$lastName') AND (firstName = '$firstName') AND (middleName = '$middleName'))";

  //INSERT INTO `login` (id, user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId) VALUES (id, 'testName', '12', 'mail@mail.com', 'test', 'first', 'NMI','01-Jun-19', 'No', '799 SFS', '1, Bule', '12345678910');


  //$resultCreate =  $mysqli->query($queryCreate);

  $findDupeUserName = $mysqli->query("SELECT user_name FROM login where user_name = '$username'");

  if ($findDupeUserName->num_rows){

    echo"<script type='text/javascript'>
    alert('User Name already taken.');


    </script>";


  }

  if ($resultDupesAdmin->num_rows) {

    echo "<script type=\"text/javascript\">
    alert(\"Member's name is already in database. Contact your System Administrator for assistance. (Duplication Error)\");</script>";

    //header("refresh:0;url=1-set-up-unit-name.php");

  }else{

    if($resultVerifyAdmin->num_rows) {

      $resultCreateAdmin =  $mysqli->query($queryCreateAdmin) or die(mysqli_connect_errno());

      $resultUpdateAdmin =  $mysqli->query($queryUpdateAdmin)or die(mysqli_connect_errno());

      //$insertAdmin = "UPDATE `login` SET `admin` = 'Yes' where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName')";

      //$updateAdmin =  $mysqli->query($insertAdmin);

      $subject = "Successfully Added f";
      $msg = '<div class="alert alert-success" role="alert" style="text-align: center">Access account was created. Redirecting to log page.</div>';

      header("refresh:3;url=/resources/Admin/Login-Logout/login.php");


    } else {
      /*echo "<script type=\"text/javascript\">
      alert(\"Member does not have permissions to have Admin account.\");

      </script>";*/
      $subject = "Failure to Added Account";

      $msg = '<div class="alert alert-danger" role="alert" style="text-align: center">Access account was not created. Contact System Administrator</div>';
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
            <h5 class="modal-title"><?php echo $subject;?></h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php echo $msg; ?> <?php  ?>
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
