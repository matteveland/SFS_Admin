<?php


require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';
include('/var/services/web/sfs/Application/data.env');
include('/Users/matteveland/code/data.env');
parse_str($_SERVER['QUERY_STRING'], $query);

$unitName = $_SESSION['unitName'];

$now = date('Y-m-d H:i:s');

$admin = $_SESSION['page_admin'];
$user = $_SESSION['page_user'];
$unitName = $_SESSION['unitName'];

$getAdminName = "SELECT * FROM login WHERE (user_name = '$admin' OR user_name = '$user')";

$resultsAdmin = mysqli_query($connection, $getAdminName);

while ($row = mysqli_fetch_assoc($resultsAdmin)) {

    $recallLast = $row['lastName'];
    $recallFirst = $row['firstName'];
}

$addedBy = $recallLast . ', ' . $recallFirst;


$year = mysqli_real_escape_string($connection, $query['year']);
$make = mysqli_real_escape_string($connection, $query['make']);
$model = mysqli_real_escape_string($connection, $query['model']);
$reg = mysqli_real_escape_string($connection, $query['reg']);

$yearStripped = htmlentities($year, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$makeStripped = htmlentities($make, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$modelStripped = htmlentities($model, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$regStripped = htmlentities($reg, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$equipmentArray = array();
$equipmentArray = ('Overhead Lights, Camper Shell, Push Bar, Gun Rack, Loud Speaker, Toolbox');

//print_r($equipmentArray);


if (isset($_SESSION['page_admin'])) {

    //Vehicle member's information section begin
    $recallVehicleInformation = "SELECT * FROM vehicles_daily WHERE registration = '$regStripped'";
    $resultRecallVehicleInformation = mysqli_query($connection, $recallVehicleInformation);

    while ($recallVehicle = mysqli_fetch_assoc($resultRecallVehicleInformation)) {
        $recallReg = $recallVehicle['registration'];
        $recallYear = $recallVehicle['modelYear'];
        $recallMake = $recallVehicle['make'];
        $recallModel = $recallVehicle['model'];
        $recallDriveType = $recallVehicle['driveType'];
        $recallDoors = $recallVehicle['DoorType'];
        $recallStickers = $recallVehicle['stickers'];
        $recallEquipmentInstalled = $recallVehicle['equipment'];

        $recallEquipmentInstalled = explode(', ', $recallEquipmentInstalled);
        sort($recallEquipmentInstalled);
        $recallDescription = $recallVehicle['description'];
        $recallPost = $recallVehicle['post'];
        $recallStatus = $recallVehicle['status'];
        $recallMileage = $recallVehicle['mileage'];

    }

    $recallDeadlineInformation = "SELECT * FROM vehicles_mileage WHERE registration = '$regStripped' AND status ='Deadlined' ORDER BY lastupdate DESC LIMIT 10";
    $resultRecallDeadlineInformation = mysqli_query($connection, $recallDeadlineInformation);



    $recallStandardVehicleInformation = "SELECT equipmentType FROM vehicleEquipment where unitName = '$unitName'";
    $recallStandardVehicleInformation = mysqli_query($connection, $recallStandardVehicleInformation);
    $recallStandardVehicleInformationArray = mysqli_fetch_assoc($recallStandardVehicleInformation);

    $equipArray = array();
    $equipArray = explode(',', $recallStandardVehicleInformationArray['equipmentType']);


    $recallHistoryAll = "SELECT * FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT 10";
    $resultsRecallHistoryAll = mysqli_query($connection, $recallHistoryAll);

    $recallHistoryAvg = "SELECT @next_mileage - mileage AS diff, @next_mileage := mileage AS Total FROM (SELECT mileage FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT 10) AS recent10 CROSS JOIN (SELECT @next_mileage := NULL) AS var";

    $resultsRecallHistoryAvg = mysqli_query($connection, $recallHistoryAvg);
    $resultsHistoryAvgReturn = mysqli_fetch_assoc($resultsRecallHistoryAvg);

    $avgMileage = "SELECT AVG(difference) AS AvgDiff FROM ( SELECT @next_mileage - mileage AS difference, @next_mileage := mileage FROM (SELECT mileage FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT 10) AS recentTen CROSS JOIN (SELECT @next_mileage := NULL) AS var ) AS recent_diffs";
    $returnAvgMileage = mysqli_query($connection, $avgMileage);
    while ($resultsReturnAvgMileage = mysqli_fetch_assoc($returnAvgMileage)) {
        $thing = $resultsReturnAvgMileage['AvgDiff'];

    }
} else {

}

?>
    <html lang="en">
    <head>
        <title>Vehicle Information for <?php echo $recallReg ?></title>
    </head>
    <body>

    <!--member's data messages -->
    <?php if (isset($successmsg)) { ?>
        <div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
    <?php if (isset($failuremsg)) { ?>
        <div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>

    <?php echo "<h1 align='center'> Current Information for $regStripped</h1>"; ?>
    <br>
    <div class="member_update">
        <div class="container" align="center">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-row" style="text-align: left">

                    <!--Vehicle information displayed-->
                    <div class="form-group col-md-12">

                        <p style="text-align: center; font-size: 36px;"> <?php echo "$recallStatus"; ?></p>
                    </div>

                </div>


                <div class="form-row" style="text-align: left">

                    <!--Vehicle information displayed-->
                    <div class="form-group col-md-2">
                        <b><label for="inputRegistration">Vehicle Registration</label></b>
                        <br>
                        <?php echo "$recallReg"; ?>
                    </div>
                    <div class="form-group col-md-2">
                        <b><label for="inputYear">Vehicle Year</label></b>
                        <br>
                        <?php echo $recallYear; ?>
                    </div>
                    <div class="form-group col-md-2">
                        <b><label for="inputRegistration">Vehicle Make</label></b>
                        <br>
                        <?php echo "$recallMake"; ?>
                    </div>
                    <div class="form-group col-md-2">
                        <b><label for="inputRegistration">Vehicle Model</label></b>
                        <br>
                        <?php echo "$recallModel"; ?>
                    </div>
                    <div class="form-group col-md-2">
                        <b><label for="inputRegistration">Last Reported Mileage</label></b>
                        <br>
                        <?php echo "$recallMileage"; ?>
                    </div>
                </div>

                <div class="form-row" style="text-align: left">
                    <div class="form-group col-md-3" style="text-align: left">
                        <label for="multiSelectEquipmentRemoved"><b>Installed Equipment</b></label><br>

                        <?php
                        for ($i = 0; $i < count($recallEquipmentInstalled); $i++) {
                            if ($recallEquipmentInstalled > 0) {
                                echo "$recallEquipmentInstalled[$i]<br>";
                            }
                        }
                        ?>

                    </div>
                </div>

                <!-- Display last 10 vehicle mileage information -->
                <div class="form-row" style="text-align: left">
                    <div class="form-group " style="text-align: left">
                        <b>Last 10 Mileage entries</b>
                        <?php
                        if (mysqli_num_rows($resultsRecallHistoryAll) > 0) {
                            echo "<table>
                            <table class='table table-striped' border = \"1\" align='center' style='width: auto'>
                            <tr>
                            <th>Status</th>
                            <th>Historical Mileage</th>
                            <th>Difference Between Reported</th>

                            <th>1800 Reported</th>
                            <th>1800 Notes Reported</th>
                            <th>Waiver Reported</th>
                            <th>Waiver Notes Reported</th>

                            <th>Mileage Reported</th>
                            <th>Last Updated By</th>
                            </tr>";

                            while (($recallHistory = mysqli_fetch_assoc($resultsRecallHistoryAll)) and ($resultsHistoryAvgReturn = mysqli_fetch_assoc($resultsRecallHistoryAvg))) {

                                echo "<tr class='nth-child' align='center'>
                                    <td class='nth-child'>" . $recallHistory['status'] . "</td>
                                    <td class='nth-child'>" . $recallHistory['mileage'] . "</td>
                                    <td class='nth-child'>" . $resultsHistoryAvgReturn['diff'] . "</td> 
                                    <td class='nth-child'>" . $recallHistory['AF1800'] . "</td>
                                    <td class='nth-child'>" . $recallHistory['1800Notes'] . "</td>
                                    <td class='nth-child'>" . $recallHistory['waiverCard'] . "</td>
                                    <td class='nth-child'>" . $recallHistory['waiverNotes'] . "</td>
                                    <td class='nth-child'>" . $recallHistory['lastUpdate'] . "</td>
                                    <td class='nth-child'>" . $recallHistory['updatedBy'] . "</td>
                                     </tr>";

                            }
                            echo "<tr class='nth-child' align='center'>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'>Avg Mileage per day " . $thing . "</td>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'></td>
                                    <td class='nth-child'></td>
                                    
                                     </tr>";

                            //need </table> to align table in proper area on page (above footer)

                            echo "</table>";
                        } else {
                            echo "<p align='center'>No Vehicle Information</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Display last 10 Deadline vehicle information -->
                <div class="form-row" style="text-align: left">
                    <div class="form-group " style="text-align: left">
                        <b>Deadline Vehicle Information</b>
                        <?php
                        if (mysqli_num_rows($resultRecallDeadlineInformation) > 0) {
                            echo "<table>
                            <table class='table table-striped' border = \"1\" align='center' style='width: auto'>
                            <tr>
                            <th>Mileage Reported When Deadlined</th>
                            <th>Post Reporting Deadline</th>
                            <th>Driver Name</th>
                            <th>Deadline Reason</th>
                            <th>Date of Deadline</th>
                            <th>Last Updated By</th>
                            
                            
                            </tr>";
 while ($recallDeadlineVehicle = mysqli_fetch_assoc($resultRecallDeadlineInformation)) {
     $recallRecallDeadlineVehicleUpdatedBy = $recallDeadlineVehicle['updatedBy'];
     $recallRecallDeadlineVehicleLastUpdate = $recallDeadlineVehicle['lastUpdate'];
     $recallRecallDeadlineVehiclePost = $recallDeadlineVehicle['post'];
     $recallRecallDeadlineVehicleStatus = $recallDeadlineVehicle['status'];
     $recallRecallDeadlineVehicleReason = $recallDeadlineVehicle['deadlineReason'];
     $recallRecallDeadlineVehicleMileage = $recallDeadlineVehicle['mileage'];
     $recallRecallDeadlineVehicleDriverName = $recallDeadlineVehicle['driverName'];

     echo "<tr class='nth-child' align='center'>
                                    <td class='nth-child'>" . $recallRecallDeadlineVehicleMileage . "</td>
                                    <td class='nth-child'>" . $recallRecallDeadlineVehiclePost . "</td>
                                    <td class='nth-child'>" . $recallRecallDeadlineVehicleDriverName . "</td>
                                    <td class='nth-child'>" . $recallRecallDeadlineVehicleReason . "</td>
                                    <td class='nth-child'>" . $recallRecallDeadlineVehicleLastUpdate . "</td>
                                    <td class='nth-child'>" . $recallRecallDeadlineVehicleUpdatedBy . "</td>
                                     </tr>";

     //need </table> to align table in proper area on page (above footer)
 }
                            echo "</table>";
                        } else {
                            echo "<p align='center'>No Deadline Vehicle Information</p>";
                        }
                        ?>
                    </div>
                </div>
            </form>

        </div>
    </div>


    </body>
    <footer>
        <!-- includes closing html tags for body and html-->

<?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>