<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();

parse_str($_SERVER['QUERY_STRING'], $query);
$id = $mysqli->real_escape_string($query['ID']);
$last = $mysqli->real_escape_string($query['last']);
$unitName = $_SESSION['unitName'];

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();


$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

$findMember = new FindMember();
$findMember->find_member($id, $last, $unitName);

$findSupervisor = new FindSupervisor();
$findSupervisor->find_member_supervisor($findMember->dodId, $findMember->lastName, $findMember->firstName);


if (isset($_POST['passwordChange'])) {
  //3.1.1 Assigning posted values to variables.


  $currentPassword = mysqli_real_escape_string($connection, $_POST['CurrentPasswordVerify']);

  //$currentPasswordHashed = password_hash($currentPassword, PASSWORD_DEFAULT);

  $query = "SELECT * FROM `login` WHERE user_name='$recallUserName'";

  $newPassword = mysqli_real_escape_string($connection, $_POST['newPassword']);
  $passwordVerify = mysqli_real_escape_string($connection, $_POST['newPasswordVerify']);

  //$resultCreate = mysqli_query($connection, $queryCreate);

  $queryAllTrue = "SELECT * FROM `login` WHERE user_name='$recallUserName'";

  $resultQueryAllTrue = mysqli_query($connection, $queryAllTrue);

  if (password_verify($currentPassword, $storedHashedPassword)) {

    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $passwordCorrect = mysqli_num_rows($result);

    //3.1.2 If the posted values are equal to the database values, then session will be created for the user.

    if ($passwordCorrect == 1) {

      if ($newPassword === $passwordVerify) {

        //if(mysqli_num_rows($resultUpdatePassword) > 0){


        if (mysqli_num_rows($resultQueryAllTrue) == 1) {

          $passwordHashed = password_hash($passwordVerify, PASSWORD_DEFAULT);

          $updatePassword = "UPDATE `login` SET password = '$passwordHashed' WHERE (`user_name` = '$recallUserName' )";

          $resultUpdatePassword = mysqli_query($connection, $updatePassword);

          $successmsg = "Password was successfully updated/changed.";

        } else {
          $errorMessage = "The information supplied does not match the records in the database.";
        }
      } else {
        $failuremsg = "Passwords did not match. - Please try again.";
      }


    } else {
      //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
      $failuremsg = "Invalid Login Credentials.";
    }
  } else {
    $failuremsg = "Current password DOES NOT match current stored password .";

  }

}

//current DODid need to match the one being sought after
//current lastname need to match the one being sought after


