<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$unitName = $_SESSION['unitName'];

$filename = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");

    mysqli_query($connection, "DELETE from import_leaveAudit where unitName = '$unitName'");

    if ($line = fgetcsv($file, 10000)) {
        $line_count = 1;
        $first = TRUE;

        // Validate the headers for the file being added.
        if ($line[0] !== 'LastName') {
            echo 'Please ensure the files 1st column is LastName. Check to ensure you are uploading the correct file. leave';

        } elseif ($line[1] !== 'FirstName') {
            echo 'Please ensure the files 2nd column is FirstName. Check to ensure you are uploading the correct file. leave';

        } elseif ($line[2] !== 'Notes') {
            echo 'Please ensure the files 3rd column is Notes. Check to ensure you are uploading the correct file. leave';

        } else {
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

                $insertLeaveUseOrLose = "INSERT INTO `import_leaveAudit` (`id`, `lastName`, `firstName`, `audit`, `unitName`)
                   VALUES (id, '" . $getData[0] . "','" . $getData[1] . "', '" . $getData[2] . "','" . $unitName . "')";

                $resultsInsertLeaveUseOrLose = mysqli_query($connection, $insertLeaveUseOrLose) or die(mysqli_error($connection));

                //Return to the import page if the insert was successfull
                if (!isset($resultsInsertLeaveUseOrLose)) {
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
