<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

//$post_setup = $mysqli->real_escape_string($_POST['next']);

if (isset($_POST['next'])) {

  $post_setup = array();
  $post_setup = implode(";", $_POST['addPost_Patrols']);
  //$post_setup = explode(';', trim($post_setup));
  $specialpost_setup = array();

  $post_setup = str_replace(",", ";",  $post_setup);
  $post_setup = str_replace(":", ";",  $post_setup);
  //$specialpost_setup = implode(";", $_POST['addPost_Patrols']);

  $specialpost_setup = explode(";", $post_setup);
  $trimmed_specialpost_setupArray = array();

  for ($i=0; $i < count($specialpost_setup); $i++) {

    $mysqli->real_escape_string($specialpost_setup[$i]);
    array_push($trimmed_specialpost_setupArray, rtrim(ltrim("$specialpost_setup[$i]")));
  }


  //$setupSectionArray = array_merge($standardSectionArray, $trimmed_specialpost_setupArray);
/*  foreach($trimmed_specialpost_setupArray as $key => $value) {

    echo $value."<br>";
  }*/



  $_SESSION['post_patrolSetup'] = $trimmed_specialpost_setupArray;

  // code...
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
</head>
<body class="hold-transition login-page">
  <div class="login-box w-auto P-3">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>SFS</b>Admin</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Create Master User</p>

        <form action="6-set-up-create-first-password.php" method="post">
            <!-- DOD ID-->

            <div class="form-group mb-3">
              <label for="inputDODID">DoD ID Number</label>
              <input type="text" class="form-control" id="inputDODID" name="inputDODID" placeholder="DoD ID Number" required>
            </div>
            <!--last 4-->
            <div class="form-group mb-3">
              <label for="inputLastFour">Last Four</label>
              <input type="text" class="form-control" id="inputLastFour" name="inputLastFour" placeholder="Last Four" required>
            </div>
            <!-- Set Rank-->
            <div class="form-group mb-3">
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
            <!-- first name-->
            <div class="form-group mb-3">
              <label for="inputFirstName">First Name</label>
              <input type="text" class="form-control" id="inputFirstName"name="inputFirstName" value="" placeholder=">First Name" required>
            </div>
            <!-- middle name-->
            <div class="form-group mb-3">
              <label for="inputMiddleName">Middle Name</label>
              <input type="text" class="form-control" name="inputMiddleName" id="inputMiddleName" value="" placeholder="Middle Name" required>
            </div>
            <!-- last name-->
            <div class="form-group mb-3">
              <label for="inputLastName">Last Name</label>
              <input type="text" class="form-control" id="inputLastName" name="inputLastName" value="" placeholder="Last Name"required>
            </div>
            <!-- Gender-->
            <div class="form-group mb-3">
              <label for="inputGender">Gender</label>

              <select class="form-control" id="inputGender" name="inputGender" required>
                <option value="">None</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>

              </select>
            </div>
            <!-- DEROS-->
            <div class="form-group mb-3">
              <label for="inputDEROS">DEROS</label>
              <input type="text" class="form-control" id="inputDEROS" name="inputDEROS" placeholder="YYYY-MM-DD">
            </div>
            <!-- Birthdate-->
            <div class="form-group mb-3">
              <label for="inputBirthdate">Birth Date</label>
              <input type="text" class="form-control" id="inputBirthdate" name="inputBirthdate" placeholder="YYYY-MM-DD" required>
            </div>
            <!-- Gov email-->
            <div class="form-group mb-3">
              <label for="inputGovEmail">Government Email Address</label>
              <input type="text" class="form-control" id="inputGovEmail" name="inputGovEmail" placeholder="Government Email Address" required>
            </div>
            <!-- Personal email-->
            <div class="form-group mb-3">
              <label for="inputPrsnlEmail">Personal Email Address</label>
              <input type="text" class="form-control" id="inputPrsnlEmail" name="inputPrsnlEmail" placeholder="Personal Email Address" required>
            </div>
            <!-- email opt-in/out-->
            <div class="form-group mb-3">
              <label for="emailOptIn">Email Opt-In:</label> <br>
              You <U><B>WILL NOT</B></U> receive emails from the Unit

              Do you wish to start to receive <?php echo $unitName; ?> emails?
              <br>

              <input type="radio" id="emailOptIn1" name="emailOptIn"  value="yes">
              <label for="emailOptIn">Yes</label>

              <input type="radio" id="emailOptIn2" name="emailOptIn"  value="no">
              <label for="emailOptIn">No</label>
            </div>
            <!-- AFSC-->
            <div class="form-group mb-3">
              <label for="inputAFSC">AFSC</label>
              <input type="text" class="form-control" id="inputAFSC" name="inputAFSC" value="" placeholder="PAFSC" required>
            </div>
            <!-- duty Section-->
            <div class="form-group mb-3">
              <label for="inputDutySectionSelect">Duty Section</label>
              <select class="form-control" id="inputDutySectionSelect" name="inputDutySectionSelect" title="dutySection" required>
                <option  disabled selected value>Select Section</option>

                <!-- wanted to use the user provided sections as a nice touch.-->
                <?php
                //asort($_SESSION['section_setup'] );
                foreach ($_SESSION['section_setup'] as $key => $value) {
                  echo '<option value="'.$value.'">'.$value.'</option>';
                } ?>
                <!--<option value="S1">S1</option>
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
                <option value="SFM">SFM</option>-->
              </select>
            </div>
            <!-- home phone-->
            <div class="form-group mb-3">
              <label for="inputhomePhone">Home Phone</label>
              <input type="text" class="form-control" id="inputhomePhone" name="inputHomePhone"  placeholder="" >
            </div>
            <!-- Cell phone-->
            <div class="form-group mb-3">
              <label for="inputCellPhone">Cell Phone</label>
              <input type="text" class="form-control" id="inputCellPhone" name="inputCellPhone"  placeholder="" required>
            </div>
            <!-- Supervisor rank-->
            <div class="form-group mb-3">
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
            <!-- Supervisor last-->
            <div class="form-group mb-3">
              <label for="inputSupervisorLastName">Supervisor Last Name</label>
              <input type="text" class="form-control" id="inputSupervisorLastName" name="inputSupervisorLastName"placeholder="" required>
            </div>
            <!-- Supervisor first-->
            <div class="form-group mb-3">
              <label for="inputSupervisorFirstName">Supervisor First Name</label>
              <input type="text" class="form-control" id="inputSupervisorFirstName" name="inputSupervisorFirstName" placeholder="" required>
            </div>
            <!-- Submit-->




          <div class="row">
            <div class="col-8">
              <div >

              </div>
            </div>
            <!-- /.col -->

            <div class="col-4">
              <button type="submit" name="next" id="next" class="btn btn-primary btn-block">Next</button>
            </div>
            <!-- /.col -->
          </div>

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
</body>
</html>