if(($findUser->dodId == $findMember->dodId) == false){

  echo "<script type=\"text/javascript\">
  alert(\"You do not have permission to view this page.\");
  window.location = \"/homepage.php\"
  </script>";
}elseif ($_SESSION['page_one'] == 'UnitRA') {

  echo "<script type=\"text/javascript\">
  alert(\"You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.\");
  window.location = \"/homepage.php\"
  </script>";

  exit();

}elseif ($_SESSION['page_one'] == 'UnitSFMQ') {

  echo "<script type=\"text/javascript\">
  alert(\"You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.\");
  window.location = \"/homepage.php\"
  </script>";

  exit();
}elseif ($_SESSION['page_one'] == 'UnitWORB') {

  echo "<script type=\"text/javascript\">
  alert(\"You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.\");
  window.location = \"/homepage.php\"
  </script>";

  exit();

}elseif ($_SESSION['page_one'] == 'ESSAdmin') {

  echo "<script type=\"text/javascript\">
  alert(\"You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.\");
  window.location = \"/homepage.php\"
  </script>";

  exit();
}else{



  // Recall IV from members information. This must be used throughout the entire site. $recallIV see recall information above if needed.
  //$encryptedCellPhone = openssl_encrypt($findMember->cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options = 0, $findMember->iv);
  $decryptedHomePhone = openssl_decrypt($findMember->homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options = 0, $findMember->iv);


  $decryptedCellPhone = openssl_decrypt($findMember->cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options = 0, $findMember->iv);


  $encryptedBirthdate = openssl_decrypt($findMember->birthdate, $_ENV['cipherMethod'], $_ENV['birthdateKey'], $options = 0, $findMember->iv);

  $decryptedGovEmail = openssl_decrypt($findMember->govEmail, $_ENV['cipherMethod'], $_ENV['govEmailKey'], $options = 0, $findMember->iv);

  $decryptedPrsnlEmail = openssl_decrypt($findMember->prsnlEmail, $_ENV['cipherMethod'], $_ENV['prsnlEmailKey'], $options = 0, $findMember->iv);

}







?>

<div class="member_update">
  <div class="container" width="auto">
    <form action="user-update-settings.php?ID=<?php echo $id; ?>&last=<?php echo $last;?>" class="member-update" method="post">



      <h3 align="center">Update User Settings</h3>

      <div class="form-row">

        <!--set to read only. -->
        <div class="form-group col-md-1" readonly>
          <label for="inputGender">Gender</label>
          <select class="form-control" id="inputGender" name="inputGender" title="inputGender" readonly>
            <option value="" <?php if ($findMember->gender == "") echo "selected"; ?>>None</option>
            <option value="Male" <?php if ($findMember->gender == "Male") echo "selected"; ?>>Male</option>
            <option value="Female" <?php if ($findMember->gender == "Female") echo "selected"; ?>>Female</option>
          </select>
        </div>

        <!--Member's rank information displayed-->
        <div class="form-group col-md-1">
          <label for="inputRankSelect">Rank</label>
          <select class="form-control" id="inputRankSelect" name="inputRankSelect" title="inputRankSelect">
            <option value="AB" <?php if ($findMember->rank == "AB") echo "selected"; ?> >AB</option>
            <option value="Amn" <?php if ($findMember->rank == "Amn") echo "selected"; ?> >AMN</option>
            <option value="A1C" <?php if ($findMember->rank == "A1C") echo "selected"; ?> >A1C</option>
            <option value="SrA" <?php if ($findMember->rank == "SrA") echo "selected"; ?> >SrA</option>
            <option value="SSgt" <?php if ($findMember->rank == "SSgt") echo "selected"; ?> >SSgt</option>
            <option value="TSgt" <?php if ($findMember->rank == "TSgt") echo "selected"; ?> >TSgt</option>
            <option value="MSgt" <?php if ($findMember->rank == "MSgt") echo "selected"; ?> >MSgt</option>
            <option value="SMSgt" <?php if ($findMember->rank == "SMSgt") echo "selected"; ?> >SMSgt</option>
            <option value="CMSgt" <?php if ($findMember->rank == "CMSgt") echo "selected"; ?> >CMSgt</option>
            <option value="2nd Lt" <?php if ($findMember->rank == "2nd Lt") echo "selected"; ?> >2nd Lt</option>
            <option value="1st Lt" <?php if ($findMember->rank == "1st Lt") echo "selected"; ?> >1st Lt</option>
            <option value="Capt" <?php if ($findMember->rank == "Capt") echo "selected"; ?> >Capt</option>
            <option value="Maj" <?php if ($findMember->rank == "Maj") echo "selected"; ?> >Maj</option>
            <option value="Lt Col" <?php if ($findMember->rank == "Lt Col") echo "selected"; ?> >Lt Col</option>
            <option value="Col" <?php if ($findMember->rank == "Col") echo "selected"; ?> >Col</option>
            <option value="Civ" <?php if ($findMember->rank == "Civ") echo "selected"; ?> >Civ</option>
          </select>
        </div>

        <!--Member's First Name information displayed-->
        <div class="form-group col-md-3">
          <label for="inputFirstName">First Name</label>
          <input type="text" class="form-control" id="inputFirstName" name="inputFirstName"
          value="<?php echo "$findMember->firstName"; ?>" placeholder="First Name">
        </div>

        <!--Member's Middle Name information displayed-->
        <div class="form-group col-md-3">
          <label for="inputMiddleName">Middle Name</label>
          <input type="text" class="form-control" name="inputMiddleName" id="inputMiddleName"
          value="<?php echo "$findMember->middleName"; ?>" placeholder="Middle Name">
        </div>
        <!--Member's Last Name information displayed-->
        <div class="form-group col-md-3">
          <label for="inputLastName">Last Name</label>
          <input type="text" class="form-control" id="inputLastName" name="inputLastName"
          value="<?php echo "$findMember->lastName"; ?>" placeholder="Last Name">
        </div>
      </div>

      <!--Member's birthdate information displayed-->
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="inputBirthdate">Birth Date</label>
          <input type="datetime" class="form-control" id="inputBirthdate" name="inputBirthdate"
          value="<?php echo "$encryptedBirthdate"; ?>" placeholder="Birthdate YYYY-MM-DD" readonly>
        </div>

        <!--Member's DoD ID number information displayed-->
        <div class="form-group col-md-3">
          <label for="readonlyDODID">DoD ID Number</label>
          <br>
          <input type="text" class="form-control" id="readonlyDODID" name="readonlyDODID"
          value="<?php echo "$findMember->dodID"; ?>" readonly>

        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="inputhomePhone">Home Phone</label>
          <input type="text" class="form-control" id="inputHomePhone" name="inputHomePhone"
          value="<?php echo "$decryptedHomePhone"; ?>" placeholder="Home Phone">
        </div>

        <div class="form-group col-md-3">
          <label for="inputCellPhone">Cell Phone</label>
          <input type="text" class="form-control" id="inputCellPhone" name="inputCellPhone"
          value="<?php echo "$decryptedCellPhone"; ?>" placeholder="Cell Phone">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="inputGovEmail">Gov Email</label>
          <input type="text" class="form-control" id="inputGovEmail" name="inputGovEmail"
          value="<?php echo "$decryptedGovEmail"; ?>" placeholder="Gov Email">
        </div>

        <div class="form-group col-md-3">
          <label for="inputPrsnlEmail">Personal Email</label>
          <input type="text" class="form-control" id="inputPrsnlEmail" name="inputPrsnlEmail"
          value="<?php echo "$decryptedPrsnlEmail"; ?>" placeholder="Personal Email">
        </div>

      </div>

      <!--- EMAIL opt-in/out  -->

      <div class="form-row">
        <div class="form-group col-lrg-10">
          <label for="emailOptInOut"><B>Email Opt-In:</B></label> <br>


          <?php

          if ($findMember->emailOptIn == '1'){
            echo "You <U><B>WILL</B></U> receive emails from your Unit.

            Do you wish to continue to receive ".$findMember->unitName." emails?
            <br>
            <br>
            <div class=\"form-group col-md-3\">

            <select class='form-control' id='emailOptIn' name='emailOptIn' title='emailOptIn'>
            <option value='0'"; if($findMember->emailOptIn=='') echo "selected"; echo ">Select Option</option>
            <option value='1'";  if($findMember->emailOptIn=='1') echo "selected"; echo ">Yes</option>
            <option value='0'"; if($findMember->emailOptIn=='0') echo "selected"; echo ">No</option>

            </select>
            </div>";


          }elseif($findMember->emailOptIn == '0'){
            echo "You <U><B>WILL NOT</B></U> receive emails from your Unit.

            Do you wish to begin to receive ".$findMember->unitName." emails?
            <br>
            <br>
            <div class=\"form-group col-md-3\">

            <select class='form-control' id='emailOptIn' name='emailOptIn' title='emailOptIn'>
            <option value='0'"; if($findMember->emailOptIn=='') echo "selected"; echo ">Select Option</option>
            <option value='1'";  if($findMember->emailOptIn=='1') echo "selected"; echo ">Yes</option>
            <option value='0'"; if($findMember->emailOptIn=='0') echo "selected"; echo ">No</option>

            </select>
            </div>";
          }else{


            echo "You <U><B>WILL NOT</B></U> receive emails from your Unit.

            Do you wish to begin to receive ".$findMember->unitName." emails?
            <br>
            <br>
            <div class=\"form-group col-md-3\">

            <select class='form-control' id='emailOptIn' name='emailOptIn' title='emailOptIn'>
            <option value='0'"; if($findMember->emailOptIn=='') echo "selected"; echo ">Select Option</option>
            <option value='1'";  if($findMember->emailOptIn=='1') echo "selected"; echo ">Yes</option>
            <option value='0'"; if($findMember->emailOptIn=='0') echo "selected"; echo ">No</option>

            </select>
            </div>";

          }


          ?>
        </div>
      </div>

      <!--Supervisor Information-->


      <br>
      <h3 align="center">Supervisor Information</h3>
      <div class="form-row">

        <div class="form-group col-md-2">
          <label for="inputSuperRankOption">Supervisor Rank</label>
          <input type="text" class="form-control" id="inputSuperRankOption" name="inputSuperRankOption"
          value="<?php echo "$findSupervisor->supRank"; ?>" placeholder="Supervisor Rank" readonly>
        </div>

        <div class="form-group col-md-3">
          <label for="inputSupervisorsFirst">First Name</label>
          <input type="text" class="form-control" id="inputSupervisorsFirst" name="inputSupervisorsFirst"
          value="<?php echo "$findSupervisor->supFirstName"; ?>" placeholder="" readonly>
        </div>

        <div class="form-group col-md-3">
          <label for="inputSupervisorsLast">Last Name</label>
          <input type="text" class="form-control" id="inputSupervisorsLast" name="inputSupervisorsLast"
          value="<?php echo "$findSupervisor->supLastName"; ?>" placeholder="Supervisor's Last Name" readonly>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="inputSupervisonBegan">Supervison Began</label>
          <input type="text" class="form-control" id="inputSupervisonBegan" name="inputSupervisonBegan"
          value="<?php echo "$findSupervisor->dateBegan"; ?>" placeholder="Supervision Began" readonly>
        </div>



        <div class="form-group col-md-6">
          <label for="inputFeedbackDate">Feedback Date</label>
          <input type="text" class="form-control" id="inputFeedbackDate" name="inputFeedbackDate"
          value="<?php if (empty($findSupervisor->feedback)) {

            echo null;


          } else {
            echo "$findSupervisor->feedback";

          }


          ?>" placeholder="No FeedBack Date" readonly>
        </div>
      </div>

      <!-- end supervisor information -->
      <br>

      <div class="row">
        <div class="form-group">
          <div align="right">
            <a href="#####">

              <input class="btn btn-outline-secondary" type="button" name="cancel" id="cancel" value="Cancel">
            </a>

          </div>
        </div>
        <div class="form-group col-lg-4">


          <div align="left">


            <input class="btn btn-md btn-primary" type="submit" name="update" id="update" value="Update Member">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

</body>
<footer>
  <!-- indluces closing html tags for body and html-->
