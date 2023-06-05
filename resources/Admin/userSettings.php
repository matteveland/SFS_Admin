<?php


require_once __DIR__.'/../dbconfig/connect.php';
include __DIR__.'/../navigation.php';
include ('/var/services/web/sfs/Application/data.env');
include ('/Applications/MAMP/htdocs/data.env');
parse_str($_SERVER['QUERY_STRING'], $query);

$unitName = $_SESSION['unitName'];


/*
require('/Applications/MAMP/htdocs/UnitTraining/dbconfig/connect.php');
include('/Applications/MAMP/htdocs/UnitTraining/navigation.html');

*/

//parse_str($_SERVER['QUERY_STRING']);

if(isset($_SESSION['page_admin']) OR (isset($_SESSION['page_user']))) {

    $cipherMethod = "AES-256-CFB";

    $userSearch = "SELECT * From login l
inner JOIN members m
on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId
WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name";
    $resultUserSearch = mysqli_query($connection, $userSearch);

    while ($row = mysqli_fetch_assoc(($resultUserSearch))) {

        $recallUserLast = $row['lastName'];
        $recallUserFirst = $row['firstName'];
        $recallUserMiddle = $row['middleName'];
        $recallUserName = $row['user_name'];
        $recallUserRank = $row['rank'];
        $storedHashedPassword = $row['password'];
        $recalldodId = $row['dodId'];
        $recallIV = $row['iv'];
        $recallImageLink = $row['image'];
        $recallImageDetail = $row['imageDetail'];


    }

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


///user update section

    $verifyUserUpdate = "SELECT * From login l
inner JOIN members m
on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId
WHERE user_name = '" . $_SESSION['page_user'] . "' AND lastName ='" . $recallUserLast . "'";
    $resultsVerifyUserUpdate = mysqli_query($connection, $verifyUserUpdate);
    $resultsVerifyUserUpdate2 = mysqli_fetch_assoc($resultsVerifyUserUpdate);


    if ($_SESSION['page_admin'] == 'UnitRA') {
        echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
        exit();
    } elseif ($_SESSION['page_admin'] == 'UnitSFMQ') {
        echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
        exit();
    } elseif ($_SESSION['page_admin'] == 'UnitWORB') {
        echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
        exit();

    } elseif ($_SESSION['page_admin'] == 'Unit_ESS') {
        echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
        exit();
    }elseif ($resultUserSearch == true) {
        //Does not exist. Redirect user back to homepage


//include('fitnessFunction.php');


        /*query varibales are
        $last
        $first
        $rank

        $sqlRank = "SELECT * FROM members WHERE members.lastName = '$recallUserLast' AND members.firstName = '$recallUserFirst' AND rank = '$rank'";

        $result2 = mysqli_query($connection, $sqlRank);

        while ($row = mysqli_fetch_assoc(($result2))) {

            $recallUserRank = $row['rank'];
            $recallLast = $row['lastName'];
            $recallUserFirst = $row['firstName'];
            $recallUserMiddle = $row['middleName'];

        }*/


        $getMember = "SELECT members.* From members
                      WHERE members.lastName = '$recallUserLast' AND members.firstName = '$recallUserFirst' AND rank = '$recallUserRank' AND unitName = '$unitName'";

        $result2 = mysqli_query($connection, $getMember);

        while ($row = mysqli_fetch_assoc(($result2))) {


           $recalldodId = $row['dodId'];
            $fName = $row['firstName'];
            $mName = $row['middleName'];
            $lName = $row['lastName'];
            // $recallUserRank = $row['rank'];
            $recalldutySection = $row['dutySection'];
            $recallafsc = $row['afsc'];
            $recallAddress = $row['address'];
            $recallHomePhone = $row['homePhone'];
            $recallCellPhone = $row['cellPhone'];
            $recallBirthdate = $row['birthdate'];
            $recallGender = $row['gender'];
            $recallEmailOptIn = $row['emailOpt_In'];
            $recallGovEmail = $row['govEmail'];
            $recallPrsnlEmail = $row['PrsnlEmail'];
            $recallIV = $row['iv'];


            // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
            $decryptedBirthday = openssl_decrypt($recallBirthdate, $cipherMethod, $birthdateKey, $options = 0, $recallIV);
            $decryptedCellPhone = openssl_decrypt($recallCellPhone, $cipherMethod, $cellPhoneKey, $options = 0, $recallIV);
            $decryptedHomePhone = openssl_decrypt($recallHomePhone, $cipherMethod, $homePhoneKey, $options = 0, $recallIV);
            $decryptedGovEmail = openssl_decrypt($recallGovEmail, $cipherMethod, $govEmailKey, $options = 0, $recallIV);
            $decryptedPrsnlEmail = openssl_decrypt($recallPrsnlEmail, $cipherMethod, $prsnlEmailKey, $options = 0, $recallIV);

        }

        $getSFMQ = "SELECT * From sfmq
                      WHERE sfmq.lastName = '$recallUserLast' AND sfmq.firstName = '$recallUserFirst' AND rank = '$recallUserRank'";

        $resultSFMQ = mysqli_query($connection, $getSFMQ);

        while ($row = mysqli_fetch_assoc(($resultSFMQ))) {

            $recallDutyPostion = $row['dutyQualPos'];
            $recallPrimCertDate = $row['primCertDate'];
            $recallReCertDate = $row['reCertDate'];
            $recallPhaseIIStart = $row['phase2Start'];
            $recallPhaseIIEnd = $row['phase2End'];
            $recallNewDutyPostion = $row['newDutyQual'];
        }

        $getSupInfo = "select * From supList s
INNER JOIN members m
on m.lastName = s.lastName AND m.firstName = s.firstName
WHERE m.lastName = '$recallUserLast' AND m.firstName = '$recallUserFirst' AND m.rank = '$recallUserRank';
";
        $resultSuper = mysqli_query($connection, $getSupInfo);

        while ($row = mysqli_fetch_assoc(($resultSuper))) {

            $recallSupRank = $row['superRank'];
            $recallSupFirstName = $row['supFirstName'];
            $recallSupLastName = $row['supLastName'];
            $recallDateBegan = $row['supDateBegin'];
            $recallFeedback = $row['feedbackCompleted'];
            $recallMbrRank = $row['rank'];
        }

        $recallPhaseIIStartStrToTime = strtotime($recallPhaseIIStart);
        $phaseIIStartDate = strtotime('Y-m-d', $recallPhaseIIStartStrToTime);

        $phaseIIEndDate = date('Y-m-d', strtotime("$recallPhaseIIStart + 60 days"));

        $feedbackDate = date('Y-m-d', strtotime("$recallDateBegan + 180 days"));

        $currentDate = date_default_timezone_set("Europe/London");


# fitness test information
        $getFitness = "select * From fitness f
INNER JOIN members m
on (m.lastName = f.lastName AND m.firstName = f.firstName and m.rank=f.rank) OR (f.dodId = m.dodId)
WHERE m.lastName = '$recallUserLast' AND m.firstName = '$recallUserFirst' AND m.rank = '$recallUserRank';
";
        $resultFitness = mysqli_query($connection, $getFitness);

        while ($row = mysqli_fetch_assoc($resultFitness)) {

            #$recallFitnessFirstName = $row['firstName'];
            #$recallFitnessLastName = $row['lastName'];
            $recallPushUps = $row['pushUps'];
            $recallSitUps = $row['sitUps'];
            $recallWaist = $row['waist'];
            $recallrun = $row['run'];
            $recallMockDate = $row['mockDate'];
            $recallDueDate = $row['dueDate'];


        }
        //$_SESSION[$recallrun];
    }
    if (isset($_POST['update'])) {


        //$rankUpdate = mysqli_real_escape_string($connection, $_POST['inputRankSelect']);
        $firstName = mysqli_real_escape_string($connection, $_POST['inputFirstName']);
        $middleName = mysqli_real_escape_string($connection, $_POST['inputMiddleName']);
        $lastName = mysqli_real_escape_string($connection, $_POST['inputLastName']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);
        $emailOptInValue = mysqli_real_escape_string($connection, $_POST['emailOptIn']);
        //$emailOptOutValue = mysqli_real_escape_string($connection, $_POST['emailOptOut']);

        $cellPhone = mysqli_real_escape_string($connection, $_POST['inputCellPhone']);
        $homePhone = mysqli_real_escape_string($connection, $_POST['inputHomePhone']);

        //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
        $encryptedCellPhone = openssl_encrypt($cellPhone, $cipherMethod, $cellPhoneKey, $options = 0, $recallIV);
        $encryptedHomePhone = openssl_encrypt($homePhone, $cipherMethod, $homePhoneKey, $options = 0, $recallIV);

        $emailGov = mysqli_real_escape_string($connection, $_POST['inputGovEmail']);
        $emailPrsnl = mysqli_real_escape_string($connection, $_POST['inputPrsnlEmail']);
        $encryptedGovEmail = openssl_encrypt($emailGov, $cipherMethod, $govEmailKey, $options = 0, $recallIV);
        $encryptedPrsnlEmail = openssl_encrypt($emailPrsnl, $cipherMethod, $prsnlEmailKey, $options = 0, $recallIV);

        $sql = "UPDATE members SET lastName = '$lastName', firstName = '$firstName', middleName =  '$middleName', homePhone = '$encryptedHomePhone', cellPhone = '$encryptedCellPhone', govEmail = '$encryptedGovEmail', PrsnlEmail = '$encryptedPrsnlEmail'
           WHERE ((lastName = '$recallUserLast' AND firstName = '$recallUserFirst' AND middleName = '$recallUserMiddle') OR (dodId = '$recalldodId'))
            ";


        $resultUpdateMembersInformation = mysqli_query($connection, $sql);

        $emailOptInUpdate = "UPDATE members SET emailOpt_In = '$emailOptInValue'
           WHERE ((lastName = '$recallUserLast' AND firstName = '$recallUserFirst' AND middleName = '$recallUserMiddle') OR (dodId = '$recalldodId')) AND unitName = '$unitName'
            ";

        $resultsSqlEmailOptIn = mysqli_query($connection, $emailOptInUpdate);

        $sqlSFMQUpdateName = "Update sfmq set lastName = '$lastName', middleName = '$middleName', firstName = '$firstName' WHERE ((sfmq.lastName = '$recallUserLast' AND sfmq.firstName = '$recallUserFirst') or (sfmq.dodId = '$recalldodId'))";


        ##$sqlSFMQUpdate = "UPDATE sfmq SET dutyQualPos = '$dutyQual', phase2Start = '$phaseIIStartDate', newDutyQual = '$newDutyQualPhaseII', primCertDate = '$priCertDate', reCertDate = '$reCertDate'
##WHERE (lastName = '$recallUserLast' AND firstName = '$recallUserFirst' AND middleName = '$recallUserMiddle')";


        #$sqlDoDID = "UPDATE `cbtList` SET dodID = '$dodId' WHERE lastName = '$last' AND firstName = '$first'";
        $sqlSupUpdateName = "Update supList set lastName = '$recallUserLast', middleName = '$recallUserMiddle', firstName = '$recallUserFirst' WHERE (supList.lastName = '$recallUserLast' AND supList.firstName = '$recallUserFirst')";

        ##$sqlSupUpdate = "UPDATE supList SET dodId = '$dodId', superRank = '$supRank', supFirstName = '$supFirstName', supLastName = '$supLastName', supDateBegin = '$dateBegan', feedbackCompleted='$feedback'
##WHERE (lastName = '$recallUserLast' AND firstName = '$recallUserFirst' AND middleName = '$recallUserMiddle')";

        $updateLogin = "Update login set lastName = '$lastName', middleName = '$middleName', firstName = '$firstName' WHERE ((login.lastName = '$recallUserLast' AND login.firstName = '$recallUserFirst') OR  (dodId = '$recalldodId'))";
        $resultUpdateLogin = mysqli_query($connection, $updateLogin);

        /*$fitnessUpdate = "UPDATE fitness
    INNER JOIN members
        ON (fitness.lastName = members.lastName) AND (fitness.firstName = members.firstName)
    SET fitness.waist = '$waistUpdate', fitness.pushUps = '$pushUpUpdate', fitness.sitUps = '$situpUpdate', fitness.run = '$runUpdate', fitness.mockDate = '$mockUpdate', fitness.dueDate = '$dueDateUpdate'
    WHERE fitness.lastName = '$recallUserLast' AND fitness.firstName = '$recallUserFirst' AND fitness.rank = '$rank'
    ";
        $sqlFitnessUpdate = "UPDATE fitness SET waist = '$waistUpdate', pushUps = '$pushUpUpdate', sitUps = '$situpUpdate', run = '$runUpdate', fitness.mockDate = '$mockUpdate', fitness.dueDate = '$dueDateUpdate'
    WHERE (lastName = '$recallUserLast' AND firstName = '$recallUserFirst' AND middleName = '$recallUserMiddle')";*/


        $resultSFMQUpdateName = mysqli_query($connection, $sqlSFMQUpdateName);
        ## $resultSFMQUpdate = mysqli_query($connection, $sqlSFMQUpdate);
        //$resultSupUpdateName = mysqli_query($connection, $sqlSupUpdateName);
        //$resultsSup = mysqli_query($connection, $sqlSupUpdate);
        //$resultsFit = mysqli_query($connection, $fitnessUpdate);

        // $resultsFit2 = mysqli_query($connection, $sqlFitnessUpdate);

        if (($resultUpdateMembersInformation /*AND $resultSFMQUpdateName  AND $resultSFMQUpdate AND $resultsSup AND $resultsFit  AND $resultSupUpdateName AND $resultsFit2*/) == true) {

            $successmsg = "Member Successfully Updated.";

            // $location = "/UnitTraining/adminpages/userSettings.php";


            // echo '<meta http-equiv="refresh" content="0; url='.$location.'">';

            echo "<meta http-equiv='refresh' content='0'>";

        } else {
            $failuremsg = "Member Was Not Updated - Please try again.";

        }


    }
}else{
    //Does not exist. Redirect user back to page-one.php
    echo "<h3 align='center'>You must login to view this page</h3><br>
           <p align='center'><a class=\"btn btn-md btn-primary\" href=\"/UnitTraining/login_logout/slpashpage.php\"'>Please login</a></p>";
    exit;
}


