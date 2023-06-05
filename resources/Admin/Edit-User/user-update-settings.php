<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
parse_str($_SERVER['QUERY_STRING'], $query);
$id = $mysqli->real_escape_string($query['ID']);
$last = $mysqli->real_escape_string($query['last']);
//$data = $mysqli->real_escape_string($query['data']);

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
//include('/var/services/web/sfs/Application/data.env');
//include('/Users/matteveland/code/data.env');

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);
$unitName = $_SESSION['unitName'];

if (isset($_POST['update'])) {
  $findMember = new FindMember();
  $findMember->find_member($id, $last, $unitName);


  //members personal information
  //$gender = mysqli_real_escape_string($mysqli, $_POST['inputGender']);
  $rankUpdate = mysqli_real_escape_string($mysqli, $_POST['inputRankSelect']);
  $firstName = mysqli_real_escape_string($mysqli, $_POST['inputFirstName']);
  $middleName = mysqli_real_escape_string($mysqli, $_POST['inputMiddleName']);
  $lastName = mysqli_real_escape_string($mysqli, $_POST['inputLastName']);
  //$birthdate = mysqli_real_escape_string($mysqli, $_POST['inputBirthdate']);
  //$dodId = mysqli_real_escape_string($mysqli, $_POST['readonlyDODID']);
  //$address = mysqli_real_escape_string($mysqli, $_POST['address']);
  $homePhone = mysqli_real_escape_string($mysqli, $_POST['inputHomePhone']);
  //$dutySection = mysqli_real_escape_string($mysqli, $_POST['inputDutySectionSelect']);
  $cellPhone = mysqli_real_escape_string($mysqli, $_POST['inputCellPhone']);
  $emailOptIn = mysqli_real_escape_string($mysqli, $_POST['emailOptIn']);

  $govEmail = mysqli_real_escape_string($mysqli, $_POST['inputGovEmail']);
  $prsnlEmail = mysqli_real_escape_string($mysqli, $_POST['inputPrsnlEmail']);
  //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));





  $encryptedHomePhone = openssl_encrypt($homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options = 0, $findMember->iv);


  $encryptedCellPhone = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options = 0, $findMember->iv);

    $decryptedCellPhone = openssl_decrypt($encryptedCellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options = 0, $findMember->iv);


  //$encryptedBirthdate = openssl_encrypt($findMember->birthdate, $_ENV['cipherMethod'], $_ENV['birthdateKey'], $options = 0, $findMember->iv);

  $encryptedGovEmail = openssl_encrypt($govEmail, $_ENV['cipherMethod'], $_ENV['govEmailKey'], $options = 0, $findMember->iv);

  $encryptedPrsnlEmail = openssl_encrypt($prsnlEmail, $_ENV['cipherMethod'], $_ENV['prsnlEmailKey'], $options = 0, $findMember->iv);



  $updateMembersInformation = $mysqli->query("UPDATE members SET lastName = '$lastName', firstName = '$firstName', middleName =  '$middleName', `rank` = '$rankUpdate', homePhone = '$encryptedHomePhone', cellPhone = '$encryptedCellPhone', govEmail = '$encryptedGovEmail', PrsnlEmail = '$encryptedPrsnlEmail', iv ='$findMember->iv', emailOpt_in = '$emailOptIn' WHERE (lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName' AND unitName = '$findMember->unitName')");


  if (!$updateMembersInformation) {


    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $failuremsg = "Member Was Not Updated - Please try again.";


  } else {
    $successmsg = "Member Successfully Updated.";

    $location = "/resources/Admin/Edit-User/user-view-settings.php?ID=$findUser->dodId&last=$findUser->lastName";


    //$here = "/resources/Admin/Edit-User/member-view.php?ID=1256916548&last=Eveland";


    //echo '<meta http-equiv="refresh" content="2; url='.$here.'">';

    //echo "<meta http-equiv='refresh' content='0': $location>";

    // header("Location: '.$location.'");

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
            <h5 class="modal-title">Update Member Information</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <p style="text-align: center"></p>
                <?php header("refresh:3;url=$location");?>
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
                <h5 class="modal-title">User updated</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>User updated successfully</p>
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
