<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
//verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];
$now = date('Y-m-d');

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

if (($_SESSION['page_admin']) OR ($_SESSION['page_user']) == true) {

  $findsectionLeave = $mysqli->query("select *
  from members m
  INNER JOIN appointmentRoster a
  ON m.lastName = a.lastName AND m.firstName = a.firstName
  where (m.dutySection = '$findUser->dutySection')
  AND a.title = 'Leave' AND ((a.startdate BETWEEN NOW() - INTERVAL 5 DAY AND NOW() + INTERVAL 45 DAY ) OR (a.enddate BETWEEN '$now' - INTERVAL 5 DAY AND '$now' + INTERVAL 75 DAY))
  AND (m.unitName = '$unitName')
  AND NOT m.lastName LIKE 'DELETE_%'
  order by a.enddate ASC") or die(mysqli_errno($mysqli));

  //print_r($findsectionLeave);
  //view open alarm data
  //Interior
  if ($findsectionLeave->num_rows) {
    // output data of each row

    echo "<br><h3 style='text-align: center'>Section Leave (".$findUser->dutySection.")</h3><table>";
    echo "<table id='leave' class='table table-bordered table-hover'>
    <thead>
    <tr>
    <th>Rank</th>
    <th>Last Name</th>
    <th>First Name</th>
    <th>State</th>
    <th>Leave Start Date</th>
    <th>Leave End Date</th>
    <th>Location</th>
    <th>Added By</th>
    <th>Date Added</th>
    <th>Override</th>
    </tr>
    </thead>";




    while ($row = $findsectionLeave->fetch_assoc()) {

      echo "<tr class='nth-child' style='text-align: center'>
      <td class='nth-child'>" . $row["rank"] . "</td>
      <td>" . $row["lastName"] . "</td>
      <td>" . $row["firstName"] . "</td>
      <td>" . $row["installation"] . "</td>
      <td>" . $row["startdate"] . "</td>
      <td>" . $row["enddate"] . "</td>
      <td>" . $row["location"] . "</td>
      <td>" . $row["addedBy"] . "</td>
      <td>" . $row["dateAdded"] . "</td>
      <td>" . $row["overRide"] . "</td>

      </tr>
      ";
      // code...
    }


  } else {
    echo "<br>
    <h3 style='text-align: center'>".$findUser->dutySection." - No personnel have leave scheduled for the next 75 days</h3>";
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
