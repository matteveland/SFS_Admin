<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  //fgets($file);//moves loop down one row before starting
  mysqli_query($mysqli, "DELETE from import_useOrLose where unitName = '$unitName'");
  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    if ($line[0] !== 'FULL_NAME') {
      echo 'Please ensure the files 1st column is FULL_NAME. Check to ensure you are uploading the correct file. leave';

    } elseif ($line[1] !== 'Use/Lose') {
      echo 'Please ensure the files 2nd column is Use/Lose. Check to ensure you are uploading the correct file. leave';

    } elseif ($line[2] !== 'Notes') {
      echo 'Please ensure the files 3rd column is Notes. Check to ensure you are uploading the correct file. leave';

    } else {
      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }


        //begin file import information data
        list($lastNameImport, $firstMiddleNameComboImport) = explode(", ", $getData[0]);

        list($firstNameImport, $middleNameImport) = explode(" ", $firstMiddleNameComboImport);

        $firstNameImport = mb_convert_case($firstNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        $middleNameImport = mb_convert_case($middleNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        $lastNameImport = mb_convert_case($lastNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        $insertLeaveUseOrLose = $mysqli->query("INSERT INTO `import_useOrLose` (`id`, `lastName`, `firstName`, `middleName`, `daysOfLeave`, `notes`, `unitName`)
        VALUES (id, '" . $lastNameImport . "', '" . $firstNameImport . "', '".$middleNameImport."', '" . $getData[1] . "', '" . $getData[2] . "', '" . $unitName . "')");

        //Return to the import page if the insert was successfull
        if (!isset($insertLeaveUseOrLose)) {
          echo "<script type=\"text/javascript\">
          alert(\"Invalid File: Please Upload CSV File.\");
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
