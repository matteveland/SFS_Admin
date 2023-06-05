<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

date_default_timezone_set('America/Los_Angeles');

$unitName = $_SESSION['unitName'];

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

//permissionsToEdit('Admin', $findUser->lastName, $findUser->dodId, $findUser->unitName, '/homepage.php');
$filename = $_FILES["file"]["tmp_name"];


if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  fgets($file);
  mysqli_query($mysqli, 'TRUNCATE TABLE importAppointment');

  //412 SFS
  //name == 0
  //time == 1
  //date == 2
  //appointment == 3
  //section == 4
  //remarksm== 5
  //date entered == 6

  while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
    if ($file == 0) {
      $file++; // 3
      continue; // 4
    }

    list($lastNameImport, $firstNameImport) = explode(", ", $getData[0]);
    $firstNameImport = mb_convert_case($firstNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
    $middleName = NULL;
    $lastNameImport = mb_convert_case($lastNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
    $apptTitle = NULL;
    $apptTitle = ucwords(strtolower($apptTitle));


//startdate ==$getData[2];
    list($day, $month, $year,) = explode("-", $getData[2]);

    $year = "20".$year;
    $startDate= $year."-".$month."-".$day;



    $startDate = date("Y-m-d ", strtotime($startDate)); //startdate


    //$endDate = date("Y-m-d ", strtotime($getData[5]));
    $dutySection = $getData[4];
    $title =  $getData[3];
    $location = NULL;

    $endDate = NULL;
    $appointmentTime = $getData[1];
    $notes = $getData[5];


    //$now = $getData[9];

    /*
    *
    * Follow this instruction:

    Go to the Import tab
    Browse and select your CSV file
    Instead of the “CSV” format, select “CSV using LOAD DATA”
    In the “Fields terminated by” field, change “;” to “,”
    Ensure that “Use LOCAL keyword” is selected
    Click on “Go”

    */

    $now = date('Y-m-d H:i:s');

    //$user =  $_SESSION['page_user'];

    /*  $getUserName = "SELECT lastName, firstName FROM login WHERE (user_name = '$user')";

    $resultsUser = mysqli_query($connection, $findUser->user_name);

    while ($row = $resultsUser->fetch_assoc()) {

    $recallAdmin_UserLastRecall = $row['lastName'];
    $recallAdmin_UserFirstRecall = $row['firstName'];
  }

  $getAdminName = "SELECT lastName, firstName FROM login WHERE (user_name = '$admin')";

  $resultsAdmin = mysqli_query($connection, $getAdminName);

  while ($row = mysqli_fetch_assoc($resultsAdmin)) {

  $recallAdmin_UserLastRecall = $row['lastName'];
  $recallAdmin_UserFirstRecall = $row['firstName'];
}*/

$addedBy = $findUser->lastName . ', ' . $findUser->firstName .' '. 'file imported';

//$importUpdateDateImporter = "UPDATE appointmentRoster set addedBy = '$addedBy' AND dateAdded = '$now' WHERE addedBy = '' AND dateAdded = ''
//";

$location = NULL;
//first import.
$importNewAppt = $mysqli->query("INSERT INTO `importAppointment`(
  `id`,
  `lastName`,
  `firstName`,
  `middleName`,
  `dutySection`,
  `title`,
  `location`,
  `startDate`,
  `endDate`,
  `appointmentTime`,
  `notes`,
  `unitName`,
  `addedBy`,
  `dateAdded`)
  VALUES (id,
    '" . $lastNameImport. "',
    '" . $firstNameImport. "',
    '" . $middleName. "',
    '" . $dutySection."',
    '" . $title . "',
    '" . $location. "',
    '" . $startDate . "',
    '" . $endDate. "',
    '" . $appointmentTime. "',
    '" . $notes."',
    '" . $findUser->unitName."',
    '" . $addedBy."',
    '" . $now."')
    ") or die(mysqli_error($mysqli));;

    /*
    `lastName`,  $firstNameImport
    `firstName`, firstNameImport
    `middleName`,firstNameImport
    `dutySection`,$dutySection
    `title`,title
    `location`, location
    `startDate`, startDate
    `endDate`, endDate
    `appointmentTime`, appointmentTime
    `notes`, notes
    `unitName`, unitName
    `addedBy`, addedBy
    `dateAdded`) now

    */

    //second import. this checks for duplicates against the current database.
    $deleteDupesfromApptRoster = $mysqli->query("DELETE importAppointment FROM importAppointment
      JOIN appointmentRoster ON importAppointment.lastName LIKE appointmentRoster.lastName AND importAppointment.firstName LIKE appointmentRoster.firstName AND importAppointment.middleName LIKE appointmentRoster.middleName AND importAppointment.title LIKE appointmentRoster.title and importAppointment.startDate LIKE appointmentRoster.startdate AND importAppointment.endDate LIKE appointmentRoster.enddate
      WHERE importAppointment.lastName LIKE appointmentRoster.lastName AND importAppointment.firstName LIKE appointmentRoster.firstName AND importAppointment.middleName LIKE appointmentRoster.middleName AND importAppointment.title LIKE appointmentRoster.title and importAppointment.startDate LIKE appointmentRoster.startdate

      ");

      $importIntoApptRoster = $mysqli->query("INSERT INTO appointmentRoster(lastName, firstName, middleName, dutySection, title, installation, startdate, enddate, appointmentTime, notes, addedBy, dateAdded, unitName)
      SELECT lastName, firstName, middleName, dutySection, title, location, startdate, endDate, appointmentTime, notes, addedBy, dateAdded, unitName
      FROM importAppointment");


      $changeEndDate = $mysqli->query("UPDATE `importAppointment` set endDate = '' WHERE endDate = '1970-01-01'");
      $changeEndDate2 = $mysqli->query("UPDATE `importAppointment` set endDate = '' WHERE endDate = '1969-12-31'");
      $updatePTTest = $mysqli->query("UPDATE `appointmentRoster` set title = 'PT Test' where title = 'Pt Test'");
      $updateWAPS = $mysqli->query("UPDATE `appointmentRoster` set title = 'WAPS' where title = 'Waps'");



      //this is the verification that the insert wroked. $result = mysqli_query($connection, $importNewAppt);
      // NOT USED $resultimportUpdateDateImporter = mysqli_query($connection, $importUpdateDateImporter);

      //$resultChangeEndDate = mysqli_query($connection, $changeEndDate);
      //$resultChangeEndDate2 = mysqli_query($connection, $changeEndDate2);
      //$resultUpdatePTTest = mysqli_query($connection, $updatePTTest);

      //$resultDelete = mysqli_query($connection, $deleteDupesfromApptRoster);
      // NOT USED $resultimportUpdateDateImporter = mysqli_query($connection, $importUpdateDateImporter);

      //$resultImport = mysqli_query($connection, $importIntoApptRoster);

      if (!isset($importIntoApptRoster)) {
        echo "<script type=\"text/javascript\">
        alert(\"Invalid File:Please Upload CSV File.\");
        window.location = \"import-view.php\"
        </script>";
      } else {
        echo "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"import-view.php\"
        </script>";
      }
    }

    fclose($file);
  }

  ?>
