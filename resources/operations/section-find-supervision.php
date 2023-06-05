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

  $findsectionSupervisorRoster = $mysqli->query("SELECT * FROM members m
    INNER JOIN supList s
    ON (m.lastName = s.lastName AND m.firstName = s.firstName AND m.middleName = s.middleName)
    where ((m.dutySection = '$findUser->dutySection') AND (m.unitName = '$unitName')
    and NOT m.lastName like 'DELETE%')
    ORDER BY m.lastName ASC") or die(mysqli_errno($mysqli));


    //view open alarm data
    //Interior
    if ($findsectionSupervisorRoster->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section Supervision (".$findUser->dutySection.")</h3><table>";
      echo "<table id='supervision' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Rank</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Supervisor Rank</th>
      <th>Supervisor First Name</th>
      <th>Supervisor Last Name</th>";
      echo"</tr>
      </thead>";




      while ($row = $findsectionSupervisorRoster->fetch_assoc()) {
        echo "<td>". $row["rank"]."</td>
        <td>".$row["lastName"]."</td>
        <td>".$row["firstName"]."</td>
        <td>".$row["superRank"]."</td>
        <td>".$row["supLastName"]."</td>
        <td>".$row["supFirstName"]."</td>
        </tr>
        ";
        // code...
      }


    } else {
      echo "<br>
      <h3 style='text-align: center'>Exterior<br>No Alarm Work Orders Requested</h3>
      <p style='text-align: center'>No personnel are assigned to your section. .</p>";
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
