<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

date_default_timezone_set('America/Los_Angeles');

$unitName = $_SESSION['unitName_setup'];
$sectionSetup = $_SESSION['section_setup'];
$post_setup = $_SESSION['post_patrolSetup'];
$post_setup = implode(",", $post_setup);

if (isset($_POST['inputFirstName']) && isset($_POST['inputLastName']) && isset($_POST['inputDODID'])) {

  $firstName = $mysqli->real_escape_string($_POST['inputFirstName']);
  $middleName = $mysqli->real_escape_string($_POST['inputMiddleName']);
  $lastName = $mysqli->real_escape_string($_POST['inputLastName']);
  $dodID = $mysqli->real_escape_string($_POST['inputDODID']);
  strlen($dodID);

  $verifyNoPriorEntry = "select * From members where lastName = '$lastName' And firstName ='$firstName' AND dodID = '$dodID' AND unitName ='$unitName'";

  $resultsVerifyNoPrior = $mysqli->query($verifyNoPriorEntry);

  if (mysqli_num_rows($resultsVerifyNoPrior)< 1){

    $lastFour = $mysqli->real_escape_string($_POST['inputLastFour']);
    $deros = $mysqli->real_escape_string($_POST['inputDEROS']);

    $rank = $mysqli->real_escape_string($_POST['inputRankSelect']);
    $gender = $mysqli->real_escape_string($_POST['inputGender']);

    $dutySection = $mysqli->real_escape_string($_POST['inputDutySectionSelect']);
    $afsc = $mysqli->real_escape_string($_POST['inputAFSC']);
    $admin = 'Yes';
    $specialAccess = "Zeus";
    $supervisorRank = $mysqli->real_escape_string($_POST['inputRankSupervisorRankSelect']);
    $supervisorLastName = $mysqli->real_escape_string($_POST['inputSupervisorLastName']);
    $supervisorFirstName = $mysqli->real_escape_string($_POST['inputSupervisorFirstName']);

    $homePhone = $mysqli->real_escape_string($_POST['inputHomePhone']);
    $address = "";
    $cellPhone = $mysqli->real_escape_string($_POST['inputCellPhone']);

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_ENV['cipherMethod']));
    $encryptedCellPhone = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options=0, $iv);
    $encryptedHomePhone = openssl_encrypt($homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options=0, $iv);

    $govEmail = $mysqli->real_escape_string($_POST['inputGovEmail']);
    $prsnlEmail = $mysqli->real_escape_string($_POST['inputPrsnlEmail']);

    $encryptedGovEmail = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['govEmailKey'], $options=0, $iv);
    $encryptedPrsnlEmail = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['prsnlEmailKey'], $options=0, $iv);

    $birthdate = $mysqli->real_escape_string($_POST['inputBirthdate']);

    $encryptedbirthdate = openssl_encrypt($birthdate, $_ENV['cipherMethod'], $_ENV['birthdateKey'], $options=0, $iv);

    if (isset($_POST['emailOptIn']) === 'no'){
      $emailOptIn = 0;
    }else{
      $emailOptIn = 1;
    }

    echo "INSERT INTO members (id, dodId, lastName, firstName,middleName,rank,dutySection,afsc,address,homePhone,cellPhone,family,birthdate,admin,govEmail,PrsnlEmail,image,imageDetail,unitName,gender,emailOpt_in,specialAccess, deletedBy,iv)
    VALUES(id,'$dodID','$lastName','$firstName','$middleName','$rank','$dutySection','$afsc','$address','$encryptedHomePhone','$encryptedCellPhone','','$encryptedbirthdate','$admin','$encryptedGovEmail','$encryptedPrsnlEmail','0','0','$unitName','$gender','$specialAccess', '$emailOptIn','','$iv')";

    $sqlMember = $mysqli->query("INSERT INTO members (id, dodId, lastName, firstName, middleName, rank, dutySection, afsc, address, homePhone, cellPhone, family, birthdate, admin, govEmail, PrsnlEmail, image, imageDetail, unitName, gender, emailOpt_in, specialAccess, deletedBy, iv) VALUES (id, '$dodID', '$lastName', '$firstName', '$middleName', '$rank', '$dutySection', '$afsc', '$address', '$encryptedHomePhone', '$encryptedCellPhone', '', '$encryptedbirthdate', '$admin', '$encryptedGovEmail', '$encryptedPrsnlEmail', '0', '0', '$unitName', '$gender', '$emailOptIn','$specialAccess', '', '$iv')");

    $sqlArming = $mysqli->query("INSERT INTO armingRoster (id, rank, lastName, firstName, middleName, lastFour, dodId, baton, useOfForce, lat, taser, m4Qual, m9Qual, m4Exp, m9Exp, smcFired, smcDue, m203Exp, m249Exp, m240Exp, m870Exp, unitName) VALUES (id, '$rank', '$lastName', '$firstName', '$middleName', '$lastFour','$dodID', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$unitName')");

    $checkMemberSFMQ = "SELECT * FROM sfmq WHERE (lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName' AND rank = '$rank' AND unitName = '$unitName')";

    $resultscheckMemberSFMQ = $mysqli->query($checkMemberSFMQ);

    if (!$resultscheckMemberSFMQ) {

      $sqlSFMQ = "INSERT INTO sfmq (id, rank, lastName, firstName, middleName, dutyQualPos, primCertDate, practical, written, verbal, reCertDate, phase2Start, newDutyQual, phase2End, qcNLT, nintyDayStart, deros, dodId, unitName, phase2_Cert) VALUES (id,'$rank','$lastName', '$firstName','$middleName','','','','','','','','','','','','','$dodID','$unitName','')";

      $resultSFMQ = $mysqli->query($sqlSFMQ) or die(mysqli_connect_errno());

    }else {
      $memberInSFMQDatabase = "Member is already in SFMQ database. Duplicate entry was not added.";
    }

    $sqlSupList = "INSERT INTO `supList`(id , dodId , rank , firstName , middleName , lastName , superRank , supFirstName , supLastName , supDateBegin , feedbackCompleted , unitName)
    VALUES (id, '$dodID', '$rank', '$firstName', '$middleName', '$lastName', '$supervisorRank', '$supervisorFirstName', '$supervisorLastName', '', '', '$unitName')";

    $updateAdminRank = "UPDATE `members` SET admin = 'Yes' WHERE (rank = 'TSgt' OR rank = 'MSgt' OR rank = 'SMSgt' OR rank = 'CMSgt' OR rank = '2nd Lt' OR rank = '1st Lt' OR rank = 'Capt' OR rank = 'Maj' OR rank = 'Lt Col' or rank = 'Col' OR rank = 'Civ')";

    //$updateUserRank = "UPDATE `members` SET admin = 'No' WHERE (rank = 'AB' OR rank = 'Amn' OR rank = 'A1C' OR rank = 'SrA' OR rank = 'SSgt')";

    //$resultMember = $mysqli->query($sqlMember);
    //$resultArming = $mysqli->query($sqlArming);
    //$resultFitness = $mysqli->query($sqlFitness);
    $resultSupList = $mysqli->query($sqlSupList) ;
    $updateResultsAdminRank = $mysqli->query($updateAdminRank);
    //$updateResultsUserRank = $mysqli->query($updateUserRank);


    $sectionSetup = implode(',', $_SESSION['section_setup']);

    $insertPermissions = $mysqli->query("INSERT INTO `specialAccess`(`id`, `unitName`, `accessValues`) VALUES (id, '$unitName', 'ESS,GTC,GPC,Fitness,Supply,VCO,Zeus')");

    $insertUnitScetions = $mysqli->query("INSERT INTO `UnitSections`(`id`, `unitName`, `sectionName`) VALUES (id,'$unitName','$sectionSetup')");


    $insertUnitPost = $mysqli->query("INSERT INTO `post`(`id`, `unitName`, `post/patrol`, `date_time`) VALUES (id,'$unitName','$post_setup',now())");

    error_reporting(2);

    if (($sqlMember AND $sqlArming /* AND $resultFitness*/ AND $resultSupList AND $insertPermissions AND $insertUnitScetions AND $insertUnitPost) == true) {
      $successmsg = "Member and Unit Successfully Added.";


      /*
      need to add inserts for the creation of a unit.
      $unitName = $_SESSION['unitName_setup'];
      $sectionSetup = $_SESSION['section_setup'];
      echo "<br>";
      echo "\$_SESSION['section_setup']"; var_dump($_SESSION['section_setup']);
      echo "<br>";
      echo "\$_SESSION['post_patrolSetup']"; var_dump($_SESSION['post_patrolSetup']);
      echo "\$_SESSION['vehicle_setup']"; var_dump($_SESSION['vehicle_setup']);
      */

    } else {
      $failuremsg = "Member Was Not Added - Please try again.";
    }

  }else {
    $failuremsg = "Member is already listed in database.";

  }

}elseif (isset($_POST['inputFirstName']) && isset($_POST['inputLastName'])) {
  $unitFailMsg = "Unit must be selected - Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php $siteTitle ?></title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

  <style>
  /* Style all input fields */
  input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
  }

  /* Style the submit button */
  input[type=submit] {
    background-color: #4CAF50;
    color: white;
  }

  /* Style the container for inputs */
  .container {
    background-color: #f1f1f1;
    padding: 20px;
  }

  /* The message box is shown when the user clicks on the password field */
  #message {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
  }

  #message p {
    padding: 10px 35px;
    font-size: 18px;
  }

  /* Add a green text color and a checkmark when the requirements are right */
  .valid {
    color: green;
  }

  .valid:before {
    position: relative;
    left: -35px;
    content: "✔";
  }

  /* Add a red text color and an "x" when the requirements are wrong */
  .invalid {
    color: red;
  }

  .invalid:before {
    position: relative;
    left: -35px;
    content: "✖";
  }
  </style>

