<?php


include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';

$unitName = $_SESSION['unitName'];

$adminName = $_SESSION['page_admin'];
$userName = $_SESSION['page_user'];

$finduser = "select * from login where (user_name = '$adminName' or user_name = '$userName') AND unitName = '$unitName'";

$resultFindUser = mysqli_query($connection, $finduser);

while ($row = mysqli_fetch_assoc($resultFindUser)) {

    $recallSubmittedByLast = $row['lastName'];
    $recallSubmittedByFirst = $row['firstName'];
}
$recallUser = array();
$recallUser = "$recallSubmittedByLast, $recallSubmittedByFirst";

$updateItemId = mysqli_real_escape_string($connection, $_GET['id']);

$now = date('Y-m-d');

$findSubmitter = "SELECT * FROM alarmData where id = '$updateItemId' and unitName ='$unitName'";

$resultsFindSubmitter = mysqli_query($connection, $findSubmitter);

while ($row = mysqli_fetch_assoc($resultsFindSubmitter)) {

    $recallSubmittedBy = $row['submittedBy'];
    $recallIv = $row['iv'];
}

if ((($_SESSION['page_admin']) == 'Unit_ESS') or (($_SESSION['page_admin']) == 'matt') or ($recallSubmittedBy === $recallUser)) {

    if (isset($_GET['id'])) {

        if (isset($_POST['update']) and ($recallSubmittedBy == $recallUser)) {

            $updateFormType = mysqli_real_escape_string($connection, $_POST['inputFormType']);
            $updateAccountName = mysqli_real_escape_string($connection, $_POST['inputAccountName']);
            $updateSensorLocation = mysqli_real_escape_string($connection, $_POST['inputSensorLocation']);
            $updateFindings = mysqli_real_escape_string($connection, $_POST['inputFindings']);
            $updateDescription = mysqli_real_escape_string($connection, $_POST['inputDescription']);

            $encryptedAlarmDescription = openssl_encrypt($updateDescription, $cipherMethod, $essDescriptionKey, $options = 0, $recallIv);

            $updateBuildingNumber = mysqli_real_escape_string($connection, $_POST['inputBuildingNumber']);

            $updateAlarmStatusUser = "UPDATE alarmData SET alarmTypeSubmit = '$updateFormType', accountName = '$updateAccountName', alarmLocationType = '$updateSensorLocation', findings = '$updateFindings',
                                alarmDescription = '$encryptedAlarmDescription', buildingNumber = '$updateBuildingNumber' WHERE (id = '$updateItemId')";

            $resultsUpdateAlarmStatus = mysqli_query($connection, $updateAlarmStatusUser);

            if (!$resultsUpdateAlarmStatus) {
                $failuremsg = "Alarm status failed to update.";

                echo '<div class="alert alert-danger" role="alert" style="alignment: center"> ' . $failuremsg . '  <p><br>';

                $location = "'viewAlarmData.php'";

                echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
            } else {
                $successmsg = "Alarm status successfully updated. Select the link below to return to the View Alarm Status.";

                echo '<div align="center" class="alert alert-success" role="alert" style="alignment: center"> ' . $successmsg . '  <p><br>';

                $location = "'viewAlarmData.php'";

                echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
            }
        }

        if ((($_SESSION['page_admin']) == 'Unit_ESS') or (($_SESSION['page_admin']) == 'matt')) {

            $updateFormType = mysqli_real_escape_string($connection, $_POST['inputFormType']);
            $updateAccountName = mysqli_real_escape_string($connection, $_POST['inputAccountName']);
            $updateSensorLocation = mysqli_real_escape_string($connection, $_POST['inputSensorLocation']);
            $updateFindings = mysqli_real_escape_string($connection, $_POST['inputFindings']);
            $updateDescription = mysqli_real_escape_string($connection, $_POST['inputDescription']);

            //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
            $encryptedAlarmDescription = openssl_encrypt($updateDescription, $cipherMethod, $essDescriptionKey, $options = 0, $recallIv);

            $updateBuildingNumber = mysqli_real_escape_string($connection, $_POST['inputBuildingNumber']);

            $updateInspectedDate = mysqli_real_escape_string($connection, $_POST['dateInspected']);
            $updateInspectedBy = mysqli_real_escape_string($connection, $_POST['inspectedBy']);
            $updateNotes = mysqli_real_escape_string($connection, $_POST['noteBox']);
            $updateCorrectedBy = mysqli_real_escape_string($connection, $_POST['inputCorrectedBy']);
            $updateStatus = mysqli_real_escape_string($connection, $_POST['alarmUpdate']);

            if (isset($_POST['update'])) {

                $updateAlarmStatus = "UPDATE alarmData SET status = '$updateStatus', notes = '$updateNotes', inspectedBy = '$updateInspectedBy', dateCorrected = '$updateInspectedDate',
                                correctedBy = '$updateCorrectedBy', alarmTypeSubmit = '$updateFormType', accountName = '$updateAccountName', alarmLocationType = '$updateSensorLocation',
                                findings = '$updateFindings', alarmDescription = '$encryptedAlarmDescription', buildingNumber = '$updateBuildingNumber' WHERE (id = '$updateItemId')";
                $resultsUpdateAlarmStatus = mysqli_query($connection, $updateAlarmStatus) or die(mysqli_error($connection));

                if (!$resultsUpdateAlarmStatus) {
                    $failuremsg = "Alarm status failed to update.";

                    echo '<div class="alert alert-danger" role="alert" style="alignment: center">> ' . $failuremsg . '  <p><br>';

                    $location = "'viewAlarmData.php'";

                    echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
                } else {

                    if ($recallSubmittedBy == $recallUser) {

                        $location = "'viewAlarmData.php'";

                        echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
                    } else {
                        $successmsg = "Alarm status successfully updated. Select the link below to return to the View Alarm Status.";

                        echo '<div align="center" class="alert alert-success" role="alert" style="alignment: center"> ' . $successmsg . '  <p><br>';

                        $location = "'viewAlarmData.php'";

                        echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
                    }
                }
            }
        }

        if (isset($_POST['cancel'])) {

            $failuremsg = "Update was cancelled. Returning to main alarm work order page.";

            echo '<div class="alert alert-danger" role="alert" align="center"> ' . $failuremsg . '  <p><br>';

            $location = "'viewAlarmData.php'";

            echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
        } else {
        }

        $selectAlarmUpdate = "SELECT * FROM alarmData WHERE id = '$updateItemId' and unitName = '$unitName'";

        $resultSelectAlarmUpdate = mysqli_query($connection, $selectAlarmUpdate);


?>
        <html>
        <title>ESS</title>

        <head>
            <br>

            <?php include('navigation.html'); ?>
            <br>

        </head>

        </html>
<?php

        if ($resultSelectAlarmUpdate > 0) {

            echo "<form class='member-update' method='post'>

                <h3 align='center'>Update Alarm Data</h3>";

            echo "<table>";
            echo ("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
            echo ("<th>Date</th>
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

                <th>Update</th>
                ");

            if ((($_SESSION['page_admin']) == 'Unit_ESS') or (($_SESSION['page_admin']) == 'matt')) {

                echo ("<th>Corrected Date</th>
                <th>Inspected By</th>
                 <th>Notes</th>
                 <th>Status</th>
                 <th>Update</th>");
            }

            while ($row = mysqli_fetch_assoc($resultSelectAlarmUpdate)) {

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
                                    ";
                echo "<td><select class='form-control' id = 'inputFormType' name = 'inputFormType' title = 'inputFormType' >
                                        <option value = '340'";
                if ($alarmFormSubmitType == '340') {
                    echo 'selected';
                }
                echo " >340</option >
                                        <option value = '781A'";
                if ($alarmFormSubmitType == '781A') {
                    echo 'selected';
                }
                echo " >781A</option ></select >";


                if ($accountName == '' or NULL) {

                    echo "<td><input type='text' class='form-control' id='inputAccountName' name='inputAccountName' value='' placeholder='Account Name'></td>";
                } else {
                    echo "<td><input type='text' class='form-control' id='inputAccountName' name='inputAccountName' value='" . $accountName . "' placeholder=''></td>";
                }

                echo "</td>";

                if ($buildingNumber == '' or NULL) {

                    echo "<td><input type='text' class='form-control' id='inputBuildingNumber' name='inputBuildingNumber' value='' placeholder='Account Name'></td>";
                } else {
                    echo "<td><input type='text' class='form-control' id='inputBuildingNumber' name='inputBuildingNumber' value='" . $buildingNumber . "' placeholder=''></td>";
                }

                echo "</td>";

                if ($sensorKind === "FOSS") {

                    $fossArray = "$sensorKind , $fossZone";

                    echo "<td>$fossArray</td>";
                } elseif ($sensorKind === "FDB") {

                    echo "<td>$fossZone</td>";
                } else {
                    echo "  <td>$sensorKind</td>";
                }

                echo "<td><select class='form-control' id = 'inputSensorLocation' name = 'inputSensorLocation' title = 'inputSensorLocation' >
                                        <option value = 'Interior'";
                if ($sensorLocation == 'Interior') {
                    echo 'selected';
                }
                echo " >Interior</option >
                                        <option value = 'Exterior'";
                if ($sensorLocation == 'Exterior') {
                    echo 'selected';
                }
                echo " >Exterior</option ></select ></td>";


                echo "<td><select class='form-control' id = 'inputFindings' name = 'inputFindings' title = 'inputFindings'>
                   <option value = 'Other'";
                if ($findings == 'Other') {
                    echo 'selected';
                }
                echo " >Other</option >
                   <option value = 'False'";
                if ($findings == 'False') {
                    echo 'selected';
                }
                echo " >False</option >
                   <option value = 'Nuisance'";
                if ($findings == 'Nuisance') {
                    echo 'selected';
                }
                echo ">Nuisance</option ></select ></td>";


                echo "
                                    <td>" . $weather . "</td>";


                echo "<td><textarea class='form-control' id='inputDescription' name='inputDescription' rows='5' placeholder='Enter ...'>";
                echo htmlspecialchars($description);
                echo "</textarea>

                  </td>


                                    <td>" . $submittedBy . "</td>
                                    <td>" . $dutySection . "</td>
                                    <td>" . $status . "</td>
                                    ";

                if ((($_SESSION['page_admin']) == 'Unit_ESS') or (($_SESSION['page_admin']) == 'matt')) {
                    echo "<td>

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

                    echo "</td><td>";
                    if ($dateCorrected == '' or NULL) {

                        echo "<input type='text' class='form-control' id='dateInspected' name='dateInspected' value='' placeholder='Date Corrected'>";
                    } else {

                        echo "<input type='text' class='form-control' id='dateInspected' name='dateInspected' value='$dateCorrected' placeholder='Date Corrected'>";
                    }

                    echo "</td>
                      <td>";
                    if ($inspectedBY == '' or NULL) {

                        echo "<input type='text' class='form-control' id='inspectedBy' name='inspectedBy' value='' placeholder='Inspected By'>";
                    } else {

                        echo "<input type='text' class='form-control' id='inspectedBy' name='inspectedBy' value='$inspectedBY' placeholder='Inspected By'>";
                    }

                    echo '</td><td>
                        <textarea class="form-control" id="noteBox" name="noteBox" rows="5" placeholder="Enter ..."> ';
                    echo htmlspecialchars($notes);
                    echo '</textarea>

                  </td>
                   <td><select class="form-control" id="alarmUpdate" name="alarmUpdate" title="alarmUpdate">
                                    <option value="open"';
                    if ($status == "") echo "selected";
                    echo '>NONE</option>
                                    <option value="submitted"';
                    if ($status == "moreInfo") echo "selected";
                    echo ' >Submitted to ESS or Contractor</option>
                                    <option value="completed"';
                    if ($status == "completed") echo "selected";
                    echo ' >Completed</option>
                                </select></td>
                                <br>
                                <br>';
                }
                echo '<td><input class="btn btn-md btn-danger" type="submit" name="cancel" id="cancel" value="cancel">
                                <input class="btn btn-md btn-primary" type="submit" name="update" id="update" value="Update Status"></td>

                                </div>
                          </form>
                    </div>
                 </div>


 ';
                // echo '<meta http-equiv="refresh" content="0; url='.$location.'">';

            }
        } else {
            echo '<p style="text-align: center">No Items Selected<br><a href="viewAlarmData.php">View Purchase Request</a></p>';
        }
    } else {

        echo "You do not have permission to view this page. (1)";
    }
} else {

    echo "You do not have permission to view this page. (2)";
}

?>
