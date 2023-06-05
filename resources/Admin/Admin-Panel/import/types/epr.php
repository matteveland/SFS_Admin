<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$unitName = $_SESSION['unitName'];


$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  //fgets($file);//moves loop down one row before starting
  mysqli_query($mysqli, "DELETE from import_eprStatus where unitName = '$unitName'");
  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    if ($line[0] !== 'Closeout Date') {
      echo 'Please ensure the files 1st column is Closeout Date. Check to ensure you are uploading the correct file. PIMR';

    } elseif ($line[1] !== 'Grade') {
      echo 'Please ensure the files 2nd column is Grade. Check to ensure you are uploading the correct file. erp';

    } elseif ($line[2] !== 'Ratee First Name') {
      echo 'Please ensure the files 3rd column is Ratee First Name. Check to ensure you are uploading the correct file. erp';

    } elseif ($line[3] !== 'Ratee Last Name') {
      echo 'Please ensure column title 4th column is Ratee Last Name. Check to ensure you are uploading the correct file. erp';

    } elseif ($line[4] !== 'Pending Coordination') {
      echo 'Please ensure column title 5th column is Pending Coordination. Check to ensure you are uploading the correct file. erp';

    } elseif ($line[5] !== 'Pending Coordination Date') {
      echo 'Please ensure column title 6th column is Pending Coordination Date. Check to ensure you are uploading the correct file. erp';

    } elseif ($line[6] !== 'Days Pending') {
      echo 'Please ensure column title 7th column is Days Pending. Check to ensure you are uploading the correct file. erp';

    } elseif ($line[7] !== 'MilPDS Update Date') {
      echo 'Please ensure column title 8th column is MilPDS Update Date. Check to ensure you are uploading the correct file. erp';

    } else {
      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }


        $rateeFirstName = mb_convert_case($getData[2], MB_CASE_TITLE, 'utf-8');
        $rateeLastName = mb_convert_case($getData[3], MB_CASE_TITLE, 'utf-8');

        $importEPR = $mysqli->query("INSERT INTO `import_eprStatus` (`id`, `closeoutDate`, `grade`, `rateeFirstName`, `rateeLastName`, `pendingCoord`, `pendingCoordDate`,  `daysPending`, `milpdsUpdateDate`, `unitName`)
        VALUES (id, '" . $getData[0] . "','" . $getData[1] . "','" . $rateeFirstName . "','" . $rateeLastName . "', '" . $getData[4] . "','" . $getData[5] . "',
          '" . $getData[6] . "','" . $getData[7] . "', '" . $unitName . "')");

          //Return to the import page if the insert was successfull
          if (!isset($importEPR)) {
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
