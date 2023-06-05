<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
  $file = fopen($filename, "r");

  // fgets($file);//moves loop down one row before starting
  mysqli_query($connection, "DELETE from import_sponsorProgram where unitName = '$unitName'");

  if ($line = fgetcsv($file, 10000)) {
    $line_count = 1;
    $first = TRUE;

    // Validate the headers for the file being added.
    if ($line[0] !== 'RANK') {
      echo 'Please ensure column title 1st column is RANK. Check to ensure you are uploading the correct file. decs';

    }elseif ($line[1] !== 'INBOUND NAME') {
      echo 'Please ensure the files 2nd column is INBOUND NAME. Check to ensure you are uploading the correct file. Decs';

    } elseif ($line[2] !== 'SEX/MARITAL STATUS') {
      echo 'Please ensure the files 3rd column is SEX/MARITAL STATUS. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[3] !== 'CHILDREN') {
      echo 'Please ensure the files 4th column is CHILDREN. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[4] !== 'AFSC') {
      echo 'Please ensure column title 5th column is AFSC. Check to ensure you are uploading the correct file. decs';

    }elseif ($line[5] !== 'RNLTD') {
      echo 'Please ensure column title 6th column is RNLTD. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[6] !== 'PROMOTING?') {
      echo 'Please ensure column title 7th column is PROMOTING?. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[7] !== 'ETA') {
      echo 'Please ensure column title 8th column is ETA. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[8] !== 'SPONSOR') {
      echo 'Please ensure column title 9th column is SPONSOR. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[9] !== 'DATE EMAILED SPONSOR') {
      echo 'Please ensure column title 10th column is DATE EMAILED SPONSOR. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[10] !== 'MilPDS UPDATED') {
      echo 'Please ensure column title 11th column is MilPDS UPDATED. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[11] !== 'DATE SPONSOR EMAILED INBOUND') {
      echo 'Please ensure column title 12th column is DATE SPONSOR EMAILED INBOUND. Check to ensure you are uploading the correct file. decs';

    } elseif ($line[12] !== 'STATUS') {
      echo 'Please ensure column title 13th column is STATUS. Check to ensure you are uploading the correct file. decs';

    } else {
      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($file == 0) {
          $file++; // 3
          continue; // 4
        }

        //begin file import information data
        list($lastNameImport, $firstNameImportANDMiddle) = explode(", ", $getData[1]);
        list($firstNameImport, $middleNameImport) = explode(" ", $firstNameImportANDMiddle);

        $firstNameImport = mb_convert_case($firstNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $middleNameImport = mb_convert_case($middleNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $lastNameImport = mb_convert_case($lastNameImport, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        //sex/marital status.
        list($gender, $maritalStatus) = explode("/", $getData[2]);

        //  list($sponsorLastName, $sponsorFirstName) = explode(" ", $sponsorFullName);
        $gender = mb_convert_case($gender, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $maritalStatus= mb_convert_case($maritalStatus, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones

        //import sponsor information. it attempts to take array (rank fullname), explode, then explode a second array (last first).
        list($sponsorRankANDsponsorLastName, $sponsorFirstName) = explode(", ", $getData[8]);
        list($sponsorRank, $sponsorLastName) = explode(" ", $sponsorRankANDsponsorLastName);

        $sponsorFirstNameImport = mb_convert_case($sponsorFirstName, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $sponsorMiddleName = NULL;
        $sponsorLastNameImport = mb_convert_case($sponsorLastName, MB_CASE_TITLE, 'utf-8');   //for hypened names like Smith-Jones
        $grade = $getData[0];
        //names see above $getData[1];
        // sex /marital status $getData[2];
        $children = $getData[3];
        $afsc = $getData[4];
        $RNLTD = $getData[5];
        $promoting = $getData[6];
        $eta = $getData[7];
        //sponsor see above $getData[8];
        $dateEmailed = $getData[9];
        $milpds = $getData[10];
        $dateSponsor = $getData[11];
        $status = $getData[12];

        $insertSponsor = $mysqli->query("INSERT INTO `import_sponsorProgram` (`id`, `grade`, `lastName`, `firstName`, `middleName`,
          `gender`, `maritalStatus`, `children`, `afsc`, `rnltd`, `promoting`, `eta`,
          `sponsorRank`, `sponsorLastName`, `sponsorFirstName`, `sponsorMiddleName`,
          `firstContactDate`,  `milpdsUpdate`, `sponsorContactDate`, `status`, `unitName`)
          VALUES (id, '".$getData[0]."', '".$lastNameImport."', '".$firstNameImport."', '".$middleNameImport."',
            '" . $gender . "', '" . $maritalStatus . "','" . $children. "', '".$afsc."', '" . $RNLTD . "', '" . $promoting . "', '" . $eta. "',
            '".$sponsorRank."', '".$sponsorLastNameImport."', '".$sponsorFirstNameImport."', '".$sponsorMiddleName."',
            '" . $dateEmailed . "',  '" . $milpds . "', '" . $dateSponsor . "', '" . $status . "', '".$unitName."')");

            //Return to the import page if the insert was successfull

            if (!isset($insertSponsor)) {
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
