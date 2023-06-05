<?php


require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../resources/Admin/Login-Logout/verifyLogin.php'; //verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');

$unitName = $_SESSION['unitName'];
$section = 'S4';
?>
<html lang="en">

<head>
    <title></title>
</head>
<body>
<h3 style="text-align: center"><?php //echo $section;?> VCO Information</h3>

<div>
    <!-- assigned vehicles-->

    <?php



        while ($Vehicle = mysqli_fetch_assoc($resultsFindVehicles)) {

            echo "<tr class='nth-child' align='center'>";



           echo "<td>" . '<a href="../S4/VCO/viewVehicle.php?reg=' . $Vehicle['registration'] . '&year=' . $Vehicle['modelYear'] . '&make=' . $Vehicle['make'] . '&model=' . $Vehicle['model'] . ' " style=color:blue> '.$Vehicle['status'].'</a></p>' . "</td>";
           echo "<td>" . $Vehicle['post'] . "</td>
            <td>" . $Vehicle['registration'] . "</td>
            <td>" . $Vehicle['mileage'] . "</td>
            <td>" . $Vehicle['modelYear'] . "</td>
            <td>" . $Vehicle['make'] . "</td>
            <td>" . $Vehicle['model'] . "</td>";
            if ($Vehicle['driveType'] == 4){
            echo "<td> 4X4 </td>";
        }else{
                echo "<td> 4X2 </td>";
        }

             if ($Vehicle['DoorType'] == 4){
            echo "<td> 4 Door </td>";
        }else{
                echo "<td> 2 Door </td>";
        }
            if ($Vehicle['stickers'] == 1){
                echo "<td> Installed </td>";
            }else{
                echo "<td> Not Installed </td>";
            }

            $equipment = explode(', ', $Vehicle['equipment']);
            sort($equipment);

            echo"<td>";

             foreach($equipment as $thing){
             echo "$thing<br>";
             }


            echo "</td>
            <td>" . $Vehicle['description'] . "</td>";
          if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){
        echo "<td>" . '<a href="../S4/VCO/updateVehicle.php?reg=' . $Vehicle['registration'] . '&year=' . $Vehicle['modelYear'] . '&make=' . $Vehicle['make'] . '&model=' . $Vehicle['model'] . ' " style=color:blue>Update '.$Vehicle['registration'].'</a></p>' . "</td>
              <td>" . '<a href="../S4/VCO/vehicle-delete.php?registration=' . $Vehicle['registration'].'" style="color:red" onclick="return confirmDelete(this);">Remove '.$Vehicle['registration'].'</a><br>' . "</td>";

          }else{

             }

        }

} else {
    echo "<p align='center'>No Vehicle Information</p>";
}
    //need </table> to align table in proper area on page (above footer)
echo "</table>";
    ?>
</div>


<div>
    <!-- Loaner vehicles-->

    <?php
    $resultsFindLoanerVehicles = mysqli_query($connection, $findLoanerVehicles);
    //$resultsFindLoanerVehicles2 = mysqli_fetch_assoc($resultsFindLoanerVehicles);


    if (mysqli_num_rows($resultsFindLoanerVehicles) > 0) {

        echo "<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        echo("<th>Current Status</th>");
        echo("<th>Current Post</th>");
        print("<th>Vehicle Registration</th>");
        print("<th>Mileage</th>");
        print("<th>Year</th>");
        print("<th>Make</th>");
        print("<th>Model</th>");
        print("<th>Drive Type</th>");
        print("<th>Doors</th>");
        print("<th>Sticker Package</th>");
        echo("<th>Equipment Installed</th>");
        echo("<th>Vehicle Description</th>");

        if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){
            echo("<th>Update</th>
<th>Delete</th>");

        }else{

        }



        while ($loanerVehicle = mysqli_fetch_assoc($resultsFindLoanerVehicles)) {

            echo "<br><h3 style='text-align: center'>Loaner Vehicle Information</h3>
                        <tr class='nth-child' align='center'>";
            echo "<td>" . '<a href="../S4/VCO/viewVehicle.php?reg=' . $loanerVehicle['registration'] . '&year=' . $loanerVehicle['modelYear'] . '&make=' . $loanerVehicle['make'] . '&model=' . $loanerVehicle['model'] . ' " style=color:blue> '.$loanerVehicle['status'].'</a></p>' . "</td>";
            echo "<td>" . $loanerVehicle['location'] . "</td>
            <td>" . $loanerVehicle['registration'] . "</td>
            <td>" . $loanerVehicle['mileage'] . "</td>
            <td>" . $loanerVehicle['modelYear'] . "</td>
            <td>" . $loanerVehicle['make'] . "</td>
            <td>" . $loanerVehicle['model'] . "</td>";
            if ($loanerVehicle['driveType'] == 4){
                echo "<td> 4X4 </td>";
            }else{
                echo "<td> 4X2 </td>";
            }

            if ($loanerVehicle['DoorType'] == 4){
                echo "<td> 4 Door </td>";
            }else{
                echo "<td> 2 Door </td>";
            }
            if ($loanerVehicle['stickers'] == 1){
                echo "<td> Installed </td>";
            }else{
                echo "<td> Not Installed </td>";
            }

            $equipment = explode(', ', $loanerVehicle['equipment']);
            sort($equipment);

            echo"<td>";

            foreach($equipment as $thing){
                echo "$thing<br>";
            }


            echo "</td>
            <td>" . $loanerVehicle['description'] . "</td>";
            if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){
                echo "<td>" . '<a href="../S4/VCO/updateVehicle.php?reg=' . $loanerVehicle['registration'] . '&year=' . $loanerVehicle['modelYear'] . '&make=' . $loanerVehicle['make'] . '&model=' . $loanerVehicle['model'] . ' " style=color:blue>Update '.$loanerVehicle['registration'].'</a></p>' . "</td>
              <td>" . '<a href="../S4/VCO/vehicle-delete.php?registration=' . $loanerVehicle['registration'].'" style="color:red" onclick="return confirmDelete(this);">Remove '.$loanerVehicle['registration'].'</a><br>' . "</td>";

            }else{

            }

        }

    } else {
        echo "<br><p align='center'>No Vehicle Information</p>";
    }
    //need </table> to align table in proper area on page (above footer)
    echo "</table>";




    ?>
</div>
    <!-- includes closing html tags for body and html-->
<section>


    <div class="col-md-12 text-center">
        <a class="btn btn-secondary my-2 my-sm-0" href="VCO/addVehicle.php" role="button" style="align-items: center">Add New Vehicle</a>
        <a class="btn btn-secondary my-2 my-sm-0" href="VCO/insertInventoryVeh.php" role="button" style="align-items: center">Add Mileage Information</a>

        <!-- end homepage ads -->


    </div>
</section>
<br>


<script>
    function confirmDelete(link) {
        if (confirm("Are you sure? Vehicle will be removed from the database.")) {
            doAjax(link.href, "GET"); // doAjax needs to send the "confirm" field
        }
        return false;
    }
</script>


<?php include __DIR__.'/../footer.php'; ?>
