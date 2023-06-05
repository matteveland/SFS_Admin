<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
parse_str($_SERVER['QUERY_STRING'], $query);
$id = $mysqli->real_escape_string($query['ID']);
$last = $mysqli->real_escape_string($query['last']);
$unitName = $_SESSION['unitName'];

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);




if (($_SESSION['page_admin']) == true) {


  $findsectionRoster = $mysqli->query("SELECT * FROM members where unitName = '$unitName' and NOT lastName LIKE 'DELETE_%' ORDER BY lastName ASC");

  //view open alarm data
  //Interior
  if ($findsectionRoster->num_rows) {
    // output data of each row

    echo "<br><div class='dataTables_wrapper dt-bootstrap4'>
    <h3 style='text-align: center'>Assigned Personnel (".$findUser->unitName.")</h3><table>";
    echo "<table id='example1' class='table table-bordered table-striped'>

    <thead>
    <tr>
    <th>DoD ID</th>
    <th>Rank</th>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Section Assigned</th>
    <th>Delete Member</th>
    <th>Current Access Permissions</th>
    </tr>
    </thead>";

    while ($row = $findsectionRoster->fetch_assoc()) {

      $memberAccessPermissions = $row['specialAccess'];
      //create array of unit access programs//
      $memberAccessPermissions = explode(", ", $memberAccessPermissions);
      //sory array alphebetical
      natsort($memberAccessPermissions);

      echo "<td>". $row["dodId"]."</td><td>". $row["rank"]."</td>
    <td><a href=/resources/Admin/Edit-User/member-view.php?ID=".$row['dodId']."&last=".$row['lastName'].">". ucfirst(strtolower($row["lastName"]))."</a></td>
      <td>".ucfirst(strtolower($row["firstName"]))."</td>

      <td>".$row["dutySection"]."</td>
      <td><a href='/resources/Admin/Delete-User/member-delete.php?ID=".$row['dodId']."&last=".$row['lastName']."' style='color:red' onclick='return confirmDelete(this);'> Delete Member </a>
      <td>";

sort($memberAccessPermissions);
      foreach ($memberAccessPermissions as $key) {

        if ($key == NULL){

        }else {

                  echo " | ".$key." | ";
                  // code...
        }



      }

     echo "</td>
      </tr>
      ";
      //ID=".$row['dodId']."&last=".$row['lastName'].">". $row["lastName"]."
      //onclick='return confirmDelete(this);
    }

  } else {

    echo "<br>
    <h3 style='text-align: center'><br>No personnel assigned to your section. (".$findUser->dutySection.")</h3>";
  }
  //this is needed to close the table must keep!
  echo "</table></div><br>";

}else {
  echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

  include __DIR__ . '/../../footer.php';

  header('Location: /UnitTraining/home.php');
  exit;
}
