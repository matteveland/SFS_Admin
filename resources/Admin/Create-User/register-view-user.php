<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
isUserLogged_in();//verify login to account before access is given to site
isAdmin('/homepage.php');

parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];

//check if user is logged in. if logged in allow access, otherwise return to login page




?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SFS Admin | Homepage</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">



  <!-- Theme style -->
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">


    <!--Nav bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>

    <!-- Main Sidebar Container -->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1403.625px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Register Member</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Register New Users</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>



      <!-- Main content -->
      <div class="container-fluid">
        <section class="content">
          <div class="container-fluid">
            <div class="col-md-8">
              <div class="row">
                <!-- left column -->
                <div class="col-md-10">
                  <!-- general form elements -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Register Member</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <!-- insert registeration form-->
                    <form action="register-insert-user.php" method="post">
                      <div class="card-body">
                        <!-- DOD ID-->

                        <div class="form-group">
                          <label for="inputDODID">DoD ID Number</label>
                          <input type="text" class="form-control" id="inputDODID" name="inputDODID" placeholder="" required>
                        </div>
                        <!--last 4-->
                        <div class="form-group">
                          <label for="inputLastFour">Last Four</label>
                          <input type="text" class="form-control" id="inputLastFour" name="inputLastFour" placeholder="" required>
                        </div>
                        <!-- Set Rank-->
                        <div class="form-group">
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
                        <div class="form-group">
                          <label for="inputFirstName">First Name</label>
                          <input type="text" class="form-control" id="inputFirstName"name="inputFirstName" value="" placeholder="" required>
                        </div>
                        <!-- middle name-->
                        <div class="form-group">
                          <label for="inputMiddleName">Middle Name</label>
                          <input type="text" class="form-control" name="inputMiddleName" id="inputMiddleName" value="" placeholder="" required>
                        </div>
                        <!-- last name-->
                        <div class="form-group">
                          <label for="inputLastName">Last Name</label>
                          <input type="text" class="form-control" id="inputLastName" name="inputLastName" value="" placeholder=""required>
                        </div>
                        <!-- Gender-->
                        <div class="form-group">
                          <label for="inputGender">Gender</label>

                          <select class="form-control" id="inputGender" name="inputGender" required>
                            <option value="">None</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>

                          </select>
                        </div>
                        <!-- DEROS-->
                        <div class="form-group">
                          <label for="inputDEROS">DEROS</label>
                          <input type="text" class="form-control" id="inputDEROS" name="inputDEROS" placeholder="YYYY-MM-DD">
                        </div>
                        <!-- Birthdate-->
                        <div class="form-group">
                          <label for="inputBirthdate">Birth Date</label>
                          <input type="text" class="form-control" id="inputBirthdate" name="inputBirthdate" placeholder="YYYY-MM-DD" required>
                        </div>
                        <!-- Gov email-->
                        <div class="form-group">
                          <label for="inputGovEmail">Government Email Address</label>
                          <input type="text" class="form-control" id="inputGovEmail" name="inputGovEmail" placeholder="" required>
                        </div>
                        <!-- Personal email-->
                        <div class="form-group">
                          <label for="inputPrsnlEmail">Personal Email Address</label>
                          <input type="text" class="form-control" id="inputPrsnlEmail" name="inputPrsnlEmail" placeholder="" required>
                        </div>
                        <!-- email opt-in/out-->
                        <div class="form-group">
                          <label for="emailOptIn">Email Opt-In:</label> <br>
                          You <U><B>WILL NOT</B></U> receive emails from the Unit

                          Do you wish to start to receive <?php echo $unitName; ?> emails?

                          <input type="radio" id="emailOptIn1" name="emailOptIn"  value="yes">
                          <label for="emailOptIn">Yes</label>

                          <input type="radio" id="emailOptIn2" name="emailOptIn"  value="no">
                          <label for="emailOptIn">No</label>
                        </div>
                        <!-- AFSC-->
                        <div class="form-group">
                          <label for="inputAFSC">AFSC</label>
                          <input type="text" class="form-control" id="inputAFSC" name="inputAFSC" value="" placeholder="" required>
                        </div>
                        <!-- duty Section-->
                        <div class="form-group">
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
                        <!-- home phone-->
                        <div class="form-group">
                          <label for="inputhomePhone">Home Phone</label>
                          <input type="text" class="form-control" id="inputhomePhone" name="inputHomePhone"  placeholder="" >
                        </div>
                        <!-- Cell phone-->
                        <div class="form-group">
                          <label for="inputCellPhone">Cell Phone</label>
                          <input type="text" class="form-control" id="inputCellPhone" name="inputCellPhone"  placeholder="" required>
                        </div>
                        <!-- Supervisor rank-->
                        <div class="form-group">
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
                        <div class="form-group">
                          <label for="inputSupervisorLastName">Supervisor Last Name</label>
                          <input type="text" class="form-control" id="inputSupervisorLastName" name="inputSupervisorLastName"placeholder="" required>
                        </div>
                        <!-- Supervisor first-->
                        <div class="form-group">
                          <label for="inputSupervisorFirstName">Supervisor First Name</label>
                          <input type="text" class="form-control" id="inputSupervisorFirstName" name="inputSupervisorFirstName" placeholder="" required>
                        </div>
                        <!-- Submit-->

                      </div>
                      <!-- end registration form-->
                      <div class="card-footer">
                        <label for="addMember-Submit"></label>
                        <button type="submit" name="addMember-Submit" id="addMember-Submit" class="btn btn-primary">Submit</button>
                      </form>


                    </div>
                    <!-- /.card -->

                    <!--/.col (left) -->
                    <!-- right column -->

                  </div>
                  <!-- /.row -->
                </div><!-- /.container-fluid -->
              </div>
            </div>
          </section>
          <!-- /.content -->
        </div>
        <!-- Content Header (Page header) -->
      </div>
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../AdminLTE-master/dist/js/adminlte.min.js"></script>
  </body>
  </html>
