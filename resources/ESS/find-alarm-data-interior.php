<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

//verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];

if (($_SESSION['page_admin']) == 0) {

    $sqlAlarmDataInterior = $mysqli->query("SELECT * FROM alarmData
      where (unitName = '$unitName' AND (status <> 'completed' AND accountedFor <>'Y' AND alarmLocationType = 'Interior' and (alarmTypeSubmit = '340') and (reportedTime BETWEEN now() - INTERVAL 30 DAY AND now() + INTERVAL 1 DAY )))

      OR (unitName = '$unitName' AND status <> 'completed' AND alarmLocationType = 'Interior' and (alarmTypeSubmit = '781A'))
      ORDER BY alarmTypeSubmit DESC, accountName asc, buildingNumber ASC, sensorKind ASC, fossZone ASC, alarmLocationType ASC, reportedTime DESC") or die(mysqli_errno($mysqli));

      //view open alarm data
      //Interior
      if ($sqlAlarmDataInterior->num_rows > 0) {
        // output data of each row

        echo "<br><h3 style='text-align: center'>Interior</h3><table>";
        echo "<table id='InteriorAlarmTables' class='table table-bordered table-hover'>
        <thead>
        <tr>
        <th>Date</th>
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
        ";

        if (($_SESSION['page_admin']) == 'Unit_ESS' OR 'matt') {
          echo '<th>Item Update</th>';
        }
        echo"</tr>
        </thead>";

        while ($row = $sqlAlarmDataInterior->fetch_assoc()) {

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
          $accessPoint = $row["accessPoint"];
          $dutySection = $row["dutySection"];
          $correctedBy = $row["correctedBy"];
          $dateCorrected = $row["dateCorrected"];
          $inspectedBY = $row["inspectedBy"];
          $status = $row["status"];
          $notes = $row["notes"];
          $description = $row["alarmDescription"];

          $iv = $row['iv'];
          $description = openssl_decrypt($description, $_ENV['cipherMethod'], $_ENV['essDescriptionKey'], 0, $iv);

          echo "<tr class='nth-child'>
          <td class='nth-child'>" . $dateFound . "</td>
          <td>" . $alarmFormSubmitType . "</td>
          <td>" . $accountName . " ";

          if (!$accessPoint == '0' or ''){
            echo "<br>
            <br>
            Alarm Point: ". $accessPoint ."</td>

            ";
          }else{
            echo "</td>";
          }
          echo "
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

            echo '</td><td><a class="btn btn-md btn-primary" href="alarm-update-status.php?id=' . $id . '">Update Alarm Work Order</a></td>';

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

      //view open alarm data
      //exterior alarms
      //


    }else {
      echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

      include __DIR__ . '/../../footer.php';

      header('Location: /UnitTraining/home.php');
      exit;
    }
