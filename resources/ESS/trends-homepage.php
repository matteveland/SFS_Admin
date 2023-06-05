<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
$unitName = $_SESSION['unitName'];
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();


  $findESSDailyNuisanceTrends = $mysqli->query("SELECT COUNT(*) as Nuisance FROM alarmData
  WHERE (findings = 'Nuisance') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));
  while($row = $findESSDailyNuisanceTrends->fetch_assoc()){
      $Nuisance_daily = $row["Nuisance"];
  }


  $findESSWeeklyNuisanceTrends = $mysqli->query("SELECT COUNT(*) as Nuisance FROM alarmData
  WHERE (findings = 'Nuisance') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 14 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));

  while($row = $findESSWeeklyNuisanceTrends->fetch_assoc()){
      $Nuisance_weekly = $row["Nuisance"];
  }


  $findESSMonthlyNuisanceTrends = $mysqli->query("SELECT COUNT(*) as Nuisance FROM alarmData
  WHERE (findings = 'Nuisance') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 30.4 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));

  while($row = $findESSMonthlyNuisanceTrends->fetch_assoc()){

      $Nuisance_monthly = $row["Nuisance"];
  }


  $findESSQrtlyNuisanceTrends = $mysqli->query("SELECT COUNT(*) as Nuisance FROM alarmData
  WHERE (findings = 'Nuisance') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 120 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));

  while($row = $findESSQrtlyNuisanceTrends->fetch_assoc()){
      $Nuisance_quarterly = $row["Nuisance"];
  }



  $findESSYearlyNuisanceTrends = $mysqli->query("SELECT COUNT(*) as Nuisance FROM alarmData
  WHERE (findings = 'Nuisance') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 356 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));


  while($row = $findESSYearlyNuisanceTrends->fetch_assoc()){
      $Nuisance_yearly = $row["Nuisance"];
  }



  //false alarm information

  $findESSDailyFalseTrends = $mysqli->query("SELECT COUNT(*) as falseAlarm FROM alarmData
  WHERE (findings = 'False') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));
  while($row = $findESSDailyFalseTrends->fetch_assoc()){
      $False_daily = $row["falseAlarm"];
  }


  $findESSWeeklyFalseTrends = $mysqli->query("SELECT COUNT(*) as falseAlarm FROM alarmData
  WHERE (findings = 'False') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 14 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));

  while($row = $findESSWeeklyFalseTrends->fetch_assoc()){
      $False_weekly = $row["falseAlarm"];
  }


  $findESSMonthlyFalseTrends = $mysqli->query("SELECT COUNT(*) as falseAlarm FROM alarmData
  WHERE (findings = 'False') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 30.4 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));

  while($row = $findESSMonthlyFalseTrends->fetch_assoc()){

      $False_monthly = $row["falseAlarm"];
  }


  $findESSQrtlyFalseTrends = $mysqli->query("SELECT COUNT(*) as falseAlarm FROM alarmData
  WHERE (findings = 'False') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 120 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));

  while($row = $findESSQrtlyFalseTrends->fetch_assoc()){
      $False_quarterly = $row["falseAlarm"];
  }



  $findESSYearlyFalseTrends = $mysqli->query("SELECT COUNT(*) as falseAlarm FROM alarmData
  WHERE (findings = 'False') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 356 DAY AND now() + INTERVAL 1 DAY)") or die(mysqli_errno($mysqli));


  while($row = $findESSYearlyFalseTrends->fetch_assoc()){
      $False_yearly = $row["falseAlarm"];
  }
