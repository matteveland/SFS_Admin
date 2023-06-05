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
<h3 style="text-align: center"><?php //echo $section;?> VCO Delete Vehicle Panel</h3>

<body>



<br>
</body>


<footer>


    <!-- indluces closing html tags for body and html-->
    <?php echo '<div align="center"><a href="vcoAdminPanel.php">VCO Administration Panel</a></div> ';
    include __DIR__ . '/../../footer.php'; ?>
