<?php


date_default_timezone_set('America/Los_Angeles');
require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';
include ('/var/services/web/sfs/Application/data.env');
//include ('/var/services/home/sfs/data.env');
$now = date('Y-m-d H:i:s');
$admin = $_SESSION['page_admin'];
$user =  $_SESSION['page_user'];
$unitName =  $_SESSION['unitName'];

$findInventory = "SELECT * from vehicles where unitName = '$unitName'";

$resultsFindInventory = mysqli_query($connection, $findInventory);

?>
<head>
</head>
<body>

    <h3 align="center">Vehicle Information Review</h3>
    <?php
/*foreach ($resultsFindInventory as $inventory){

        echo "<div style='alignment: center'> $inventory[date_time] $inventory[inventory]<br></div>";

    }*/


    if (mysqli_num_rows($resultsFindInventory) > 0) {

        echo"<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>section</th>");
        print("<th>Date / Time</th>");
        print("<th>Submitted By</th>");
        print("<th>Post / Patrol</th>");
        print("<th>Vehicle</th>");

        while($row = mysqli_fetch_assoc($resultsFindInventory)) {

            echo "<tr class='nth-child'>
                                <td class='nth-child'>" . strtoupper($row["registration"]). "</td>
                                <td>". $row["date_time"]." </td>
                                <td>".  ucwords($row["submittedBy"])." </td>
                                <td>".  ucwords($row["post_patrol"])." </td>
                                <td>" . $row["inventory"]. "</td>
                                </tr>
                </tr>";

        }


    } else {
        echo "<p style='text-align:center'>No inventories have been submitted.</p>";
    }
    echo "</table><br>

";

    ?>

</body>
<footer>
    <?php

    if (isset($_SESSION['page_admin'])){



        echo "<p align='center'>Logged in as "; echo " ".$_SESSION['page_admin']." from the ".$_SESSION['unitName'].""; echo ". (Admin)<br> </p></footer>";
        /*$username = $_SESSION['username'];
        header("Location: login_success.php");
        echo "Hai " . $username . "
        ";
        echo "This is the Members Area
        ";
        echo "<a href='logout.php'>Logout</a>";*/



    }elseif(isset($_SESSION['page_user'])) {
        echo "<p align='center'>Logged in as "; echo $_SESSION['page_user']; echo ". (User)<br> </p>";



        //3.2 When the user visits the page first time, simple login form will be displayed.

    } else {

    }

    ?>

</footer>
<!-- indluces closing html tags for body and html-->
<!-- place below last </div> tag -- indluces closing html tags for body and html-->
<?php include __DIR__ . '/footer.php';?>
