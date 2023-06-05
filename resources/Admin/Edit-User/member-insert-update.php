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
  $gender = mysqli_real_escape_string($mysqli, $_POST['inputGender']);
  $rankUpdate = mysqli_real_escape_string($mysqli, $_POST['inputRankSelect']);
  $firstName = mysqli_real_escape_string($mysqli, $_POST['inputFirstName']);
  $middleName = mysqli_real_escape_string($mysqli, $_POST['inputMiddleName']);
  $lastName = mysqli_real_escape_string($mysqli, $_POST['inputLastName']);
  $birthdate = mysqli_real_escape_string($mysqli, $_POST['inputBirthdate']);
  $dodId = mysqli_real_escape_string($mysqli, $_POST['readonlyDODID']);
  $address = mysqli_real_escape_string($mysqli, $_POST['address']);
  //$homePhone = mysqli_real_escape_string($mysqli, $_POST['inputHomePhone']);
  $dutySection = mysqli_real_escape_string($mysqli, $_POST['inputDutySectionSelect']);
  $homePhone = mysqli_real_escape_string($mysqli, trim($_POST['inputHomePhone']));
  $cellPhone = mysqli_real_escape_string($mysqli, trim($_POST['inputCellPhone']));
  $inputSMC = mysqli_real_escape_string($mysqli, $_POST['inputSMC']);
  $updateAdminRights = mysqli_real_escape_string($mysqli, $_POST['inputAdminSelect']);




  $encryptedCellPhone = openssl_encrypt($cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options = 0, $findMember->iv);
  $encryptedHomePhone = openssl_encrypt($homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options = 0, $findMember->iv);

  $govEmail = mysqli_real_escape_string($mysqli, filter_var($_POST['inputGovEmail'], FILTER_SANITIZE_EMAIL));

  $prsnlEmail = mysqli_real_escape_string($mysqli, filter_var($_POST['inputPrsnlEmail'], FILTER_SANITIZE_EMAIL));
  $encryptedGovEmail = openssl_encrypt($govEmail, $_ENV['cipherMethod'], $_ENV['govEmailKey'], $options = 0, $findMember->iv);

  $encryptedPrsnlEmail = openssl_encrypt($prsnlEmail, $_ENV['cipherMethod'], $_ENV['prsnlEmailKey'], $options = 0, $findMember->iv);



  //$govmail = $mysqli->query("UPDATE members set govEmail = '$encryptedGovEmail' where dodId = '$findMember->dodId'");

  //echo "UPDATE members set govEmail = '$encryptedGovEmail' where dodID = '$findMember->dodId'";

  //$prsnlmail = $mysqli->query("UPDATE members set prsnlEmail = '$encryptedPrsnlEmail' where dodId = '$findMember->dodId'");
  //echo "UPDATE members set prsnlEmail = '$encryptedPrsnlEmail' where dodID = '$findMember->dodId'";


  //print_r($decryptCell);

  //curent access within database
  $currentAccessArray = explode(', ', $findMember->specialAccess); //is array

  var_dump($currentAccessArray);
  //could be null or could be n

  //add to current access with $accessAdd
  $accessAdd = $_POST['accessAdd']; //is array when present --
  //merge current access with access being added -- accessUpdateAddArray
  //$new_total_access_premissions =  array_merge($accessAdd, $currentAccessArray);

  //removed items will be selected from form. so items selected are the items requiring access still -- unslected would be to remove access, remaining indicated access still needed.
  $accessRemove = $_POST['accessRemove']; //is array when items present

  if ($currentAccessArray[0] == NULL) {

    $accessAdd = implode(", ", $accessAdd);
    $updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$accessAdd' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

  }elseif (($accessAdd != NULL) AND ($accessRemove == NULL)) {
    // code...
    $accessAdd = implode(", ", $accessAdd);
    $updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$accessAdd' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

  } elseif ($accessAdd != NULL) {

    //look to see if current access is being removed.
    $current_access_with_item_removed = array_intersect($accessRemove, $currentAccessArray); //find items in current permissions and those removed. only show those remaining.

    //echo "<br>current_access_with_item_removed".json_encode($current_access_with_item_removed, JSON_PRETTY_PRINT)."<br>";

    $new_total_access_premissions_added =  array_merge($accessAdd, $current_access_with_item_removed);

    //echo "<br>new_total_access_premissions_added".json_encode($new_total_access_premissions_added, JSON_PRETTY_PRINT)."<br>";
    $new_total_access_premissions_added = implode(", ", $new_total_access_premissions_added);
var_dump($new_total_access_premissions_added);
    $updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$new_total_access_premissions_added' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

  } elseif (($accessAdd == NULL) AND ($accessRemove != NULL)) {

    if (($key = array_search('Zeus', $currentAccessArray)) !== false) {

      array_push($accessRemove, "Zeus");
    }

    $accessRemove = implode(", ", $accessRemove);


    $updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$accessRemove' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

  }
  else {
        $updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = NULL WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

  }













  //new_total_access_premissions == add to and current premissions
  //$new_total_access_premissions =  array_merge($accessAdd, $currentAccessArray);

  //  echo "new_total_access_premissions".json_encode($new_total_access_premissions, JSON_PRETTY_PRINT)."<br>";


  //  $current_access_itmes = array_intersect($accessRemove, $new_total_access_premissions); //find items in current permissions and those removed. only show those remaining.

  //echo "current_access_itmes".json_encode($current_access_itmes, JSON_PRETTY_PRINT)."<br>";
  //$mergedArray = array_merge($removed_itmes, $addToAccess);

  //$new_total_access_premissions = implode(", ", $new_total_access_premissions);







  //echo "UPDATE members SET specialAccess = '$new_total_access_premissions' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')";



  //$updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$new_total_access_premissions' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

  //$currentAccessArray = explode(', ', array($findMember->specialAccess));
  /*
  if((isset($_POST['accessAdd'])) AND ($_POST['accessAdd'] !=',')){
  $accessUpdateAddArray = join(', ', $accessAdd);
  $combineArray = $accessUpdateAddArray .', '. join(', ', array($findMember->specialAccess));
  $updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$combineArray' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

}else{
$newAccessArray = array_diff($accessRemove, array($findMember->specialAccess));
$newAccessArray = join(', ', $newAccessArray);
$updateAddAdmin = $mysqli->query("UPDATE members SET specialAccess = '$newAccessArray' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");
if (($updateAddAdmin) == true) {
$successmsg = "Access Successfully Updated.";
} else {
$failuremsg = "Access Was Not Updated - Please try again.";
}
}
*/











