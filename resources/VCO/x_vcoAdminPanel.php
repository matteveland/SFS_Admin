<?php


date_default_timezone_set('America/Los_Angeles');
require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';

//$config = parse_ini_file('/Users/mattheweveland/Desktop/config.ini', true);

//use PHPMailer\PHPMailer\PHPMailer;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
require __DIR__ . '/../../adminpages/vendor/autoload.php';

if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> Please login to an Admin or User account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/UnitTraining/login_logout/splashpage.php'>Login</a></p>";
    exit;
}

if (isset($_SESSION['page_user'])) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> You must be have an Admin account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/sfs/index.html'>Home Page</p>";
    exit;
}

$unitName = $_SESSION['unitName'];
$section = 'S4';
?>
<html lang="en">
<head>
    <title>
    </title>
</head>

<body>
<h3 style="text-align: center"><?php //echo $section;?> VCO Administration Panel</h3>



<div>

<section>


    <div class="col-md-12 text-center">
        <a class="btn btn-secondary my-2 my-sm-0" href="addVehicle.php" role="button" style="align-items: center">Add New Vehicle</a>
        <a class="btn btn-secondary my-2 my-sm-0" href="insertInventoryVeh.php" role="button" style="align-items: center">Add Mileage Information</a>
        <a class="btn btn-secondary my-2 my-sm-0" href="/resources/VCO.php" role="button" style="align-items: center">Update Vehicle</a>

        <!-- end homepage ads -->


    </div>
</section>
</div>

<br>



<footer>


    <!-- indluces closing html tags for body and html-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
 
