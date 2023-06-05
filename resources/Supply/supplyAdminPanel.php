<?php


date_default_timezone_set('America/Los_Angeles');
require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';
$unitName = $_SESSION['unitName'];
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

$findInventory = "SELECT * FROM supply_Receiving where unitName = '$unitName'";

$resultsFindInventory = mysqli_query($connection, $findInventory);


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
        <a class="btn btn-secondary my-2 my-sm-0" href="addEquipment.php" role="button" style="align-items: center">Add New Equipment</a>
        <a class="btn btn-secondary my-2 my-sm-0" href="../vco.php" role="button" style="align-items: center">Update Equipment</a>
        <a class="btn btn-secondary my-2 my-sm-0" href="deleteEquipment.php" role="button" style="align-items: center">Delete Equipment</a>
        <a class="btn btn-secondary my-2 my-sm-0" href="initialIssue.php" role="button" style="align-items: center">Initial Issue</a>
        <!-- end homepage ads -->


    </div>
</section>
</div>
<br>
<h4 style="text-align: center"><?php //echo $section;?>Current Inventory</h4>
<?php
/*foreach ($resultsFindInventory as $inventory){

        echo "<div style='alignment: center'> $inventory[date_time] $inventory[inventory]<br></div>";

    }*/


if (mysqli_num_rows($resultsFindInventory) > 0) {

    echo"<table>";
    echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
    print("<tr>
    <th>Item Name</th>
    <th>Model Name</th>
    <th>Description</th>
     <th>Quantity</th>
    <th>Item Cost</th>
    <th>Quantity Type</th>
    <th>Issue Type</th>
   
    ");

    while($row = mysqli_fetch_assoc($resultsFindInventory)) {

        echo "<tr class='nth-child'>
                                <td class='nth-child'>" . strtoupper($row["itemName"]). "</td>
                                <td>". $row["modelName"]." </td>
                                <td>".  ucwords($row["itemDescription"])." </td>
                                <td>".  ucwords($row["itemQuantity"])." </td>
                                <td>".  ucwords($row["itemCost"])." </td>
                                
                                <td>".  ucwords($row["quantityType"])." </td>
                                <td>".  ucwords($row["issueType"])." </td>
                          
                                </tr>
                </tr>";

    }


} else {
    echo "<p style='text-align:center'>No equipment in the inventory.</p>";
}
echo "</table><br>

";

?>



<footer>


    <!-- indluces closing html tags for body and html-->
    <?php include __DIR__ . '/../../footer.php'; ?>
