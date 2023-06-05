<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
parse_str($_SERVER['QUERY_STRING'], $query);
$id = $mysqli->real_escape_string($query['ID']);
$last = $mysqli->real_escape_string($query['last']);

$returnTo = $_SERVER['HTTP_REFERER'];
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];


$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

if(!empty($id) AND !empty($last)) {

  $findMember = new FindMember();
  $findMember->find_member($id, $last, $unitName);

  /* dont think this is needed based on sfsAdmin.class.php


  $selectMember = $mysqli->query("SELECT rank FROM members WHERE rank = '$findMember->rank' AND lastName = '$findMember->lastName' AND firstName = '$findMember->firstName'");

  //$result2 = mysqli_query($connection, $sqlRank);

  while ($row = mysqli_fetch_assoc(($result2))) {

  $recallRank = $row['rank'];

}


$sqlImgPath = "SELECT image FROM members WHERE (lastName = '$lastName' AND firstName = '$firstName' AND middleName = '$middleName')";

$resultSQLImgPath = mysqli_query($connection, $sqlImgPath);

while ($row = mysqli_fetch_assoc($resultSQLImgPath)) {


$imagePath = $row['image'];
$imagePath = "/UnitTraining/adminpages/$imagePath";

}*/




$now = date('Y-m-d H:i:sa');
//$addedBy = $getData[8];

$deletedBy = $findUser->lastName.',  '.$findUser->firstName.':  '.$now;

$appointmentRemove = $mysqli->query("UPDATE `appointmentRoster` SET lastName = 'DELETE_$findMember->lastName' WHERE (lastName = '$findMember->lastName' AND firstName = '$findMember->firstName' AND middleName = '$findMember->middleName') OR (dodId = '$findMember->dodId')");
$armingRemove = $mysqli->query("UPDATE `armingRoster` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$lfindMember->astName' AND dodId = '$findMember->dodId'");
$CBTRemove = $mysqli->query("DELETE FROM `cbtList` WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName'");
$CCTKRemove = $mysqli->query("UPDATE `cctkList` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$findMember->lastName' AND firstName = '$findMember->firstName'");
$fitnessRemove = $mysqli->query("UPDATE `fitness` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$lfindMember->astName' AND dodId = '$findMember->dodId' ");
$loginRemove = $mysqli->query("UPDATE `login` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId'");
$adminDelete = $mysqli->query("UPDATE `members` SET deletedBy = '$deletedBy' WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId'");
$memberRemove = $mysqli->query("UPDATE `members` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId'");
$sfmqRemove = $mysqli->query("UPDATE `sfmq` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId'");
$supRemove = $mysqli->query("UPDATE `supList` SET lastName = 'DELETE_$findMember->lastName' WHERE lastName = '$findMember->lastName' AND dodId = '$findMember->dodId'");
$familyRemove = $mysqli->query("UPDATE `family` SET dodId = 'DELETE_$findMember->dodId' WHERE dodId = '$findMember->dodId'");


$result = ($appointmentRemove AND $armingRemove AND $CBTRemove AND $CCTKRemove AND $fitnessRemove AND $loginRemove AND $adminDelete AND $memberRemove AND $sfmqRemove AND $supRemove AND $familyRemove /*AND $deletePath*/);
if (!isset($result)) {
  echo "<script type=\"text/javascript\">
  alert(\"$findMember->rank $findMember->lastName, $findMember->firstName' was not deleted.\");
  window.location = \"$returnTo\"
  </script>";
} else {
  echo "<script type=\"text/javascript\">
  alert(\"$findMember->rank $findMember->lastName, $findMember->firstName was successfully deleted from all databases.\");
  window.location = \"$returnTo\"
  </script>";
}
}

?>
