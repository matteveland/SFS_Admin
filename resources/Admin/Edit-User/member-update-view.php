<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
parse_str($_SERVER['QUERY_STRING'], $query);
$id = $mysqli->real_escape_string($query['ID']);
$last = $mysqli->real_escape_string($query['last']);

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];



if (($_SESSION['page_admin']) == true) {

  $findMember = new FindMember();
  $findMember->find_member($id, $last, $unitName);

  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_ENV['cipherMethod']));

  //  $Iv = $mysqli->query("UPDATE members set iv = '$iv' WHERE lastName = '$findMember->lastName' AND dodID = '$findMember->dodId'");


  //while($row = $decrypted->fetch_assoc()){

  //look for user IV. if empty, the old infomation associated with the IV is deleted and the new IV is addedd. this allows the new iv to be the only part of the encryption associated with the member.
  if(empty($findMember->iv)){

    $removeOldInformation = $mysqli->query("UPDATE members SET cellPhone = '', govEmail = '', PrsnlEmail = '', homePhone='', birthdate='' WHERE iv = '' and dodId = '$findMember->dodID'");

    $iv = $mysqli->query("UPDATE members set iv = '$iv' WHERE lastName = '$findMember->lastName' AND dodID = '$findMember->dodId'");

  }


  $findMember = new FindMember();
  $findMember->find_member($id, $last, $unitName);

  $decryptCell = openssl_decrypt($findMember->cellPhone, $_ENV['cipherMethod'], $_ENV['cellPhoneKey'], $options = 0, $findMember->iv);

  $decryptPrsnlEmail = openssl_decrypt($findMember->prsnlEmail, $_ENV['cipherMethod'], $_ENV['prsnlEmailKey'], $options = 0, $findMember->iv);

  $decryptBirthdate = openssl_decrypt($findMember->birthdate, $_ENV['cipherMethod'], $_ENV['birthdateKey'], $options = 0, $findMember->iv);

  $decryptHome = openssl_decrypt($findMember->homePhone, $_ENV['cipherMethod'], $_ENV['homePhoneKey'], $options = 0, $findMember->iv);

  $decryptGovEmail = openssl_decrypt($findMember->govEmail, $_ENV['cipherMethod'], $_ENV['govEmailKey'], $options = 0, $findMember->iv);
  //}


  $recallSpecialAccess = explode(', ', $findMember->specialAccess);
  sort($recallSpecialAccess);


  $recallArmingInformation = $mysqli->query("SELECT * From armingRoster WHERE lastName = '$findMember->lastName' AND dodID = '$findMember->dodId'");

  //$resultRecallArmingInformation = mysqli_query($connection, $recallArmingInformation);

  while ($row = $recallArmingInformation->fetch_assoc()) {

    $recallSMCCompleted = $row['smcFired'];
    $recallSMCDue = $row['smcDue'];
    $recallM4FiringDateCompleted = date('Y-m-d', strtotime($row['m4Qual']));
  }

  $recallMemberSFMQInformation = $mysqli->query("SELECT * FROM  sfmq WHERE sfmq.lastName = '$findMember->lastName' AND sfmq.firstName = '$findMember->firstName' AND rank = '$findMember->rank' AND unitName ='$unitName'");

  //$resultRecallMemberSFMQInformation = mysqli_query($connection, $recallMemberSFMQInformation);

  while ($row = $recallMemberSFMQInformation->fetch_assoc()) {

    $recallDutyPosition = $row['dutyQualPos'];
    $recallPrimCertDate = $row['primCertDate'];
    // $recallReCertDate = $row['reCertDate'];
    $recallPhaseIIStart = $row['phase2Start'];
    $recallPhaseIIEnd = $row['phase2End'];
    $recallNewDutyPosition = $row['newDutyQual'];
    $recallVerbalScore = $row['verbal'];
    $recallWrittenScore = $row['written'];
    $recallPracticalScore = $row['practical'];
    $recallReCertDate = date('Y-m-d', strtotime("$recallPrimCertDate + 365 days"));
  }

  $recallMemberSupervisorInformation = $mysqli->query("SELECT * FROM supList
    WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName' AND rank = '$findMember->rank' AND unitName ='$unitName'");

    //$resultRecallMemberSupervisorInformation = mysqli_query($connection, $recallMemberSupervisorInformation);

    while ($row = $recallMemberSupervisorInformation->fetch_assoc()) {

      $recallSupRank = $row['superRank'];
      $recallSupFirstName = $row['supFirstName'];
      $recallSupLastName = $row['supLastName'];
      $recallDateBegan = $row['supDateBegin'];
      $recallFeedback = $row['feedbackCompleted'];
      //$recallMemberRank = $row['rank'];
    }

    $recallPhaseIIStartStrToTime = strtotime($recallPhaseIIStart);
    $recallPhaseIIStartDate = strtotime('Y-m-d', $recallPhaseIIStartStrToTime);
    $recallPhaseIIEndDate = date('Y-m-d', strtotime("$recallPhaseIIStart + 60 days"));
    $feedbackDate = date('Y-m-d', strtotime("$recallDateBegan + 180 days"));
    $currentDate = date_default_timezone_set("Europe/London");


    # fitness test information
    $recallMemberFitnessInformation = $mysqli->query("select * From fitness
    WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName' AND rank = '$findMember->rank' AND unitName = '$unitName'
    ");
    //$resultRecallMemberFitnessInformation = mysqli_query($connection, $recallMemberFitnessInformation);

    while ($row = $recallMemberFitnessInformation->fetch_assoc()) {

      #$recallFitnessFirstName = $row['firstName'];
      #$recallFitnessLastName = $row['lastName'];
      $recallPushUps = $row['pushUps'];
      $recallSitUps = $row['sitUps'];
      $recallWaist = $row['waist'];
      $recallRun = $row['run'];
      $recallMockDate = $row['mockDate'];
      $recallDueDate = $row['dueDate'];
    }

    $recallMiscCertification = $mysqli->query("SELECT * FROM miscCerts where dodId = '$findMember->dodID'");

    //$resultsRecallMiscCerts = mysqli_query($connection, $recallMiscCertification);

    while ($row = $recallMiscCertification->fetch_assoc()) {

      #$recallFitnessFirstName = $row['firstName'];
      #$recallFitnessLastName = $row['lastName'];
      $recallRanger = $row['ranger'];
      $recallRaven = $row['raven'];
      $recall5ton = $row['5ton'];
      $recallDagr = $row['dagr'];
      $recallLeaderLed = $row['leaderLed'];
    }

  }else {
    echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

    include __DIR__ . '/../../footer.php';

    header('Location: /UnitTraining/home.php');
    exit;
  }

  ?>

  <div class="member_update">
    <div class="container" width="auto">
      <form action="member-insert-update.php?ID=<?php echo $id; ?>&last=<?php echo $last;?>" class="member-update" method="post">

        <div class="row">
          <div class="form-group col-lg-3">
            <div align="center">

              <?php $returnTo = $_SERVER['HTTP_REFERER']; ///resources/operations/section-view-roster.php ?>
              <a href="<?php echo $returnTo; ?>">
                <input class="btn btn-outline-secondary" type="button" name="cancel" id="cancel" value="Cancel">
              </a>

            </div>
          </div>
          <div class="form-group col-lg-7">

          </div>
          <div class="form-group col-lg-2">
            <input class="btn btn-md btn-primary" type="submit" name="update" id="update" value="Update Member">
          </div>
        </div>

        <h3 align="center">Personal Information</h3>
        <div class="form-row">
          <div class="form-group col-md-1" hidden>
            <label for="did">Gender</label>
            <select class="form-control" id="inputGender" name="inputGender" title="inputGender">
              <option value="" <?php if ($findMember->gender == "") echo "selected"; ?>>None</option>
              <option value="Male" <?php if ($findMember->gender == "Male") echo "selected"; ?>>Male</option>
              <option value="Female" <?php if ($findMember->gender == "Female") echo "selected"; ?>>Female</option>
            </select>
          </div>
          <!--Member's gender information displayed-->
          <div class="form-group col-md-1">
            <label for="inputGender">Gender</label>
            <select class="form-control" id="inputGender" name="inputGender" title="inputGender">
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
            <input type="text" class="form-control" id="inputBirthdate" name="inputBirthdate"
            value="<?php echo "$decryptBirthdate"; ?>" placeholder="Birthdate YYYY-MM-DD">
          </div>

          <!--Member's DoD ID number information displayed-->
          <div class="form-group col-md-3">
            <label for="readonlyDODID">DoD ID Number</label>
            <br>
            <input type="text" class="form-control" id="readonlyDODID" name="readonlyDODID"
            value="<?php echo "$findMember->dodID"; ?>" readonly>

          </div>
        </div>
        <!--Contct information-->
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="inputhomePhone">Home Phone</label>
            <input type="text" class="form-control" id="inputHomePhone" name="inputHomePhone"
            value="<?php echo "$decryptHome"; ?>" placeholder="Home Phone">
          </div>

          <div class="form-group col-md-3">
            <label for="inputCellPhone">Cell Phone</label>
            <input type="text" class="form-control" id="inputCellPhone" name="inputCellPhone"
            value="<?php echo "$decryptCell"; ?>" placeholder="Cell Phone">
          </div>

          <div class="form-group col-md-3">
            <label for="inputGovEmail">Gov Email</label>
            <input type="text" class="form-control" id="inputGovEmail" name="inputGovEmail"
            value="<?php echo "$decryptGovEmail"; ?>" placeholder="Gov Email">
          </div>

          <div class="form-group col-md-3">
            <label for="inputPrsnlEmail">Personal Email</label>
            <input type="text" class="form-control" id="inputPrsnlEmail" name="inputPrsnlEmail"
            value="<?php echo "$decryptPrsnlEmail"; ?>" placeholder="Personal Email">
          </div>
        </div>


        <!--

        do not display family information until the rows can be added.

        <div class="form-row">
        <div class="form-group col-md-4">
        <label for="inputFamilyInfo">Family Information</label>
        <textarea type="text" class="form-control" id="inputFamilyInfo" name="inputFamilyInfo" value="<?php // echo "$recallFamily"; ?>" placeholder="Family Information"></textarea>
      </div>
    </div>


    <h3>Family Information</h3><br>
    <textarea id="family" name="family" placeholder="Family Information, Spouse, Children"><?php //echo "$recallFamily"; ?></textarea>

    <h3 align="center">Family Details</h3>


    <!-- <input align="center" class="btn" type="submit" name="submit" id="submit" value="Add Member">-->

    <!-- </div>-->


    <!--Member's Duty information displayed-->

    <h3 align="center">Duty Information</h3>

    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="inputDutySectionSelect">Duty Section</label>
        <select class="form-control" id="inputDutySectionSelect" name="inputDutySectionSelect"
        title="inputDutySectionSelect">
        <option value="S1" <?php if ($findMember->dutySection == "S1") echo "selected"; ?> >S1</option>
        <option value="S2" <?php if ($findMember->dutySection == "S2") echo "selected"; ?> >S2</option>
        <option value="S3" <?php if ($findMember->dutySection == "S3") echo "selected"; ?> >S3</option>
        <option value="S3OA" <?php if ($findMember->dutySection == "S3OA") echo "selected"; ?> >S3OA</option>
        <option value="S3OB" <?php if ($findMember->dutySection == "S3OB") echo "selected"; ?> >S3OB</option>
        <option value="S3OC" <?php if ($findMember->dutySection == "S3OC") echo "selected"; ?> >S3OC</option>
        <option value="S3OD" <?php if ($findMember->dutySection == "S3OD") echo "selected"; ?> >S3OD</option>
        <option value="S3OE" <?php if ($findMember->dutySection == "S3OE") echo "selected"; ?> >S3OE</option>
        <option value="S3OF" <?php if ($findMember->dutySection == "S3OF") echo "selected"; ?> >S3OF</option>
        <option value="S3K" <?php if ($findMember->dutySection == "S3K") echo "selected"; ?> >S3K</option>
        <option value="S3T" <?php if ($findMember->dutySection == "S3T") echo "selected"; ?> >S3T</option>
        <option value="S4" <?php if ($findMember->dutySection == "S4") echo "selected"; ?> >S4</option>
        <option value="S5" <?php if ($findMember->dutySection == "S5") echo "selected"; ?> >S5</option>
        <option value="SFMQ" <?php if ($findMember->dutySection == "SFMQ") echo "selected"; ?> >SFMQ</option>
        <option value="CC" <?php if ($findMember->dutySection == "CC") echo "selected"; ?> >CC</option>
        <option value="CCF" <?php if ($findMember->dutySection == "CCF") echo "selected"; ?> >CCF</option>
        <option value="SFM" <?php if ($findMember->dutySection == "SFM") echo "selected"; ?> >SFM</option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="inputAdminSelect">Is Unit Admin?</label>
      <select class="form-control" id="inputAdminSelect" name="inputAdminSelect"
      title="inputAdminSelect">
      <option value="">Select as Admin</option>
      <option value="Yes" <?php if ($findMember->admin == "Yes") echo "selected"; ?> >Yes</option>
      <option value="No" <?php if ($findMember->admin == "No") echo "selected"; ?> >No</option>
    </select>
  </div>


  <!-- Select to remove access -->

  <div class="form-group col-md-3">
    <label for="accessRemove"><b>Current Access:</b></label>
    <br>
    <?php
    //find units access programs//
    $findAccessValues = $mysqli->query("SELECT accessValues FROM specialAccess WHERE unitName ='$unitName'");
    $findAccessValuesAssocArray = $findAccessValues->fetch_assoc();
    $unitAccessPermissions = $findAccessValuesAssocArray['accessValues'];

    $unitAccessPermissions = explode(',', $unitAccessPermissions);

    $membersAccessArray = explode(', ', $findMember->specialAccess);
    if (($key = array_search('Zeus', $membersAccessArray)) !== false) {

      echo '<label for="accessRemove[]"></label><input style="alignment:left" type="checkbox" checked name="accessRemove[]" id="accessRemove[]" value="Zeus" onclick="return false;">Zeus<br>';
    }
    //remvoe zeus access from being displayed.
    if (($key = array_search('Zeus', $unitAccessPermissions)) !== false) {

      unset($unitAccessPermissions[$key]);
    }
    sort($unitAccessPermissions);



    for ($i = 0; $i < count($unitAccessPermissions); $i++) {
      if (in_array($unitAccessPermissions[$i], $membersAccessArray)) {

        echo '<input style="alignment:left" type="checkbox" checked id="accessRemove[]" name="accessRemove[]" value="' . $unitAccessPermissions[$i] . '">' . $unitAccessPermissions[$i] . '<br>';
      }

    }

    ?>

  </div>

  <!-- Select to give access -->
  <div class="form-group col-md-3" style="text-align: left">
    <b><label for="equipmentAdd">No Current Access</label></b><br>


    <?php
    for ($i = 0; $i < count($unitAccessPermissions); $i++) {

      if (!in_array($unitAccessPermissions[$i], $membersAccessArray)) {
        echo '<label for="accessAdd[]"></label>
        <input style="alignment:left" type="checkbox" id="accessAdd[]" name="accessAdd[]" value="' . $unitAccessPermissions[$i] . '"> ' . $unitAccessPermissions[$i] . '<br>';
      }

    }
    //echo substr(rtrim($_POST['accessAdd']), 0, -1);
    ?>

  </div>

  <div>
    <h3 align="center">Phase II Information</h3>
    <br>
    <!--new Phase II things-->
    <?php
    //query if for if statement and while loop only
    $recallCertSFMQInformation = $mysqli->query("SELECT * From sfmq WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName' AND rank = '$findMember->rank' AND middleName = '$findMember->middleName' AND unitName = '$unitName' AND phase2_Cert = 'certified'");

    //$resultRecallCertSFMQInformation = mysqli_query($connection, $recallCertSFMQInformation);
    if ($recallCertSFMQInformation->num_rows) {
      //($row = mysqli_fetch_array($result) > 1)
      echo "<h3 align=\"center\">Certified Phase II Information</h3>
      <div class=\"form-row\">
      <table class=\"table table-bordered\">
      <thead>
      <tr>
      <th scope=\"col\" style='width: auto'>Duty Position</th>
      <th scope=\"col\" style='width: auto'>Certification Date</th>
      <th scope=\"col\" style='width: auto'>Re-certification Date</th>
      <th scope=\"col\" style='width: auto'>Practical Score</th>
      <th scope=\"col\" style='width: auto'>Written Score</th>
      <th scope=\"col\" style='width: auto'>Verbal Score</th>
      </tr>
      </thead>";

      while ($row = $recallCertSFMQInformation->fetch_assoc()) {

        $recallReCertDate = date('Y-m-d', strtotime($row['primCertDate']));
        $recallReCertDate = date('Y-m-d', strtotime("$recallReCertDate + 365 days"));

        echo "<tbody>
        <tr>
        <td>" . $row['dutyQualPos'] . "</td>
        <td>" . $row['primCertDate'] . "</td>";

        //find new DPE date for Member//
        if ($row['reCertDate'] = '' OR 'NULL') {

          echo "<td>" . $recallReCertDate . "</td>";

        } else {
          echo "<td>" . $recallReCertDate . "</td>";
        }


        //return to list for members DPE information.
        echo "<td>";
        if ($row['practical'] == '100') {
          echo "Go";
        } else echo "No-Go";
        echo "</td>
        <td>" . $row['written'] . "</td>
        <td>" . $row['verbal'] . "</td>
        </tr>
        </tbody>
        ";
      }
    } else {
    }

    $recallPhaseIISFMQInformation = $mysqli->query("SELECT * From sfmq
      WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName' AND rank = '$findMember->rank' AND middleName = '$findMember->middleName' AND unitName = '$unitName' AND phase2_Cert = 'phaseII'");



      if ($recallPhaseIISFMQInformation->num_rows) {


        echo "</table>";

        while ($row = $recallPhaseIISFMQInformation->fetch_assoc()) {


          echo "
          <div class='table-md'>
          <table class='table table-bordered'>
          <tbody>
          <thead class='thead-light' style='alignment: left'>
          <tr>
          <th scope='col' style='width: 10%'>Duty Position</th>
          <th scope='col' style='width: auto'>Phase II Start Date</th>
          <th scope='col' style='width: auto'>Phase II End Date</th>
          <th scope='col' style='width: auto'>Certification Date</th>
          <th scope='col' style='width: auto'>Practical Score</th>
          <th scope='col' style='width: auto'>Written Score</th>
          <th scope='col' style='width: auto'>Verbal Score</th>
          <th scope='col' style='width: auto'>Type</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <td style='alignment: left; width: auto'>
          <select id='inputDutyPositionSelect' name='inputDutyPositionSelect' title='inputDutyPositionSelect' class='form-control name_list'>
          <option value='NONE'>NONE</option>
          <option value='RFM'";
          if ($row['newDutyQual'] == 'RFM') echo "selected";
          echo ">RFM</option>
          <option value='RFL'";
          if ($row['newDutyQual'] == 'RFL') echo "selected";
          echo " >RFL</option>
          <option value='BDOC'";
          if ($row['newDutyQual'] == 'BDOC') echo "selected";
          echo " >BDOC</option>
          <option value='Flight Chief'";
          if ($row['newDutyQual'] == 'Flight Chief') echo "selected";
          echo " >Flight Chief</option>
          <option value='Armory'";
          if ($row['newDutyQual'] == 'Armory') echo "selected";
          echo " >Armory</option>
          <option value='RFM/Armory'";
          if ($row['newDutyQual'] == 'RFM/Armory') echo "selected";
          echo " >RFM/Armory</option>
          <option value='RFL/Armory'";
          if ($row['newDutyQual'] == 'RFL/Armory') echo "selected";
          echo " >RFL/Armory</option>
          </select>
          </td>

          <td>
          <input type='text' id='inputPhaseIIStart' name='inputPhaseIIStart' class='form-control name_list' value='";
          if ($row['phase2Start'] <> '') {
            echo $row['phase2Start'];
          } else {
            echo "";

          }
          echo "'>
          </td>
          <td>
          <input type='text' id='inputPhaseIIEnd' name='inputPhaseIIEnd' class='form-control name_list' value='";
          if ($row['phase2End'] <> '') {

            echo $row['phase2End'];

          } else {
            $phaseIIStartDateStringToTime = date('Y-m-d', strtotime($row['phase2Start']));
            $phaseIIEndDateStringToTime = date('Y-m-d', strtotime("" . $row['phase2End'] . " + 60 days"));
            echo $phaseIIEndDateStringToTime;
          }
          echo " '>
          </td>
          <td>
          <input type='text' id='inputPrimCertDate' name='inputPrimCertDate' placeholder='' class='form-control name_list'>
          </td>
          <td>
          <select class='form-control' id='inputDPEPracticalScore' name='inputDPEPracticalScore' title='inputDPEPracticalScore'>
          <option value=''>NONE</option>
          <option value='100'>Go</option>
          <option value='0'>No-Go</option>
          </select>

          </td>
          <td>
          <input type='text' id='inputDPEWrittenScore' name='inputDPEWrittenScore' placeholder='' class='form-control name_list'>
          </td>
          <td>
          <input type='text' id='inputDPEVerbalScore' name='inputDPEVerbalScore' placeholder='' class='form-control name_list'>
          </td>
          <td>
          <select class='form-control' id='inputDPEType' name='inputDPEType' title='inputDPEType'>
          <option value='phaseII'";
          if ($row['phase2_Cert'] == 'phaseII') {
            echo "selected";
          }
          echo ">Phase II</option>

          <option value='certified'>Certified</option>
          <option value='failure'>Failure</option>
          <option value='remove'>Remove</option>
          </select>
          </td>
          </tr>
          </tbody>
          </table>
          </div>
          ";
          echo "<b>NOTE:</b>  To remove an individual from Phase II the duty position must be 'NONE' and all date field must be empty.<br>";

        }

      } else {
        echo "


        <div class='table-responsive-md'>
        <table class='table table-bordered'>
        <tbody>
        <thead class='thead-light' style='alignment: left';>
        <tr>
        <th scope='col' style='width: auto'>Duty Position</th>
        <th scope='col' style='width: auto'>Phase II Start Date</th>
        <th scope='col' style='width: auto'>Phase II End Date</th>
        <!--<th scope='col' style='width: auto'>Certification Date</th>
        <th scope='col' style='width: auto'>Practical Score</th>
        <th scope='col' style='width: auto'>Written Score</th>
        <th scope='col' style='width: auto'>Verbal Score</th>-->

        <th scope='col' style='width: auto'>Type</th>
        </tr>
        </thead>

        <tbody>
        <tr>
        <td style='alignment: left; width: auto' >
        <select class='form-control' id='inputDutyPositionSelect' name='inputDutyPositionSelect' title='inputDutyPositionSelect'>
        <option value=''>None</option>
        <option value='RFL'>RFM</option>
        <option value='RFL'>RFL</option>
        <option value='BDOC'>BDOC</option>
        <option value='Flight Chief'>Flight Chief</option>
        <option value='Armory'>Armory</option>
        <option value='RFM/Armory'>RFM/Armory</option>
        <option value='RFL/Armory'>RFL/Armory</option>
        </select>
        </td>
        <td>
        <div class='col-md-12'>
        <input type='text' id='inputPhaseIIStart' name='inputPhaseIIStart' value='' class='form-control name_list'>
        </div>
        </td>
        <td>
        <div class='col-md-12'>
        <input type='text' id='inputPhaseIIEnd' name='inputPhaseIIEnd' value='' class='form-control name_list'>
        </div>
        </td>

        <td>

        <div class='col-md-12'>
        <select class='form-control' id='inputDPEType' name='inputDPEType' title='inputDPEType'>
        <option value=''>None</option>
        <option value='phaseII' >Phase II </option>
        <!--<option value='certified' >Certified</option>-->
        </select>
        </div>
        </td>
        </tbody>
        </table>
        </div>

        ";
      }
      ?>


      <!--End Phase II          -->

      <!--Misc Certifiactions-->
      <h3 align="center">Misc Certifcations</h3>


      <div class='table-responsive-md'>
        <table class='table table-bordered'>
          <tbody>
            <thead class='thead-light' style='alignment: left' ;>
              <tr>
                <th scope='col' style='width: auto alignment:center'>Ranger</th>
                <th scope='col' style='width: auto'>Raven</th>
                <th scope='col' style='width: auto'>DAGR</th>
                <th scope='col' style='width: auto'>5 Ton</th>

              </tr>
            </thead>

            <tr>
              <td style='alignment: left; width: auto'>
                <div class="form-group">
                  <label for="inputRanger"></label>
                  <input type="text" class="form-control" id="inputRanger" name="inputRanger"
                  value="<?php echo $recallRanger; ?>" placeholder="YYYY-MM-DD">

                </div>

              </td>
              <td>
                <div class="form-group">
                  <label for="input5ton"></label>
                  <input type="text" class="form-control" id="input5ton" name="input5ton"
                  value="<?php echo $recall5ton; ?>" placeholder="YYYY-MM-DD">

                </div>

              </td>
              <td>
                <div class="form-group">
                  <label for="inputRaven"></label>
                  <input type="text" class="form-control" id="inputRaven" name="inputRaven"
                  value="<?php echo $recallRaven; ?>" placeholder="YYYY-MM-DD">

                </div>

              </td>
              <td>

                <div class="form-group">
                  <label for="inputDagr"></label>
                  <input type="text" class="form-control" id="inputDagr" name="inputDagr"
                  value="<?php echo $recallDagr; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
            </tr>

            <thead class='thead-light' style='alignment: left' ;>
              <tr>
                <th scope='col' style='width: auto'>Leader Led Training</th>
                <th scope='col' style='width: auto'>POI</th>
                <th scope='col' style='width: auto'>SABRE</th>
                <th scope='col' style='width: auto'>SABRE Instructor</th>

              </tr>
              <tr>
                <td style='alignment: left; width: auto'>
                  <div class="form-group">
                    <label for="inputLeaderLed"></label>
                    <input type="text" class="form-control" id="inputLeaderLed" name="inputLeaderLed"
                    value="<?php echo $recallLeaderLed; ?>" placeholder="YYYY-MM-DD">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <label for="xxx"></label>
                    <input type="text" class="form-control" id="xxx" name="xxx"
                    value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <label for="xxx"></label>

                    <input type="text" class="form-control" id="xxx" name="xxx"
                    value="<?php // $recallItem; ?>" placeholder="YYYY-MM-DD">
                  </div>

                </td>
                <td>
                  <div class="form-group">
                    <label for="xxx"></label>

                    <input type="text" class="form-control" id="xxx" name="xxx"
                    value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                  </div>
                </td>
              </tr>
            </thead>
            <thead class='thead-light' style='alignment: left' ;>
              <tr>
                <th scope='col' style='width: auto'>INAWC</th>
                <th scope='col' style='width: auto'>Airfield Driving</th>
                <th scope='col' style='width: auto'>SMC Completed</th>
                <th scope='col' style='width: auto'>row 3</th>

              </tr>
            </thead>
            <tr>
              <td style='alignment: left; width: auto'>
                <div class="form-group">
                  <input type="text" class="form-control" id="xxx" name="xxx"
                  value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
              <td>
                <div class="form-group">
                  <input type="text" class="form-control" id="xxx" name="xxx" value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
              <td>
                <div class="form-group">
                  <label for="inputSMC"></label>
                  <input type="text" class="form-control" id="inputSMC" name="inputSMC" value="<?php
                  $now = date('Y-m-d');

                  $firingPlus5 = date('Y-m-d', strtotime("$recallM4FiringDateCompleted + 5 Months"));
                  $firingPlus7 = date('Y-m-d', strtotime("$recallM4FiringDateCompleted + 7 Months"));


                  if($recallSMCCompleted == '' AND ($now <=$firingPlus5)){
                    echo "not required";
                  }
                  elseif($recallSMCCompleted == '' AND (($now >=$firingPlus5) && ($now <= $firingPlus7))){

                    echo "Between";
                  }elseif($recallSMCCompleted == '' AND ($now >= $firingPlus7)){
                    echo "AFQC Required";
                  }else{
                    echo $recallSMCCompleted;

                  }



                  ?>" placeholder="YYYY-MM-DD"> <?php echo "Last firing date: $recallM4FiringDateCompleted"; ?>

                </div>
              </td>
              <td>
                <div class="form-group">
                  <input type="text" class="form-control" id="xxx" name="xxx"
                  value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
            </tr>
            <thead class='thead-light' style='alignment: left' ;>
              <tr>
                <th scope='col' style='width: auto'>row 4</th>
                <th scope='col' style='width: auto'>row 4</th>
                <th scope='col' style='width: auto'>row 4</th>
                <th scope='col' style='width: auto'>row 4</th>

              </tr>
            </thead>
            <tr>
              <td style='alignment: left; width: auto'>
                <div class="form-group">
                  <label for="xxx"></label>
                  <input type="text" class="form-control" id="xxx" name="xxx"
                  value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
              <td>
                <div class="form-group">
                  <label for="xxx"></label>
                  <input type="text" class="form-control" id="xxx" name="xxx"
                  value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
              <td>
                <div class="form-group">
                  <label for="xxx"></label>
                  <input type="text" class="form-control" id="xxx" name="xxx"
                  value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>

              </td>
              <td>
                <div class="form-group">
                  <label for="xxx"></label>
                  <input type="text" class="form-control" id="xxx" name="xxx"
                  value="<?php //echo $recallItem; ?>" placeholder="YYYY-MM-DD">
                </div>
              </td>
            </tr>
          </table>
        </div>


        <!--Misc Certifiactions-->


        <br>
        <h3 align="center">Supervisor Information</h3>
        <div class="form-row">

          <div class="form-group col-md-2">
            <label for="inputSuperRankOption">Supervisor Rank</label>
            <select class="form-control" id="inputSuperRankOption" name="inputSuperRankOption"
            title="inputSuperRankOption">
            <option value="" <?php if ($recallSupRank == '') echo "selected"; ?>>NONE</option>
            <option value="AB" <?php if ($recallSupRank == "AB") echo "selected"; ?> >AB</option>
            <option value="AMN" <?php if ($recallSupRank == "AMN") echo "selected"; ?> >AMN</option>
            <option value="A1C" <?php if ($recallSupRank == "A1C") echo "selected"; ?> >A1C</option>
            <option value="SrA" <?php if ($recallSupRank == "SrA") echo "selected"; ?> >SrA</option>
            <option value="SSgt" <?php if ($recallSupRank == "SSgt") echo "selected"; ?> >SSgt</option>
            <option value="TSgt" <?php if ($recallSupRank == "TSgt") echo "selected"; ?> >TSgt</option>
            <option value="MSgt" <?php if ($recallSupRank == "MSgt") echo "selected"; ?> >MSgt</option>
            <option value="SMSgt" <?php if ($recallSupRank == "SMSgt") echo "selected"; ?> >SMSgt</option>
            >
            <option value="CMSgt" <?php if ($recallSupRank == "CMSgt") echo "selected"; ?> >CMSgt</option>
            <option value="2nd Lt" <?php if ($recallSupRank == "2nd Lt") echo "selected"; ?> >2nd Lt
            </option>
            <option value="1st Lt" <?php if ($recallSupRank == "1st Lt") echo "selected"; ?> >1st Lt
            </option>
            <option value="Capt" <?php if ($recallSupRank == "Capt") echo "selected"; ?> >Capt</option>
            <option value="Maj" <?php if ($recallSupRank == "Maj") echo "selected"; ?> >Maj</option>
            <option value="Lt Col" <?php if ($recallSupRank == "Lt Col") echo "selected"; ?> >Lt Col
            </option>
            <option value="Col" <?php if ($recallSupRank == "Col") echo "selected"; ?> >Col</option>
          </select>
        </div>

        <div class="form-group col-md-5">
          <label for="inputSupervisorsFirst">First Name</label>
          <input type="text" class="form-control" id="inputSupervisorsFirst" name="inputSupervisorsFirst"
          value="<?php echo "$recallSupFirstName"; ?>" placeholder="Supervisor Frist Name">
        </div>

        <div class="form-group col-md-5">
          <label for="inputSupervisorsLast">Last Name</label>
          <input type="text" class="form-control" id="inputSupervisorsLast" name="inputSupervisorsLast"
          value="<?php echo "$recallSupLastName"; ?>" placeholder="Supervisor's Last Name">
        </div>

        <div class="form-group col-md-6">
          <label for="inputSupervisonBegan">Supervison Began</label>
          <input type="text" class="form-control" id="inputSupervisonBegan" name="inputSupervisonBegan"
          value="<?php echo "$recallDateBegan"; ?>" placeholder="Supervision Began">
        </div>


        <div class="form-group col-md-6">
          <label for="inputFeedbackDate">Feedback Date</label>
          <input type="text" class="form-control" id="inputFeedbackDate" name="inputFeedbackDate"
          value="<?php if (empty($recallDateBegan)) {

            echo null;


          } else {
            echo "$feedbackDate";

          }


          ?>" placeholder="No FeedBack Date">
        </div>
      </div>


      <h3 align='center'>Fitness Assessment Information</h3>
      <?php
      //query if for if statement and while loop only

      $recallMemberFitnessInformation = $mysqli->query("SELECT * FROM fitness
        WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId' AND unitName = '$findMember->unitName'");

        if ($recallMemberFitnessInformation->num_rows) {
          //($row = mysqli_fetch_array($result) > 1)


          echo "

          <div class=\"table-responsive\">
          <table class=\"table table-bordered\">

          <thead>
          <tr>
          <th scope=\"col\" style='width: auto'>Fitness Assessment Date</th>
          <th scope=\"col\" style='width: auto'>Run</th>
          <th scope=\"col\" style='width: auto'>Push-Ups</th>
          <th scope=\"col\" style='width: auto'>Situps</th>
          <th scope=\"col\" style='width: auto'>Waist</th>
          <th scope=\"col\" style='width: auto'>Type</th>
          <th scope=\"col\" style='width: auto'>Delete Record</th>

          </tr>
          </thead>
          ";
          while ($row = $recallMemberFitnessInformation->fetch_assoc()) {

            echo "<tbody>
            <tr>
            <td>" . $row['dueDate'] . "</td>
            <td>" . $row['run'] . "</td>
            <td>" . $row['pushUps'] . "</td>
            <td>" . $row['sitUps'] . "</td>
            <td>" . $row['waist'] . "</td>
            <td>" . $row['fitness_mockType'] . "</td>
            <td>";
            if ($row['fitness_mockType'] == "Mock Test") {

              echo "
              <form method='GET'> <p align='center'><a href='/UnitTraining/adminpages/deleteFitness.php?id=" . $row['id'] . "&lastName=" . $row['lastName'] . "' style='color:red' onclick='return confirmDelete(this);' > Delete Assessment </a></p></form>
              ";
            } else {

              echo '<p align="center">N/A</p>';

            }


            echo "  </td>
            </tr>
            </tbody>
            ";
          }

        } else {
        }


        echo "
        <div class='table-responsive-md'>
        <table class='table table-bordered'>
        <tbody>
        <thead class='thead-light' style='alignment: left'>
        <tr>
        <th scope=\"col\" style='width: auto'>Fitness Assessment Date</th>
        <th scope=\"col\" style='width: auto'>Run</th>
        <th scope=\"col\" style='width: auto'>Push-Ups</th>
        <th scope=\"col\" style='width: auto'>Situps</th>
        <th scope=\"col\" style='width: auto'>Waist</th>
        <th scope=\"col\" style='width: auto'>Type</th>
        </tr>
        </thead>

        <tr>
        <td style='alignment: left; width: auto' >
        <div class='col-md-12'>
        <input type='text' id='fitnessAssessmentDate' name='fitnessAssessmentDate' value='' class='form-control name_list'>
        </div>
        </td>
        <td>
        <div class='col-md-12'>
        <input type='text' id='inputRunning' name='inputRunning' value='' class='form-control name_list'>
        </div>
        </td>
        <td>
        <div class='col-md-12'>
        <input type='text' id='inputSitup' name='inputSitup' value='' class='form-control name_list'>
        </div>
        </td>
        <td>
        <div class='col-md-12'>
        <input type='text' id='inputPushup' name='inputPushup' placeholder='' class='form-control name_list'>
        </div>
        </td>
        <td>
        <div class='col-md-12'>
        <input type='text' id='inputWaist' name='inputWaist' placeholder='' class='form-control name_list'>
        </div>
        </td>
        <td>
        <div class='col-md-12'>
        <select class='form-control' id='inputFitnessType' name='inputFitnessType' title='inputFitnessType'>
        <option value=''></option>
        <option value='Mock Test' >Mock Test</option>
        <option value='Official Test' >Fitness Assessment</option>
        </select>
        </div>
        </td>


        </tbody>
        </table>
        </div>";


        ?>

      </div>
    </form>
  </div>


  <div class="container" align="center">
    <div class="form-group col-md-3" align="center">
      <form method="POST" enctype="multipart/form-data">
        Upload New Image:
        <input class="btn btn-md btn-secondary" type="file" name="file"/>

        <input class="btn btn-md btn-primary" type="submit" name="imgUploadNoImg" id="imgUploadNoImg"
        value="Update Member Photo">

      </form>
    </div>
  </div>


</body>
<footer>
  <!-- indluces closing html tags for body and html-->
