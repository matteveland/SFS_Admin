<?php


require_once __DIR__.'/../dbconfig/connect.php';
include __DIR__.'/../navigation.php';
include ('/var/services/web/sfs/Application/data.env');
//include ('/var/services/home/sfs/data.env');
date_default_timezone_set('America/Los_Angeles');

$unitName =  $_SESSION['unitName'];

if(!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))){
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> Please login to an Admin or User account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/UnitTraining/login_logout/splashpage.php'>Login</a></p>";
    exit;
}

if(isset($_SESSION['page_user'])){
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> You must be have an Admin account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/../../index.html'>Home Page</p>";
    exit;
}

/*
 * proved problematic if ESS needed to add someone
 * if (stristr($_SESSION['page_admin'], 'Unit') ==true) {
    echo "You cannot update your individual information. You are logged in as a Unit Administrator. Please contact your system administrator for assistance.";
    exit();

}*/

// If the values are posted, insert them into the database.
if (isset($_POST['inputFirstName']) && isset($_POST['inputLastName']) && ($unitName != "NULL")) {

    $firstName = mysqli_real_escape_string($connection, $_POST['inputFirstName']);
    $middleName = mysqli_real_escape_string($connection, $_POST['inputMiddleName']);
    $lastName = mysqli_real_escape_string($connection, $_POST['inputLastName']);
    $dodID = mysqli_real_escape_string($connection, $_POST['inputDODID']);

    $verifyNoPriorEntry = "select * From members where lastName = '$lastName' And firstName ='$firstName' AND dodID = '$dodID' AND unitName ='$unitName'";

    $resultsVerifyNoPrior = mysqli_query($connection, $verifyNoPriorEntry);

    if (mysqli_num_rows($resultsVerifyNoPrior)< 1){

        $lastFour = mysqli_real_escape_string($connection, $_POST['inputLastFour']);
        $deros = mysqli_real_escape_string($connection, $_POST['inputDEROS']);

        $rank = mysqli_real_escape_string($connection, $_POST['inputRankSelect']);
        $gender = mysqli_real_escape_string($connection, $_POST['inputGender']);

        $dutySection = mysqli_real_escape_string($connection, $_POST['inputDutySectionSelect']);
        $afsc = mysqli_real_escape_string($connection, $_POST['inputAFSC']);
        $admin = '';
        $supervisorRank = mysqli_real_escape_string($connection, $_POST['inputRankSupervisorRankSelect']);
        $supervisorLastName = mysqli_real_escape_string($connection, $_POST['inputSupervisorLastName']);
        $supervisorFirstName = mysqli_real_escape_string($connection, $_POST['inputSupervisorFirstName']);

        $homePhone = mysqli_real_escape_string($connection, $_POST['inputHomePhone']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);
        $cellPhone = mysqli_real_escape_string($connection, $_POST['inputCellPhone']);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
        $encryptedCellPhone = openssl_encrypt($cellPhone, $cipherMethod, $cellPhoneKey, $options=0, $iv);
        $encryptedHomePhone = openssl_encrypt($homePhone, $cipherMethod, $homePhoneKey, $options=0, $iv);

        $govEmail = mysqli_real_escape_string($connection, $_POST['inputGovEmail']);
        $prsnlEmail = mysqli_real_escape_string($connection, $_POST['inputPrsnlEmail']);

        $encryptedGovEmail = openssl_encrypt($cellPhone, $cipherMethod, $govEmail, $options=0, $iv);
        $encryptedPrsnlEmail = openssl_encrypt($cellPhone, $cipherMethod, $prsnlEmailKey, $options=0, $iv);

        $birthdate = mysqli_real_escape_string($connection, $_POST['inputBirthdate']);

        $encryptedbirthdate = openssl_encrypt($birthdate, $cipherMethod, $birthdateKey, $options=0, $iv);
        if (isset($_POST['emailOptIn']) === 'no')

        {
            $emailOptIn = 0;


        }else{

            $emailOptIn = 1;
        }

        $sqlMember = "INSERT INTO `members` (id, dodId, lastName, firstName, middleName, rank, dutySection, afsc, address, homePhone, cellPhone, family, birthdate, admin, govEmail, PrsnlEmail, image, imageDetail, unitName, gender, emailOpt_in, deletedBy, iv)
        VALUES (id, '$dodID', '$lastName', '$firstName', '$middleName', '$rank', '$dutySection', '$afsc', '$address', '$encryptedHomePhone', '$encryptedCellPhone', '', '$encryptedbirthdate', '$admin', '$encryptedGovEmail', '$encryptedPrsnlEmail', '0', '0', '$unitName', '$gender', '$emailOptIn', '','$iv')";

        $sqlArming = "INSERT INTO `armingRoster` (id, rank, lastName, firstName, middleName, lastFour, dodId, baton, useOfForce, lat, taser, m4Qual, m9Qual, m4Exp, m9Exp, smcFired, smcDue, m203Exp, m249Exp, m240Exp, m870Exp, unitName)
        VALUES (id, '$rank', '$lastName', '$firstName', '$middleName', '$lastFour','$dodID', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$unitName')
        ";
        /*
         *
         * removed SFMQ creation. this is no longer needed because SFMQ data can be added on an individual basis.
         *
         * $checkMemberSFMQ = "SELECT * FROM `sfmq` WHERE (lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName' AND rank = '$rank' AND unitName = '$unitName')
        VALUES (id, '$lastName', '$firstName', '$middleName', '$rank', '$deros', '$dodID', '$unitName')
        ";
        $resultscheckMemberSFMQ = mysqli_query($connection, $checkMemberSFMQ);


        if (!$resultscheckMemberSFMQ) {

            $sqlSFMQ = "INSERT INTO `sfmq`(id, rank, lastName, firstName, middleName, dutyQualPos, primCertDate, practical, written, verbal, reCertDate, phase2Start, newDutyQual, phase2End, qcNLT, nintyDayStart, deros, dodId, unitName, phase2_Cert)
            VALUES (id,'$rank','$lastName', '$firstName','$middleName','','','','','','','','','','','','','$dodID','$unitName','')
                        ";

            $resultSFMQ = mysqli_query($connection, $sqlSFMQ) or die(mysqli_error($connection));

        } else {

            $memberInSFMQDatabase = "Member is already in SFMQ database. Duplicate entry was not added.";

        }*/
//no need to add on import. There is an option to add within the update member section of the site.
        /*$sqlFitness = "INSERT INTO `fitness`(id, rank, lastName, firstName, middleName, pushUps , sitUps , run , waist , dodId , dueDate , unitName , fitness_mockType)
            VALUES (id, '$rank', '$lastName', '$firstName', '$middleName', '', '', '', '', '$dodID', '', '$unitName', '')
        ";*/
        $sqlSupList = "INSERT INTO `supList`(id , dodId , rank , firstName , middleName , lastName , superRank , supFirstName , supLastName , supDateBegin , feedbackCompleted , unitName)
      VALUES (id, '$dodID', '$rank', '$firstName', '$middleName', '$lastName', '$supervisorRank', '$supervisorFirstName', '$supervisorLastName', '', '', '$unitName')";

        /*$sqlLogin = "INSERT INTO `login` (id, lastName, firstName, middleName, dodId)
    VALUES ('id', '$lastName', '$firstName', '$middleName', '$dodID')";*/


        $familyName = count($_POST['familyName']);
        $familyBirthdate = count($_POST['familyBirthdate']);
        $familyGender = count($_POST['familyGender']);
        $familyRelationship = count($_POST['familyRelationship']);

        if ($familyName > 0) {
            for ($i = 0; $i < $familyName; $i++) {
                if (trim($_POST["familyName"][$i] != '')) {
                    $sql = "INSERT INTO `family` (id, dodId, fname, birthdate, gender, relationship, unitName) VALUES('id', '$dodID', '" . mysqli_real_escape_string($connection, $_POST["familyName"][$i]) . "', '" . mysqli_real_escape_string($connection, $_POST["familyBirthdate"][$i]) . "', '" . mysqli_real_escape_string($connection, $_POST["familyGender"][$i]) . "', '" . mysqli_real_escape_string($connection, $_POST["familyRelationship"][$i]) . "', '$unitName')";
                    mysqli_query($connection, $sql);
                }
            }
        }

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

        //$updateAdminRank = mysqli_query($connection, $updateAdminRank);
        /* $updateAdmin4 = mysqli_query($connection, $updateAdminMSgt);
         $updateAdmin5 = mysqli_query($connection, $updateAdminSMSgt);
         $updateAdmin6 = mysqli_query($connection, $updateAdminCMSgt);
         $updateAdmin7 = mysqli_query($connection, $updateAdmin2ndLt);
         $updateAdmin8 = mysqli_query($connection, $updateAdmin1stLt);
         $updateAdmin9 = mysqli_query($connection, $updateAdminCapt);
         $updateAdmin10 = mysqli_query($connection, $updateAdminMaj);
         $updateAdmin11 = mysqli_query($connection, $updateAdminLtCol);
         $updateAdmin12 = mysqli_query($connection, $updateAdminCol);*/

        $resultMember = mysqli_query($connection, $sqlMember) or die(mysqli_error($connection));
        $resultArming = mysqli_query($connection, $sqlArming);
        $resultFitness = mysqli_query($connection, $sqlFitness);
        $resultSupList = mysqli_query($connection, $sqlSupList) ;
        $updateResultsAdminRank = mysqli_query($connection, $updateAdminRank);
        $updateResultsUserRank = mysqli_query($connection, $updateUserRank);
        //$resultsLogin = mysqli_query($connection, $sqlLogin);

error_reporting(2);
        // $resultLogin = mysqli_query($connection, $sqlLogin);
//    $resultFamilyMember = mysqli_query($connection, $sqlFamilyMember);

        //AND $resultLogin

        if (($resultMember AND $resultArming /* AND $resultFitness*/ AND $resultSupList) == true) {
            $successmsg = "Member Successfully Added.";
        } else {
            $failuremsg = "Member Was Not Added - Please try again.";

        }

    }else {
        $failuremsg = "Member is already listed in database.";

    }

}elseif (isset($_POST['inputFirstName']) && isset($_POST['inputLastName']) && ($unitName = "NULL")) {
    $unitFailMsg = "Unit must be selected - Please try again.";

}


?>
    <html>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <head>
        <title>Register New Member</title>

    </head>
    <header>
    </header>
    <body>

    <div class="member_signin" >
        <div class="container">
            <form class="member-signin" method="POST">

                <br>
                <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
                <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>
                <?php if(isset($unitFailMsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $unitFailMsg; ?> </div><?php } ?>
                <?php if(isset($memberInSFMQDatabase)){ ?><div class="alert alert-secondary" role="alert"> <?php echo $memberInSFMQDatabase; ?> </div><?php } ?>
                <br>
                <H3 align = 'center'>Register New Member</H3>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputGender">Gender</label>

                        <select class="form-control" id="inputGender" name="inputGender" required>
                            <option value="">None</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>

                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputDODID">DoD ID Number</label>
                        <input type="text" class="form-control" id="inputDODID" name="inputDODID" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputLastFour">Last Four</label>
                        <input type="text" class="form-control" id="inputLastFour" name="inputLastFour" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputDEROS">DEROS</label>
                        <input type="text" class="form-control" id="inputDEROS" name="inputDEROS" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputBirthdate">Birth Date</label>
                        <input type="text" class="form-control" id="inputBirthdate" name="inputBirthdate" placeholder="YYYY-MM-DD" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="rankSelect">Rank</label>
                        <select class="form-control" id="inputRankSelect" name="inputRankSelect">
                            <option value="NULL">None</option>
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
                            <option value="Civ">Civ</option>

                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputFirstName">First Name</label>
                        <input type="text" class="form-control" id="inputFirstName"name="inputFirstName" value="" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputMiddleName">Middle Name</label>
                        <input type="text" class="form-control" name="inputMiddleName" id="inputMiddleName" value="" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" class="form-control" id="inputLastName" name="inputLastName" value="" placeholder=""required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputGovEmail">Government Email Address</label>
                        <input type="text" class="form-control" id="inputGovEmail" name="inputGovEmail" placeholder="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPrsnlEmail">Personal Email Address</label>
                        <input type="text" class="form-control" id="inputPrsnlEmail" name="inputPrsnlEmail" placeholder="" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lrg-10">



                            <label for="emailOptIn">Email Opt-In:</label> <br>
                            You <U><B>WILL NOT</B></U> receive emails from the Unit
                                <br>
                                Do you wish to start to receive <?php echo $unitName; ?> emails?
                                <br>
                                <br>
                                 <input type="radio" id="emailOptIn1" name="emailOptIn"  value="yes">
                                 <label for="emailOptIn">Yes</label>
                                 <br>
                                 <input type="radio" id="emailOptIn2" name="emailOptIn"  value="no">
                                 <label for="emailOptIn">No</label>

                            <br>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputDutySectionSelect">Duty Section</label>
                        <select class="form-control" id="inputDutySectionSelect" name="inputDutySectionSelect" title="dutySection" required>
                            <option  disabled selected value>Select Section</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="S3OA">S3OA</option>
                            <option value="S3OB">S3OB</option>
                            <option value="S3OC">S3OC</option>
                            <option value="S3OD">S3OD</option>
                            <option value="S3OE">S3OE</option>
                            <option value="S3OF">S3OF</option>
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



                    <div class="form-group col-md-3">
                        <label for="inputAFSC">AFSC</label>
                        <input type="text" class="form-control" id="inputAFSC" name="inputAFSC" value="" placeholder="" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputRankSupervisorRankSelect">Supervisor Rank</label>
                        <select class="form-control" id="inputRankSupervisorRankSelect" name="inputRankSupervisorRankSelect" title="rankSupervisor">
                            <option value="NULL">None</option>
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

                    <div class="form-group col-md-4">
                        <label for="inputSupervisorLastName">Supervisor Last Name</label>
                        <input type="text" class="form-control" id="inputSupervisorLastName" name="inputSupervisorLastName"placeholder="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputSupervisorFirstName">Supervisor First Name</label>
                        <input type="text" class="form-control" id="inputSupervisorFirstName" name="inputSupervisorFirstName" placeholder="" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputhomePhone">Home Phone</label>
                        <input type="text" class="form-control" id="inputhomePhone" name="inputHomePhone"  placeholder="" >
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputCellPhone">Cell Phone</label>
                        <input type="text" class="form-control" id="inputCellPhone" name="inputCellPhone"  placeholder="" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="table-responsive form-row">
                        <table class="table" id="dynamic_field">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Family Member Name</th>
                                <th scope="col">Family Member Birthdate</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Relationship</th>
                                <th scope="col">Remove</th>
                                <th scope="col">Add</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <div class="form-group col-md-4">
                                    <td>
                                        <input type="text" id="familyName" name="familyName[]" placeholder="" class="form-control name_list">
                                    </td>
                                </div>


                                <div class="form-group col-md-4">
                                    <td>
                                        <input type="text" id="familyBirthdate" name="familyBirthdate[]" placeholder="" class="form-control name_list">
                                    </td>
                                </div>


                                <div class="form-group col-md-4">
                                    <td>
                                        <select class="form-control" id="familyGender" name="familyGender[]">
                                            <option>....</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </td>
                                </div>

                                <div class="form-group col-md-4">
                                    <td>
                                        <select class="form-control" id="familyRelationship" name="familyRelationship[]">
                                            <option>....</option>
                                            <option>Spouse</option>
                                            <option>Child</option>
                                            <option>Other</option>
                                        </select>
                                    </td>
                                </div>
                                <div class="form-group col-md-4">
                                    <td>
                                        <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>
                                    </td>
                                </div>
                                <div class="form-group col-md-4">
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                                    </td>
                                </div>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <input align="center" class="btn btn-primary" type="submit" name="submit" id="submit" value="Add Member">
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            var i=1;
            $('#add').click(function(){

                $('#dynamic_field').append('<tr id="row'+i+'">' +
                    '<td><input type="text" id="familyName" name="familyName[]" class="form-control name_list"></td>' +
                    '<td><input type="text" id="familyBirthdate" name="familyBirthdate[]" class="form-control name_list"></td>' +
                    '<td><select class="form-control"id="familyGender" name="familyGender[]"><option>....</option><option>Male</option><option>Female</option></select></td>' +
                    '<td><select class="form-control" id="familyRelationship" name="familyRelationship[]"><option>....</option><option>Spouse</option><option>Child</option><option>Other</option></select></td> ' +
                    '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td> ' +
                    '<td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>' +
                    '</tr>');

            });
            $(document).on('click', '.btn_remove',

                function(){
                    var button_id = $(this).attr("id");
                    $('#row'+button_id+'').remove();
                });
        });
    </script>



    <br>
    </body>
    <br>
<footer>
<?php
if (isset($_SESSION['page_admin'])){



    echo "<p align='center'>Logged in as "; echo " ".$_SESSION['page_admin']." from the ".$_SESSION['unitName'].""; echo ". (Admin)<br> </p></footer>";
    /*$username = $_SESSION['username'];
    header("Location: login_success.php");
    echo "Hai " . $username . "
    ";
    echo "This is the Members Area
    ";
    echo "<a href='logout.php'>Logout</a>";*/




}elseif(isset($_SESSION['page_user'])) {
    echo "<div id='footer' <p id=\"footer\" align='center'>Logged in as "; echo "'".$_SESSION['page_user']."'.'from'.'".$_SESSION['unitName']."'"; echo ". (User)<br> </p><div>";



    //3.2 When the user visits the page first time, simple login form will be displayed.

} else {
    ?>

    </footer>
    </html>
<?php } ?>