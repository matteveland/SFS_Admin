<?php
//get registration for inclusion from vehicle-update-data.php
$registration = $_SESSION['registration'];
$id = $_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';


//$id= $mysqli->real_escape_string($_POST['id']);


//Select Vehicle information to display for history

$recallHistoryAll = "SELECT * FROM vehicles_mileage WHERE registration = '$registration' ORDER BY mileage DESC";
$resultsRecallHistoryAll = $mysqli->query($recallHistoryAll);

$recallHistoryAvg = "SELECT @next_mileage - mileage AS diff, @next_mileage := mileage AS Total FROM (SELECT mileage FROM vehicles_mileage WHERE registration = '$registration' ORDER BY lastUpdate DESC) AS recent10 CROSS JOIN (SELECT @next_mileage := NULL) AS var";

$resultsRecallHistoryAvg = $mysqli->query($recallHistoryAvg);
while($resultsHistoryAvgReturn = $resultsRecallHistoryAvg->fetch_assoc()){

$avgDiff = $resultsHistoryAvgReturn['diff'];

}


$avgMileage = "SELECT AVG(difference) AS AvgDiff FROM ( SELECT @next_mileage - mileage AS difference, @next_mileage := mileage FROM (SELECT mileage FROM vehicles_mileage WHERE registration = '$registration' ORDER BY lastUpdate DESC) AS recentTen CROSS JOIN (SELECT @next_mileage := NULL) AS var ) AS recent_diffs";

$returnAvgMileage = $mysqli->query($avgMileage);

while ($resultsReturnAvgMileage = $returnAvgMileage->fetch_assoc()) {
  $thing = $resultsReturnAvgMileage['AvgDiff'];
}




?>

<div class="form-group">
  <h4>Mileage Information</h4>
</div>

<?php
if ($resultsRecallHistoryAll->num_rows > 0) {
  echo "<table id='mileage' class='table table-bordered table-hover'>
          <thead>
            <tr>
              <th>Status</th>
              <th>Historical Mileage</th>
              <th>Mileage Difference Reported</th>
              <th>Mileage Reported</th>
              <th>Last Updated By</th>
              <th>Edit/Remove</th>
            </tr>
          </thead>";

  while (($recallHistory = $resultsRecallHistoryAll->fetch_assoc())) {

    echo "<tr class='nth-child' align='center'>
            <td class='nth-child'>" . $recallHistory['status'] . "</td>
            <td class='nth-child'>" . $recallHistory['mileage'] . "</td>
            <td class='nth-child'>" . $avgDiff . "</td>
            <td class='nth-child'>" . $recallHistory['lastUpdate'] . "</td>
            <td class='nth-child'>" . $recallHistory['updatedBy'] . "</td>
    ";
    if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){
      echo "<td>" . '<a class="btn btn-md btn-primary" href="vehicle-view-entry-information.php?id=' . $recallHistory['id']. '&reg='.$registration.'">Update Entry</a></p>' . "</td>
      </tr>";
    }else{
    }
  }
  echo "<tr class='nth-child' align='center'>
          <td class='nth-child'></td>
          <td class='nth-child'></td>
          <td class='nth-child'>Avg mileage per day " . $thing . "</td>
          <td class='nth-child'></td>
          <td class='nth-child'></td>
          <td class='nth-child'></td>
        </tr>";



} else {
  echo "<p align='center'>No Vehicle Information</p>";
}
//need </table> to align table in proper area on page (above footer)
echo "</table>";
