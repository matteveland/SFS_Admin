<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
date_default_timezone_set('America/Los_Angeles');

//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];

//find user class.
$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

$updateItemId = $mysqli->real_escape_string($_GET['id']);

$selectAlarmUpdate = $mysqli->query("SELECT * FROM alarmData WHERE id = '$updateItemId' and unitName = '$unitName'") or die(mysqli_errno($mysqli));


while ($row = $selectAlarmUpdate->fetch_assoc()) {

    $id = $row["id"];
    $dateFound = $row["reportedTime"];
    $alarmFormSubmitType = $row["alarmTypeSubmit"];
    $submittedBy = $row["submittedBy"];
    $weather = $row["weather"];
    $findings = $row["findings"];
    $sensorKind = $row["sensorKind"];
    $accessPoint = $row["accessPoint"];
    $fossZone = $row["fossZone"];
    $accountName = $row["accountName"];
    $roomNumber = $row["roomNumber"];
    $sensorLocation = $row["alarmLocationType"];
    $buildingNumber = $row["buildingNumber"];
    $dutySection = $row["dutySection"];
    $correctedBy = $row["correctedBy"];
    $dateCorrected = $row["dateCorrected"];
    $inspectedBy = $row["inspectedBy"];
    $status = $row["status"];
    $notes = $row["notes"];

    $description = $row["alarmDescription"];
    $iv = $row['iv'];

    $description = openssl_decrypt($description, $_ENV['cipherMethod'], $_ENV['essDescriptionKey'], 0, $iv);
}

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
    <link rel="stylesheet" href="../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../AdminLTE-master/dist/css/adminlte.min.css">


    <!-- Theme style -->
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    <script>
        var fossZones = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
            "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"
        ];
        //var insideOutside= ["exterior"];

        var interior = ["BMS", "PIR", "TAMPER", "Video", "Duress", "Other"];

        var exterior = ["FOSS", "Duress", "PIRAMID", "TAMPER", "Video", "Other"];


        var cameraZones = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
            "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59",
            "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "77", "74", "75", "76", "78", "79", "80",
            "81", "82", "83", "88", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"
        ];


        var something = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
            "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"
        ];

        //var piramid = ["Left", "Right", "Center"];
        var fdbListing = ["FDB 1", "FDB 2", "FDB 3", "FDB 4", "FDB 5", "FDB 6", "FDB 7", "FDB 8", "FDB 9", "FDB 10", "FDB 11", "FDB 12", "FDB 13", "FDB 14", "FDB 15", "FDB 16", "FDB 17", "FDB 18", "FDB 19", "FDB 20",
            "FDB 21", "FDB 22", "FDB 23", "FDB 24", "FDB 25", "FDB 26", "FDB 27", "FDB 28", "FDB 29", "FDB 30", "FDB 31", "FDB 32", "FDB 33", "FDB 34", "FDB 35", "FDB 36", "FDB 38", "FDB 39", "FDB 40",
        ];

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

      <!-- Main Sidebar Container -->
      <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>General Form</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">General Form</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Alarm Information</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="run-update-Alarm-Status.php" method="POST">
                                        <div class="form-group" hidden>
                                            <label for="getID">get id</label>
                                            <input type="text" class="form-control" id="getID" name="getID" value="<?php echo "$updateItemId" ?>" title="getID">
                                        </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="inputDate">Date Found</label><br>
                                        <?php echo $dateFound ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputWorkOrderType">Form Type</label>
                                            <select class="form-control" id="inputWorkOrderType" name="inputWorkOrderType" title="inputWorkOrderType" required autofocus>
                                                <?php

                                                echo "<option value = '340'";
                                                if ($alarmFormSubmitType == '340') {
                                                    echo 'selected';
                                                }
                                                echo " >340</option >";
                                                echo "<option value = '781A'";
                                                if ($alarmFormSubmitType == '781A') {
                                                    echo 'selected';
                                                }
                                                echo " >781A</option ></select >";

                                                ?>
                                            </select>
                                        </div>
                                      <!-- Account Name is Account number in database-->
                                        <div class="form-group">
                                            <label for="inputAccountName">Account Number</label>
                                            <input type="text" class="form-control" id="inputAccountName" name="inputAccountName" value="<?php echo "$accountName" ?>" title="inputAccountNumber" placeholder="Account Number" required autofocus>


                                        </div>

                                        <div class="form-group">
                                            <label for="inputBuildingName">Building Number</label>
                                            <input type="text" name="inputBuildingName" id="inputBuildingName" class="form-control" value="<?php echo $buildingNumber; ?>" placeholder="Building Number" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputRoomNumber">Room Number</label>
                                            <input type="text" name="inputRoomNumber" id="inputRoomNumber" class="form-control" value="<?php echo $roomNumber; ?>" placeholder="Room Number" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAccessPoint">Access Point</label>
                                            <input type="text" class="form-control" id="inputAccessPoint" name="inputAccessPoint" title="inputAccessPoint" value="<?php echo $accessPoint ?>" placeholder="Access Point">


                                        </div>
                                        <div class="form-group">
                                            <label for="inputLocationSelect">Location Type</label>
                                            <select class="form-control" id="inputLocationSelect" name="inputLocationSelect" title="locationType" onchange="changeCat1(this)" required>
                                                <option value="">Type</option>
                                                <option value="Interior" <?php if ($sensorLocation == "Interior") echo "selected" ?>>Interior</option>
                                                <option value="Exterior" <?php if ($sensorLocation == "Exterior") echo "selected" ?>>Exterior</option>
                                                <option value="Other" <?php if ($sensorLocation == "Other") echo "selected" ?>>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSensorKind">Sensor Type</label>
                                            <input type="text" class="form-control" id="inputSensorKind" name="inputSensorKind" value="<?php echo "$sensorKind" ?>" title="inputSensorKind" placeholder="Sensor Kind" required autofocus>


                                        </div>
                                        <div class="form-group">
                                            <label for="inputFindings">Findings</label>
                                            <input type="text" class="form-control" id="inputFindings" name="inputFindings" title="inputFindings" value="<?php echo "$findings" ?>" placeholder="Findings"required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <!-- textarea -->
                                                    <div class="form-group">
                                                        <label for="inputDescriptionField">Description</label>
                                                        <textarea id='inputDescriptionField' name='inputDescriptionField' class="form-control" rows="3" placeholder="Enter Description" value="<?php $description ?>"><?php echo $description ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- /.card-body -->