//$resultUpdateVehicleInformation = $mysqli->query($updateVehicleInformation);

//if (($resultUpdateVehicleInformation) == true) {
//$successmsg = "Vehicle Information Successfully Updated.";
//} else {
//$failuremsg = "Vehicle Information Was Not Updated - Please try again.";
//}
//}//

/*  $encryptedHomePhone = openssl_encrypt($findMember->homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options = 0, $findMember->iv);*/

$encryptedBirthdate = openssl_encrypt($birthdate, $_ENV['cipherMethod'], $_ENV['birthdateKey'], $options = 0, $findMember->iv);




//Members duty qualification information
$newDutyQual = mysqli_real_escape_string($mysqli, $_POST['inputDutyPositionSelect']);
$priCertDate = mysqli_real_escape_string($mysqli, $_POST['inputPrimCertDate']);
$phaseIIStartDate = mysqli_real_escape_string($mysqli, $_POST['inputPhaseIIStart']);
// $newDutyQualPhaseII = mysqli_real_escape_string($mysqli, $_POST['inputPhaseIISelect']);
$phaseIIEndDate = mysqli_real_escape_string($mysqli, $_POST['inputPhaseIIEnd']);
$reCertDate = mysqli_real_escape_string($mysqli, $_POST['inputReCertDate']);
$reCertDate = date('Y-m-d', strtotime($_POST['inputPrimCertDate'] . '+365 days'));
$verbalScore = mysqli_real_escape_string($mysqli, $_POST['inputDPEVerbalScore']);
$writtenScore = mysqli_real_escape_string($mysqli, $_POST['inputDPEWrittenScore']);
$practicalScore = mysqli_real_escape_string($mysqli, $_POST['inputDPEPracticalScore']);
$insertDPEType = mysqli_real_escape_string($mysqli, $_POST['inputDPEType']);
//$certifiedInsertMemberType = mysqli_real_escape_string($mysqli, $_POST['startCertDate']);
$inputRanger = mysqli_real_escape_string($mysqli, $_POST['inputRanger']);
$inputRaven = mysqli_real_escape_string($mysqli, $_POST['inputRaven']);
$inputDagr = mysqli_real_escape_string($mysqli, $_POST['inputDagr']);
$input5ton = mysqli_real_escape_string($mysqli, $_POST['input5ton']);
$inputLeaderLed = mysqli_real_escape_string($mysqli, $_POST['inputLeaderLed']);

