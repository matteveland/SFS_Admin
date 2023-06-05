<?php


require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';
include('/var/services/web/sfs/Application/data.env');


$unitName = $_SESSION['unitName'];
if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> Please login to an Admin or User account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/UnitTraining/login_logout/splashpage.php'>Login</a></p>";
    exit;
}

?>
    <html>
<title>ESS</title>

<head>
    <h3 align="center">ESS Trends</h3>
    <br>
    <?php include('navigation.html'); ?>

</head>
<body>

<br>
<?php
if (($_SESSION['page_admin']) or ($_SESSION['page_user']) == true) {
    $positionSelect = mysqli_escape_string($connection, $_POST['selectPosition']);
    $timeSelect = mysqli_escape_string($connection, $_POST['queryTimePeriod']);

    if (isset($_POST['submit'])) {

        $timeSelect = mysqli_escape_string($connection, $_POST['queryTimePeriod']);

//form type search

        $formTypeMultiSelect = $_POST['multiSelectFormType'];
        if (count($formTypeMultiSelect) <= 1) {

            $queryMultiformType = "$formTypeMultiSelect[0]";

        } else {

            $queryMultiformType = "$formTypeMultiSelect[0]', '$formTypeMultiSelect[1]";

        }

        $alarmLocationTypeMultiSelect = $_POST['multiAlarmLocationType'];
        if (count($alarmLocationTypeMultiSelect) <= 1) {

            $queryMultiAlarmLocationType = "$alarmLocationTypeMultiSelect[0]";
        } else {

            $queryMultiAlarmLocationType = "$alarmLocationTypeMultiSelect[0]', '$alarmLocationTypeMultiSelect[1]";
        }


        //Sensor Status open closed submitted(781A)

        $queryMultiAlarmStatusMultiSelect = $_POST['multiAlarmStatusType'];
        if (count($queryMultiAlarmStatusMultiSelect) <= 1) {

            $queryMultiAlarmStatusMultiSelect = "$queryMultiAlarmStatusMultiSelect[0]";
        }elseif (count($queryMultiAlarmStatusMultiSelect) <= 2) {

            $queryMultiAlarmStatusMultiSelect = "$queryMultiAlarmStatusMultiSelect[0]', '$queryMultiAlarmStatusMultiSelect[1]";
        }elseif (count($queryMultiAlarmStatusMultiSelect) <= 3) {

            $queryMultiAlarmStatusMultiSelect = "$queryMultiAlarmStatusMultiSelect[0]', '$queryMultiAlarmStatusMultiSelect[1]', '$queryMultiAlarmStatusMultiSelect[2]";
        }else{

            echo "error";


        }


//sensor type search

        $queryMultiSensorType = $_POST['multiSelectSensorType'];

        if (count($queryMultiSensorType) <= 1) {

            $queryMultiSensorType = "$queryMultiSensorType[0]";

        } elseif (count($queryMultiSensorType) <= 2) {

            $queryMultiSensorType = "$queryMultiSensorType[0]', '$queryMultiSensorType[1]";

        } elseif (count($queryMultiSensorType) <= 3) {

            $queryMultiSensorType = "$queryMultiSensorType[0]', '$queryMultiSensorType[1]', '$queryMultiSensorType[2]";

        } elseif (count($queryMultiSensorType) <= 4) {

            $queryMultiSensorType = "$queryMultiSensorType[0]', '$queryMultiSensorType[1]', '$queryMultiSensorType[2] ', '$queryMultiSensorType[3]";

        } elseif (count($queryMultiSensorType) <= 5) {

            $queryMultiSensorType = "$queryMultiSensorType[0]', '$queryMultiSensorType[1]', '$queryMultiSensorType[2] ', '$queryMultiSensorType[3]', '$queryMultiSensorType[4]";

        } else {

            echo "error";

        }

        $findESSTrends = "SELECT * from alarmData
                        where unitName = '$unitName'
                        AND alarmTypeSubmit in ('$queryMultiformType')
                        AND sensorKind in ('$queryMultiSensorType')
                        AND alarmLocationType in ('$queryMultiAlarmLocationType')
                        AND alarmData.status in ('$queryMultiAlarmStatusMultiSelect')
                        AND (reportedTime BETWEEN now() - INTERVAL '$timeSelect' DAY AND now() + INTERVAL 1 DAY )
                        ORDER BY alarmTypeSubmit, accountName, sensorKind DESC
                        ";

        $resultFindESSTrends = mysqli_query($connection, $findESSTrends);



        if (!$resultFindESSTrends) {
            echo '<div class="alert alert-danger" role="alert"><p align="center">Error with search query.</p></div>';
        } else {
            if (mysqli_num_rows($resultFindESSTrends) > 0) {


                echo "<h3 align='center'>$unitName Alarm Data</h3>";


                echo "<table>";
                echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
                print("<tr>");
                echo("<th>Date</th>
                <th>Form Type</th>
                <th>Account Name</th>
                <th>Sensor Kind</th>
                <th>Findings</th>
                <th>Sensor Location</th>
                <th>Weather Condition</th>
                <th>Description</th>
                <th>Submitted By</th>
                <th>Duty Section</th>
                <th>Status</th>
                <th>Corrected By</th>
                <th>Date Corrected</th>
                <th>Inspected By</th>
                 <th>Notes</th>

                ");


                while ($row = mysqli_fetch_assoc($resultFindESSTrends)) {

                    $id = $row["id"];
                    $dateFound = $row["reportedTime"];
                    $alarmFormSubmitType = $row["alarmTypeSubmit"];
                    $submittedBy = $row["submittedBy"];
                    $weather = $row["weather"];
                    $findings = $row["findings"];
                    $sensorKind = $row["sensorKind"];
                    $fossZone = $row["fossZone"];
                    $accountName = $row["accountName"];
                    $dutySection = $row["dutySection"];
                    //$description = $row["alarmDescription"];
                    $alarmPointLocation = $row["alarmLocationType"];
                    $correctedBy = $row["correctedBy"];
                    $dateCorrected = $row["dateCorrected"];
                    $inspectedBY = $row["inspectedBy"];
                    $status = $row["status"];
                    $notes = $row["notes"];

                    $description = $row["alarmDescription"];
                    $iv = $row['iv'];

                    $description = openssl_decrypt($description, $cipherMethod, $essDescriptionKey, 0, $iv);


                    echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $dateFound . "</td>
                                    <td>" . $alarmFormSubmitType . "</td>
                                    <td>" . $accountName . "</td>
                                     ";

                    if ($sensorKind === "FOSS") {

                        $fossArray = "$sensorKind , $fossZone";

                        echo "<td>$fossArray</td>";

                    } else {
                        echo "  <td>$sensorKind</td>";
                    }

                    echo "
                                    <td>" . $findings . "</td>
                                     <td>" . $alarmPointLocation . "</td>
                                    <td>" . $weather . "</td>
                                    <td >" . $description . "</td>
                                    <td>" . $submittedBy . "</td>
                                    <td>" . $dutySection . "</td>
                                    <td>" . $status . "</td>
                                    <td>" . $correctedBy . "</td>
                                    <td>" . $dateCorrected . "</td>
                                     <td>" . $inspectedBY . "</td>
                                    <td>" . $notes . "</td>


                                </tr>
                                </tr>
                </tr>";

                }

                mysqli_free_result($resultFindESSTrends);
            } else {

                echo '<div class="alert alert-danger" role="alert"><p align="center">Error with search query. One item from all options must be selected.</p></div>';
            }
            echo "</table><br>";


        }
    } else {

    }
} else {

    //echo "no alarm data.";
}

?>

<div class="member-update">
    <div class="container">
        <form class="member-update" method="post">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="multiSelectFormType">Form Type</label>
                    <select class="form-control" id="multiSelectFormType" name="multiSelectFormType[]" multiple="multiple">
                        <option value="340">340</option>
                        <option value="781A">781A</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="multiSelectSensorType">Sensor Kind</label>
                    <select class="form-control" id="multiSelectSensorType" name="multiSelectSensorType[]" multiple="multiple">
                        <option value="BMS">BMS</option>
                        <option value="Duress">Duress</option>
                        <option value="FOSS">FOSS</option>
                        <option value="PIR">PIR</option>
                        <option value="Tamper">Tamper</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="multiAlarmLocationType">Alarm Port Location</label>
                    <select class="form-control" id="multiAlarmLocationType" name="multiAlarmLocationType[]" multiple="multiple">
                        <option value="Interior">Interior</option>
                        <option value="Exterior">Exterior</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="multiAlarmStatusType">Alarm Status</label>
                    <select class="form-control" id="multiAlarmStatusType" name="multiAlarmStatusType[]" multiple="multiple">
                        <option value="open">Open (None 781A)</option>
                        <option value="submitted">Open (781A)</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="queryTimePeriod">Time Period Selected</label>
                    <select class="form-control" id="queryTimePeriod" name="queryTimePeriod" title="Time Period">
                        <option value="">NONE</option>
                        <option value="1">1 Day</option>
                        <option value="7">7 Days</option>
                        <option value="30">30 Days</option>
                        <option value="90">90 Days</option>
                        <option value="180">180 Days</option>
                        <option value="365">1 Year</option>
                        <option value="730">2 Years</option>
                    </select>
                </div>
            </div>

            <p align="center">
                <button type="submit" id="submit" name="submit" class="btn btn-primary">Display ESS Trends</button>
            </p>


        </form>
    </div>
</div>

</body>

<!-- indluces closing html tags for body and html-->
<?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
