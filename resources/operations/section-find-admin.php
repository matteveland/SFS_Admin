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
  $findsectionCSSActionsEPR = $mysqli->query("SELECT *
    from members m
    INNER JOIN import_eprStatus AS e
    where m.lastName = e.rateeLastName AND m.firstName = e.rateeFirstName AND (m.dutySection = '$findUser->dutySection')
    AND (m.unitName = '$unitName')
    AND NOT m.lastName LIKE 'DELETE_%'
    order by e.closeoutDate ASC") or die(mysqli_errno($mysqli));

    if ($findsectionCSSActionsEPR->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section EPR Status (".$findUser->dutySection.")</h3><table>";
      echo "<table id='sectionEPRs' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Rank</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Currently With</th>
      <th>With Since</th>
      <th>Days Pending</th>
      <th>MilPDS Date</th>
      </tr>
      </thead>";




      while ($row = $findsectionCSSActionsEPR->fetch_assoc()) {
        echo "<tr class='nth-child' style='text-align: center';'>
        <td class='nth-child'>" . $row["grade"] . "</td>
        <td>" . $row["rateeLastName"] . "</td>
        <td>" . $row["rateeFirstName"] . "</td>
        <td>" . $row["pendingCoord"] . "</td>
        <td>" . $row["pendingCoordDate"] . "</td>
        <td>" . $row["daysPending"] . "</td>
        <td>" . $row["milpdsUpdateDate"] . "</td>
        </tr>";
      }


    } else {
      echo "<br>
      <h3 style='text-align: center'>No personnel have EPR Actions Required (".$findUser->dutySection.").</h3>";
    }
    echo "</table><br>";

    //----------------------DEC items------------------------//
    $findsectionCSSActionsDECs = $mysqli->query("SELECT *
      from members m
      INNER JOIN import_decStatus AS d
      where (m.dutySection = '$findUser->dutySection')
      AND m.lastName = d.lastName AND m.firstName = d.firstName
      AND (m.unitName = '$unitName')
      AND NOT m.lastName LIKE 'DELETE_%'
      order by d.enddate") or die(mysqli_errno($mysqli));

      if ($findsectionCSSActionsDECs->num_rows) {
        // output data of each row

        echo "<br><h3 style='text-align: center'>Section Decoration Status (".$findUser->dutySection.")</h3><table>";
        echo "<table id='sectionDecs' class='table table-bordered table-hover'>
        <thead>
        <tr>
        <th>Rank</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Currently With</th>
        <th>Date Assigned</th>
        <th>End Date</th>
        <th>Start Date</th>
        <th>Reason</th>
        <th>Type</th>
        </tr>
        </thead>";

        while ($row = $findsectionCSSActionsDECs->fetch_assoc()) {
          echo "<tr class='nth-child' style='text-align: center';'>
          <td class='nth-child'>" . $row["lastName"] .  "</td>
          <td>" . $row["firstName"] . "</td>
          <td>" . $row["currentAssigned"] ."</td>
          <td>" . $row["pendingCoordDate"] . "</td>
          <td>" . $row["endDate"] . "</td>
          <td>" . $row["startDate"] . "</td>
          <td>" . $row["reason"] . "</td>
          <td>" . $row["decType"] . "</td>
          <td>" . $row["grade"] . "</td>
          </tr>";
        }


      } else {
        echo "<br>
        <h3 style='text-align: center'>No personnel have DEC Actions Required. (".$findUser->dutySection.")</h3>";
      }
      echo "</table><br>";



      //----------------------GTC items------------------------//


      $findsectionCSSActionsGTC = $mysqli->query("SELECT *
        from members m
        INNER JOIN import_gtc AS g
        ON m.lastName = g.lastName AND m.firstName = g.firstName
        where (m.dutySection = '$findUser->dutySection')
        AND (m.unitName = '$unitName')
        AND NOT m.lastName LIKE 'DELETE_%'
        order by m.lastName ASC") or die(mysqli_errno($mysqli));

        if ($findsectionCSSActionsGTC->num_rows) {
          // output data of each row

          echo "<br><h3 style='text-align: center'>Section GTC Status (".$findUser->dutySection.")</h3><table>";
          echo "<table id='sectionGTC' class='table table-bordered table-hover'>
          <thead>
          <tr>
          <th>Rank</th>
          <th>Last Name</th>
          <th>First Name</th>
          <th>S1 Status</th>
          <th>State</th>
          <th>Current Status</th>
          <th>Instructions</th>
          </tr>
          </thead>";

          while ($row = $findsectionCSSActionsGTC->fetch_assoc()) {
            echo "<tr class='nth-child' style='text-align: center';'>
            <td class='nth-child'>" . $row["rank"] . "</td>
            <td>" . $row["lastName"] . "</td>
            <td>" . $row["firstName"] . "</td>
            <td>" . $row["s1Status"] . "</td>
            <td>" . $row["currentStatus"] . "</td>
            <td>" . $row["startdate"] . "</td>
            <td>" . $row["instructions"] . "</td>

            </tr>";
          }


        } else {
          echo "<br>
          <h3 style='text-align: center'>No personnel have GTC Actions Required. (".$findUser->dutySection.")</h3>";
        }
        echo "</table><br>";


        //----------------------Sponser items------------------------//


        $findsectionCSSActionsSponsor = $mysqli->query("SELECT *
          from members m
          INNER JOIN import_sponsorProgram AS s
          ON m.lastName = s.sponsorLastName AND m.firstName = s.sponsorFirstName
          where (m.dutySection = '$findUser->dutySection')
          AND (m.unitName = '$unitName')
          AND NOT m.lastName LIKE 'DELETE_%'
          order by m.lastName ASC") or die(mysqli_errno($mysqli));



          if (!$findsectionCSSActionsSponsor) {
            trigger_error('Invalid query: ' . $mysqli->error);
          }
          if ($findsectionCSSActionsSponsor->num_rows) {
            // output data of each row
            echo "<br><h3 style='text-align: center'>Section Sponsorships (".$findUser->dutySection.")</h3><table>";
            echo "<table id='sectionSponsor' class='table table-bordered table-hover '>
            <thead>
            <tr>
            <th>Rank</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Gender</th>
            <th>Marital Status</th>
            <th>Number of Children</th>
            <th>afsc</th>
            <th>RNLTD</th>
            <th>Promoting</th>
            <th>Arrival Date</th>
            <th>Sponsor Last Name</th>
            <th>Sponsor First Name</th>
            <th>First Contact Date</th>
            <th>MilPDS Update</th>
            <th>Sponsor Contact Date</th>
            <th>Status</th>
            </tr>
            </thead>";

            while ($row = $findsectionCSSActionsSponsor->fetch_assoc()) {

              echo "<tr class='nth-child' style='text-align: center';'>
              <td class='nth-child'>" . $row["rank"] . "</td>
              <td>" . $row["lastName"] . "</td>
              <td>" . $row["firstName"] . "</td>
              <td>" . $row["gender"] . "</td>
              <td>" . $row["maritalStatus"] . "</td>
              <td>" . $row["children"] . "</td>
              <td>" . $row["afsc"] . "</td>
              <td>" . $row["rnltd"] . "</td>
              <td>" . $row["promoting"] . "</td>
              <td>" . $row["eta"] . "</td>
              <td>" . $row["sponsorLastName"] . "</td>
              <td>" . $row["sponsorFirstName"] . "</td>
              <td>" . $row["firstContactDate"] . "</td>
              <td>" . $row["milpdsUpdate"] . "</td>
              <td>" . $row["sponsorContactDate"] . "</td>
              <td>" . $row["status"] . "</td>
              </tr>";
            }
          }   else {
            echo "<br>
            <h3 style='text-align: center'>No personnel have Sponsor Actions Required. (".$findUser->dutySection.")</h3>";
          }
          echo "</table><br>";


          //Part of the inital if statement to see if the user is logged in.
        }else {
          echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

          include __DIR__ . '/../../footer.php';

          header('Location: /UnitTraining/home.php');
          exit;
        }
