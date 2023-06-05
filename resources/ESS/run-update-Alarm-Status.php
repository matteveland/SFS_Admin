<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

parse_str($_SERVER['QUERY_STRING'], $id);
$unitName = $_SESSION['unitName'];
$adminName = $_SESSION['page_admin'];
$userName = $_SESSION['page_user'];

$id = $mysqli->real_escape_string($_POST['getID']);
$updateFormType = $mysqli->real_escape_string($_POST['inputWorkOrderType']);
$updateAccountName = $mysqli->real_escape_string($_POST['inputAccountName']);
$updateBuildingNumber= $mysqli->real_escape_string($_POST['inputBuildingName']);
$updateRoomNumber= $mysqli->real_escape_string($_POST['inputRoomNumber']);
if(!$_POST['inputAccessPoint'] == ''){

    $updateAccessPoint = $mysqli->real_escape_string($_POST['inputAccessPoint']);
}else{
    $updateAccessPoint = '0';
}

$updateSensorLocation= $mysqli->real_escape_string($_POST['inputLocationSelect']);
$updateSensorKind= $mysqli->real_escape_string($_POST['inputSensorKind']);
$updateFindings= $mysqli->real_escape_string($_POST['inputFindings']);
$updateDescription= $mysqli->real_escape_string($_POST['inputDescriptionField']);



//$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));

$findIV = $mysqli->query("SELECT iv FROM alarmData where id = '$id'");


while($row = $findIV->fetch_assoc()){
$recallIV = $row['iv'];
}

$encryptedAlarmDescription = openssl_encrypt($updateDescription, $cipherMethod, $essDescriptionKey, $options = 0, $recallIV);


$updateStatus = $mysqli->real_escape_string($_POST['alarmUpdate']);
$updateCorrectedBy= $mysqli->real_escape_string($_POST['inputCorrectedBy']);
$updateInspectedBy = $mysqli->real_escape_string($_POST['inspectedBy']);
$updateInspectedDate = $mysqli->real_escape_string($_POST['dateCorrected']);
$updateNotes= $mysqli->real_escape_string($_POST['noteBox']);

       if (isset($_POST['adminSubmit'])){

            $updateAlarmStatus = $mysqli->query("UPDATE alarmData SET status = '$updateStatus', notes = '$updateNotes', inspectedBy = '$updateInspectedBy', dateCorrected = '$updateInspectedDate',
                                correctedBy = '$updateCorrectedBy', alarmTypeSubmit = '$updateFormType', accountName = '$updateAccountName', accessPoint = '$updateAccessPoint', alarmLocationType = '$updateSensorLocation',
                                findings = '$updateFindings', alarmDescription = '$encryptedAlarmDescription', buildingNumber = '$updateBuildingNumber', roomNumber = '$updateRoomNumber', sensorKind = '$updateSensorKind' WHERE (id = '$id')") or die(mysqli_errno($mysqli));
              //  $resultsUpdateAlarmStatus = mysqli_query($mysqli, $updateAlarmStatus) or die(mysqli_errno($mysqli));


                //echo $updateAlarmStatus;

                if (!$updateAlarmStatus) {
           $failuremsg = "Alarm status failed to update.";
//echo "no";
           //  echo '<div class="alert alert-danger" role="alert" style="alignment: center">> ' . $failuremsg . '  <p><br>';

                  //  $location = "'viewAlarmData.php'";

                  //  echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';

                }else{
                 $successmsg = "Alarm status successfully updated. Select the link below to return to the View Alarm Status.";
                   //echo "yes";
             // echo '<div align="center" class="alert alert-success" role="alert" style="alignment: center"> ' . $successmsg . '  <p><br>';

                //    $location = "'viewAlarmData.php'";

                  //  echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
                }




      /*if(isset($_POST['cancel'])){

            $failuremsg = "Update was cancelled. Returning to main alarm work order page.";

            echo '<div class="alert alert-danger" role="alert" align="center"> ' . $failuremsg . '  <p><br>';

            $location = "'viewAlarmData.php'";

            echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';

                }
                else {

        }

        $selectAlarmUpdate = "SELECT * FROM alarmData WHERE id = '$updateItemId' and unitName = '$unitName'";

        $resultSelectAlarmUpdate = mysqli_query($mysqli, $selectAlarmUpdate);
*/
    }



?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<body>
<div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Insert Alarm Data Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php } ?>
                    <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php } ?>
                    <p style="text-align: center"></p>
                    <?php header("refresh:3;url=alarm-update-status.php?id=$id");?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bs-example">
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logging In</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>You will be rerouted to the SFSAdmin homepage</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>
<style>
    .bs-example{
        margin: 20px;
    }
</style>




<!-- indluces closing html tags for body and html-->
<!-- place below last </div> tag -- indluces closing html tags for body and html-->