//Members supervisor information
$supRank = mysqli_real_escape_string($mysqli, $_POST['inputSuperRankOption']);
$supFirstName = mysqli_real_escape_string($mysqli, $_POST['inputSupervisorsFirst']);
$supLastName = mysqli_real_escape_string($mysqli, $_POST['inputSupervisorsLast']);
$dateBegan = mysqli_real_escape_string($mysqli, $_POST['inputSupervisonBegan']);
$feedback = mysqli_real_escape_string($mysqli, $_POST['inputFeedbackDate']);


/*$inputPOI = mysqli_real_escape_string($mysqli, $_POST['poi']);
$inputLeaderLed = mysqli_real_escape_string($mysqli, $_POST['inputLeaderLed']);
$inputLeaderLed = mysqli_real_escape_string($mysqli, $_POST['inputLeaderLed']);
$inputLeaderLed = mysqli_real_escape_string($mysqli, $_POST['inputLeaderLed']);
$inputLeaderLed = mysqli_real_escape_string($mysqli, $_POST['inputLeaderLed']);*/

//if(isset($_POST['inputDPEType']) == 'phaseII'){

//has all items needed to update member information. all variable good
$updateMembersArmingInformation = $mysqli->query("UPDATE armingRoster SET smcFired = '$inputSMC' WHERE (lastName = '$findMember->lastName' AND firstName = '$findMember->firstName' AND middleName = '$findMember->middleName' AND unitName = '$unitName')");
echo "<br>";

//has all items needed to update member information. all variable good
$updateMembersInformation = $mysqli->query("UPDATE members SET lastName = '$lastName', firstName = '$firstName', middleName =  '$middleName', rank = '$rankUpdate', dutySection = '$dutySection', address ='$address', homePhone = '$encryptedHomePhone', cellPhone = '$encryptedCellPhone', birthdate = '$encryptedBirthdate', govEmail = '$encryptedGovEmail', PrsnlEmail = '$encryptedPrsnlEmail', gender='$gender' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");


//has all items needed to update member information. all variable good
$querySFMQPhaseII = $mysqli->query("SELECT * FROM sfmq where ((lastName = '$findMember->lastName' AND dodId = '$findMember->dodId') AND phase2_Cert = 'phaseII')");

$updateAdmin = $mysqli->query("UPDATE login SET admin = '$updateAdminRights' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");


