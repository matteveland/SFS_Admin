<?php


include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
include('/var/services/web/sfs/Application/data.env');
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];
require_once __DIR__ . '/../../login_logout/verifyLogin.php'; //verify login to account before access is given to site

//if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {

if (($_SESSION['page_admin']) == 0) {
    echo "<h3 style='text-align: center'>ESS Open Alarm Data</h3><br>";

    include ('navigation.html');

    $sqlAlarmDataExterior = "SELECT * FROM alarmData
                where unitName = '$unitName'
                AND
                (status <> 'completed' AND accountedFor <>'Y' AND alarmLocationType = 'Exterior' and (alarmTypeSubmit = '340') and (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY ))

               OR (status <> 'completed' AND alarmLocationType = 'Exterior' and (alarmTypeSubmit = '781A'))
                ORDER BY alarmTypeSubmit DESC, accountName asc, buildingNumber ASC, sensorKind ASC, fossZone ASC, alarmLocationType ASC, reportedTime ASC";

    $resultAlarmDataExterior = mysqli_query($connection, $sqlAlarmDataExterior) or die(mysqli_error($connection));

    $sqlAlarmDataInterior = "SELECT * FROM alarmData
                where unitName = '$unitName'
               AND
                (status <> 'completed' AND accountedFor <>'Y' AND alarmLocationType = 'Interior' and (alarmTypeSubmit = '340') and (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY ))

               OR (status <> 'completed' AND alarmLocationType = 'Interior' and (alarmTypeSubmit = '781A'))
                ORDER BY alarmTypeSubmit DESC, accountName asc, buildingNumber ASC, sensorKind ASC, fossZone ASC, alarmLocationType ASC, reportedTime ASC";

    $resultAlarmDataInterior = mysqli_query($connection, $sqlAlarmDataInterior)or die(mysqli_error($connection));


    //view open alarm data
    //Exterior
    if (mysqli_num_rows($resultAlarmDataExterior) > 0) {
        // output data of each row

        echo "<br><h3 style='text-align: center'>Exterior</h3><table>";
        echo("<table class='table table-striped' style='text-align: center; width: auto; border:1px solid black; border-collapse: collapse;'>");
        print("<tr>");
        echo("<th>Date</th>
                <th>Form Type</th>
                <th>Account Name</th>
                <th>Building Number</th>
                <th>Sensor Kind</th>
                <th>Sensor Location</th>
                <th>Findings</th>
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

        if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {
            echo '<th>Item Update</th>';
        }

        while ($row = mysqli_fetch_assoc($resultAlarmDataExterior)) {

            $id = $row["id"];
            $dateFound = $row["reportedTime"];
            $alarmFormSubmitType = $row["alarmTypeSubmit"];
            $submittedBy = $row["submittedBy"];
            $weather = $row["weather"];
            $findings = $row["findings"];
            $sensorKind = $row["sensorKind"];
            $fossZone = $row["fossZone"];
            $accountName = $row["accountName"];
            $sensorLocation = $row["alarmLocationType"];
            $buildingNumber = $row["buildingNumber"];
            $dutySection = $row["dutySection"];
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
                                    <td>" . $buildingNumber . "</td>
                                    ";

            if ($sensorKind === "FOSS") {

                $fossArray = "$sensorKind, $fossZone";

                echo "<td>$fossArray</td>";

            }elseif ($sensorKind === "FDB"){

                echo "<td>$fossZone</td>";
            }
            else{
              echo "  <td>$sensorKind</td>";
            }

            echo "
                                    <td>" . $sensorLocation . "</td>
                                    <td>" . $findings . "</td>
                                    <td>" . $weather . "</td>
                                    <td style='word-wrap:break-word'>" . $description . "</td>
                                    <td>" . $submittedBy . "</td>
                                    <td>" . $dutySection . "</td>
                                    <td>" . $status . "</td>
                                    <td>" . $correctedBy . "</td>
                                    <td>" . $dateCorrected . "</td>
                                     <td>" . $inspectedBY . "</td>
                                    <td>" . $notes . "</td>

                                     ";
            if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {

                echo '</td><td><a class="btn btn-md btn-primary" href="updateAlarmStatusNew.php?id=' . $id . '">Update Alarm Work Order</a></td>';

            }
            echo " </tr>
                   </tr>";
        }

    } else {
        echo "<br>
        <h3 style='text-align: center'>Exterior<br>No Alarm Work Orders Requested</h3>
        <p style='text-align: center'>No Alarm Work Orders Request have been submitted. (Exterior NARFAR is 3 within 24 hours).</p>";
    }

    echo "</table><br>";

    //view alarm data
    //interior alarms
    //
    if (mysqli_num_rows($resultAlarmDataInterior) > 0) {
        // output data of each row

        echo "<br><h3 style='text-align: center'>Interior</h3><table>";
        echo("<table class='table table-striped' style='text-align: center; width: auto; border:1px solid black; border-collapse: collapse;'>");
        print("<tr>");
        echo("<th>Date</th>
                <th>Form Type</th>
                <th>Account Name</th>
                <th>Building Number</th>
                <th>Sensor Kind</th>
                <th>Sensor Location</th>
                <th>Findings</th>
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

        if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {
            echo '<th>Item Update</th>';
        }

        while ($row = mysqli_fetch_assoc($resultAlarmDataInterior)) {

            $id = $row["id"];
            $dateFound = $row["reportedTime"];
            $alarmFormSubmitType = $row["alarmTypeSubmit"];
            $submittedBy = $row["submittedBy"];
            $weather = $row["weather"];
            $findings = $row["findings"];
            $sensorKind = $row["sensorKind"];
            $fossZone = $row["fossZone"];
            $accountName = $row["accountName"];
            $sensorLocation = $row["alarmLocationType"];
            $buildingNumber = $row["buildingNumber"];
            $dutySection = $row["dutySection"];
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
                                    <td>" . $buildingNumber . "</td>
                                    ";

            if ($sensorKind === "FOSS") {

                $fossArray = "$sensorKind, $fossZone";

                echo "<td>$fossArray</td>";

            }elseif ($sensorKind === "FDB"){

                echo "<td>$fossZone</td>";
            }
            else{
                echo "  <td>$sensorKind</td>";
            }

            echo "
                                    <td>" . $sensorLocation . "</td>
                                    <td>" . $findings . "</td>
                                    <td>" . $weather . "</td>
                                    <td>" . $description . "</td>
                                    <td>" . $submittedBy . "</td>
                                    <td>" . $dutySection . "</td>
                                    <td>" . $status . "</td>
                                    <td>" . $correctedBy . "</td>
                                    <td>" . $dateCorrected . "</td>
                                     <td>" . $inspectedBY . "</td>
                                    <td>" . $notes . "</td>

                                     ";
            if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {

                echo '</td><td><a class="btn btn-md btn-primary" href="updateAlarmStatusNew.php?id=' . $id . '">Update Alarm Work Order</a></td>';

            }
            echo " </tr>
                   </tr>";
        }

    } else {


        echo "<br>
        <h3 style='text-align: center'>Interior<br>No Alarm Work Orders Requested</h3>
        <p style='text-align: center'>No Alarm Work Orders Request have been submitted. (Interior NARFAR is 3 within 30 days).</p>";
    }

    echo "</table><br>";

}else {
    echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

    include __DIR__ . '/../../footer.php';

    header('Location: /UnitTraining/home.php');
    exit;
}


//being view of closed Alarm work orders
if (($_SESSION['page_admin']) == 'Unit_ESS' OR  ($_SESSION['page_admin']) == 'matt') {


    //$password = mysqli_escape_string($connection, $_POST['password']);
    //$unitNameUserInput = mysqli_escape_string($connection, $_POST['unitName']);
    //$link = 'Location: /UnitTraining/S4/viewWorkorderRequest.php';


    $sqlCompletedAlarmData = "SELECT * FROM alarmData
                where unitName = '$unitName'

                AND status = 'completed'";

    $resultSqlCompletedAlarmData = mysqli_query($connection, $sqlCompletedAlarmData);

    if (mysqli_num_rows($resultSqlCompletedAlarmData) > 0) {
        //($row = mysqli_fetch_array($resultappointment) > 1)

        // output data of each row
        echo "<h3 style='text-align: center'>Completed Alarm Data</h3>";

        echo "<table>";
        echo "<h3 style='text-align: center'>Exterior</h3><table>";
        echo("<table class='table table-striped' style='text-align: center; width: auto; border:1px solid black; border-collapse: collapse;'>");
        print("<tr>");
        echo("<th>Date</th>
                <th>Form Type</th>
                <th>Account Name</th>
                <th>Building Number</th>
                <th>Sensor Kind</th>
                <th>Sensor Location</th>
                <th>Findings</th>
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


        if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {
            echo '<th>Item Update</th>';
        }

        while ($row = mysqli_fetch_assoc($resultSqlCompletedAlarmData)) {

            $id = $row["id"];
            $dateFound = $row["reportedTime"];
            $alarmFormSubmitType = $row["alarmTypeSubmit"];
            $submittedBy = $row["submittedBy"];
            $weather = $row["weather"];
            $sensorLocation = $row["alarmLocationType"];
            $buildingNumber = $row["buildingNumber"];
            $findings = $row["findings"];
            $sensorKind = $row["sensorKind"];
            $accountName = $row["accountName"];
            $dutySection = $row["dutySection"];
            $correctedBy = $row["correctedBy"];
            $dateCorrected = $row["dateCorrected"];
            $inspectedBy = $row["inspectedBy"];
            $status = $row["status"];
            $notes = $row["notes"];

            $description = $row["alarmDescription"];
            $iv = $row['iv'];

            $description = openssl_decrypt($description, $cipherMethod, $essDescriptionKey, 0, $iv);


            echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $dateFound . "</td>
                                    <td>" . $alarmFormSubmitType . "</td>
                                    <td>" . $accountName . "</td>
                                    <td>" . $buildingNumber . "</td>
                                    <td>" . $sensorKind . "</td>
                                    <td>" . $sensorLocation . "</td>
                                    <td>" . $findings . "</td>
                                    <td>" . $weather . "</td>
                                    <td style='word-wrap:break-word'>" . $description . "</td>
                                    <td>" . $submittedBy . "</td>
                                    <td>" . $dutySection . "</td>
                                    <td>" . $status . "</td>
                                    <td>" . $correctedBy . "</td>
                                    <td>".$dateCorrected."</td>
                                     <td>" . $inspectedBy . "</td>
                                    <td>" . $notes . "</td>

                                     ";
            if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {




                echo '</td><td><a class="btn btn-md btn-primary" href="updateAlarmStatusNew.php?id=' . $id . '">Update Alarm Work Order</a></td>';

            }
            echo " </tr>
                   </tr>";
        }

    } else {

        echo "<br>
        <h3 style='text-align: center'>Completeed Work Orders<br>No Completed Alarm Work Orders Requested</h3>
        <p style='text-align: center'>No Completed Alarm Work Orders.</p>";

    }

    echo "</table><br>";

 include __DIR__ . '/../../footer.php';

    exit;

}else{

   // echo "You do not have permissions to view this page.";
}
?>
