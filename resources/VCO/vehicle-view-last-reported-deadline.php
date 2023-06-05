<?php
//get registration for inclusion from vehicle-update-data.php
$registration = $_SESSION['registration'];
$id = $_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
//$id= $mysqli->real_escape_string($_POST['id']);


$recallDeadlineInformation = "SELECT * FROM vehicles_mileage WHERE registration = '$registration' ORDER BY lastupdate";
$resultRecallDeadlineInformation = $mysqli->query($recallDeadlineInformation);


//Select Vehicle information to display for history

?>

<!-- Select mileage for vehicle, display select option -->


<!-- Display last 10 Deadline vehicle information -->
  <div class="form-group">
<h4>Deadline Information</h4>
</div>
    <?php
    if ($resultRecallDeadlineInformation->num_rows > 0) {
      echo "<table>
      <table id='deadlined' class='table table-bordered table-hover'>
        <thead>
      <tr>
      <th>Mileage Reported When Deadlined</th>
      <th>Post Reporting Deadline</th>
      <th>Driver Name</th>
      <th>Deadline Reason</th>
      <th>Date of Deadline</th>
      <th>Last Updated By</th>


      </tr>
      </thead>";
      while ($recallDeadlineVehicle = $resultRecallDeadlineInformation->fetch_assoc()) {
        $recallRecallDeadlineVehicleUpdatedBy = $recallDeadlineVehicle['updatedBy'];
        $recallRecallDeadlineVehicleLastUpdate = $recallDeadlineVehicle['lastUpdate'];
        $recallRecallDeadlineVehiclePost = $recallDeadlineVehicle['post'];
        $recallRecallDeadlineVehicleStatus = $recallDeadlineVehicle['status'];
        $recallRecallDeadlineVehicleReason = $recallDeadlineVehicle['deadlineReason'];
        $recallRecallDeadlineVehicleMileage = $recallDeadlineVehicle['mileage'];
        $recallRecallDeadlineVehicleDriverName = $recallDeadlineVehicle['driverName'];

        echo "<tr class='nth-child' align='center'>
        <td class='nth-child'>" . $recallRecallDeadlineVehicleMileage . "</td>
        <td class='nth-child'>" . $recallRecallDeadlineVehiclePost . "</td>
        <td class='nth-child'>" . $recallRecallDeadlineVehicleDriverName . "</td>
        <td class='nth-child'>" . $recallRecallDeadlineVehicleReason . "</td>
        <td class='nth-child'>" . $recallRecallDeadlineVehicleLastUpdate . "</td>
        <td class='nth-child'>" . $recallRecallDeadlineVehicleUpdatedBy . "</td>
        </tr>";

        //need </table> to align table in proper area on page (above footer)
      }
      echo "</table>";
    } else {
      echo "<p align='center'>No Deadline Vehicle Information</p>";
    }
    ?>