//if statment to check for phase II infomration being inserted. if any of the phase II are not empty insert the input information.
if (((!empty($_POST['inputDutyPositionSelect'])) && (!empty($_POST['inputPhaseIIStart'])) && (!empty($_POST['inputPhaseIIEnd'])) && (isset($_POST['inputDPEType']) == 'phaseII')) === true) {

  if (($querySFMQPhaseII->num_rows) == 0) {

    //has all items needed to update member information. all variable good
    $insertPhaseIIInformation = $mysqli->query("INSERT INTO `sfmq` (id, dodId, rank, lastName, firstName, middleName, dutyQualPos, primCertDate, practical, written, verbal, reCertDate, phase2Start, newDutyQual, phase2End, qcNLT, nintyDayStart, deros, unitName, phase2_Cert) VALUES (id, '$findMember->dodId', '$rank', '$findMember->lastName', '$findMember->firstName', '$middleName', '', '', '0', '0', '0', '', '$phaseIIStartDate', '$newDutyQual', '$phaseIIEndDate', '', '', '', '$unitName', 'phaseII')");

    if (!$resultInsertPhaseIIInformation->affected_row) {
      $failuremsg = 'Members DPE (Phase II) information was not added.';
    } else {
      $successmsg = 'Members DPE info added (phase II insert)';
    }
  }//no else for this

}
//if statment to check for phase II infomration being inserted. if member has information for phase II the infomration is just updated.
if ((!empty($_POST['inputDutyPositionSelect'])) && (!empty($_POST['inputPhaseIIStart'])) && (!empty($_POST['inputPhaseIIEnd'])) && (isset($_POST['inputDPEType']) == 'phaseII') == true) {

  if ($querySFMQPhaseII->num_rows) {
    //has all items needed to update member information. all variable good
    $updatePhaseIIInformation = $mysqli->query("UPDATE sfmq SET phase2Start = '$phaseIIStartDate', newDutyQual = '$newDutyQual', phase2End = '$phaseIIEndDate' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId' AND newDutyQual = '$recallNewDutyPosition' AND phase2_Cert = 'phaseII')");

    if (!$updatePhaseIIInformation->affected_row) {
      $failuremsg = 'Members DPE information was not updated';
    } else {

      $successmsg = "Member's DPE information was updated ";
    }
  }//no else for this
}

