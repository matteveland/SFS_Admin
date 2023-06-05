<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  //fgets($file);//moves loop down one row before starting
  mysqli_query($mysqli, "DELETE from import_decStatus where unitName = '$unitName'");

  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    if ($line[0] !== 'Member Rank') {
      echo 'Please ensure the files 1st column is Member Rank. Check to ensure you are uploading the correct file. Decs';

    } elseif ($line[1] !== 'Member Last Name') {
      echo 'Please ensure the files 2nd column is Member Last Name. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[2] !== 'Member First Name') {
      echo 'Please ensure the files 3rd column is Member First Name. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[3] !== 'Decoration') {
      echo 'Please ensure column title 4th column is Decoration. Check to ensure you are uploading the correct file. decs';

    }elseif ($line[4] !== 'Condition') {
      echo 'Please ensure column title 4th column is Condition. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[5] !== 'Start Date') {
      echo 'Please ensure column title 4th column is Start Date. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[6] !== 'End Date') {
      echo 'Please ensure column title 4th column is End Date. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[7] !== 'Date/Time Submitted') {
      echo 'Please ensure column title 4th column is Date/Time Submitted. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[8] !== 'Assigned To') {
      echo 'Please ensure column title 4th column is Assigned To. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[9] !== 'Pending Coordination Date') {
      echo 'Please ensure column title 4th column is Pending Coordination Date. Check to ensure you are uploading the correct file. decs';

    }  else {


      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }


        //begin file import information data
        // list($lastNameImport, $firstNameImport) = explode(", ", $getData[0]);

        $lastNameImport = mb_convert_case($getData[1], MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $firstNameImport = mb_convert_case($getData[2], MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        //$middleName = NULL;



        $insertDecs = $mysqli->query("INSERT INTO `import_decStatus` (`id`, `grade`, `lastName`, `firstName`, `decType`, `reason`, `startDate`, `endDate`, `submitDate`, `currentAssigned`, `pendingCoordDate`, `unitName`)
        VALUES (id, '".$getData[0]."', '".$lastNameImport."', '".$firstNameImport."','" . $getData[3] . "',  '" . $getData[4] . "', '" . $getData[5] . "', '" . $getData[6] . "', '" . $getData[7] . "', '" . $getData[8] . "','" . $getData[9] . "', '".$unitName."')");




        //Return to the import page if the insert was successfull

        if (!isset($insertDecs)) {
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