<!-- card-footer not used
                                    <div class="card-footer">
                                    </div> -->
                                </div>

                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- Form Element sizes -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Admin Information</h3>
                                </div>
                                <div class="card-body">


                                <?php if ((($_SESSION['page_admin']) == 'ESSAdmin') or (($_SESSION['page_admin']) == 'matt')) { ?>

                                        <div class='form-group'>
                                            <label for='alarmUpdate'>Currently Assigned</label>
                                            <select class="form-control" id="alarmUpdate" name="alarmUpdate" title="alarmUpdate">
                                                <option value="open" <?php if ($status == "") echo "open" ?>>Open</option>
                                                <option value="submitted" <?php if ($status == "submitted") echo "selected" ?>>Submitted to ESS or Contractor</option>
                                                <option value="completed" <?php if ($status == "completed") echo "selected" ?>>Completed</option>
                                            </select>
                                        </div>
                                    <?php
                                        echo "<td>
                                        <div class='form-group'>
                                        <label for='status'>Corrected By</label>
                                        <select class='form-control' id = 'inputCorrectedBy' name = 'inputCorrectedBy' title = 'inputCorrectedBy' >
                                                            <option value = ''";
                                        if ($status == '') {
                                            echo 'selected';
                                        }
                                        echo " > NONE</option >
                                                            <option value = 'ESS'";
                                        if ($correctedBy == 'ESS') {
                                            echo 'selected';
                                        }
                                        echo " > ESS</option >
                                                            <option value = 'Advantor'";
                                        if ($correctedBy == 'Advantor') {
                                            echo 'selected';
                                        }
                                        echo " > Advantor</option >
                                                            <option value = 'Xator'";
                                        if ($correctedBy == 'Xator') {
                                            echo 'selected';
                                        }
                                        echo " > Xator</option >
                                                            </select >";

                                        echo "</select>

                                        </div>";
                                    ?>

<div class='form-group'>
                                            <label for='inspectedBy'>Inpsected By</label>
                                            <input type='text' class='form-control' id='inspectedBy' name='inspectedBy' value='<?php echo "$inspectedBy" ?>' placeholder='Inspected By'>
                                        </div>

                                        <div class='form-group'>
                                            <label for='dateCorrected'>Date Inspected</label>
                                            <input type="date" class='form-control' id='dateCorrected' name='dateCorrected' value='<?php echo "$dateCorrected" ?>' min="2010-01-01" max="2050-12-31">
                                        </div>


                                        <div class='form-group'>
                                            <label for='noteBox'>Notes</label>
                                            <textarea class="form-control" id="noteBox" name="noteBox" rows="5" placeholder="Enter ..." ><?php echo "$notes" ?></textarea>
                                        </div>


                                        <div class="card-footer">
                                        <label for='adminSubmit'></label>
                                            <button class="btn btn-primary" name="adminSubmit" id="adminSubmit" href="run-update-Alarm-status.php?id=<?php echo $updateItemId?>">Update Alarm Work Order</button>
                                       <!-- <button type="submit" name="manualSubmit" id="manualSubmit" class="btn btn-secondary">Submit</button>-->
                                    </div>
                                        </form>

                                </div>
                            </div>


                        <?php } else {
                                    } ?>
                                    <!-- /.card-body -->


                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.1.0-rc
        </div>
        <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>-->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>


</html>
