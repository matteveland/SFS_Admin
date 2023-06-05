<?php


require_once __DIR__.'/../dbconfig/connect.php';
include __DIR__.'/../navigation.php';
include ('/var/services/web/sfs/Application/data.env');
/*


if(!isset($_SESSION['page_admin'])){
    //Does not exist. Redirect user back to page-one.php
    header('Location: home.php');
    exit;
}*/
//Check to see if session variable exists.

    // If the values are posted, insert them into the database.
$rankLeader = 'TSgt' OR 'MSgt' OR 'SMSgt' OR 'CMSgt' OR '2nd Lt' OR '1st Lt' OR 'Capt' OR 'Maj' OR 'Lt Col' OR 'Col';
$rankSub = 'AB' OR 'Amn' OR 'A1C' OR 'SrA' OR 'SSgt';

$lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
$firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
$middleName = mysqli_real_escape_string($connection, $_POST['middleName']);


if (isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] != $_POST['verifyPassword'])) {

        echo "<script type=\"text/javascript\">
							alert(\"Passwords do not match.\");
						
						  </script>";

    }elseif(isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] == $_POST['verifyPassword'])) {


    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    //$lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
    //$firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    //$middleName = mysqli_real_escape_string($connection, $_POST['middleName']);
    $TAFMSD = mysqli_real_escape_string($connection, $_POST['TAFMSD']);
    $rank = $_POST['rank'];
    $admin = $_POST['admin'];
    $user = $_POST['user'];
    $dodId = $_POST['dodId'];

    $dutySection = $_POST['dutySection'];


    $queryMembers = "Select members.lastName, members.middleName, members.firstName, members.rank
                        from members
                        where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName')
                        AND (members.rank = '$rank')
                        ";
    $resultVerify = mysqli_query($connection, $queryMembers);

    /* $sqlRank = "SELECT members.rank FROM members WHERE members.lastName = '$lastName' AND members.firstName = '$firstName' AND middleName = '$middleName'";

   $result2 = mysqli_query($connection, $sqlRank);

    while ($row = mysqli_fetch_assoc(($result2))) {

        $recallRank = $row['rank'];

    }*/


    $queryDupes = "Select login.lastName, login.firstName, login.middleName, login.emailAddress, login.user_name
                      from login
                      WHERE ((lastName = '$lastName') AND (firstName = '$firstName') AND (middleName = '$middleName')) AND ((user_name = '$username') OR (emailAddress = '$email'))";

    $resultDupesAdmin = mysqli_query($connection, $queryDupes);

    $queryCreate = "INSERT INTO `login` (user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, dodId) VALUES ('$username', '$password', '$email', '$lastName', '$firstName', '$middleName', '$TAFMSD', '$admin', '$user', '$dodId')";

    //$resultCreate = mysqli_query($connection, $queryCreate);


    if (mysqli_num_rows($resultDupesAdmin) > 0) {

        echo "<script type=\"text/javascript\">
							alert(\"Member's name is already in database. (Duplication Error)\");
					
						
						  </script>";

        trigger_error("Member already registered as Admin.");


    } elseif (mysqli_num_rows($resultVerify) >= 0) {

        $sqlRank = "SELECT members.rank
                    FROM members
                    WHERE members.lastName = '$lastName' AND members.firstName = '$firstName' AND middleName = '$middleName'";

        $result2 = mysqli_query($connection, $sqlRank);

        while ($row = mysqli_fetch_assoc(($result2))) {

            $recallRank = $row['rank'];
        }

        if (($recallRank == $rankLeader) AND ($admin = true)) {

            $resultCreate = mysqli_query($connection, $queryCreate);

            $successmsg1 = "Administration Account Created Successfully.";

        }


    } elseif (mysqli_num_rows($resultVerify) >= 0) {

        if (($user = true)) {

            $resultCreate = mysqli_query($connection, $queryCreate);

            $successmsg2 = "User Account Created Successfully.";
        }else{}

    } else {

        echo "<script type=\"text/javascript\">
							alert(\"Member does not exist in Members Database. Please register Member.\");

						  </script>";
        $failuremsg = "User Registration Failed.";

        echo "<script type=\"text/javascript\">
							alert(\"Member does not have permissions to have admin account.\");

						  </script>";
    }

}


?>



<html>
<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



</head>
<body>

<div class="container">
      <form class="form-signin" method="POST">
            
            <?php if(isset($successmsg1)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg1; ?> </div><?php } ?>
          <?php if(isset($successmsg2)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg2; ?> </div><?php } ?>

          <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>

        <h2 class="form-signin-heading">Please register for admin account</h2>

          <label>Duty Section</label>
          <select name="dutySection" title="dutySection">
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
          <br>
            <label>Rank</label>
            <select name="rank" title="rank">
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
          <input type="text" name="dodId" id="dodId" class="form-control" value=""placeholder="DoD ID Number" required autofocus>

                <input type="text" name="firstName" id="firstName" class="form-control" value=""placeholder="First Name" required autofocus>
                <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Middle Name" required>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" required>
                <input type="text" name="TAFMSD" id="TAFMSD" class="form-control" placeholder="TAFMSD or TAFMSC (DD-MMM-YY)" required>
            <br>
          <br>


            <div>
	            <input type="text" name="username" class="form-control" placeholder="Username" required>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" maxlength="30"required>
                <input type="password" name="verifyPassword" id="inputPassword" class="form-control" placeholder="Verify Password" maxlength="30" required>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required>
            </div>

      <!--  <label for="inputBirthdate" class="sr-only">Birthdate</label>
        <input type="date" name="birthdate" id="inputbirthdate" class="form-control" placeholder="Birthdate" required>
        
       
        <div class="tandc">
        <input type="checkbox" name="tandc" id="tandc" class="form-control" required><label for="useragreement" class="tandc"><a link href="tandcs.html">You agree to the terms and conditions</a></label>
        </div>-->

          <div>

              <input type="checkbox" name="admin" value="admin"> Admin Account<br>

              <input type="checkbox" name="user" value="user"> User Account<br>

          </div>
        </br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Create User Account</button>
          <br>

      </form>
    <a href="/UnitTraining/login_logout/forgotUserName_Password.php" class="btn btn-lg btn-primary btn-block" type="button">Forgot Username or Password</a>
</div>
<!-- indluces closing html tags for body and html-->
<?php include __DIR__.'/../footer.php';?>
