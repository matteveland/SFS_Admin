<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

date_default_timezone_set('America/Los_Angeles');

$returnLink = "<div style='text-align: center' > <a class='btn btn-primary' href='import-view.php' role='button'>Return to Import Page</a></div>";

$uploadType = $_POST['importType'];

if (isset($_POST["uploadImport"])) {

    if ($uploadType === "pimr") {

        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/pimr.php';
        echo $returnLink;
        exit();

    } elseif ($uploadType == "leaveAudit") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/leaveAudit.php';
        echo $returnLink;
        exit();


    }  elseif ($uploadType == "useOrLose") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/useOrLose.php';
        echo $returnLink;
        exit();


    }elseif ($uploadType == "gtc") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/gtc.php';
        echo $returnLink;
        exit();


    } elseif ($uploadType == "epr") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/epr.php';
        echo $returnLink;
        exit();


    } elseif ($uploadType == "decs") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/decs.php';
        echo $returnLink;
        exit();


    } elseif ($uploadType == "ioaDocs") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/ioaDocs.php';
        echo $returnLink;
        exit();


    } elseif ($uploadType == "sponsor") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/sponsorship.php';
        echo $returnLink;
        exit();


    } elseif ($uploadType == "cbt") {
        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/cbt.php';
        echo $returnLink;
        exit();


    } elseif ($uploadType == "appointment") {


        include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Admin-Panel/import/types/appointments.php';
        echo $returnLink;
        exit();


    }else {

        echo "try again. Upload failed";


    }
} else {

    echo "An error occurred.";
}
