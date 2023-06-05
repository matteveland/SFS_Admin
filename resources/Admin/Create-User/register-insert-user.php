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
$unitName = $_SESSION['unitName'];

//include ('/var/services/home/sfs/data.env');
date_default_timezone_set('America/Los_Angeles');

$unitName =  $_SESSION['unitName'];


/*
* proved problematic if ESS needed to add someone
* if (stristr($_SESSION['page_admin'], 'Unit') ==true) {
echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
exit();

}*/

// If the values are posted, insert them into the database.
if (isset($_POST['inputFirstName']) && isset($_POST['inputLastName']) && (!empty($unitName))) {

  $firstName = $mysqli->real_escape_string($_POST['inputFirstName']);
  $middleName = $mysqli->real_escape_string($_POST['inputMiddleName']);
  $lastName = $mysqli->real_escape_string($_POST['inputLastName']);
  $dodID = $mysqli->real_escape_string($_POST['inputDODID']);

  $verifyNoPriorEntry = "select * From members where lastName = '$lastName' And firstName ='$firstName' AND dodID = '$dodID' AND unitName ='$unitName'";

  $resultsVerifyNoPrior = $mysqli->query($verifyNoPriorEntry);

  if (mysqli_num_rows($resultsVerifyNoPrior)< 1){

    $lastFour = $mysqli->real_escape_string($_POST['inputLastFour']);
    $deros = $mysqli->real_escape_string($_POST['inputDEROS']);

    $rank = $mysqli->real_escape_string($_POST['inputRankSelect']);
    $gender = $mysqli->real_escape_string($_POST['inputGender']);

    $dutySection = $mysqli->real_escape_string($_POST['inputDutySectionSelect']);
    $afsc = $mysqli->real_escape_string($_POST['inputAFSC']);
    $admin = '';
    $supervisorRank = $mysqli->real_escape_string($_POST['inputRankSupervisorRankSelect']);
    $supervisorLastName = $mysqli->real_escape_string($_POST['inputSupervisorLastName']);
    $supervisorFirstName = $mysqli->real_escape_string($_POST['inputSupervisorFirstName']);

    $homePhone = $mysqli->real_escape_string($_POST['inputHomePhone']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $cellPhone = $mysqli->real_escape_string($_POST['inputCellPhone']);

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_ENV['cipherMethod']));
    $encryptedCellPhone = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options=0, $iv);
    $encryptedHomePhone = openssl_encrypt($homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options=0, $iv);

    $govEmail = $mysqli->real_escape_string($_POST['inputGovEmail']);
    $prsnlEmail = $mysqli->real_escape_string($_POST['inputPrsnlEmail']);

    $encryptedGovEmail = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['govEmailKey'], $options=0, $iv);
    $encryptedPrsnlEmail = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['prsnlEmailKey'], $options=0, $iv);

    $birthdate = $mysqli->real_escape_string($_POST['inputBirthdate']);

    $encryptedbirthdate = openssl_encrypt($birthdate, $_ENV['cipherMethod'], $_ENV['birthdateKey'
  ], $options=0, $iv);

  if (isset($_POST['emailOptIn']) === 'no')

  {
    $emailOptIn = 0;


  }else{

    $emailOptIn = 1;
  }

  $sqlMember = "INSERT INTO members (id, dodId, lastName, firstName, middleName, rank, dutySection, afsc, address, homePhone, cellPhone, family, birthdate, admin, govEmail, PrsnlEmail, image, imageDetail, unitName, gender, emailOpt_in, deletedBy, iv) VALUES (id, '$dodID', '$lastName', '$firstName', '$middleName', '$rank', '$dutySection', '$afsc', '$address', '$encryptedHomePhone', '$encryptedCellPhone', '', '$encryptedbirthdate', '$admin', '$encryptedGovEmail', '$encryptedPrsnlEmail', '0', '0', '$unitName', '$gender', '$emailOptIn', '','$iv')";

  $sqlArming = "INSERT INTO armingRoster (id, rank, lastName, firstName, middleName, lastFour, dodId, baton, useOfForce, lat, taser, m4Qual, m9Qual, m4Exp, m9Exp, smcFired, smcDue, m203Exp, m249Exp, m240Exp, m870Exp, unitName)
  VALUES (id, '$rank', '$lastName', '$firstName', '$middleName', '$lastFour','$dodID', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$unitName')";
  /*
  *
  * removed SFMQ creation. this is no longer needed because SFMQ data can be added on an individual basis.
  */
  $checkMemberSFMQ = "SELECT * FROM sfmq WHERE (lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName' AND rank = '$rank' AND unitName = '$unitName')";

  $resultscheckMemberSFMQ = $mysqli->query($checkMemberSFMQ);


  if (!$resultscheckMemberSFMQ) {

    $sqlSFMQ = "INSERT INTO sfmq (id, rank, lastName, firstName, middleName, dutyQualPos, primCertDate, practical, written, verbal, reCertDate, phase2Start, newDutyQual, phase2End, qcNLT, nintyDayStart, deros, dodId, unitName, phase2_Cert) VALUES (id,'$rank','$lastName', '$firstName','$middleName','','','','','','','','','','','','','$dodID','$unitName','')";

    $resultSFMQ = $mysqli->query($sqlSFMQ) or die(mysqli_connect_errno());

  } else {

    $memberInSFMQDatabase = "Member is already in SFMQ database. Duplicate entry was not added.";

  }
  //no need to add on import. There is an option to add within the update member section of the site.
  /*$sqlFitness = "INSERT INTO `fitness`(id, rank, lastName, firstName, middleName, pushUps , sitUps , run , waist , dodId , dueDate , unitName , fitness_mockType)
  VALUES (id, '$rank', '$lastName', '$firstName', '$middleName', '', '', '', '', '$dodID', '', '$unitName', '')
  ";*/
  $sqlSupList = "INSERT INTO `supList`(id , dodId , rank , firstName , middleName , lastName , superRank , supFirstName , supLastName , supDateBegin , feedbackCompleted , unitName)
  VALUES (id, '$dodID', '$rank', '$firstName', '$middleName', '$lastName', '$supervisorRank', '$supervisorFirstName', '$supervisorLastName', '', '', '$unitName')";

  /*$sqlLogin = "INSERT INTO `login` (id, lastName, firstName, middleName, dodId)
  VALUES ('id', '$lastName', '$firstName', '$middleName', '$dodID')";*/

  /*
  $familyName = count($_POST['familyName']);
  $familyBirthdate = count($_POST['familyBirthdate']);
  $familyGender = count($_POST['familyGender']);
  $familyRelationship = count($_POST['familyRelationship']);

  if ($familyName > 0) {
  for ($i = 0; $i < $familyName; $i++) {
  if (trim($_POST["familyName"][$i] != '')) {
  $sql = "INSERT INTO `family` (id, dodId, fname, birthdate, gender, relationship, unitName) VALUES('id', '$dodID', '" . $mysqli->real_escape_string($_POST["familyName"][$i]) . "', '" . $mysqli->real_escape_string($_POST["familyBirthdate"][$i]) . "', '" . $mysqli->real_escape_string($_POST["familyGender"][$i]) . "', '" . $mysqli->real_escape_string($_POST["familyRelationship"][$i]) . "', '$unitName')";
  $mysqli->query($sql);
}
}
}*/

$updateAdminRank = "UPDATE `members` SET admin = 'Yes' WHERE (rank = 'TSgt' OR rank = 'MSgt' OR rank = 'SMSgt' OR rank = 'CMSgt' OR rank = '2nd Lt' OR rank = '1st Lt' OR rank = 'Capt' OR rank = 'Maj' OR rank = 'Lt Col' or rank = 'Col' OR rank = 'Civ')";

$updateUserRank = "UPDATE `members` SET admin = 'No' WHERE (rank = 'AB' OR rank = 'Amn' OR rank = 'A1C' OR rank = 'SrA' OR rank = 'SSgt')";
/*$updateAdminMSgt = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'MSgt'";
$updateAdminSMSgt = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'SMSgt'";
$updateAdminCMSgt = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'CMSgt'";
$updateAdmin2ndLt = "UPDATE `members` SET admin = 'Yes' WHERE rank = '1st LT'";
$updateAdmin1stLt = "UPDATE `members` SET admin = 'Yes' WHERE rank = '2nd LT'";
$updateAdminCapt = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'Capt'";
$updateAdminMaj = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'Maj'";
$updateAdminLtCol = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'Lt Col'";
$updateAdminCol = "UPDATE `members` SET admin = 'Yes' WHERE rank = 'Col'";*/

//$updateAdminRank = $mysqli->query($updateAdminRank);
/* $updateAdmin4 = $mysqli->query($updateAdminMSgt);
$updateAdmin5 = $mysqli->query($updateAdminSMSgt);
$updateAdmin6 = $mysqli->query($updateAdminCMSgt);
$updateAdmin7 = $mysqli->query($updateAdmin2ndLt);
$updateAdmin8 = $mysqli->query($updateAdmin1stLt);
$updateAdmin9 = $mysqli->query($updateAdminCapt);
$updateAdmin10 = $mysqli->query($updateAdminMaj);
$updateAdmin11 = $mysqli->query($updateAdminLtCol);
$updateAdmin12 = $mysqli->query($updateAdminCol);*/

$resultMember = $mysqli->query($sqlMember) or die(mysqli_connect_errno());
$resultArming = $mysqli->query($sqlArming);
$resultFitness = $mysqli->query($sqlFitness);
$resultSupList = $mysqli->query($sqlSupList) ;
$updateResultsAdminRank = $mysqli->query($updateAdminRank);
$updateResultsUserRank = $mysqli->query($updateUserRank);
//$resultsLogin = $mysqli->query($sqlLogin);

error_reporting(2);
// $resultLogin = $mysqli->query($sqlLogin);
//    $resultFamilyMember = $mysqli->query($sqlFamilyMember);

//AND $resultLogin

if (($resultMember AND $resultArming /* AND $resultFitness*/ AND $resultSupList) == true) {
  $successmsg = "Member Successfully Added.";
} else {
  $failuremsg = "Member Was Not Added - Please try again.";

}

}else {
  $failuremsg = "Member is already listed in database.";

}

}elseif (isset($_POST['inputFirstName']) && isset($_POST['inputLastName']) && (!empty($unitName))) {
  $unitFailMsg = "Unit must be selected - Please try again.";

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
            <h5 class="modal-title">Member Successfully Registered</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <p style="text-align: center"></p>
                <?php  header("refresh:3;url=register-view-user.php");?>
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
