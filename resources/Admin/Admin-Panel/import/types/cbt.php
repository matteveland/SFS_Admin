<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  fgets($file);
  mysqli_query($connection, "DELETE from cbtList799 where unitName = '$unitName'");

  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    //
    ////adjust column titles
    ///
    if ($line[0] !== 'Office') {
      echo 'Please ensure the files 1st column is Office. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[1] !== 'Last Name') {
      echo 'Please ensure the files 2nd column is Last Name. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[2] !== 'First Name') {
      echo 'Please ensure the files 3rd column is First Name. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[3] !== 'Rank') {
      echo 'Please ensure the files 4th column is Rank. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[4] !== 'Status') {
      echo 'Please ensure the files 5th column is Status. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[5] !== 'Imm') {
      echo 'Please ensure the files 6th column is Imm. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[6] !== 'Den') {
      echo 'Please ensure the files 7th column is Den. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[7] !== 'Lab') {
      echo 'Please ensure the files 8th column is Lab. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[8] !== 'DLC') {
      echo 'Please ensure the files 9th column is DLC. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[9] !== 'PHA') {
      echo 'Please ensure the files 10th column is PHA. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[10] !== 'Eqp') {
      echo 'Please ensure the files 11th column is Eqp. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[11] !== 'IMR') {
      echo 'Please ensure the files 12th column is IMR. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[12] !== 'Metrics') {
      echo 'Please ensure the files 13th column is Metrics. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[13] !== 'Action List') {
      echo 'Please ensure the files 14th column is Action List.Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[14] !== 'GoRedDate') {
      echo 'Please ensure the files 15th column is GoRedDate. Check to ensure you are uploading the correct file. CBT';

    } elseif ($line[15] !== 'Site') {
      echo 'Please ensure the files 16th column is Site. Check to ensure you are uploading the correct file. CBT';

    } else {

      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }

        list($lastNameImport, $firstNameImport) = explode(", ", $getData[0]);

        $firstNameImport = mb_convert_case($firstNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $middleName = NULL;
        $lastNameImport = mb_convert_case($lastNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        $datetimeDODCombatTrafficking = date("Y-m-d ", strtotime($getData[2]));
        $datetimeCyber = date("Y-m-d ", strtotime($getData[3]));
        $datetimeFP = date("Y-m-d ", strtotime($getData[4]));
        $datetimeGreenCurrent = date("Y-m-d ", strtotime($getData[5]));
        $datetimeGreenNext = date("Y-m-d ", strtotime($getData[6]));
        $datetimeCBRNCBT = date("Y-m-d ", strtotime($getData[7]));
        $datetimeCBRNCBTPretest = date("Y-m-d ", strtotime($getData[7]));
        $datetimeNoFEAR = date("Y-m-d ", strtotime($getData[9]));
        $datetimeAfCIED = date("Y-m-d ", strtotime($getData[10]));
        $datetimeAfCIED_Old = date("Y-m-d ", strtotime($getData[11]));
        $datetime15ReligiousFreedom = date("Y-m-d ", strtotime($getData[12]));
        $datetimeSABC = date("Y-m-d ", strtotime($getData[13]));
        $datetimeSABC_HandsOn = date("Y-m-d ", strtotime($getData[14]));
        $datetimeLOAC = date("Y-m-d ", strtotime($getData[15]));
        $datetimeEMS = date("Y-m-d ", strtotime($getData[16]));
        $datetimeRiskManagement = date("Y-m-d ", strtotime($getData[17]));
        $datetimeBlendedRetirement = date("Y-m-d ", strtotime($getData[18]));

        $insertSQL = $mysqli->query("INSERT INTO `cbtList799` (id, lastName, firstName, grade, dodCombatTrafficking, cyberAwareness, fp, greenDotCurrent, greenDotNext, cbrnCBT, cbrnCBTPretest, noFEAR, afCIED, afCIED_Old, religiousFreedom, sabc, sabcHandsOn, loac, ems, riskManagement, blendedRetirement, unitName)
        VALUES (id, '" . $lastNameImport . "','" . $firstNameImport . "','" . $getData[1] . "','" . $datetimeDODCombatTrafficking . "','" . $datetimeCyber . "','" . $datetimeFP . "','" . $datetimeGreenCurrent . "','" . $datetimeGreenNext . "','" . $datetimeCBRNCBT . "','" . $datetimeCBRNCBTPretest . "',
          '" . $datetimeNoFEAR . "','" . $datetimeAfCIED . "', '" . $datetimeAfCIED_Old . "','" . $datetime15ReligiousFreedom . "','" . $datetimeSABC . "','" . $datetimeSABC_HandsOn . "',
          '" . $datetimeLOAC . "','" . $datetimeEMS . "', '" . $datetimeRiskManagement . "', '" . $datetimeBlendedRetirement . "', '".$unitName."',)");

          $result = mysqli_query($connection, $sql);

          if ($datetimeDODCombatTrafficking == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeDODCombatTrafficking = $mysqli->query("UPDATE `cbtList799` set dodCombatTrafficking = '' where dodCombatTrafficking = '1969-12-31'");
          }
          if ($datetimeCyber == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedatetimeCyber = $mysqli->query("UPDATE `cbtList799` set cyberAwareness = '' where cyberAwareness = '1969-12-31'");
          }
          if ($datetimeFP == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedatetimeFP = $mysqli->query("UPDATE `cbtList799` set fp = '' where fp = '1969-12-31'");
          }
          if ($datetimeGreenCurrent == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedatetimeGreenCurrent = $mysqli->query("UPDATE `cbtList799` set greenDotCurrent = '' where greenDotCurrent = '1969-12-31'");
          }
          if ($datetimeGreenNext == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedatetimeGreenNext = $mysqli->query("UPDATE `cbtList799` set greenDotNext = '' where greenDotNext = '1969-12-31'");
          }

          if ($datetimeCBRNCBT == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedatetimeCBRNCBT = $mysqli->query("UPDATE `cbtList799` set cbrnCBT = '' where cbrnCBT = '1969-12-31'");
          }
          if ($datetimeCBRNCBTPretest == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedatetimeCBRNCBTPretest = $mysqli->query("UPDATE `cbtList799` set cbrnCBTPretest = '' where cbrnCBTPretest = '1969-12-31'");
          }
          if ($datetimeNoFEAR == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedDatetimeNoFEAR = $mysqli->query("UPDATE `cbtList799` set noFEAR = '' where noFEAR = '1969-12-31'");
          }
          if ($datetimeAfCIED == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeAfCIED = $mysqli->query("UPDATE `cbtList799` set afCIED = '' where afCIED = '1969-12-31'");
          }

          if ($datetimeAfCIED_Old == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeAfCIED_Old = $mysqli->query("UPDATE `cbtList799` set afCIED_Old = '' where afCIED_Old = '1969-12-31'");
          }
          if ($datetime15ReligiousFreedom == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetime15ReligiousFreedom = $mysqli->query("UPDATE `cbtList799` set religiousFreedom = '' where religiousFreedom = '1969-12-31'");
          }

          if ($datetimeSABC == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updatedDatetimeSABC = $mysqli->query("UPDATE `cbtList799` set sabc = '' where sabc = '1969-12-31'");
          }
          if ($datetimeSABC_HandsOn == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeSABC_HandsOn = $mysqli->query("UPDATE `cbtList799` set sabcHandsOn = '' where sabcHandsOn = '1969-12-31'");
          }
          if ($datetimeLOAC == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeLOAC = $mysqli->query("UPDATE `cbtList799` set loac = '' where loac = '1969-12-31'");
          }
          if ($datetimeEMS == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeEMS = $mysqli->query("UPDATE `cbtList799` set ems = '' where ems = '1969-12-31'");
          }
          if ($datetimeBlendedRetirement == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeBlendedRetirement = $mysqli->query("UPDATE `cbtList799` set blendedRetirement = '' where blendedRetirement = '1969-12-31'");
          }

          if ($datetimeRiskManagement == date("Y-m-d ", strtotime('1969-12-31'))) {
            $updateDatetimeRiskManagement = $mysqli->query("UPDATE `cbtList799` set riskManagement = '' where riskManagement = '1969-12-31'");
          }

          //$updateDate1 = $mysqli->query("UPDATE `cbtList799` set '' where '1969-12-31'");

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

          $updateDate1 = $mysqli->query("UPDATE `cbtList799` set trngLast = NULL where trngLast <= '2000-01-01'");
          $updateDate2 = $mysqli->query("UPDATE `cbtList799` set trngDue  = NULL where trngDue = '1970-01-01'");

          if (!isset($insertSQL)) {

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