</head>
<body class="hold-transition login-page">

  <div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php //echo $subject; ?>Successfully Added</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
              <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                <p style="text-align: center"></p>

                <?php if(isset($noupdate)){ ?><div class="alert alert-secondary" role="alert" style="text-align: center"> <?php echo $noupdate; ?> </div><?php } ?>
                  <p style="text-align: center"></p>
                  <?php //header("refresh:3;url=$returnTo");?>
                </div>
              </div>
            </div>
          </div>
        </div>




        <div class="login-box w-50 P-3">
          <!-- /.login-logo -->
          <div class="card card-outline card-primary">
            <div class="card-header text-center">
              <a href="#" class="h1"><b>SFS</b>Admin</a>
            </div>
            <div class="card-body">
              <p class="login-box-msg">Create Account for first user. This account will have "Zeus" rights. (Zeus access is limited to one person be unit. Contact System Administration if you requrie additaionl Zeus access accounts.</p>

              <form action="set-up-insert.php" method="post">

                <!-- DOD ID-->


                <h2 class="form-signin-heading">Please register for an account</h2>




                <!--  <input type="text" name="dodId" id="dodId" class="form-control" value=""placeholder="DOD ID Number" required>-->

                <input type="text" name="firstName" id="firstName" class="form-control" value=""placeholder="First Name" required>
                <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Middle Name" required>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" required>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Your @us.af.mil/@mail.mil address" required>
                <input type="text" name="TAFMSD" id="inputTAFMSD" class="form-control" placeholder="TAFMSD DD-MMM-YY " required>


                <div>
                  <input type="text" name="username" class="form-control" placeholder="Username" required>


                  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" maxlength="30"required>
                  <input type="password" name="verifyPassword" id="inputPassword" class="form-control" placeholder="Verify Password" maxlength="30"  required>



                  <div id="message">
                    <h3>Password must contain the following:</h3>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                  </div>

                </div>
                <br>
                <div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="secretQuestion">Secret Question</label>
                      <select class="form-control" id="secretQuestion" name="secretQuestion" required autofocus>
                        <option value="">Select</option>
                        <option value="1">What is your favorite color?</option>
                        <option value="2">Make of your first car?</option>
                        <option value="3">Favorite sport?</option>
                        <option value="4">Best location your have visited?</option>
                        <option value="5">Are sharks fish?</option>
                      </select>
                    </div>
                  </div>
                  <input type="text" name="secretAnswer" id="secretAnswer" class="form-control" placeholder="Secret Answer" required>
                </div>

                <!--  <label for="inputBirthdate" class="sr-only">Birthdate</label>
                <input type="date" name="birthdate" id="inputbirthdate" class="form-control" placeholder="Birthdate" required>


                <div class="tandc">
                <input type="checkbox" name="tandc" id="tandc" class="form-control" required><label for="useragreement" class="tandc"><a link href="tandcs.html">You agree to the terms and conditions</a></label>
              </div>-->

              <div>


              </div>
              <br>

              <button class="btn btn-lg btn-success btn-block" type="submit">Create User Account</button>


            </form>

            <!-- /.col -->

            <div class="col-4">
              <button type="submit" name="next" id="next" class="btn btn-primary btn-block">Next</button>
            </div>
            <!-- /.col -->


          </form>

          <!-- /.col -->
        </div>



      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../../AdminLTE-master/dist/js/adminlte.min.js"></script>


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


</body>
</html>
