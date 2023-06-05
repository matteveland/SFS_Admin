<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);


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
  <title><?php echo $siteTitle; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../AdminLTE-master/dist/css/adminlte.min.css">

  <!-- Theme style -->
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>



  <script>
  var fossZones = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
  "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
  "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];
  //var insideOutside= ["exterior"];

  var interior = ["BMS", "PIR", "TAMPER", "Video", "Duress", "Other"];

  var exterior = ["FOSS", "Duress", "PIRAMID", "TAMPER", "Video", "Other"];


  var cameraZones = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
  "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
  "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59",
  "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "77", "74", "75", "76", "78", "79", "80",
  "81", "82", "83", "88", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];


  var something = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
  "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
  "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];

  //var piramid = ["Left", "Right", "Center"];
  var fdbListing = ["FDB 1", "FDB 2", "FDB 3", "FDB 4", "FDB 5", "FDB 6", "FDB 7", "FDB 8", "FDB 9", "FDB 10", "FDB 11", "FDB 12", "FDB 13", "FDB 14", "FDB 15", "FDB 16", "FDB 17", "FDB 18", "FDB 19", "FDB 20",
  "FDB 21", "FDB 22", "FDB 23", "FDB 24", "FDB 25", "FDB 26", "FDB 27", "FDB 28", "FDB 29", "FDB 30", "FDB 31", "FDB 32", "FDB 33", "FDB 34", "FDB 35", "FDB 36", "FDB 38", "FDB 39", "FDB 40"];

  var changeCat1 = function changeCat1(firstList) {
    var newSel = document.getElementById("inputSensorKind");
    //if you want to remove this default option use newSel.innerHTML=""
    //newSel.innerHTML = "<option value=\"\">Select</option>"; // to reset the second list everytime
    var opt;

    //test according to the selected value
    switch (firstList.options[firstList.selectedIndex].value) {
      case "Interior":
      for (var i = 0; len = interior.length, i < len; i++) {
        opt = document.createElement("option");
        opt.value = interior[i];
        opt.text = interior[i];
        newSel.appendChild(opt);
      }
      break;
      case "Exterior":
      for (var i = 0; len = exterior.length, i < len; i++) {
        opt = document.createElement("option");
        opt.value = exterior[i];
        opt.text = exterior[i];
        newSel.appendChild(opt);
      }
      break;

    }

  };

  var changeCat2 = function changeCat1(secondList) {
    var newSel = document.getElementById("fossZone");
    //if you want to remove this default option use newSel.innerHTML=""
    //newSel.innerHTML = "<option value=\"\">Select</option>"; // to reset the second list everytime
    var opt;

    //test according to the selected value
    switch (secondList.options[secondList.selectedIndex].value) {
      case "FOSS":
      for (var i = 0; len = fossZones.length, i < len; i++) {
        opt = document.createElement("option");
        opt.value = fossZones[i];
        opt.text = fossZones[i];
        newSel.appendChild(opt);
      }
      break;
      case "Video":
      for (var i = 0; len = cameraZones.length, i < len; i++) {
        opt = document.createElement("option");
        opt.value = cameraZones[i];
        opt.text = cameraZones[i];
        newSel.appendChild(opt);
      }
      break;

      case "FDB":
      for (var i = 0; len = fdbListing.length, i < len; i++) {
        opt = document.createElement("option");
        opt.value = fdbListing[i];
        opt.text = fdbListing[i];
        newSel.appendChild(opt);
      }
      break;
    }

  }


  $(function() {
    $('#dim_inputTime').hide();
    $('#occurrence').change(function() {
      if ($('#occurrence').val() == 'now') {
        $('#dim_inputTime').hide();
      } else {
        $('#dim_inputTime').show();
      }
    });
  });

  $(function() {
    $('#dim_inputDate').hide();
    $('#occurrence').change(function() {
      if ($('#occurrence').val() == 'now') {
        $('#dim_inputDate').hide();
      } else {
        $('#dim_inputDate').show();
      }
    });
  });

  $(function() {
    $('#manualSubmit').hide();
    $('#occurrence').change(function() {
      if ($('#occurrence').val() == 'now') {
        $('#manualSubmit').hide();
        $('#inputSubmit').show();
      } else if ($('#occurrence').val() == 'other') {
        $('#manualSubmit').show();
        $('#inputSubmit').hide();
      } else {
        $('#inputSubmit').show();
        $('#manualSubmit').hide();
      }
    });
  });
  </script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">


    <!--Nav bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>
    <!--side bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Alarm Data</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Insert Alarm Data</li>
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
                      <h3 class="card-title">Submit Alarm Information</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="insert-alarm-report.php" method="post">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="occurrence">Occurrence</label>
                          <select class="form-control" id="occurrence" name="occurrence" title="occurrence" required autofocus>
                            <option value="">Select</option>
                            <option value="now">Now</option>
                            <option value="other">Earlier</option>

                          </select>
                        </div>
                        <div class="form-group" id="dim_inputDate">
                          <label for="dim_inputDate" style="text-align: left">Date of Incident</label><br>
                          <input type="date" name="dim_inputDate" id="dim_inputDate" class="form-control" value="" min="2010-01-01" max="2050-12-31">

                        </div>
                        <div class="form-group" id="dim_inputTime">
                          <label for="dim_inputTime" style="text-align: left">Time of Incident</label><br>
                          <input type="time" name="dim_inputTime" id="dim_inputTime" class="form-control" value="" placeholder="HH:MM">

                        </div>
                        <div class="form-group">
                          <label for="inputWorkOrderType">Form Type</label>
                          <select class="form-control" id="inputWorkOrderType" name="inputWorkOrderType" title="inputWorkOrderType" required>
                            <option value="">Type</option>
                            <option value="340">340</option>
                            <option value="781A">781A</option>

                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inputLocationSelect">Location Type</label>
                          <select class="form-control" id="inputLocationSelect" name="inputLocationSelect" title="locationType" onchange="changeCat1(this)" required>
                            <option value="">Type</option>
                            <option value="Interior">Interior</option>
                            <option value="Exterior">Exterior</option>
                            <option value="Other">Other</option>

                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inputSensorKind">Sensor Type</label>
                          <select class="form-control" id="inputSensorKind" name="inputSensorKind" title="inputSensorKind" onchange="changeCat2(this)" required>
                            <option value="">Select</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inputAccessPoint">Alarm Point</label>
                          <select name="inputAccessPoint" id="inputAccessPoint" class="form-control" required>
                            <option value="">Select</option>
                            <option value="0">N/A</option>
                            <!---->
                            <?php
                            for ($i = 1; $i < 20; $i++) {
                              echo '<option value="' . $i . '"<br>' . $i . '</option>';
                            } ?>

                          </select>
                        </div>
                        <div class="form-group">
                          <label for="fossZone">Number Sector/Camera</label>
                          <select name="fossZone" id="fossZone" class="form-control">

                            <option value="">Select</option>
                          </select>
                        </div>
                        <div class="form-group">

                          <label for="inputFindings">Alarm Activation Cause</label>
                          <select class="form-control" id="inputFindings" name="inputFindings" title="inputFindings" onchange="changeCat1(this)" required>
                            <option value="">Type</option>
                            <option value="False">False</option>
                            <option value="Nuisance">Nuisance</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inputAccountName">Account Number</label>
                          <input type="text" name="inputAccountName" id="inputAccountName" class="form-control" value="" placeholder="Acct Number" required>
                        </div>
                        <div class="form-group">
                          <label for="inputBuildingName">Building Number</label>
                          <input type="text" name="inputBuildingName" id="inputBuildingName" class="form-control" value="" placeholder="Building Number" required>
                        </div>
                        <div class="form-group">
                          <label for="inputRoomNumber">Room Number</label>
                          <input type="text" name="inputRoomNumber" id="inputRoomNumber" class="form-control" value="" placeholder="Room Number" required>
                        </div>


                        <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/sectionSelect.php'; ?>


                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-12">
                              <!-- textarea -->
                              <div class="form-group">
                                <label>Description</label>
                                <textarea id='inputDescriptionField' name='inputDescriptionField' class="form-control" rows="3" placeholder="Enter Description"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="submit" name="inputSubmit" id="inputSubmit" class="btn btn-primary">Submit</button>
                        <button type="submit" name="manualSubmit" id="manualSubmit" class="btn btn-secondary">Submit</button>
                      </div>
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
      <!-- /.content-wrapper -->
      <!-- Footer -->


      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
    <!-- jQuery -->
    <script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../AdminLTE-master/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../AdminLTE-master/plugins/jszip/jszip.min.js"></script>
    <script src="../../AdminLTE-master/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../AdminLTE-master/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../AdminLTE-master/dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#ExteriorAlarmTables').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      $('#InteriorAlarmTables').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      $('#AdminViewCompletedAlarmTables').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
    </script>
  </body>
  </html>