//$selfupdate = $_SESSION['page_user'];


?>


    <html>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>



    <head>


        <title>User Settings</title>

    </head>
    <body>

    <?php

    echo "<h1 align='center'>User Settings - $recallUserRank $recallUserLast, $recallUserFirst </h1>";?>



    <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
    <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>
    <?php if(isset($errorMessage)){ ?><div class="alert alert-danger" role="alert"> <?php echo $errorMessage; ?> </div><?php } ?>


    <?php

    if ($recallImageDetail == '1'){

        echo '<div class="row">
              <div class="container" align="">
              <p align="center"><img class="square" src=\'/UnitTraining/adminpages/' . $recallImageLink . '\' style="width: 200px; height: 200px"></p>

                <div>
         </div>';

    }else {
        $defaultImagePath = "/UnitTraining/adminpages/uploads/default.jpeg";
        echo '<div class="row">
            <div class="container">
            <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '">
             <img class="rounded-circle" src=\'' . $defaultImagePath . '\' style="width: 200px; height: 200px;">
             </a>
            </div>
          </div>';
    }
    ?>
    <!--Member update-->


    <div class="member_update">
        <div class="container">
            <form class="member-update" method="post" ">
            <br>
            <div align="center"> <input class="btn btn-md btn-danger" type="submit" name="cancel" id="cancel" value="cancel">
                <input class="btn btn-md btn-primary" type="submit" name="update" id="update" value="Update Member">
                <br>
                <br>

                <a class="btn btn-md btn-secondary" href="/UnitTraining/appointments.php"role="button">Add Appointment</a>
                <a class="btn btn-md btn-secondary" href="/UnitTraining/leave.php" role="button">Add Leave</a>


            </div>
            <br>

            <h2 align="center">Personal Information</h2>
            <br>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="recallGender"><B>Gender</B></label>
                    <br>
                    <?php echo "$recallGender"; ?>

                </div>


                <!--<div class="form-group col-md-2">
                    <label for="inputRankSelect"><B>Rank</B></label>
                    <select class="form-control" id="inputRankSelect" name="inputRankSelect" title="inputRankSelect">
                        <option value="AB" <?php if($recallUserRank=="AB") echo "selected"; ?> >AB</option>
                        <option value="Amn" <?php if($recallUserRank=="Amn") echo "selected"; ?> >AMN</option>
                        <option value="A1C" <?php if($recallUserRank=="A1C") echo "selected"; ?> >A1C</option>
                        <option value="SrA" <?php if($recallUserRank=="SrA") echo "selected"; ?> >SrA</option>
                        <option value="SSgt" <?php if($recallUserRank=="SSgt") echo "selected"; ?> >SSgt</option>
                        <option value="TSgt" <?php if($recallUserRank=="TSgt") echo "selected"; ?> >TSgt</option>
                        <option value="MSgt" <?php if($recallUserRank=="MSgt") echo "selected"; ?> >MSgt</option>
                        <option value="SMSgt" <?php if($recallUserRank=="SMSgt") echo "selected"; ?> >SMSgt</option>>
                        <option value="CMSgt" <?php if($recallUserRank=="CMSgt") echo "selected"; ?> >CMSgt</option>
                        <option value="2nd Lt" <?php if($recallUserRank=="2nd Lt") echo "selected"; ?> >2nd Lt</option>
                        <option value="1st Lt" <?php if($recallUserRank=="1st Lt") echo "selected"; ?> >1st Lt</option>
                        <option value="Capt" <?php if($recallUserRank=="Capt") echo "selected"; ?> >Capt</option>
                        <option value="Maj" <?php if($recallUserRank=="Maj") echo "selected"; ?> >Maj</option>
                        <option value="Lt Col" <?php if($recallUserRank=="Lt Col") echo "selected"; ?> >Lt Col</option>
                        <option value="Col" <?php if($recallUserRank=="Col") echo "selected"; ?> >Col</option>
                    </select>
                </div>-->

                <div class="form-group col-md-3">
                    <label for="inputFirstName"><B>First Name</B></label>
                    <input type="text" class="form-control" id="inputFirstName"name="inputFirstName" value="<?php echo "$fName"; ?>" placeholder="First Name" >
                </div>

                <div class="form-group col-md-2">
                    <label for="inputMiddleName"><B>Middle Name</B></label>
                    <input type="text" class="form-control" name="inputMiddleName" id="inputMiddleName" value="<?php echo "$mName"; ?>" placeholder="Middle Name">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputLastName"><B>Last Name</B></label>
                    <input type="text" class="form-control" id="inputLastName" name="inputLastName" value="<?php echo "$lName"; ?>" placeholder="Last Name" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputBirthdate"><B>Birth Date</B></label>
                    <br>
                    <?php echo "$decryptedBirthday"; ?>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputDODID"><B>DoD ID Number</B></label>
                    <br>
                    <?php echo "$recalldodId"; ?>
                </div>
            </div>

            <div class="form-row">
                <!--<div class="form-group col-md-4">
                    <textarea name="address" value="" placeholder="address"><?php echo "$recallAddress"; ?></textarea>
                </div>-->

                <div class="form-group col-md-3">
                    <label for="inputhomePhone"><B>Home Phone</B></label>
                    <input type="text" class="form-control" id="inputHomePhone" name="inputHomePhone" value="<?php echo "$decryptedHomePhone"; ?>" placeholder="Home Phone">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputCellPhone"><b>Cell Phone</b></label>
                    <input type="text" class="form-control" id="inputCellPhone" name="inputCellPhone" value="<?php echo "$decryptedCellPhone"; ?>" placeholder="Cell Phone">
                </div>
            </div>

            <div class="form-row">
                <!--<div class="form-group col-md-4">
                    <textarea name="address" value="" placeholder="address"><?php echo "$recallAddress"; ?></textarea>
                </div>-->

                <div class="form-row">
                    <div class="form-group col-lrg-10">



                        <label for="emailOptInOut"><B>Email Opt-In:</B></label> <br>


                        <?php

                        if ($recallEmailOptIn == '1'){
                            echo "You <U><B>WILL</B></U> receive emails from your Unit.

                                     Do you wish to continue to receive ".$unitName." emails?
                                     <br>
                                <br>
                                 <div class=\"form-group col-md-3\">

                    <select class='form-control' id='emailOptIn' name='emailOptIn' title='emailOptIn'>
                        <option value='1'";  if($recallEmailOptIn=='1') echo "selected"; echo ">Yes</option>
                        <option value='0'"; if($recallEmailOptIn=='0') echo "selected"; echo ">No</option>

                    </select>
                </div>";

                        }else{
                            echo "You <U><B>WILL NOT</B></U> receive emails from your Unit.

                                     Do you wish to begin to receive ".$unitName." emails?
                                     <br>
                                <br>
                                 <div class=\"form-group col-md-3\">

                    <select class='form-control' id='emailOptIn' name='emailOptIn' title='emailOptIn'>
                        <option value='1'";  if($recallEmailOptIn=='1') echo "selected"; echo ">Yes</option>
                        <option value='0'"; if($recallEmailOptIn=='0') echo "selected"; echo ">No</option>

                    </select>
                </div>";
                        }


                        ?>
                        <br>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputGovEmail"><B>Government Email Address</B></label>
                    <input type="email" class="form-control" id="inputGovEmail" name="inputGovEmail" value="<?php echo "$decryptedGovEmail"; ?>" placeholder="Government Email Address">

                </div>

                <div class="form-group col-md-6">
                    <label for="inputPrsnlEmail"><B>Personal Email Address</B></label>
                    <input type="email" class="form-control" id="inputPrsnlEmail" name="inputPrsnlEmail" value="<?php echo "$decryptedPrsnlEmail"; ?>" placeholder="Personal Email Address">

                </div>
            </div>







        </div>
        <!--

               do not display family information until the rows can be added.

               <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputFamilyInfo">Family Information</label>
                        <textarea type="text" class="form-control" id="inputFamilyInfo" name="inputFamilyInfo" value="<?php echo "$recallFamily"; ?>" placeholder="Family Information"></textarea>
                    </div>
                </div>


                <h3>Family Information</h3><br>
                <textarea id="family" name="family" placeholder="Family Information, Spouse, Children"><?php echo "$recallFamily"; ?></textarea>

                    <h3 align="center">Family Details</h3>


                    <!-- <input align="center" class="btn" type="submit" name="submit" id="submit" value="Add Member">-->

        <!-- </div>-->







        <!--<h3 align="center">Duty Information</h3>



            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputDutySectionSelect">Duty Section</label>
                    <select class="form-control" id="inputDutySectionSelect" name="inputDutySectionSelect" title="inputDutySectionSelect">
                        <option value="S1" <?php if($recalldutySection=="S1") echo "selected"; ?> >S1</option>
                        <option value="S2" <?php if($recalldutySection=="S2") echo "selected"; ?> >S2</option>
                        <option value="S3" <?php if($recalldutySection=="S3") echo "selected"; ?> >S3</option>
                        <option value="S3OA" <?php if($recalldutySection=="S3OA") echo "selected"; ?> >S3OA</option>
                        <option value="S3OB" <?php if($recalldutySection=="S3OB") echo "selected"; ?> >S3OB</option>
                        <option value="S3OC" <?php if($recalldutySection=="S3OC") echo "selected"; ?> >S3OC</option>
                        <option value="S3OD" <?php if($recalldutySection=="S3OD") echo "selected"; ?> >S30D</option>
                        <option value="S3K" <?php if($recalldutySection=="S3K") echo "selected"; ?> >S3K</option>
                        <option value="S3T" <?php if($recalldutySection=="S3T") echo "selected"; ?> >S3T</option>
                        <option value="S4" <?php if($recalldutySection=="S4") echo "selected"; ?> >S4</option>
                        <option value="S5" <?php if($recalldutySection=="S5") echo "selected"; ?> >S5</option>
                        <option value="SFMQ" <?php if($recalldutySection=="SFMQ") echo "selected"; ?> >SFMQ</option>
                        <option value="CC" <?php if($recalldutySection=="CC") echo "selected"; ?> >CC</option>
                        <option value="CCF" <?php if($recalldutySection=="CCF") echo "selected"; ?> >CCF</option>
                        <option value="SFM" <?php if($recalldutySection=="SFM") echo "selected"; ?> >SFM</option>
                    </select>
                </div>
            </div>

            <h3 align="center">Certified Phase II Information</h3>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputDutyPositionSelect">Duty Position</label>
                    <select class="form-control" id="inputDutyPositionSelect" name="inputDutyPositionSelect" title="inputDutyPositionSelect">
                        <option value="" <?php if($recallDutyPostion=='') echo "selected"; ?>>NONE</option>
                        <option value="RFM" <?php if($recallDutyPostion=="RFM") echo "selected"; ?> >RFM</option>
                        <option value="RFL" <?php if($recallDutyPostion=="RFL") echo "selected"; ?> >RFL</option>
                        <option value="BDOC" <?php if($recallDutyPostion=="BDOC") echo "selected"; ?> >BDOC</option>
                        <option value="FC" <?php if($recallDutyPostion=="FC") echo "selected"; ?> >FC</option>
                        <option value="Armory" <?php if($recallDutyPostion=="Armory") echo "selected"; ?> >Armory</option>
                        <option value="RFL/AR" <?php if($recallDutyPostion=="RFL/AR") echo "selected"; ?> >RFL/AR</option>
                    </select>
                </div>





                <div class="form-group col-md-3">
                    <label for="inputPrimCertDate">Primary Certification Date</label>
                    <input type="text" class="form-control" id="inputPrimCertDate" name="inputPrimCertDate" value="<?php if (isset($recallPrimCertDate) OR (NULL) OR is_nan(!1970-01-01 ) ) { echo "$recallPrimCertDate"; }
        else{
            echo "$recallPrimCertDate";
        }?>" placeholder="Certificatoin Date">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputReCertDate">Primary Certification Date</label>
                    <input type="text" class="form-control" id="inputReCertDate" name="inputReCertDate" value="<?php if (isset($recallReCertDate) OR (NULL) OR is_nan(!1970-01-01 ) ) { echo ""; }
        else{
            echo "$recallReCertDate";
        }?>" placeholder="Re-Certification Date">
                </div>




            </div>

            <br>
            <h3 align="center">Upgrade Phase II Information</h3>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputPhaseIISelect">Phase II Information</label>
                    <select class="form-control" id="inputPhaseIISelect" name="inputPhaseIISelect" title="inputPhaseIISelect">
                        <option value=""<?php if($recallNewDutyPostion=='NULL') echo "selected"; ?> >NONE</option>
                        <option value="RFM" <?php if($recallNewDutyPostion=="RFM") echo "selected"; ?> >RFM</option>
                        <option value="RFL" <?php if($recallNewDutyPostion=="RFL") echo "selected"; ?> >RFL</option>
                        <option value="BDOC" <?php if($recallNewDutyPostion=="BDOC") echo "selected"; ?> >BDOC</option>
                        <option value="FC" <?php if($recallNewDutyPostion=="FC") echo "selected"; ?> >FC</option>
                        <option value="Armory" <?php if($recallNewDutyPostion=="Armory") echo "selected"; ?> >Armory</option>
                        <option value="RFL/AR" <?php if($recallNewDutyPostion=="RFL/AR") echo "selected"; ?> >RFL/AR</option>
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label for="inputPhaseIIStart">Phase II Start Date</label>
                    <input type="text" class="form-control" id="inputPhaseIIStart" name="inputPhaseIIStart" value="<?php if (isset($recallPhaseIIStart) OR (NULL) OR is_nan(!1970-01-01 ) ) { echo "$recallPhaseIIStart"; }
        else{
            echo "$recallPhaseIIStart";
        }?>" placeholder="Phase II Start">
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPhaseIIEnd">Phase II End Date</label>
                    <input type="text" class="form-control" id="inputPhaseIIEnd" name="inputPhaseIIEnd" value="<?php if (!empty($recallPhaseIIStart) OR ($recallPhaseIIStart=!'1970-01-01' )) {

            echo "$phaseIIEndDate";

        } else {

            echo null;
        }


        ?>" placeholder="Phase II End">
                </div>
            </div>
            <br>
            <h3 align="center">Supervisor Information</h3>
            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="inputSuperRankOption">Supervisor Rank</label>
                    <select class="form-control" id="inputSuperRankOption" name="inputSuperRankOption" title="inputSuperRankOption">
                        <option value="" <?php if ($recallSupRank=='') echo "selected"; ?>>NONE</option>
                        <option value="AB" <?php if($recallSupRank=="AB") echo "selected"; ?> >AB</option>
                        <option value="AMN" <?php if($recallSupRank=="AMN") echo "selected"; ?> >AMN</option>
                        <option value="A1C" <?php if($recallSupRank=="A1C") echo "selected"; ?> >A1C</option>
                        <option value="SrA" <?php if($recallSupRank=="SrA") echo "selected"; ?> >SrA</option>
                        <option value="SSgt" <?php if($recallSupRank=="SSgt") echo "selected"; ?> >SSgt</option>
                        <option value="TSgt" <?php if($recallSupRank=="TSgt") echo "selected"; ?> >TSgt</option>
                        <option value="MSgt" <?php if($recallSupRank=="MSgt") echo "selected"; ?> >MSgt</option>
                        <option value="SMSgt" <?php if($recallSupRank=="SMSgt") echo "selected"; ?> >SMSgt</option>>
                        <option value="CMSgt" <?php if($recallSupRank=="CMSgt") echo "selected"; ?> >CMSgt</option>
                        <option value="2nd Lt" <?php if($recallSupRank=="2nd Lt") echo "selected"; ?> >2nd Lt</option>
                        <option value="1st Lt" <?php if($recallSupRank=="1st Lt") echo "selected"; ?> >1st Lt</option>
                        <option value="Capt" <?php if($recallSupRank=="Capt") echo "selected"; ?> >Capt</option>
                        <option value="Maj" <?php if($recallSupRank=="Maj") echo "selected"; ?> >Maj</option>
                        <option value="Lt Col" <?php if($recallSupRank=="Lt Col") echo "selected"; ?> >Lt Col</option>
                        <option value="Col" <?php if($recallSupRank=="Col") echo "selected"; ?> >Col</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputSupervisorsFirst">First Name</label>
                    <input type="text" class="form-control" id="inputSupervisorsFirst" name="inputSupervisorsFirst" value="<?php echo "$recallSupFirstName"; ?>"  placeholder="Supervisor Frist Name">
                </div>

                <div class="form-group col-md-4">
                    <label for="inputSupervisorsLast">Last Name</label>
                    <input type="text" class="form-control" id="inputSupervisorsLast" name="inputSupervisorsLast" value="<?php echo "$recallSupLastName"; ?>"  placeholder="Supervisor's Last Name">
                </div>

                <div class="form-group col-md-5">
                    <label for="inputSupervisonBegan">Supervison Began</label>
                    <input type="text" class="form-control" id="inputSupervisonBegan" name="inputSupervisonBegan" value="<?php echo "$recallDateBegan"; ?>" placeholder="Supervision Began">
                </div>



                <div class="form-group col-md-5">
                    <label for="inputFeedbackDate">Feedback Date</label>
                    <input type="text" class="form-control" id="inputFeedbackDate" name="inputFeedbackDate" value="<?php if (empty($recallDateBegan)) {

            echo null;


        } else {
            echo "$feedbackDate";

        }


        ?>" placeholder="No FeedBack Date">
                </div>
            </div>






            <br>
            <h3 align="center">Fitness Assessment Information</h3>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputMockDate">Mock Fitness Assessment Date</label>

                    <input type="text" class="form-control" id="inputMockDate" name="inputMockDate" value="<?php if (empty($recallMockDate)) {
            echo null;
        } else {
            echo "$recallMockDate";
        }
        ?>" placeholder="Mock Date">
                </div>




                <div class="form-group col-md-6">
                    <label for="inputFitnessDate">Fitness Assessment Date</label>
                    <input type="text" class="form-control" id="inputFitnessDate" name="inputFitnessDate" value="<?php if (empty($recallDueDate)) {

            echo null;
        } else {
            echo "$recallDueDate";

        }

        ?>" placeholder="Due Date">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputRunning">Running Time</label>

                    <input type="text" class="form-control" id="inputRunning" name="inputRunning" value="<?php if (empty($recallrun)) {
            echo null;
        } else {
            echo "$recallrun";
        }
        ?>" placeholder="Running Score">
                </div>




                <div class="form-group col-md-3">
                    <label for="inputSitup">Sit Up Score</label>
                    <input type="text" class="form-control" id="inputSitup" name="inputSitup" value="<?php if (empty($recallSitUps)) {

            echo null;
        } else {
            echo "$recallSitUps";

        }

        ?>" placeholder="Sit Up Score">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPushup">Push Up Score</label>
                    <input type="text" class="form-control" id="inputPushup" name="inputPushup" value="<?php if (empty($recallPushUps)) {

            echo null;
        } else {
            echo "$recallPushUps";

        }

        ?>" placeholder="Sit Up Score">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputWaist">Waist Score</label>
                    <input type="text" class="form-control" id="inputWaist" name="inputWaist" value="<?php if (empty($recallWaist)) {

            echo null;
        } else {
            echo "$recallWaist";

        }

        ?>" placeholder="Sit Up Score">
                </div>-->

    </div>
    </form>
    </div>
    <div class="container">
        <form class="form-signin" method="POST" action="">


            <h2 align='center' class="form-signin-heading">Change User Password</h2>
            <p>Current Password</p>
            <input type="password" name="CurrentPasswordVerify" id="CurrentPasswordVerify" class="form-control" placeholder="Current Password" required>

            <br>
            <p>New Password</p>
            <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            <input type="password" name="newPasswordVerify" id="newPasswordVerify" class="form-control" placeholder="New Password" required>


            </br>

            <button class="btn btn-lg btn-success btn-block" name="passwordChange" id="passwordChange" type="submit">Change User Password</button>

            <br>

        </form>


    </div>
    </div>

    </body>
    <footer>
        <!-- indluces closing html tags for body and html-->
        <?php include __DIR__.'/../footer.php';?>
