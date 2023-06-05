<?php
require_once __DIR__.'/../dbconfig/connect.php';
include __DIR__.'/../navigation.php';
include ('/var/services/web/sfs/Application/data.env');
include ('/Applications/MAMP/htdocs/data.env');

/*
if(!isset($_SESSION['page_admin'])){
    //Does not exist. Redirect user back to page-one.php
    header('Location: home.php');
    exit;
}*/
//Check to see if session variable exists.


$lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
$firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
$middleName = mysqli_real_escape_string($connection, $_POST['middleName']);
$unitName = mysqli_real_escape_string($connection, $_POST['unitNameDropDown']);

$findDoDId = "SELECT * FROM members WHERE ((lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName') AND unitName = '$unitName') ";

$resultFindDoDId = mysqli_query($connection, $findDoDId) or die(mysqli_error($connection));

while ($row = mysqli_fetch_assoc($resultFindDoDId)) {

    $recallresultFindDoDID = $row['dodId'];

}

//echo $recallresultFindDoDID;


    // If the values are posted, insert them into the database.
if (isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] != $_POST['verifyPassword'])) {

        echo "<script type=\"text/javascript\">
							alert(\"Passwords do not match.\");

						  </script>";

    }elseif(isset($_POST['username']) && isset($_POST['password']) && ($_POST['password'] == $_POST['verifyPassword'])) {



    $email = ($_POST['email']);

    $encodedEmail=urlencode($email);

    $email = mysqli_real_escape_string($connection, $encodedEmail);

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
    $encryptedEmail = openssl_encrypt($email, $cipherMethod, $emailKey, $options=0, $iv);

    $emailDecrypted = openssl_decrypt($encryptedEmail, $cipherMethod, $emailKey, 0, $iv);

    print_r($emailDecrypted);

    //$dodId = mysqli_real_escape_string($connection, $_POST['dodId']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_escape_string($connection, $_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $TAFMSD = mysqli_real_escape_string($connection, $_POST['TAFMSD']);

    $secretQuestion = mysqli_real_escape_string($connection, $_POST['secretQuestion']);
    $secretAnswer = mysqli_real_escape_string($connection, $_POST['secretAnswer']);

    $secretBoth = array($secretQuestion, $secretAnswer);
    $secretBoth = implode(',', $secretBoth);

    //$dutySection = $_POST['dutySection'];



    // ADMIN query section

    $queryMembersAdmin = "Select members.lastName, members.middleName, members.firstName, members.admin
                        from members
                        where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName' AND members.admin = 'Yes' AND unitName = '$unitName')
                        ";

    $resultVerifyAdmin = mysqli_query($connection, $queryMembersAdmin) or die(mysqli_error($connection));

    $queryDupesAdmin = "Select login.lastName, login.firstName, login.middleName, login.emailAddress, login.user_name
                      from login
                      WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName') AND login.user_name = FALSE)";

    $resultDupesAdmin = mysqli_query($connection, $queryDupesAdmin)or die(mysqli_error($connection));

    $queryCreateAdmin = "INSERT INTO `login` (user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId) VALUES ('$username', '$hash', '$encryptedEmail', '$lastName', '$firstName', '$middleName', '$TAFMSD', 'Yes', '$unitName', '$secretBoth', '')";
    $queryUpdateAdmin = "UPDATE `login` SET dodId = '$recallresultFindDoDID' WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName'))";


    // USER query section

    $queryMembersUser = "Select members.lastName, members.middleName, members.firstName, members.admin
                        from members
                        where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName' AND (members.admin = 'No' OR members.admin = '' OR members.admin = NULL))
                        ";

    $resultVerifyUser = mysqli_query($connection, $queryMembersUser) or die(mysqli_error($connection));

    $queryDupesUser = "Select login.lastName, login.firstName, login.middleName, login.emailAddress, login.user_name
                      from login
                      WHERE ((lastName LIKE '$lastName') AND (firstName LIKE '$firstName') AND (middleName LIKE '$middleName'))";

    $resultDupesUser = mysqli_query($connection, $queryDupesUser)or die(mysqli_error($connection));

    $queryCreateUser = "INSERT INTO `login` (id, user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId)
                                    VALUES (id, '$username', '$hash', '$encryptedEmail', '$lastName', '$firstName', '$middleName','$TAFMSD', 'No', '$unitName', '$secretBoth', '$recallresultFindDoDID')";
    //$queryUpdateUser = "UPDATE `login` SET dodId = '$recallresultFindDoDID' WHERE ((lastName = '$lastName') AND (firstName = '$firstName') AND (middleName = '$middleName'))";

    //INSERT INTO `login` (id, user_name, password, emailAddress, lastName, firstName, middleName, enterDate, admin, unitName, secret, dodId) VALUES (id, 'testName', '12', 'mail@mail.com', 'test', 'first', 'NMI','01-Jun-19', 'No', '799 SFS', '1, Bule', '12345678910');


    //$resultCreate = mysqli_query($connection, $queryCreate);

    $findDupeUserName = "select username FROM login where username = '$username'";

    if ($findDupeUserName >0){

        echo"<script type='text/javascript'>
            alert('User Name already taken.');


                              </script>";
        exit();

    }

        if (mysqli_num_rows($resultDupesAdmin) > 0) {

                echo "<script type=\"text/javascript\">
                                alert(\"Member's name is already in database. (Duplication Error)\");


                              </script>";

                trigger_error("Member already registered.");

            }elseif(mysqli_num_rows($resultVerifyAdmin)) {

            $resultCreateAdmin = mysqli_query($connection, $queryCreateAdmin) or die(mysqli_error($connection));

            $resultUpdateAdmin = mysqli_query($connection, $queryUpdateAdmin)or die(mysqli_error($connection));

            //$insertAdmin = "UPDATE `login` SET `admin` = 'Yes' where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName')";

            //$updateAdmin = mysqli_query($connection, $insertAdmin);

            $successmsg1 = "Administration Account Created Successfully.";

        } else {
                    /*echo "<script type=\"text/javascript\">
                                alert(\"Member does not have permissions to have Admin account.\");

                              </script>";*/
                    $failuremsg = "Admin Account Not Created.";
            }

        if (mysqli_num_rows($resultDupesUser) > 0) {

            echo "<script type=\"text/javascript\">
							alert(\"Member's name is already in database. (Duplication Error)\");


						  </script>";

            trigger_error("Member already registered.");


        }elseif(mysqli_num_rows($resultVerifyUser)) {
            $resultCreateUser = mysqli_query($connection, $queryCreateUser)or die(mysqli_error($connection));

            //$resultUpdateUser = mysqli_query($connection, $queryUpdateUser);

            if (!$resultCreateUser){

                $failuremsg2 = "User Account Not Created.";
            }else{

                $successmsg2 = "User Account Created Successfully.";
            }


            //$insertUser = "UPDATE `login` SET `admin` = 'NO' where (lastName LIKE '$lastName' AND firstName LIKE '$firstName' AND middleName LIKE '$middleName')";

            //$updateUser = mysqli_query($connection, $insertUser);



        } else {

           /* echo "<script type=\"text/javascript\">
							alert(\"Member does not have permissions to have account.\");

						  </script>";*/
            $failuremsg = "User Account Not Created else.";
        }


    }









?>

<html>
<head>

<!-- Latest compiled and minified CSS -->

<!-- Latest compiled and minified JavaScript -->
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

<body>


<div class="container">
      <form class="form-signin" method="POST">

            <?php if(isset($successmsg1)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg1; ?> </div><?php } ?>
          <?php if(isset($successmsg2)){ ?><div class="alert alert-success" role="alert"> <?php echo $successmsg2; ?> </div><?php } ?>

          <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>
          <?php if(isset($failuremsg2)){ ?><div class="alert alert-danger" role="alert"> <?php echo $failuremsg2; ?> </div><?php } ?>

        <h2 class="form-signin-heading">Please register for an account</h2>

          <!--<label>Duty Section</label>
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
           </select>-->



        <!--  <input type="text" name="dodId" id="dodId" class="form-control" value=""placeholder="DOD ID Number" required>-->

                <input type="text" name="firstName" id="firstName" class="form-control" value=""placeholder="First Name" required>
                <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Middle Name" required>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" required>
          <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Your @us.af.mil/@mail.mil address" required>
          <input type="text" name="TAFMSD" id="inputTAFMSD" class="form-control" placeholder="TAFMSD DD-MMM-YY " required>
            <br>
          <br>


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
    <a class="btn btn-lg btn-info btn-block" href="/UnitTraining/login_logout/forgotUserName_Password.php">Forgot Username or Password</a>

</div>
<!--
    <script>


        var letter = document.getElementById("letter");


        var myInput = document.getElementById("inputPassword");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            // Validate length
            if(myInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }
        }
    </script>-->
</body>

    <!-- indluces closing html tags for body and html-->
<?php include __DIR__.'/../footer.php';?>
