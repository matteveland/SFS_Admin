<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];

if (($_SESSION['page_admin']) == 0) {

  //queries

  $findVehicles = $mysqli->query("SELECT * FROM vehicles_daily where unitName = '$unitName' AND registration NOT LIKE '%DELETE_%'");
  $findLoanerVehicles = $mysqli->query("SELECT m.registration, m.mileage, m.location, m.dutySection, m.lastUpdate, m.status FROM vehicles_mileage AS m LEFT JOIN vehicles_daily AS d ON m.registration = d.registration WHERE d.registration IS NULL AND m.unitName = '$unitName' AND m.registration NOT LIKE '%DELETE_%'");

    //assigned vehicles
    if ($findVehicles->num_rows > 0) {
        // output data of each row

        echo "<br><h3 style='text-align: center'>Vehicels Assigend</h3><table>
            <table id='AssignedVehicleTables' class='table table-bordered table-hover'>
                <thead>
                    <tr>
                    <th>Current Status</th>
                    <th>Current Post</th>
                    <th>Vehicle Registration</th>
                    <th>Mileage</th>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Drive Type</th>
                    <th>Doors</th>
                    <th>Sticker Package</th>
                    <th>Equipment Installed</th>
                    <th>Vehicle Description</th>
                ";

                //admin view of select things
        if (($_SESSION['page_admin']) == 'Unit_VCO' OR 'matt') {
            echo '<th>Update</th>
            <th>Delete</th>';
        }
                echo"</tr>
                        </thead>";


        while ($row = $findVehicles->fetch_assoc()) {

            echo "<tr class='nth-child'>
                <td>" . '<a href="../S4/VCO/viewVehicle.php?reg=' . $row['registration'] . '&year=' . $row['modelYear'] . '&make=' . $row['make'] . '&model=' . $row['model'] . ' " style=color:blue> '.$row['status'].'</a></p>' . "</td>
                <td>" . $row['post'] . "</td>
                <td>" . $row['registration'] . "</td>
                <td>" . $row['mileage'] . "</td>
                <td>" . $row['modelYear'] . "</td>
                <td>" . $row['make'] . "</td>
                <td>" . $row['model'] . "</td>";

             if ($row['driveType'] == 4){
                    echo "<td> 4X4 </td>";
                }else{
                 echo "<td> 4X2 </td>";
                }

              if ($row['DoorType'] == 4){
                    echo "<td> 4 Door </td>";
                }else{
                 echo "<td> 2 Door </td>";
                }
             if ($row['stickers'] == 1){
                    echo "<td> Installed </td>";
                }else{
                     echo "<td> Not Installed </td>";
                }

             $equipment = explode(', ', $row['equipment']);
             sort($equipment);

            echo"<td>";

              foreach($equipment as $thing){
                echo "$thing<br>";
                }


            echo "</td>
                  <td>" . $row['description'] . "</td>";

                  //admin view only buttons
                if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){
                    echo "<td>" . '<a class="btn btn-md btn-primary" href="/resources/VCO/vehicle-view-data.php?reg=' . $row['registration'] . '&id=' . $row['id'] . '">Update '.$row['registration'].'</a></p>' . "</td>
                    <td>" . '<a class="btn btn-md btn-danger" href="/resources/VCO/vehicle-delete.php?registration=' . $row['registration'].'" onclick="return confirmDelete(this);">Remove '.$row['registration'].'</a><br>' . "</td>";
                    }else{
                    }
                 //end while loop


            echo " </tr>
                   </tr>";
        }//end if loop
  //end all assigned vehicle view

    }/*//end if loop// */ else {

        //no vehicles assigned to the unit
        echo "<br>
        <h3 style='text-align: center'>Exterior<br>No Vehicles assigned.</h3>";
    }

    echo "</table><br>";


    //Begin loaner vehicle section

    if ($findLoanerVehicles->num_rows > 0) {
        // output data of each row
        echo "<br><h3 style='text-align: center'>Vehicels Assigend</h3><table>
            <table id='LoanerVehicleTables' class='table table-bordered table-hover'>
                <thead>
                    <tr>
                    <th>Current Status</th>
                    <th>Current Post</th>
                    <th>Vehicle Registration</th>
                    <th>Mileage</th>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Drive Type</th>
                    <th>Doors</th>
                    <th>Sticker Package</th>
                    <th>Equipment Installed</th>
                    <th>Vehicle Description</th>
                ";

                //admin view of select things
        if (($_SESSION['page_admin']) == 'Unit_VCO' OR 'matt') {
            echo '<th>Update</th>
            <th>Delete</th>';
        }
                echo"</tr>
                        </thead>";


        while ($row = $findLoanerVehicles->fetch_assoc()) {

            echo "<tr class='nth-child'>
                <td>" . '<a href="../S4/VCO/viewVehicle.php?reg=' . $row['registration'] . '&year=' . $row['modelYear'] . '&make=' . $row['make'] . '&model=' . $row['model'] . ' " style=color:blue> '.$row['status'].'</a></p>' . "</td>
                <td>" . $row['post'] . "</td>
                <td>" . $row['registration'] . "</td>
                <td>" . $row['mileage'] . "</td>
                <td>" . $row['modelYear'] . "</td>
                <td>" . $row['make'] . "</td>
                <td>" . $row['model'] . "</td>";

             if ($row['driveType'] == 4){
                    echo "<td> 4X4 </td>";
                }else{
                 echo "<td> 4X2 </td>";
                }

              if ($row['DoorType'] == 4){
                    echo "<td> 4 Door </td>";
                }else{
                 echo "<td> 2 Door </td>";
                }
             if ($row['stickers'] == 1){
                    echo "<td> Installed </td>";
                }else{
                     echo "<td> Not Installed </td>";
                }

             $equipment = explode(', ', $row['equipment']);
             sort($equipment);

            echo"<td>";

              foreach($equipment as $thing){
                echo "$thing<br>";
                }


            echo "</td>
                  <td>" . $row['description'] . "</td>";

                  //admin view only buttons
                if((($_SESSION['page_admin']) == 'Unit_VCO') OR (($_SESSION['page_admin']) == 'matt')){
                    echo "<td>" . '<a href="../S4/VCO/updateVehicle.php?reg=' . $row['registration'] . '&year=' . $row['modelYear'] . '&make=' . $row['make'] . '&model=' . $row['model'] . ' " style=color:blue>Update '.$row['registration'].'</a></p>' . "</td>
                    <td>" . '<a href="../S4/VCO/vehicle-delete.php?registration=' . $row['registration'].'" style="color:red" onclick="return confirmDelete(this);">Remove '.$row['registration'].'</a><br>' . "</td>";
                    }else{
                    }
                 //end while loop


            echo " </tr>
                   </tr>";
        }//end if loop
  //end all assigned  loaner vehicle view

    }/*//end if loop// */ else {

        //no vehicles assigned to the unit
        echo "<br>
        <h3 style='text-align: center'>Loaner Vehicle Inventory<br>No loaner vehicles currently assigned.</h3>";
    }

    echo "</table><br>";

}/*//end starting if loop// */
else {
    echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

    exit;
}

?>

<script>
    function confirmDelete(link) {
        if (confirm("Are you sure? Vehicle will be removed from the database.")) {
            doAjax(link.href, "GET"); // doAjax needs to send the "confirm" field
        }
        return false;
    }
</script>
