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



  //------------------------------CBT Status-------------------///
  $findsectionCBTs = $mysqli->query("SELECT *
    from members m
    INNER join cbtList799 c
    on m.lastName LIKE c.lastName AND m.firstName LIKE c.firstName
    where (dutySection = '$findUser->dutySection') AND (c.dodCombatTrafficking BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.cyberAwareness BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.fp BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.greenDotCurrent BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.greenDotNext BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.cbrnCBT BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.cbrnCBTPretest BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.noFEAR BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.afCIED BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.afCIED_Old BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.religiousFreedom BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.sabc BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.sabcHandsOn BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.loac BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.ems BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.riskManagement BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.blendedRetirement BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.profRelationship BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY
    OR c.airfieldDriving BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY )
    and NOT m.lastName LIKE 'DELETE_%'
    AND (m.unitName = '$unitName')
    order by m.lastName ASC") or die(mysqli_errno($mysqli));

    if ($findsectionCBTs->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section CBT Status (".$findUser->dutySection.")</h3><table>";
      echo "<table id='CBTTables' class='table table-bordered table-hover'>
      <thead>
        <tr>
      <th>Last Name</th>
      <th>First Name</th>
      <th>DOD Combat Trafficking (Annual)<br>";
      // echo ( 10 / ($row_cntResultCountSectionTrafficking / $row_cnt )); echo "</th>";
      echo "<th>Cyber Awareness (Annual)</th>
      <th>Force Protection (Annual)</th>
      <th>Green DOT Current (Annual)</th>
      <th>Green DOT Next (Annual)</th>
      <th>Airfield Driving (Annual)</th>
      <th>Professional Relationships (Annual)</th>
      <th>CBRN (18 Month)</th>
      <th>CBRN Pretest (18 Month)</th>
      <th>No FEAR Act (Biannual)</th>
      <th>AF CIED (Triannual)</th>
      <th>AF CIED Old (Triannual)</th>
      <th>Religious Freedoms</th>
      <th>SABC (Triannual)</th>
      <th>SABC Hands-On (Triannual)</th>
      <th>LOAC (Triannual)</th>
      <th>EMS (Triannual)</th>
      <th>Risk Management (Triannual)</th>
      <th>Blended Retirement (One-Time)</th></tr></thead>";

      while ($row = $findsectionCBTs->fetch_assoc()) {

        //these can be used to find dates for now/in 30 days/in 60 days. These are required to make the table display poperly
        $now = date('Y-m-d');
        $now30 = date('Y-m-d', strtotime("$now + 30 days"));
        $now60 = date('Y-m-d', strtotime("$now + 60 days"));

        echo    "<tr class='nth-child' style='text-align: center'>
        <td class='nth-child'>" . $row["lastName"] . "</td>
        <td>" . $row["firstName"] . "</td>";

        $trafficingDate =  $row["dodCombatTrafficking"];
        $trafficingDate = date('Y-m-d', strtotime("$trafficingDate + 365 days"));

        if (($trafficingDate) < ($now30)){
          $color='red';
        }
        elseif (($trafficingDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $trafficingDate ."</td>";



        //----------------------------------------------------------------------------------------//
        $cyberAwarenessDate =  $row["cyberAwareness"];
        $cyberAwarenessDate = date('Y-m-d', strtotime("$cyberAwarenessDate + 365 days"));

        if (($cyberAwarenessDate) < ($now30)){
          $color='red';
        }
        elseif (($cyberAwarenessDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $cyberAwarenessDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $forceProDate =  $row["fp"];
        $forceProDate = date('Y-m-d', strtotime("$forceProDate + 365 days"));

        if (($forceProDate) < ($now30)){
          $color='red';
        }
        elseif (($forceProDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $forceProDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $greenDotCurrentDate =  $row["greenDotCurrent"];
        //$greenDotCurrentDate = date('Y-m-d', strtotime("$greenDotCurrentDate + 365 days"));

        if (($greenDotCurrentDate)){
          $color='black';
        }
        elseif ((!$greenDotCurrentDate)) {
          $color = 'goldenrod';
        }else {
          $color = 'red';
        }

        echo    "<td style='color:$color'> ". $greenDotCurrentDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $greenDotNextDate =  $row["greenDotNext"];


        if (($greenDotNextDate)){
          $color='black';
        }
        elseif ((!$greenDotNextDate)) {
          $color = 'goldenrod';
        }else {
          $color = 'red';
        }

        //$greenDotNextDateDue = date('Y-m-d', strtotime("$greenDotNextDate + 365 days"));


        echo    "<td style='color:$color'>"; if ($greenDotNextDate){
          echo $greenDotNextDate;
        }else echo "";
        echo "</td>";

        //----------------------------------------------------------------------------------------//
        $airfieldDate =  $row["airfieldDriving"];


        if (($airfieldDate)){
          $color='black';
        }
        elseif ((!$airfieldDate)) {
          $color = 'goldenrod';
        }else {
          $color = 'red';
        }

        //$greenDotNextDateDue = date('Y-m-d', strtotime("$greenDotNextDate + 365 days"));


        echo    "<td style='color:$color'>"; if ($airfieldDate){
          echo $airfieldDate;
        }else echo "";
        echo "</td>";

        //----------------------------------------------------------------------------------------//
        $profRelationshipDate =  $row["profRelationship"];


        if (($profRelationshipDate)){
          $color='black';
        }
        elseif ((!$profRelationshipDate)) {
          $color = 'goldenrod';
        }else {
          $color = 'red';
        }

        //$greenDotNextDateDue = date('Y-m-d', strtotime("$greenDotNextDate + 365 days"));


        echo    "<td style='color:$color'>"; if ($profRelationshipDate){
          echo $profRelationshipDate;
        }else echo "";
        echo "</td>";

        //----------------------------------------------------------------------------------------//
        $cbrnCBTDate =  $row["cbrnCBT"];
        $cbrnCBTDate = date('Y-m-d', strtotime("$cbrnCBTDate + 547 days"));

        if (($cbrnCBTDate) < ($now30)){
          $color='red';
        }
        elseif (($cbrnCBTDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $cbrnCBTDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $cbrnCBTPretestDate =  $row["cbrnCBTPretest"];
        $cbrnCBTPretestDate = date('Y-m-d', strtotime("$cbrnCBTPretestDate + 547 days"));

        if (($cbrnCBTPretestDate) < ($now30)){
          $color='red';
        }
        elseif (($cbrnCBTPretestDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $cbrnCBTPretestDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $noFEARDate =  $row["noFEAR"];
        $noFEARDate = date('Y-m-d', strtotime("$noFEARDate + 730 days"));

        if (($noFEARDate) < ($now30)){
          $color='red';
        }
        elseif (($noFEARDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $noFEARDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $afCIEDDate =  $row["afCIED"];
        $afCIEDDate = date('Y-m-d', strtotime("$afCIEDDate + 1095 days"));

        if (($afCIEDDate) < ($now30)){
          $color='red';
        }
        elseif (($afCIEDDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $afCIEDDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $afCIED_OldDate =  $row["afCIED_Old"];
        $afCIED_OldDate = date('Y-m-d', strtotime("$afCIED_OldDate + 1095 days"));

        if (($afCIED_OldDate) < ($now30)){
          $color='red';
        }
        elseif (($afCIED_OldDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $afCIED_OldDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $religiousFreedomDate =  $row["religiousFreedom"];
        $religiousFreedomDate = date('Y-m-d', strtotime("$religiousFreedomDate + 1095 days"));

        if (($religiousFreedomDate) < ($now30)){
          $color='red';
        }
        elseif (($religiousFreedomDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $religiousFreedomDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $sabcDate =  $row["sabc"];
        $sabcDate = date('Y-m-d', strtotime("$sabcDate + 1095 days"));

        if (($sabcDate) < ($now30)){
          $color='red';
        }
        elseif (($sabcDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $sabcDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $sabcHandsOnDate =  $row["sabcHandsOn"];
        $sabcHandsOnDate = date('Y-m-d', strtotime("$sabcHandsOnDate + 1095 days"));

        if (($sabcHandsOnDate) < ($now30)){
          $color='red';
        }
        elseif (($sabcHandsOnDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $sabcHandsOnDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $loacDate =  $row["loac"];
        $loacDate = date('Y-m-d', strtotime("$loacDate + 1095 days"));

        if (($loacDate) < ($now30)){
          $color='red';
        }
        elseif (($loacDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $loacDate ." </td>";
        //----------------------------------------------------------------------------------------//
        $emsDate =  $row["ems"];
        $emsDate = date('Y-m-d', strtotime("$emsDate + 1095 days"));

        if (($emsDate) < ($now30)){
          $color='red';
        }
        elseif (($emsDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $emsDate ." </td>";
        //----------------------------------------------------------------------------------------//


        $riskDate =  $row["riskManagement"];
        $riskDate = date('Y-m-d', strtotime("$riskDate + 1095 days"));

        if (($riskDate) < ($now30)){
          $color='red';
        }
        elseif (($riskDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $riskDate ." </td>";
        //----------------------------------------------------------------------------------------//

        $blendedRetirementDate =  $row["blendedRetirement"];
        //$blendedRetirementDate = date('Y-m-d', strtotime("$blendedRetirementDate + 365 days"));

        if ((!$blendedRetirementDate)){
          $color='red';
        } else {
          $color = 'black';
        }

        echo    "<td style='color:$color'> ". $blendedRetirementDate ." </td>";



        echo "</td>


        </tr>";
      }

    } else {
      echo "<br>
      <h3 style='text-align: center'>".$findUser->dutySection." - No personnel have Training CBTS qualifications.</h3>";
    }

    echo "</table><br>";

    //view open alarm data
    //exterior alarms
    //

    //------------------------------CCTK Status-------------------///
    $findsectionCCTK = $mysqli->query("SELECT *
      from members m
      INNER join cctkList c
      on m.lastName = c.lastName AND m.firstName = c.firstName
      where (((imm LIKE 'R' OR lab LIKE 'Y' OR lab LIKE 'R' OR pha LIKE 'R' OR pha LIKE 'Y' OR imr LIKE 'Y' OR imr LIKE 'R' OR actionList > '')
      AND dutySection = '$findUser->dutySection')
      and NOT m.lastName LIKE 'DELETE_%'
      AND (m.unitName = '$unitName'))
      order by m.lastName ") or die(mysqli_errno($mysqli));



      if ($findsectionCCTK->num_rows) {
        echo "<br><h3 style='text-align: center'>Section CCTK Status (".$findUser->dutySection.")</h3><table>";
        echo "<table id='CCTKTables' class='table table-bordered table-hover'>
        <thead>
        <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Immunizatoins</th>
        <th>Dental</th>
        <th>Lab</th>
        <th>DLC</th>
        <th>PHA</th>
        <th>EQP</th>
        <th>IMR</th>
        <th>Go Red Date</th>
        <th>Action List</th>
        </tr>
        </thead>";

        while ($row = $findsectionCCTK->fetch_assoc()) {

          //these can be used to find dates for now/in 30 days/in 60 days. These are required to make the table display poperly
          //$now = date('Y-m-d');
          //$now30 = date('Y-m-d', strtotime("$now + 30 days"));
          //$now60 = date('Y-m-d', strtotime("$now + 60 days"));
          echo "<tr class='nth-child' style='text-align: center'>
          <td class='nth-child'>" . $row["lastName"] . "</td>
          <td>" . $row["firstName"] . "</td>
          <td>" . $row["imm"] . "</td>
          <td>" . $row["den"] . "</td>
          <td>" . $row["lab"] . "</td>
          <td>" . $row["dlc"] . "</td>
          <td>" . $row["pha"] . "</td>
          <td>" . $row["eqp"] . "</td>
          <td>" . $row["imr"] . "</td>
          <td>" . $row["goRed"] . "</td>
          <td>" . $row["actionList"] . "</td>
          </tr>";

        }
      }else {
        echo "<br>
        <h3 style='text-align: center'>".$findUser->dutySection." - No personnel have weapons qualifications.</h3>";
      }
      echo "</table>";
    }else {
      echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

      include __DIR__ . '/../../footer.php';

      header('Location: /UnitTraining/home.php');
      exit;
    }
