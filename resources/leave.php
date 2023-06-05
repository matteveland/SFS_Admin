<?php


require __DIR__.'/dbconfig/connect.php';
include __DIR__.'/navigation.php';
//parse_str($_SERVER['QUERY_STRING']);
date_default_timezone_set('America/Los_Angeles');
$unitName = $_SESSION['unitName'];//parse_str($_SERVER['QUERY_STRING']);
if (stristr($_SESSION['page_admin'], 'Unit') ==true) {
    echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
    exit();

}
if(!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))){
    //Does not exist. Redirect user back to page-one.php
    echo "<p align='center'> Please login to an Admin or User account to view this page.</p>";
    echo "<p align='center'><a href='/UnitTraining/login_logout/splashpage.php'>Login</a></p>";
    exit;
}
$dodId = mysqli_real_escape_string($connection, $_POST['dodId']);
$lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
$firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
$middleName = mysqli_real_escape_string($connection, $_POST['middleName']);
$installation = mysqli_real_escape_string($connection, $_POST['locationState']);
$location = mysqli_real_escape_string($connection, $_POST['locationCity']);
$type = $_POST['type'];
$rank = $_POST['rank'];
$startDate =mysqli_real_escape_string($connection, $_POST['startDate']);
$dutySection = mysqli_real_escape_string($connection,$_POST['dutySection']);
$endDate = mysqli_real_escape_string($connection,$_POST['endDate']);

$now = date('Y-m-d H:i:s');

$admin = $_SESSION['page_admin'];
$user =  $_SESSION['page_user'];

$getUserName = "SELECT lastName, firstName FROM login WHERE (user_name = '$user')";

$resultsUser = mysqli_query($connection, $getUserName);

while ($row = mysqli_fetch_assoc($resultsUser)) {

    $recallAdmin_UserLastRecall = $row['lastName'];
    $recallAdmin_UserFirstRecall = $row['firstName'];
}

$getAdminName = "SELECT lastName, firstName FROM login WHERE (user_name = '$admin')";

$resultsAdmin = mysqli_query($connection, $getAdminName);

while ($row = mysqli_fetch_assoc($resultsAdmin)) {

    $recallAdmin_UserLastRecall = $row['lastName'];
    $recallAdmin_UserFirstRecall = $row['firstName'];
}

$addedBy = $recallAdmin_UserLastRecall . ', ' . $recallAdmin_UserFirstRecall;

$findLeave = "SELECT * FROM appointmentRoster
                          WHERE ((lastName ='$lastName' AND firstName = '$firstName') AND ((startdate BETWEEN '$startDate' AND '$endDate') OR (enddate BETWEEN '$startDate' AND '$endDate')))";


$resultFindLeave = mysqli_query($connection, $findLeave);

while ($row = mysqli_fetch_assoc($resultFindLeave)) {

    $recallRank = $row['rank'];
    $recallLastName = $row['lastName'];
    $recallFirstName = $row['firstName'];
    $recallTitleName = $row['title'];
    $recallStartDate = $row['startdate'];
    $recallStartTime = $row['appointmentTime'];
    $recallEndDate = $row['enddate'];
    $recallEndDateTime = $row['endTime'];
}

$leaveSQL = "INSERT INTO `appointmentRoster` (dodId, rank, email, firstName, middleName, lastName, title, installation, location, startdate, appointmentTime, selfMade, dutySection, enddate, addedBy, dateAdded, notes, endTime, unitName, overRide)
                          VALUES ('$dodId', '$rank', '$email', '$firstName', '$middleName', '$lastName', 'Leave', '$installation', '$location', '$startDate', '0000', '$selfMade', '$dutySection', '$endDate', '$addedBy', '$now', 'None','2400', '$unitName', 'Yes')
                          ";

$findLeave = "SELECT * FROM appointmentRoster
                          WHERE ((lastName ='$lastName' AND firstName = '$firstName') AND ((startdate BETWEEN '$startDate' AND '$endDate') OR (enddate BETWEEN '$startDate' AND '$endDate')))";

$resultFindLeave = mysqli_query($connection, $findLeave);
while ($row = mysqli_fetch_assoc($resultFindLeave)) {

    $recallRank = $row['rank'];
    $recallLastName = $row['lastName'];
    $recallFirstName = $row['firstName'];
    $recallTitleName = $row['title'];
    $recallStartDate = $row['startdate'];
    $recallStartTime = $row['appointmentTime'];
    $recallEndDate = $row['enddate'];
    $recallEndDateTime = $row['endTime'];
}

$deleteLeaveSql = "DELETE FROM `appointmentRoster`
    WHERE lastName = '$lastName' AND firstName = '$firstName' AND dodId = '$dodId' AND middleName = '$middleName' AND 
    rank = '$rank' AND  installation = '$installation' AND  location= '$location' AND startdate= '$startDate' AND enddate ='$endDate'
                ";

