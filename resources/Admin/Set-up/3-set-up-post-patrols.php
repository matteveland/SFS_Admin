<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

if (isset($_POST['specialUnitSection']) AND isset($_POST['next'])) {
  $section_setup = array();
  $section_setup = implode(";", $_POST['specialUnitSection']);
  $section_setup = explode(';', trim($section_setup));

  $recallUnitSections = $mysqli->query("SELECT sectionName FROM unitSections where unitName = 'Master Listing'");
  $standardSectionArray = $recallUnitSections->fetch_array();
  $standardSectionArray = explode(',', $standardSectionArray['sectionName']);

  $specialSection_setup = array();

  str_replace(",", ";",  $_POST['specialUnitSection']);
  str_replace(":", ";",  $_POST['specialUnitSection']);
  $specialSection_setup = implode(";", $_POST['specialUnitSection']);

  $specialSection_setupArray = explode(",", $specialSection_setup);
  $trimmed_specialSection_setupArray = array();

  for ($i=0; $i < count($specialSection_setupArray); $i++) {

    $mysqli->real_escape_string($specialSection_setupArray[$i]);
    array_push($trimmed_specialSection_setupArray, rtrim(ltrim("$specialSection_setupArray[$i]")));
  }

  $setupSectionArray = array_merge($standardSectionArray, $trimmed_specialSection_setupArray);

  foreach($setupSectionArray as $key => $value) {

    echo $value."<br>";
  }

  $_SESSION['section_setup'] = $setupSectionArray;


}elseif(empty($_POST['specialUnitSection']) AND isset($_POST['next'])) {

  $recallUnitSections = $mysqli->query("SELECT sectionName FROM unitSections where unitName = 'Master Listing'");
  $standardSectionArray = $recallUnitSections->fetch_array();
  $standardSectionArray = explode(',', $standardSectionArray['sectionName']);
  $_SESSION['section_setup'] = $standardSectionArray;
  // code...
} else{

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
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>SFS</b>Admin</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Do you wish to insert S3O Post and Patrols? </p>

        <form action="4-yes-set-up-post-patrols.php" method="post">


          <div class="row">

            <!-- /.col -->

            <div class="col-4">
              <button type="submit" name="next" id="next" value="no" class="btn btn-danger btn-block">No</button>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4">
              <button type="submit" name="next" id="next" value="yes"   class="btn btn-primary btn-block">Yes</button>
            </div>
            <!-- /.col -->
          </div>


        </form>
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
