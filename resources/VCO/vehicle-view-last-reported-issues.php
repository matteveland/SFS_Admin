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


if (isset($_POST['selectFormNumberSumbit'])) {
  $selectNumber = $_POST['selectFormNumber'] + 1;


  $resultsRecallFormHistoryAll = $mysqli->query("SELECT * FROM vehicles_mileage WHERE registration = '$registration' ORDER BY lastUpdate DESC LIMIT $selectNumber");
} else {

  $resultsRecallFormHistoryAll = $mysqli->query("SELECT * FROM vehicles_mileage WHERE registration = '$registration' ORDER BY lastUpdate");

}
 ?>

 <div class="form-group">
<h4>Issues Reported</h4>
</div>
<?php

if ($resultsRecallFormHistoryAll->num_rows > 0) {

  echo "<table>
<table id='issues' class='table table-bordered table-hover'>
<thead>
  <tr>
  <th>Status</th>
  <th>AF1800 </th>
  <th>VCO Notified</th>
  <th>Waiver Card</th>
  <th>VCO Notified</th>
  <th>section</th>
  <th>Date Reported</th>
  <th>Reported By</th>
  </tr>
  </thead>";

  while ($recallFormHistory = $resultsRecallFormHistoryAll->fetch_assoc()) {

    echo "<tr class='nth-child' align='center'>
    <td class='nth-child'>" . $recallFormHistory['status'] . "</td>
    <td class='nth-child'>" . $recallFormHistory['AF1800'] . "</td>
    <td class='nth-child'>" . $recallFormHistory['1800Notes'] . "</td>
    <td class='nth-child'>" . $recallFormHistory['waiverCard'] . "</td>
    <td class='nth-child'>" . $recallFormHistory['waiverNotes'] . "</td>
    <td class='nth-child'>" . $recallFormHistory['dutySection'] . "</td>
    ";

    if (($recallFormHistory['AF1800'] !== 'Current') OR ($recallFormHistory['waiverCard'] !== 'Current')){

      echo "<td class='nth-child' style='color:red'><p>" . $recallFormHistory['lastUpdate'] . "</p></td>";

    } else{
      echo "<td class='nth-child'>" . $recallFormHistory['lastUpdate'] . "</td>";
    }

    echo "</td>
    <td class='nth-child'>" . $recallFormHistory['updatedBy'] . "</td>
    </tr>";
  }
  echo "";
} else {
  echo "<p align='center'>No Vehicle Information</p>";
}
//need </table> to align table in proper area on page (above footer)
echo "</table>";
?>