//$startDate = date('Y-m-d', $startDate);
//$endDate = date('Y-m-d', $endDate);

$findCBT = "SELECT * FROM cbtList799 c
                                      WHERE (lastName ='$lastName' AND firstName = '$firstName')
                                     AND (((c.dodCombatTrafficking BETWEEN '$startDate' AND '$endDate') 
                                        OR (c.cyberAwareness BETWEEN '$startDate' AND '$endDate')
                                        OR (c.fp BETWEEN '$startDate' AND '$endDate')
                                        OR (c.greenDotCurrent BETWEEN '$startDate' AND '$endDate')
                                        OR (c.greenDotNext BETWEEN '$startDate' AND '$endDate')
                                        OR (c.cbrnCBT BETWEEN '$startDate' AND '$endDate')
                                        OR (c.cbrnCBTPretest BETWEEN '$startDate' AND '$endDate')
                                        OR (c.noFEAR BETWEEN '$startDate' AND '$endDate')
                                        OR (c.afCIED BETWEEN '$startDate' AND '$endDate')
                                        OR (c.afCIED_Old BETWEEN '$startDate' AND '$endDate')
                                        OR (c.religiousFreedom BETWEEN '$startDate' AND '$endDate')
                                        OR (c.sabc BETWEEN '$startDate' AND '$endDate')
                                        OR (c.sabcHandsOn BETWEEN '$startDate' AND '$endDate')
                                        OR (c.loac BETWEEN '$startDate' AND '$endDate')
                                        OR (c.ems BETWEEN '$startDate' AND '$endDate')
                                        OR (c.blendedRetirement BETWEEN '$startDate' AND '$endDate'))
                                        
                                        OR
                                        
                                        ((c.dodCombatTrafficking = '') 
                                        OR (c.cyberAwareness = '')
                                        OR (c.fp = '')
                                        OR (c.greenDotCurrent = '')
                                        OR (c.greenDotNext = '')
                                        OR (c.cbrnCBT = '')
                                        OR (c.cbrnCBTPretest = '')
                                        OR (c.noFEAR <> '')
                                        OR (c.afCIED = '')
                                        OR (c.afCIED_Old = '')
                                        OR (c.religiousFreedom = '')
                                        OR (c.sabc = '')
                                        OR (c.sabcHandsOn = '')
                                        OR (c.loac = '')
                                        OR (c.ems = '')
                                        OR (c.blendedRetirement = ''))) ";

$resultFindCBT = mysqli_query($connection, $findCBT);

while ($row = mysqli_fetch_assoc($resultFindCBT)){

    $id = $row['id'];
    $trafficingDate =  $row["dodCombatTrafficking"];
    $cyberAwarenessDate =  $row["cyberAwareness"];
    $forceProDate =  $row["fp"];
    $greenDotCurrentDate =  $row["greenDotCurrent"];
    $greenDotNextDate =  $row["greenDotNext"];
    $cbrnCBTDate =  $row["cbrnCBT"];
    $cbrnCBTPretestDate =  $row["cbrnCBTPretest"];
    $noFEARDate =  $row["noFEAR"];
    $afCIEDDate =  $row["afCIED"];
    $afCIED_OldDate =  $row["afCIED_Old"];
    $religiousFreedomDate =  $row["religiousFreedom"];
    $sabcDate =  $row["sabc"];
    $sabcHandsOnDate =  $row["sabcHandsOn"];
    $loacDate =  $row["loac"];
    $emsDate =  $row["ems"];
    $blendedRetirementDate =  $row["blendedRetirement"];
}

//find other members on leave in the section
$findLeaveFromOthers = "SELECT * FROM appointmentRoster AS a 
WHERE a.title = 'Leave' and a.dutySection = '$dutySection' AND a.unitName = '$unitName' AND ((a.startdate BETWEEN '$startDate' AND '$endDate') OR (a.enddate BETWEEN '$startDate' AND '$endDate'))";

$resultFindLeaveFromOthers = mysqli_query($connection, $findLeaveFromOthers);
//count memebrs on leave in section
$countFindLeaveFromOthers = mysqli_num_rows($resultFindLeaveFromOthers);


//find number of members in section
$findFromOthers = "SELECT * FROM appointmentRoster
                                      WHERE (unitName = '$unitName' AND dutySection = '$dutySection')";
$resultFindOthers = mysqli_query($connection, $findFromOthers);
//count members in section
$countFindOthers = mysqli_num_rows($resultFindOthers);


