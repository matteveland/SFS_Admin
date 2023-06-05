<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");
  $lineCount = 1;
  $first = true;


  //fgets($file);//moves loop down one row before starting
  mysqli_query($mysqli, "DELETE from cctkList where unitName = '$unitName'");

  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    if ($line[0] !== 'Office') {
      echo 'Please ensure the files 1st column is Office. Check to ensure you are uploading the correct file. PIMR';

    } elseif ($line[1] !== 'Last Name') {
      echo 'Please ensure the files 2nd column is Last Name. Check to ensure you are uploading the correct file. PIMR';

    } elseif ($line[2] !== 'First Name') {
      echo 'Please ensure the files 3rd column is First Name. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[3] !== 'Rank') {
      echo 'Please ensure the files 4th column is Rank. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[4] !== 'Status') {
      echo 'Please ensure the files 5th column is Status. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[5] !== 'Imm') {
      echo 'Please ensure the files 6th column is Imm. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[6] !== 'Den') {
      echo 'Please ensure the files 7th column is Den. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[7] !== 'Lab') {
      echo 'Please ensure the files 8th column is Lab. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[8] !== 'DLC') {
      echo 'Please ensure the files 9th column is DLC. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[9] !== 'PHA') {
      echo 'Please ensure the files 10th column is PHA. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[10] !== 'Eqp') {
      echo 'Please ensure the files 11th column is Eqp. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[11] !== 'IMR') {
      echo 'Please ensure the files 12th column is IMR. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[12] !== 'Metrics') {
      echo 'Please ensure the files 13th column is Metrics. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[13] !== 'Action List') {
      echo 'Please ensure the files 14th column is Action List.Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[14] !== 'GoRedDate') {
      echo 'Please ensure the files 15th column is GoRedDate. Check to ensure you are uploading the correct file. PIMR';

    }elseif ($line[15] !== 'Site') {
      echo 'Please ensure the files 16th column is Site. Check to ensure you are uploading the correct file. PIMR';

    }else {

      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }


    $goRedDate = $getData[14];
    $firstName = $getData[2];
    $firstName = ucwords(strtolower($firstName));
    $lastName = $getData[1];
    $lastName = ucwords(strtolower($lastName));

    $insertPIMR = ("INSERT INTO cctkList (id, office, lastName, firstName, grade, status, imm, den, lab, dlc, pha, eqp, imr, metrics, actionList, goRed, site, unitName)
    VALUES (id,
    '" . $getData[0] . "',
    '" . $lastName . "',
    '" . $firstName . "',
    '" . $getData[3] . "',
    '" . $getData[4] . "',
    '" . $getData[5] . "',
    '" . $getData[6] . "',
    '" . $getData[7] . "',
    '" . $getData[8] . "',
    '" . $getData[9] . "',
    '" . $getData[10] . "',
    '" . $getData[11] . "',
    '" . $getData[12] . "',
    '" . $getData[13] . "',
    '" . $goRedDate . "',
    '" . $getData[15] . "',
    '" . $unitName . "'
  )");

    /*$sql= "INSERT INTO `cctkList` (id, lastName, firstName, middleName, afsc, grade, aefi, completed, imrOverall, personnelStatus, trngStatus)
    VALUES (id, '".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."')";
    */


    $updateMSgt = $mysqli->query("UPDATE `cctkList` SET grade = 'MSgt' WHERE grade = 'MSG'");
    $updateSMSgt = $mysqli->query("UPDATE `cctkList` SET grade = 'SMSgt' WHERE grade = 'SMS'");
    $updateAB = $mysqli->query("UPDATE `cctkList` SET grade = 'AB' WHERE grade = 'AB'");
    $updateAmn = $mysqli->query("UPDATE `cctkList` SET grade = 'Amn' WHERE grade = 'AMN'");
    $updateA1C = $mysqli->query("UPDATE `cctkList` SET grade = 'A1C' WHERE grade = 'A1C'");
    $updateSrA = $mysqli->query("UPDATE `cctkList` SET grade = 'SrA' WHERE grade = 'SrA'");
    $updateSSgt = $mysqli->query("UPDATE `cctkList` SET grade = 'SSgt' WHERE grade = 'SSG'");
    $updateTSgt = $mysqli->query("UPDATE `cctkList` SET grade = 'TSgt' WHERE grade = 'TSG'");
    $updateCMSgt = $mysqli->query("UPDATE `cctkList` SET grade = 'CMSgt' WHERE grade = 'CMS'");
    $update2ndLt = $mysqli->query("UPDATE `cctkList` SET grade = '2nd Lt' WHERE grade = '1LT'");
    $update1stLt = $mysqli->query("UPDATE `cctkList` SET grade = '1st Lt' WHERE grade = '2LT'");
    $updateCapt = $mysqli->query("UPDATE `cctkList` SET grade = 'Capt' WHERE grade = 'CPT'");
    $updateMaj = $mysqli->query("UPDATE `cctkList` SET grade = 'Maj' WHERE grade = 'MAJ'");
    $updateLtCol = $mysqli->query("UPDATE `cctkList` SET grade = 'Lt Col' WHERE grade = 'LTC'");
    $updateCol = $mysqli->query("UPDATE `cctkList` SET grade = 'Col' WHERE grade = 'COL'");

    //Return to the import page if the insert was successfull
    if (!isset($insertPIMR)) {
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

}
}

?>
