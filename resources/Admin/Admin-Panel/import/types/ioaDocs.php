<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  //fgets($file);//moves loop down one row before starting
  mysqli_query($connection, "DELETE from import_ioaDocs where unitName = '$unitName'");

  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    if ($line[0] !== 'FULL_NAME') {
      echo 'Please ensure the files 1st column is FULL_NAME. Check to ensure you are uploading the correct file. Decs';

    } elseif ($line[1] !== 'IAO Documents Required') {
      echo 'Please ensure the files 2nd column is IAO Documents Required. Check to ensure you are uploading the correct file. decs';

    }  else {

      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }

        //begin file import information data
        list($lastNameImport, $firstNameImport) = explode(", ", $getData[0]);

        $firstNameImport = mb_convert_case($firstNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $middleName = NULL;
        $lastNameImport = mb_convert_case($lastNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        
        $insertIOADocs = $mysqli->query("INSERT INTO `import_ioaDocs` (`id`, `lastName`, `firstName`, `middleName`, `docsRequired`, `unitName`)
        VALUES (id, '".$lastNameImport."', '".$firstNameImport."', '".$middleName."', '" . $getData[1] . "', '".$unitName."')");

        //Return to the import page if the insert was successfull

        if (!isset($insertIOADocs)) {
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