//Admin overriding or double booking an appointment
if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['overRide']) && ((isset($_POST['rank']) != "") && (isset($_POST['dutySection']) != ""))) {

    if (isset($_POST['overRide'])) {
        $resultAppointment = mysqli_query($connection, $leaveSQL);
        $successmsgOverride = "$rank $firstName $lastName has been scheduled for Leave on $startDate to $endDate. (Admin approved override)";

    }else{

        $errormsgOverride = "$recallRank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (Admin, must Override or Delete)";

    }

}else{}

//Admin deleting an appointment
if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['delete']) && (isset($_POST['rank']) != "") && (isset($_POST['dutySection']) != "")) {

    if (mysqli_num_rows($resultFindLeave) > 0) {

        $resultAppointment = mysqli_query($connection, $deleteLeaveSql);

        $successmsgDelete = "Leave has been DELETED for $recallRank $firstName $lastName on $startDate to $endDate. (Admin deletion approved)";

    } else {
        $errormsgDelete = "$recallRank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (Admin, must Override or Delete)";

    }
}else{}


//member adding appointment
if ((isset($_POST['firstName']) && isset($_POST['lastName']) && !isset($_POST['delete']) && !isset($_POST['overRide']))) {

    $leaveSQL = "INSERT INTO `appointmentRoster` (dodId, rank, email, firstName, middleName, lastName, title, installation, location, startdate, appointmentTime, selfMade, dutySection, enddate, addedBy, dateAdded, notes, endTime, unitName, overRide)
                          VALUES ('$dodId', '$rank', '$email', '$firstName', '$middleName', '$lastName', 'Leave', '$installation', '$location', '$startDate', '0000', '$selfMade', '$dutySection', '$endDate', '$addedBy', '$now', 'None','2400', '$unitName', 'No')
                          ";
    //appointment finder
    if (($countFindLeaveFromOthers / $countFindOthers * 100) >= 10/100){

        if (mysqli_num_rows($resultFindLeaveFromOthers) > 0) {

            echo '<div class="alert alert-danger" align="center" role="alert">Leave cannot be scheduled. The following person(s) are on leave during the same time, causing the section to to have more than 10% of all assigned persons on leave.';

            while ($row = mysqli_fetch_assoc($resultFindLeaveFromOthers)) {

                $recallOthersFirstName = $row["firstName"];
                $recallOthersLastName = $row["lastName"];
                $recallOthersStartDate = $row["startdate"];
                $recallOthersEndDate = $row["enddate"];
                $recallOthersEndDate = $row["enddate"];

              echo '<p align="center">'.$recallOthersLastName.' '.$recallOthersFirstName.'. On leave from '.$recallOthersStartDate.' through '.$recallOthersEndDate.'';

            }
            echo '</div>';


        }
        } elseif (((mysqli_num_rows($resultFindLeave) > 0)) || (mysqli_num_rows($resultFindCBT) > 0)) {
        $CBTerrormsgUser = "$rank $lastName $firstName has CBT due between $startDate and $endDate. (User account logged in or Admin needs to override or delete)";

        //insert appointment
    } elseif ((mysqli_num_rows($resultFindLeave) > 0)) {
        $errormsgUser = "$rank $recallFirstName $recallLastName has $recallTitleName scheduled for $recallStartDate at $recallStartTime to $recallEndDateTime. (User account logged in or Admin needs to override or delete)";

        //cbt finder
    }else
     {
        $resultAppointment = mysqli_query($connection, $leaveSQLNoOverride);
        $successmsgUser = "$rank $firstName $lastName has been scheduled for Leave beginning $startDate through $endDate. (User, no override/no delete needed)";
    }
}else {}

?>

<html>
<head>
</head>
<body>

<div class="container">
      <form class="form-signin" method="POST">
          <?php if(isset($successmsgUser)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsgUser; ?> </div><?php } ?>
          <?php if(isset($successmsgDelete)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsgDelete; ?> </div><?php } ?>
          <?php if(isset($successmsgOverride)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsgOverride; ?> </div><?php } ?>
          <?php if(isset($errormsgOverride)){ ?><div class="alert alert-danger" role="alert"> <?php echo $errormsgOverride; ?> </div><?php } ?>
          <?php if(isset($errormsgDelete)){ ?><div class="alert alert-danger" role="alert"> <?php echo $errormsgDelete; ?> </div><?php } ?>
          <?php if(isset($errormsgUser)){ ?><div class="alert alert-danger" role="alert"> <?php echo $errormsgUser; ?> </div><?php } ?>
        
          <?php if(isset($CBTerrormsgUser)){ ?><div class="alert alert-danger" role="alert"> <?php echo "$CBTerrormsgUser"; ?> </div><?php } ?>
          <?php if(isset($selectRankSection)){ ?><div class="alert alert-danger" role="alert"> <?php echo $selectRankSection; ?> </div><?php } ?>
          <?php if(isset($selectDutySection)){ ?><div class="alert alert-danger" role="alert"> <?php echo $selectDutySection; ?> </div><?php } ?>