if ((isset($_POST['inputDPEType']) == 'certified') && (!empty($_POST['inputPrimCertDate'])) && (!empty($_POST['inputDPEVerbalScore'])) && (!empty($_POST['inputDPEWrittenScore'])) && (!empty($_POST['inputDPEPracticalScore'])) == true) {

  if ($querySFMQPhaseII->num_rows) {

    //has all items needed to update member information. all variable good
    $updateDPE = $mysqli->query("UPDATE sfmq
      SET primCertDate = '$priCertDate' , practical = '$practicalScore', written = '$writtenScore', verbal = '$verbalScore', reCertDate = '$reCertDate', dutyQualPos = '$newDutyQual', nintyDayStart = '', phase2_cert = 'certified', newDutyQual = '', phase2Start = '', phase2End = ''
      WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId' AND newDutyQual = '$recallNewDutyPosition')");

      if (!$updateDPE->affected_row) {
        $failuremsg = 'Members DPE information was not updated';
      }//no else


    } else {
      $successmsg = "Member's DPE info added (update for certification)";
    }
  } //no else for this

  if ($querySFMQPhaseII->num_rows) {

    if (((isset($_POST['inputDutySectionSelect']) == 'NONE') == true) && ((isset($_POST['inputDPEType']) == 'removed') == true) && (empty($_POST['inputPhaseIIStart']))) {

      //has all items needed to update member information. all variable good
      $removeDPE = $mysqli->query("DELETE FROM sfmq
        WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId' AND newDutyQual = '$recallNewDutyPosition' AND phase2Start = '$recallPhaseIIStart' AND phase2End = '$recallPhaseIIEnd' AND dodId = '$recalldodId')");

        if (!$removeDPE->affected_row) {
          $failuremsg = 'Members DPE information was not updated';
        } else {
          $successmsg = 'Members DPE info was removed';
        }
      }
    }

    //misc certification
    if ($resultsRecallMiscCerts->num_rows) {

      $insertMiscCerts = $mysqli->query("INSERT INTO miscCerts (id, dodId, 5ton, ranger, raven, dagr, leaderLed)
      values (id, '$findMember->dodId', '$input5ton', '$inputRanger', '$inputRaven', '$input5ton', '$inputLeaderLed')");

      if(!$insertMiscCerts->affected_row){
        echo "Misc Certs were not inserted into the database. an error occured";
      }else {
        echo "Misc Certs inserted into the database!!!!";
      }
    } elseif ($insertMiscCerts->num_rows) {

      $updateMiscCerts = $mysqli->query("UPDATE miscCerts
        SET ranger = '$inputRanger', raven = '$inputRaven', dagr = '$inputDagr', 5ton = '$input5ton', leaderLed = '$inputLeaderLed' where dodId = '$findMember->dodId'");

        if (!$updateMiscCerts->affected_row) {
          echo "Misc Certs were not updated";
        } else {
          echo "Misc Certs updated!!!!";
        }
      } else {
        echo "Misc Certs were not updated";
      }

      //Update supervisor's information for member
      $supUpdateName = $mysqli->query("UPDATE supList
        SET superRank = '$supRank', supFirstName = '$supFirstName', supLastName = '$supLastName', supDateBegin = '$dateBegan', feedbackCompleted='$feedback' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

        //Update supervison information for member
        $memberSupUpdate = $mysqli->query("UPDATE supList
          SET superRank = '$supRank', supFirstName = '$supFirstName', supLastName = '$supLastName', supDateBegin = '$dateBegan', feedbackCompleted='$feedback' WHERE (lastName = '$findMember->lastName' AND dodId = '$findMember->dodId')");

          //Members fitness information
          //$fitnessAssessmentDateInput = mysqli_real_escape_string($mysqli, $_POST['fitnessAssessmentDate']);
          $fitnessAssessmentDateInput = date('Y-m-d', strtotime(mysqli_real_escape_string($mysqli, $_POST['fitnessAssessmentDate'])));

          $fitnessAssessmentType = mysqli_real_escape_string($mysqli, $_POST['inputFitnessType']);

          //$mockInput = mysqli_real_escape_string($mysqli, $_POST['inputMockDate']);
          // $dueDateInput = mysqli_real_escape_string($mysqli, $_POST['inputFitnessDate']);
          $gender = mysqli_real_escape_string($mysqli, $_POST['inputGender']);
          $waistInput = mysqli_real_escape_string($mysqli, $_POST['inputWaist']);
          $runInput = mysqli_real_escape_string($mysqli, $_POST['inputRunning']);
          $pushUpInput = mysqli_real_escape_string($mysqli, $_POST['inputPushup']);
          $situpInput = mysqli_real_escape_string($mysqli, $_POST['inputSitup']);

          if (($fitnessAssessmentType == 'Mock Test' || $fitnessAssessmentType == "Official Test") AND (isset($_POST['inputRunning']) != '') AND (isset($_POST['inputPushup']) != '') AND (isset($_POST['inputWaist']) != '') AND (isset($_POST['inputSitup']) != '')) {
            //due date is the date either assessment was compeleted.
            $memberFitnessInput = ("INSERT INTO `fitness`(`id`, `rank`, `lastName`, `firstName`, `middleName`, `pushUps`, `sitUps`, `run`, `waist`, `dodId`, `dueDate`, `unitName`, `fitness_mockType`) VALUES (id, '$rank', '$findMember->lastName', '$findMember->firstName','$findMember->middleName', '$pushUpInput', '$situpInput', '$runInput', '$waistInput', '$recalldodId', '$fitnessAssessmentDateInput', '$unitName', '$fitnessAssessmentType')");

            $resultMemberFitnessInput = mysqli_query($mysqli, $memberFitnessInput);

            $fitnessSuccessMsg = "Member's fitness information was added successfully";

          }

          $memberFitnessUpdate = $mysqli->query("UPDATE `fitness` SET waist = '', pushUps = '', sitUps = '', run = '', fitness_mockType = '', dueDate = '' WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId'");

          $resultMemberFitnessUpdate = mysqli_query($mysqli, $memberFitnessUinput);

          //Members family information
          /*
          $familyName = count($_POST['familyName']);
          $familyBirthdate = count($_POST['familyBirthdate']);
          $familyGender = count($_POST['familyGender']);
          $familyRelationship = count($_POST['familyRelationship']);

          if ($familyName > 0) {
          for ($i = 0; $i < $familyName; $i++) {
          if (trim($_POST["familyName"][$i] != '')) {
          $memberFamilyUpdate = "UPDATE `family` SET (id, dodId, fname, birthdate, gender, relationship) VALUES('id', '$dodID', '" . mysqli_real_escape_string($mysqli, $_POST["familyName"][$i]) . "', '" . mysqli_real_escape_string($mysqli, $_POST["familyBirthdate"][$i]) . "', '" . mysqli_real_escape_string($mysqli, $_POST["familyGender"][$i]) . "', '" . mysqli_real_escape_string($mysqli, $_POST["familyRelationship"][$i]) . "'
          WHERE lastName = '$recallLast' AND firstName = '$recallFirst' AND middleName = '$recallMiddle')";
          mysqli_query($mysqli, $memberFamilyUpdate);
        }
      }
    }
    */

    #$sqlDoDID = "UPDATE `cbtList` SET dodID = '$dodId' WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName'";

    //Miscellaneous update/queries
    /*$updateLogin = "Update sfmq
    set lastName = '$lastName', middleName = '$middleName', firstName = '$firstName', dodId = $dodId
    WHERE (login.lastName = '$recallLast'
    AND login.firstName = '$recallFirst')";*/
    //if all queries and updates are correct the following will occur, message indicating all areas where updated
    if (($updateMembersInformation AND $supUpdateName AND $memberSupUpdate AND $updateAdmin) == true) {

      $successmsg = "Member Successfully Updated.";


      $location = "member-view.php?ID=$findMember->dodId&last=$lastName";

      echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';

      //$here = "/resources/Admin/Edit-User/member-view.php?ID=1256916548&last=Eveland";


      //echo '<meta http-equiv="refresh" content="2; url='.$here.'">';

      //  echo "<meta http-equiv='refresh' content='3': url='.$location>.'";

      // header("Location: '.$location.'");

    } else {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      $failuremsg = "Member Was Not Updated - Please try again.";


    }
  }

  if(isset($_POST['cancel'])){



    $location ="/resources/operations/section-view-roster.php";

    //echo '<meta http-equiv="refresh" content="0; url=' . $location . '">';
    header('Location:' . $location);

    //header('Location:' . $_SERVER['DOCUMENT_ROOT']'./resources/operations/section-view-roster.php'); /*Something Wrong?*/
    //  echo "<meta http-equiv='refresh' content='3': url='.$location>.'";

    // code...
  }

  //UPLOAD Photo
  if (isset($_POST["imgUploadNoImg"])) {

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');


    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {

        if ($fileSize < 262144) {

          $imgUpdate = "UPDATE members SET imageDetail = '1' where dodId = '$recalldodId'";

          $resultImgUpdate = mysqli_query($mysqli, $imgUpdate);


          if ($resultImgUpdate == true) {

            $fileNameNew = "profile" . ".$last.$first.$recalldodId.$fileActualExt";

            $fileDestination = './uploads/' . $fileNameNew;

            $imgMap = "UPDATE members SET image = '$fileDestination' where dodId = '$recalldodId'";

            $resultImgMap = mysqli_query($mysqli, $imgMap);


            if ($resultImgUpdate == true) {
              move_uploaded_file($fileTmpName, $fileDestination);
              $uploadSuccess = "Your photo has been uploaded successfully";
            } else {

              echo 'file did not upload. sorry (moved file)';

            }
          } else {

            echo 'file did not upload. sorry (moved file)';

          }
        } else {

          echo "Your file is larger than .25 MB.";
        }

      } else {
        echo "There was an error uploading your file.";
      }
    } else {

      $uploadFailure = "Your file was not uploaded.";


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
                  <?php // header("refresh:5;url=alarm-report.php");?>
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
                  <h5 class="modal-title">Member updated</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p>Member updated successfully</p>
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
