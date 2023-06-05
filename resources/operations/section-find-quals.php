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

  ///-------currently certified sfmq status--------------------///
  $findsectionQuals = $mysqli->query("SELECT *
    from members m
    INNER join sfmq s
    on m.lastName = s.lastName AND m.firstName = s.firstName
    where ((dutySection = '$findUser->dutySection')
    AND (m.unitName = '$unitName'))
    and NOT m.lastName like 'DELETE%'
    AND m.rank <> 'Civ'
    order by m.lastName, s.dutyQualPos ASC") or die(mysqli_errno($mysqli));

    if ($findsectionQuals->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section Duty Qualifications (".$findUser->dutySection.")</h3><table>";
      echo "<table id='currentQuals' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Rank</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Duty Section</th>
      <th>Duty Position</th>
      <th>Date Certified</th>
      <th>QC within 90 Days</th>
      </tr>
      </thead>";

      while ($row = $findsectionQuals->fetch_assoc()) {
        echo "<tr class='nth-child' align='center'>
        <td class='nth-child'>" . $row["rank"] . "</td>
        <td>" . ucfirst(strtolower($row["lastName"])) . "</td>
        <td>" . ucfirst(strtolower($row["firstName"])) . "</td>
        <td>" . $row["dutySection"] . "</td>
        <td>

        "; if (isset($row["dutyQualPos"])){
          echo $row["dutyQualPos"];
        } else {
          $null = NULL;
          $null = "";
          echo $null;
        }echo "</td>

        <td>" . $row["primCertDate"] . "</td>
        <td>" . $row["nintyDayStart"] . "</td> </tr>
        </tr>";
      }

    } else {
      echo "<br>
      <h3 style='text-align: center'>".$findUser->dutySection." - No personnel have duty qualifications.</h3>";
    }

    echo "</table><br>";


    ///-------New-Opened sfmq status--------------------///
    $findsectionQualsNew = $mysqli->query("SELECT *
      from members m
      INNER join sfmq s
      on m.lastName = s.lastName AND m.firstName = s.firstName
      where ((dutySection = '$findUser->dutySection') OR (phase2start BETWEEN now() - INTERVAL 5 DAY AND now() + INTERVAL 60 DAY ))
      AND ((s.primCertDate = FALSE) OR (s.phase2Start = TRUE))
      AND (m.unitName = '$unitName')
      AND m.rank <> 'Civ'
      AND NOT m.lastName LIKE 'DELETE_%'
      order by m.lastName, s.dutyQualPos ASC") or die(mysqli_errno($mysqli));

      if ($findsectionQualsNew->num_rows) {
        // output data of each row

        echo "<br><h3 style='text-align: center'>Section Duty Qualifications (".$findUser->dutySection.")</h3><table>";
        echo "<table id='newQuals' class='table table-bordered table-hover'>
        <thead>
        <tr>
        <th>Rank</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>New Duty Position</th>
        <th>Phase II Start Date</th>
        <th>Phase II End Date</th>
        </tr>
        </thead>";

        while ($row = $findsectionQualsNew->fetch_assoc()) {

          echo "<tr class='nth-child' align='center'>
          <td class='nth-child'>" . $row["rank"] . "</td>
          <td>" . $row["lastName"] . "</td>
          <td>" . $row["firstName"] . "</td>
          <td>" . $row["newDutyQual"] . "</td>
          <td>" . $row["phase2Start"] . "</td>

          <!-- if the phase 2 endate is blank the $ endDate will display a date 60 days from now. the below line of code asks to display '(blank)' if the starDate is blank as well.-->
          <td>"; if ($row["phase2Start"] == ''){
            echo '';
          } else {
            echo $endDate;
          }
          echo "</td>

          </tr>";
        }

      } else {
        echo "<br>
        <h3 style='text-align: center'>No personnel are opened for duty qualifications. (".$findUser->dutySection.")</h3>";


        echo '<br>
        <div style="text-align: center;">
        <button type="submit" name="submitDPENew" id="submitDPENew" class="btn btn-primary" onclick="openWindow()">Add New DPE</button>
        </div>';

      }

      echo "</table><br>";

    }else {
      echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

      include __DIR__ . '/../../footer.php';

      header('Location: /UnitTraining/home.php');
      exit;
    }
    ?>
