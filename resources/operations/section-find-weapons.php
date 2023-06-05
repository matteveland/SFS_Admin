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

  $findsectionWeapons = $mysqli->query("SELECT * from members m
    INNER join armingRoster a on m.lastName = a.lastName AND m.firstName = a.firstName
    where (dutySection = '$findUser->dutySection') AND ((a.m4Exp BETWEEN now() - INTERVAL 1000 DAY AND now() + INTERVAL 90 DAY) OR (a.m9Exp BETWEEN now() - INTERVAL 500 DAY AND now() + INTERVAL 90 DAY) OR (a.m4Qual <> '' OR a.m9Qual <> '')) AND (m.unitName = '$unitName') AND NOT m.lastName LIKE 'DELETE_%' AND m.rank <> 'Civ'
    order by m.lastName") or die(mysqli_errno($mysqli));
    
    //view open alarm data
    //Interior
    if ($findsectionWeapons->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section Weapons Qualifications (".$findUser->dutySection.")</h3><table>";
      echo "<table id='weapons' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Rank</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Baton</th>
      <th>Use of Force</th>
      <th>Form 2760</th>
      <th>Taser</th>
      <th>M4 Qaul</th>
      <th>M4 Expriry</th>
      <th>M9 Qual</th>
      <th>M9 Expriry</th>
      <th>SMC Fired</th>
      <th>SMC Expriry</th>
      <th>203 Expriry</th>
      <th>249 Expriry</th>
      <th>240 Expriry</th>
      <th>870 Expriry</th>
      </tr>
      </thead>";




      while ($row = $findsectionWeapons->fetch_assoc()) {

        //these find the dates for now/in 30 days/in 60 days. These are required to make the table display poperly
        $now = date('Y-m-d');
        $now30 = date('Y-m-d', strtotime("$now + 30 days"));
        $now60 = date('Y-m-d', strtotime("$now + 60 days"));

        // echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngtype"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";

        echo "<tr class='nth-child'>
        <td class='nth-child'>" . $row["rank"]. "</td>
        <td>" . $row["lastName"]. "</td>
        <td>" . $row["firstName"]. "</td>";
        //----------------------------------------------------------------------------------------//

        $batonDate =  $row["baton"];
        $batonDate = date('Y-m-d', strtotime("$batonDate + 365 days"));

        if (($batonDate) < ($now30)){
          $color='red';
        }
        elseif (($batonDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["baton"]){
          echo $batonDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//

        $useOfForceDate =  $row["useOfForce"];
        $useOfForceDate = date('Y-m-d', strtotime("$useOfForceDate + 365 days"));

        if (($useOfForceDate) < ($now30)){
          $color='red';
        }
        elseif (($useOfForceDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["useOfForce"]){
          echo $useOfForceDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//

        $latDate =  $row["lat"];
        $latDate = date('Y-m-d', strtotime("$latDate + 365 days"));

        if (($latDate) < ($now30)){
          $color='red';
        }
        elseif (($latDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["lat"]){
          echo $latDate;
        }else echo " ";
        echo "</td>";

        //----------------------------------------------------------------------------------------//

        $taserDate =  $row["taser"];
        $taserDate = date('Y-m-d', strtotime("$taserDate + 365 days"));

        if (($taserDate) < $now30){
          $color='red';
        }
        elseif ((!$taserDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'>"; if ($row["taser"]){
          echo $taserDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $m4QualDate =  $row["m4Qual"];
        $m4QualDate = date('Y-m-d', strtotime("$m4QualDate + 365 days"));


        if (($m4QualDate) < $now30){
          $color='red';
        }
        elseif (($m4QualDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'black';
        }

        echo    "<td style='color:$color'>"; if ($row["m4Qual"]){
          echo $m4QualDate;
        }else echo "";
        echo "</td>";


        //----------------------------------------------------------------------------------------//
        $m4ExpDate =  $row["m4Exp"];
        $m4ExpDate = date('Y-m-d', strtotime("$m4ExpDate + 547 days"));

        if (($m4ExpDate) < ($now30)){
          $color='red';
        }
        elseif (($m4ExpDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }

        echo    "<td style='color:$color'>"; if ($row["m4Exp"]){
          echo $m4ExpDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $m9QualDate =  $row["m9Qual"];
        $m9QualDate = date('Y-m-d', strtotime("$m9QualDate + 365 days"));

        if (($m9QualDate) < ($now30)){
          $color='red';
        }
        elseif (($m9QualDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["m9Qual"]){
          echo $m9QualDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $m9ExpDate =  $row["m9Exp"];
        $m9ExpDate = date('Y-m-d', strtotime("$m9ExpDate + 365 days"));

        if (($m9ExpDate) < ($now30)){
          $color='red';
        }
        elseif (($m9ExpDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["m9Exp"]){
          echo $m9ExpDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $smcFiredDate =  $row["smcFired"];
        $smcFiredDate = date('Y-m-d', strtotime("$smcFiredDate + 365 days"));

        if (($smcFiredDate) < ($now30)){
          $color='red';
        }
        elseif (($smcFiredDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }

        echo    "<td style='color:$color'>"; if ($row["smcFired"]){
          echo $smcFiredDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $smcDue =  $row["smcDue"];
        $smcDue = date('Y-m-d', strtotime("$smcDue + 365 days"));

        if (($smcDue) < ($now30)){
          $color='red';
        }
        elseif (($smcDue) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["smcDue"]){
          echo $smcDue;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $m203ExpDate =  $row["m203Exp"];
        $m203ExpDate = date('Y-m-d', strtotime("$m203ExpDate + 365 days"));

        if (($m203ExpDate) < ($now30)){
          $color='red';
        }
        elseif (($m203ExpDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["m203Exp"]){
          echo $m203ExpDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $m249ExpDate =  $row["m249Exp"];
        $m249ExpDate = date('Y-m-d', strtotime("$m249ExpDate + 365 days"));

        if (($m249ExpDate) < ($now30)){
          $color='red';
        }
        elseif (($m249ExpDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["m249Exp"]){
          echo $m249ExpDate;
        }else echo " ";
        echo "</td>";
        //----------------------------------------------------------------------------------------//
        $m240ExpDate =  $row["m240Exp"];
        $m240ExpDate = date('Y-m-d', strtotime("$m240ExpDate + 365 days"));

        if (($m240ExpDate) < ($now30)){
          $color='red';
        }
        elseif (($m240ExpDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["m240Exp"]){
          echo $m240ExpDate;
        }else echo " ";
        echo "</td>";


        //----------------------------------------------------------------------------------------//
        $m870ExpDate =  $row["m870Exp"];
        $m870ExpDate = date('Y-m-d', strtotime("$m870ExpDate + 365 days"));

        if (($m870ExpDate) < ($now30)){
          $color='red';
        }
        elseif (($m870ExpDate) < $now60) {
          $color = 'goldenrod';
        }else {
          $color = 'balck';
        }
        echo    "<td style='color:$color'>"; if ($row["m870Exp"]){
          echo $m870ExpDate;
        }else echo " ";
        echo "</td>";

        echo "</td>

        </tr>";
      }


    } else {
      echo "<br>
      <h3 style='text-align: center'>".$findUser->dutySection." - No personnel have weapons qualifications.</h3>";
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
