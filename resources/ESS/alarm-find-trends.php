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



  //----------------------EPR items------------------------//
  $findESSExterior = $mysqli->query("SELECT accountName, count(*) AS total FROM alarmData where reportedTime > '2021-09-01' and alarmLocationType = 'Exterior' GROUP BY accountName ORDER BY total Desc");

  $findESSInterior = $mysqli->query("SELECT accountName, count(*) AS total FROM alarmData where reportedTime > '2021-09-01' and alarmLocationType = 'Interior' GROUP BY accountName ORDER BY total Desc");



    if ($findESSExterior->num_rows) {
      // output data of each row
      echo "<br><h3 style='text-align: center'>Exterior Alarms Status</h3><table>";
      echo "<table id='alarm' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Account</th>
      <th>Total</th>
      </tr>
      </thead>";

      while ($row = $findESSExterior->fetch_assoc()) {
        echo "<tr class='nth-child' style='text-align: center';'>
        <td class='nth-child'>".$row['accountName']."</td>
        <td>".$row['total']."</td>

        </tr>";
      }

    } else {
      echo "<br>
      <h3 style='text-align: center'>No personnel have EPR Actions Required (".$findUser->dutySection.").</h3>";
    }
    echo "</table><br>";


        if ($findESSInterior->num_rows) {
          // output data of each row
            echo "<br><h3 style='text-align: center'>Interior Alarms Status</h3><table>";
          echo "<table id='alarm' class='table table-bordered table-hover'>
          <thead>
          <tr>
          <th>Account</th>
          <th>Total</th>
          </tr>
          </thead>";

          while ($row = $findESSInterior->fetch_assoc()) {
            echo "<tr class='nth-child' style='text-align: center';'>
            <td class='nth-child'>".$row['accountName']."</td>
            <td>".$row['total']."</td>

            </tr>";
          }

        } else {
          echo "<br>
          <h3 style='text-align: center'>No personnel have EPR Actions Required (".$findUser->dutySection.").</h3>";
        }
        echo "</table><br>";


          //Part of the inital if statement to see if the user is logged in.
        }
