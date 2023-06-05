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

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

if (($_SESSION['page_admin']) OR ($_SESSION['page_user']) == true) {

  $findsectionAppointments = $mysqli->query("SELECT *
    FROM members m INNER JOIN appointmentRoster a
    ON (m.lastName = a.lastName AND m.firstName = a.firstName)
    where (m.dutySection = '$findUser->dutySection')
    AND (a.startdate BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 30 DAY)
    AND NOT a.title = 'Leave'
    and NOT a.lastName LIKE 'DELETE_%'
    AND (m.unitName = '$findUser->unitName')

    order by a.startdate, m.lastName ASC");

    //view open alarm data
    //Interior
    if ($findsectionAppointments->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section Appointments (".$findUser->dutySection.")</h3><table>";
      echo "<table id='appointments' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Rank</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Appointment Type</th>
      <th>Date</th>
      <th>Time</th>
      <th>Installation</th>
      <th>Location</th>
      <th>Self Made</th>
      <th>Notes</th>
      </tr>
      </thead>";




      while ($row = $findsectionAppointments->fetch_assoc()) {

        ucwords(strtolower($row["title"]));


        echo "<tr class='nth-child'>
        <td class='nth-child'>" . $row["rank"]. "</td>
        <td>" . ucwords(strtolower($row["lastName"])). "</td>
        <td>" . ucwords(strtolower($row["firstName"])). "</td>
        <td>" . ucwords(strtolower($row["title"])) . "</td>
        <td>". $row["startdate"] ." </td>
        <td>" . $row["appointmentTime"]. "</td>
        <td>" . ucwords(strtolower($row["installation"])). "</td>
        <td>" . ucwords(strtolower($row["location"])). "</td>
        <td>" . ucwords(strtolower($row["selfMade"])). "</td>
        <td>" . $row["notes"] . "</td></tr>
        ";
        // code...
      }


    } else {
      echo "<br>
      <h3 style='text-align: center'>".$findUser->dutySection." has no appointments scheduled for the next 30 days</h3>";
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