<h2 class="form-signin-heading">Please add leave</h2>

          <div class="form-row">
              <div class="form-group col-md-1.5">
                  <label for="dutySection">Duty Section</label>
                  <select class="form-control" id="dutySection" name="dutySection" title="dutySection" required>
                      <option value="">Select Section</option>
                      <option value="S1">S1</option>
                      <option value="S2">S2</option>
                      <option value="S3">S3</option>
                      <option value="S3OA">S3OA</option>
                      <option value="S3OB">S3OB</option>
                      <option value="S3OC">S3OC</option>
                      <option value="S3OD">S3OD</option>
                      <option value="S3K">S3OK</option>
                      <option value="S3T">S3T</option>
                      <option value="S4">S4</option>
                      <option value="S5">S5</option>
                      <option value="SFMQ">SFMQ</option>
                      <option value="CC">CC</option>
                      <option value="CCF">CCF</option>
                      <option value="SFM">SFM</option>
                  </select>
              </div>
          </div>

          <div class="form-row">
              <div class="form-group col-md-1.5">
                  <label for="rank">Rank</label>
                  <select class="form-control" id="rank" name="rank" title="rank" required>
                      <option value="">Select Rank</option>
                      <option value="AB">AB</option>
                      <option value="Amn">Amn</option>
                      <option value="A1C">A1C</option>
                      <option value="SrA">SrA</option>
                      <option value="SSgt">SSgt</option>
                      <option value="TSgt">TSgt</option>
                      <option value="MSgt">MSgt</option>
                      <option value="SMSgt">SMSgt</option>
                      <option value="CMSgt">CMCgt</option>
                      <option value="2nd Lt">2nd Lt</option>
                      <option value="1st Lt">1st Lt</option>
                      <option value="Capt">Capt</option>
                      <option value="Maj">Maj</option>
                      <option value="Lt Col">Lt Col</option>
                      <option value="Col">Col</option>
                  </select>
              </div>
          </div>

          <div class="form-row">
              <div class="form-group col-md-3">
                  <label for="dodId">DOD ID Number</label>
                  <input type="text" name="dodId" id="dodId" class="form-control" value=""placeholder="" required>
              </div>
              <div class="form-group col-md-3">
                  <label for="firstName">First Name</label>
                  <input type="text" name="firstName" id="firstName" class="form-control" value="" placeholder="" required>
              </div>
              <div class="form-group col-md-3">
                  <label for="middleName">Middle Name</label>
                  <input type="text" name="middleName" id="middleName" class="form-control" placeholder="" required>
              </div>
              <div class="form-group col-md-3">
                  <label for="LastName">Last Name</label>
                  <input type="text" name="lastName" id="lastName" class="form-control" placeholder="" required>
              </div>
          </div>


          <div class="form-row">
                      <div class="form-group col-md-3">
                          <label for="locationCityCity">City</label>
                          <input type="text" name="locationCity" id="locationCity" class="form-control" placeholder="" required>
                      </div>
                      <div class="form-group col-md-3">
                          <label for="locationState">State</label>
                          <input type="text" name="locationState" id="locationState" class="form-control" placeholder="" maxlength="30" required>
                      </div>

                      <div class="form-group col-md-3">
                          <label for="startDate">Start Date</label>
                          <input type="text" name="startDate" id="startDate" class="form-control" placeholder="YYYY-MM-DD" required>
                      </div>
                      <div class="form-group col-md-3">
                          <label for="endDate">End Date</label>
                          <input type="text" name="endDate" id="endDate" class="form-control" placeholder="YYYY-MM-DD" maxlength="30" required>
                      </div>
          </div>

            <div class="form-row">
                <?php if(isset($_SESSION['page_admin'])){
                    echo "
                            
                            <div class=\"form-group col-md-5\">
                                <label for=\"overRide\">Override appointment with leave</label>
                                <input type=\"checkbox\" name=\"overRide\" id=\"overRide\" class=\"form-control\" value=\"overRide\">
                            </div>
                            
                              <div class=\"form-group col-md-5\">
                    <label for=\"delete\">Delete Previous Leave</label>
                    <input type=\"checkbox\" name=\"delete\" id=\"delete\" class=\"form-control\" value=\"delete\">
                </div>
                            ";

                }elseif(isset($_SESSION['page_user'])){
                    echo "
                            <div class=\"form-group col-md-4\">
                                <label for=\"selfMade\">Self Made</label>
                                <input type=\"checkbox\" name=\"selfMade\" id=\"selfMade\" class=\"form-control\" value=\"Yes\">
                            </div>";

                }

                ?></div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Add Appointment</button>
            <br>

      </form>
</div>

<!-- indluces closing html tags for body and html-->
<!-- place below last </div> tag -- indluces closing html tags for body and html-->
<?php include __DIR__.'/footer.php';?>