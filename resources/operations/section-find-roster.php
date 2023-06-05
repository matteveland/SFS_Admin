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


  $findsectionRoster = $mysqli->query("SELECT * FROM members where unitName = '$unitName' AND dutySection = '$findUser->dutySection' and NOT lastName LIKE 'DELETE_%'") or ådie(mysqli_errno($mysqli));


  //view open alarm data
  //Interior
  if ($findsectionRoster->num_rows) {
    // output data of each row

    echo "<br><h3 style='text-align: center'>Assigned Personnel (".$findUser->dutySection.")</h3><table>";
    echo "<table id='roster' class='table table-bordered table-hover'>
    <thead>
    <tr>
    <th>Rank</th>
    <th>Last Name</th>
    <th>First Name</th>";

    if ($findUser->admin !="Yes") {

      // code...
    }else{
      echo "<th>Delete Member</th>
      </tr>";

    }

    echo "</thead>";




    while ($row = $findsectionRoster->fetch_assoc()) {
      echo "<td>". $row["rank"]."</td>
      <td><a href=/resources/Admin/Edit-User/member-view.php?ID=".$row['dodId']."&last=".$row['lastName'].">". $row["lastName"]."</a></td>
      <td>".$row["firstName"]."</td>";


      if ($findUser->admin !="Yes") {

        // code...
      }else{
        echo "<td><a href='/resources/Admin/Delete-User/member-delete.php?ID=".$row['dodId']."&last=".$row['lastName']."' style='color:red' onclick='return confirmDelete(this);'> Delete Member </a></td>";
      }


      echo"</tr>
      ";
      //ID=".$row['dodId']."&last=".$row['lastName'].">". $row["lastName"]."
      //onclick='return confirmDelete(this);
    }


  } else {

    echo "<br>
    <h3 style='text-align: center'><br>No personnel assigned to your section. (".$findUser->dutySection.")</h3>";
  }
  //this is needed to close the table must keep!
  echo "</table><br>";

}else {
  echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

  include __DIR__ . '/../../footer.php';

  header('Location: /UnitTraining/home.php');
  exit;
}
