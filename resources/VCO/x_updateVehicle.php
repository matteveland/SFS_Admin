<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();

//include('/var/services/web/sfs/Application/data.env');
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
$model = mysqli_escape_string($connection, $_GET['model']);
$reg = mysqli_escape_string($connection, $_GET['reg']);
$make = mysqli_escape_string($connection, $_GET['make']);
$year = mysqli_escape_string($connection, $_GET['year']);

$addedBy = $recallLast . ', ' . $recallFirst;
//$year = mysqli_real_escape_string($connection, $query['year']);
//$make = mysqli_real_escape_string($connection, $query['make']);
//$model = mysqli_real_escape_string($connection, $query['model']);
///=$reg = mysqli_real_escape_string($connection, $query['reg']);

$yearStripped = htmlentities($year, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$makeStripped = htmlentities($make, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$modelStripped = htmlentities($model, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$regStripped = htmlentities($reg, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$equipmentArray = array();
$equipmentArray = ('Overhead Lights, Camper Shell, Push Bar, Gun Rack, Loud Speaker, Toolbox');

//print_r($equipmentArray);

if ((($_SESSION['page_admin']) == 'Unit_VCO') or (($_SESSION['page_admin']) == 'matt')) {

  //Vehicle member's information section begin
  $recallVehicleInformation = "SELECT * FROM vehicles_daily WHERE registration = '$regStripped'";
  $resultRecallVehicleInformation = mysqli_query($connection, $recallVehicleInformation);

  $recallVehiclePhotos = "SELECT * FROM vehicles_img WHERE registration = '$regStripped' order by imgDetail ASC";
  $resultRecallVehiclePhotos = mysqli_query($connection, $recallVehiclePhotos);

  $recallDeadlineInformation = "SELECT * FROM vehicles_mileage WHERE registration = '$regStripped' AND status ='Deadlined' ORDER BY lastupdate DESC LIMIT 10";
  $resultRecallDeadlineInformation = mysqli_query($connection, $recallDeadlineInformation);


  //Select Vehicle information to display for history
  if (isset($_POST['selectNumberSumbit'])) {
    $selectNumber = $_POST['selectNumber'] + 1;

    $recallHistoryAll = "SELECT * FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT $selectNumber";
    $resultsRecallHistoryAll = mysqli_query($connection, $recallHistoryAll);

    $recallHistoryAvg = "SELECT @next_mileage - mileage AS diff, @next_mileage := mileage AS Total FROM (SELECT mileage FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT $selectNumber) AS recent10 CROSS JOIN (SELECT @next_mileage := NULL) AS var";
    $resultsRecallHistoryAvg = mysqli_query($connection, $recallHistoryAvg);
    $resultsHistoryAvgReturn = mysqli_fetch_assoc($resultsRecallHistoryAvg);

    $avgMileage = "SELECT AVG(difference) AS AvgDiff FROM ( SELECT @next_mileage - mileage AS difference, @next_mileage := mileage FROM (SELECT mileage FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT $selectNumber) AS recentTen CROSS JOIN (SELECT @next_mileage := NULL) AS var ) AS recent_diffs";

    $returnAvgMileage = mysqli_query($connection, $avgMileage);
    while ($resultsReturnAvgMileage = mysqli_fetch_assoc($returnAvgMileage)) {
      $thing = $resultsReturnAvgMileage['AvgDiff'];
    }
  } else {

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
  }

  //select forms to display
  if (isset($_POST['selectFormNumberSumbit'])) {
    $selectNumber = $_POST['selectFormNumber'] + 1;

    $recallFormHistoryAll = "SELECT * FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT $selectNumber";
    $resultsRecallFormHistoryAll = mysqli_query($connection, $recallFormHistoryAll);
  } else {

    $recallFormHistoryAll = "SELECT * FROM vehicles_mileage WHERE registration = '$regStripped' ORDER BY lastUpdate DESC LIMIT 10";
    $resultsRecallFormHistoryAll = mysqli_query($connection, $recallFormHistoryAll);

  }

  //Add equipment to vehicle
  if (isset($_POST['add'])) {

    //items that can not be changed: year, make, model, re
    $equipmentInstalledUpdateAdd = $_POST['equipmentAdd'];
    $equipmentInstalledUpdateAddArray = join(', ', $_POST['equipmentAdd']);
    $combineArray = $equipmentInstalledUpdateAddArray . ', ' . join(', ', $recallEquipmentInstalled);

    $updateVehicleInformation = "UPDATE vehicles_daily SET equipment = '$combineArray', updatedBy = '$addedBy', lastUpdate = '$now' WHERE (registration = '$recallReg'
      AND modelyear = '$recallYear'
      AND make = '$recallMake'
      AND model = '$recallModel')";

      $resultUpdateVehicleInformation = mysqli_query($connection, $updateVehicleInformation);

      if (($resultUpdateVehicleInformation) == true) {
        $successmsg = "Vehicle Information Successfully Updated.";

        echo "<meta http-equiv='refresh' content='0'>";

      } else {
        $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
      }
    }
    //Remove equipment from vehicle
    if (isset($_POST['remove'])) {

      //items that can not be changed: year, make, model, re
      $equipmentInstalledUpdateRemove = $_POST['equipmentRemove'];
      $newEquipmentListArray = array_diff($recallEquipmentInstalled, $equipmentInstalledUpdateRemove);
      //  print_r($equipmentInstalledUpdateRemove);
      $equipmentInstalledUpdateRemoveArray = join(', ', $newEquipmentListArray);
      $updateVehicleInformation = "UPDATE vehicles_daily SET equipment = '$equipmentInstalledUpdateRemoveArray', updatedBy = '$addedBy', lastUpdate = '$now' WHERE (registration = '$recallReg'
        AND modelyear = '$recallYear'
        AND make = '$recallMake'
        AND model = '$recallModel')";
        $resultUpdateVehicleInformation = mysqli_query($connection, $updateVehicleInformation);

        if (($resultUpdateVehicleInformation) == true) {
          $successmsg = "Vehicle Information Successfully Updated.";

          echo "<meta http-equiv='refresh' content='0'>";

        } else {
          $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
        }
      }
      //Update vehicle information
      if (isset($_POST['update'])) {

        //items that can not be changed: year, make, model, reg
        //$equipmentInstalledUpdate = mysqli_real_escape_string($connection, $_POST['inputEquipmentSelect']);
        //$stickersUpdate = mysqli_real_escape_string($connection, $_POST['inputStickersSelect']);

        $descriptionUpdate = mysqli_real_escape_string($connection, $_POST['description']);

        $updateVehicleInformation = "UPDATE vehicles_daily SET description = '$descriptionUpdate' WHERE (registration = '$regStripped'
          AND modelyear = '$yearStripped'
          AND make = '$makeStripped'
          AND model = '$modelStripped')";

          $resultUpdateVehicleInformation = mysqli_query($connection, $updateVehicleInformation) or die('Database Selection Failed' . mysqli_error($connection));

          if (($resultUpdateVehicleInformation) == true) {
            $successmsg = "Vehicle Information Successfully Updated.";
            //$location = "./updateMember.php?rank=$rankUpdate&last=$lastName&first=$firstName&middle=$middleName\"";
            // uncommnet to work    echo '<meta http-equiv="refresh" content="0; url='.$location.'">';
            echo "<meta http-equiv='refresh' content='0'>";
            // header("Location: '.$location.'");
          } else {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            $failuremsg = "Vehicle Information Was Not Updated - Please try again.";
          }
        }
        //UPLOAD Photo
        if (isset($_POST["imgUploadNoImg"])) {

          $selectView = mysqli_escape_string($connection, $_POST['selectView']);

          $file = $_FILES['file'];
          $fileName = $_FILES['file']['name'];
          $fileTmpName = $_FILES['file']['tmp_name'];
          $fileSize = $_FILES['file']['size'];
          $fileError = $_FILES['file']['error'];
          $fileType = $_FILES['file']['type'];
          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));
          $allowed = array('jpg', 'jpeg', 'png');

          $fileNameNew = "$recallReg.$selectView.$fileActualExt";
          $fileDestination = './vehicle_img/' . $fileNameNew;

          if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
              if ($fileSize < 524288) {

                //find image
                $findImg = "SELECT * from vehicles_img where registration = '$recallReg' AND imgDetail = '$selectView'";
                $resultFindImg = mysqli_query($connection, $findImg)or die(mysqli_error($connection));

                //if update is true
                if (mysqli_num_rows($resultFindImg) >=1 ) {
                  $remove = "DELETE from vehicles_img where img = '$fileDestination' AND imgDetail = '$selectView' AND registration = '$recallReg'";
                  $resultRemove = mysqli_query($connection, $remove)or die(mysqli_error($connection));

                  $imgUpdate = "INSERT INTO vehicles_img SET imgDetail = '$selectView', registration = '$recallReg', img='$fileDestination'";
                  $resultImgUpdate = mysqli_query($connection, $imgUpdate) or die(mysqli_error($connection));

                  if ($resultImgUpdate = true) {
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $uploadSuccess = "Your Vehicle photo has been updated successfully Update";
                    echo "<meta http-equiv='refresh' content='2'>";
                  } else {
                    $failuremsg = "Your file was not uploaded. Did not Insert (1)";
                  }


                } elseif (mysqli_num_rows($resultFindImg) < 1) {

                  $imgUpdate = "INSERT INTO vehicles_img SET imgDetail = '$selectView', registration = '$recallReg', img='$fileDestination'";
                  $resultImgUpdate = mysqli_query($connection, $imgUpdate) or die(mysqli_error($connection));

                  if ($resultImgUpdate = true) {
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $uploadSuccess = "Your Vehicle photo has been updated successfully Update";
                    echo "<meta http-equiv='refresh' content='2'>";
                  } else {
                    $failuremsg = "Your file was not uploaded. Did not Insert (1)";
                  }


                } else {
                  //did not remove
                  $failuremsg = "Your file was not uploaded OG file not removed (3).";
                  echo "<meta http-equiv='refresh' content='2'>";
                }

                /* if (mysqli_num_rows($resultFindImg) <= 0) {
                $imgInsert = "INSERT INTO vehicles_img SET imgDetail = '$selectView', registration = '$recallReg', img='$fileDestination'";
                $resultImgInsert = mysqli_query($connection, $imgInsert)or die(mysqli_error($connection));

                if ($resultImgInsert = true) {
                move_uploaded_file($fileTmpName, $fileDestination);
                $uploadSuccess = "Your vehicle photo has been uploaded successfully insert";
                echo "<meta http-equiv='refresh' content='2'>";
              } else {
              $failuremsg = "Your file was not Inserted (4).";
              echo "<meta http-equiv='refresh' content='2'>";
            }
          } else {
          $failuremsg = "Your file was not Inserted (5).";
          echo "<meta http-equiv='refresh' content='2'>";
        }*/

      } else {
        echo "Your file is larger than .25 MB.";
        echo "<meta http-equiv='refresh' content='2'>";
      }
    } else {
      $failuremsg = "Your file was not uploaded (6).";
      echo "<meta http-equiv='refresh' content='2'>";
    }
  } else {
    $failuremsg = "Your file was not uploaded.";
    echo "<meta http-equiv='refresh' content='2'>";
  }
} else {

}
}

?>
<html lang="en">
<head>
  <title>Update Vehicle Information for <?php echo $recallReg ?></title>
</head>
<script>
function confirmDelete(link) {
  if (confirm("Are you sure? Fitness record will be removed from the Member's records.")) {
    doAjax(link.href, "GET"); // doAjax needs to send the "confirm" field
  }
  return false;
}
</script>

<body>

  <!--vehicle's data messages -->
  <?php if (isset($successmsg)) { ?>
    <div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
    <?php if (isset($failuremsg)) { ?>
      <div class="alert alert-danger" role="alert"> <?php echo $failuremsg; ?> </div><?php } ?>
      <?php if (isset($uploadSuccess)) { ?>
        <div class="alert alert-success" role="alert"> <?php echo $uploadSuccess; ?> </div><?php } ?>

        <?php if ((($_SESSION['page_admin']) == 'Unit_VCO') or (($_SESSION['page_admin']) == 'matt')){ ?>

          <?php echo "<h1 align='center'> Update Vehicle Information for $regStripped</h1>"; ?>
          <br>
          <section>
            <div class="col-md-12 text-center">
              <a class="btn btn-secondary my-2 my-sm-0" href="addVehicle.php" role="button" style="align-items: center">Add New Vehicle</a>
              <a class="btn btn-secondary my-2 my-sm-0" href="insertInventoryVeh.php" role="button" style="align-items: center">Add Mileage Information</a>
              <a class="btn btn-secondary my-2 my-sm-0" href="/resources/VCO.php" role="button" style="align-items: center">Update Vehicle</a>
              <!-- end homepage ads -->
            </div>
          </section>
          <br>
          <div class="member_update">
            <div class="container" align="center">
              <form method="POST" enctype="multipart/form-data">

                <!-- Show vehicle information for selected -->
                <div class="form-row" style="text-align: left">

                  <!--Vehicle information displayed-->
                  <div class="form-group col-md-3">
                    <b><label for="inputRegistration">Vehicle Registration</label></b>
                    <br>
                    <?php echo "$recallReg"; ?>
                  </div>
                  <div class="form-group col-md-3">
                    <b><label for="inputYear">Vehicle Year</label></b>
                    <br>
                    <?php echo $recallYear; ?>
                  </div>
                  <div class="form-group col-md-3">
                    <b><label for="inputRegistration">Vehicle Make</label></b>
                    <br>
                    <?php echo "$recallMake"; ?>
                  </div>
                  <div class="form-group col-md-3">
                    <b><label for="inputRegistration">Vehicle Model</label></b>
                    <br>
                    <?php echo "$recallModel"; ?>
                  </div>
                </div>

                <!--Description-->
                <div class="form-row" style="text-align: left">
                  <b><label for="description">Description</label></b>
                  <textarea class="form-control" rows="6"
                  name="description"><?php echo $recallDescription; ?></textarea>

                  <input class="btn btn-md btn-outline-secondary" type="submit" name="update" id="update"
                  value="Update Description" style="alignment: center">
                </div>

                <!--add photos-->
                <!--//recall vehicle photograph if supplied-->
                <?php
                $sqlImg = "SELECT * FROM vehicles_daily WHERE (registration = '$recallReg')";

                $resultImg = mysqli_query($connection, $sqlImg);

                //  img add
                if (mysqli_num_rows($resultImg) > 1) {

                  while ($row = mysqli_fetch_assoc($resultImg)) {

                    $img = $row['img'];
                    $imgDetail = $row['imgDetails'];

                    $sqlImgPath = "SELECT * FROM vehicles_img WHERE (registration = '$recallReg' )";

                    $resultSQLImgPath = mysqli_query($connection, $sqlImgPath);

                    while ($row = mysqli_fetch_assoc($resultSQLImgPath)) {
                      $imagePath = $row['img'];
                      echo ' <div class="form-group col-md-9" align="center">
                      <img src=' . $imagePath . ' style=\"width: auto; height: auto;\" />
                      </div>
                      <br>
                      ';
                      echo '<div class="container" align="center">
                      <div class="form-group col-md-12" align="center">

                      <label for="selectView">Upload Vehicle View:</label>
                      <select name="selectView" id="selectView" >
                      <option value="0">None</option>
                      <option value="1">Front</option>
                      <option value="2">Driver\'s Side Exterior</option>
                      <option value="3">Driver\'s Side Interior (Front)</option>
                      <option value="4">Driver\'s Side Interior (Back)</option>
                      <option value="5">Passenger\'s Side Exterior</option>
                      <option value="6">Passenger\'s Side Interior (Front)</option>
                      <option value="7">Passenger\'s Side Interior (Back)</option>
                      <option value="8">Rear</option>
                      <option value="9">Rear Interior</option>
                      <option value="10">Misc</option></select>
                      <br>
                      <br>
                      File size must be less that .5 MB
                      <input class="btn btn-md btn-secondary" type="file" name="file"/><input class="btn btn-md btn-primary" type="submit" name="imgUploadNoImg" id="imgUploadNoImg" value="Update Vehicle Photo">

                      </div>
                      </div>
                      <br>';
                    }
                  }
                } //if not photograph is supplied show upload image section
                else {
                  echo "<div style=\"display: flex; justify-content: center;\"><img src='vehicle_img/default.png' align='center' style=\"width: auto; height: auto;\"></div>";

                  echo '<div class="container" align="center">
                  <div class="form-group col-md-12" align="center">

                  <label for="selectView">Upload Vehicle View:</label>
                  <select name="selectView" id="selectView" >
                  <option value="0">None</option>
                  <option value="1">Front</option>
                  <option value="2">Driver\'s Side Exterior</option>
                  <option value="3">Driver\'s Side Interior (Front)</option>
                  <option value="4">Driver\'s Side Interior (Back)</option>
                  <option value="5">Passenger\'s Side Exterior</option>
                  <option value="6">Passenger\'s Side Interior (Front)</option>
                  <option value="7">Passenger\'s Side Interior (Back)</option>
                  <option value="8">Rear</option>
                  <option value="9">Rear Interior</option>
                  <option value="10">Misc</option></select>
                  <br>
                  <br>
                  File size must be less that .5 MB
                  <input class="btn btn-md btn-secondary" type="file" name="file"/><input class="btn btn-md btn-primary" type="submit" name="imgUploadNoImg" id="imgUploadNoImg" value="Update Vehicle Photo">

                  </div>
                  </div>
                  <br>';

                }
                //end image display or upload section
                ?>

                <!-- Show Vehicle photos -->
                <h4>Vehicle Photos</h4>
                <br>
                <div class='form-row' style='text-align: left'>

                  <?php
                  while ($img = mysqli_fetch_assoc($resultRecallVehiclePhotos)) {

                    for ($i = 0; $i < count($img); $i++) {
                      if (($img['imgDetail'] = $i) == true) {

                      } else {
                        echo "<div class='form-group col-md-3'><a href='" . $img['img'] . "'><img alt='' width='250' height='170' src=" . $img['img'] . "></a></div>";
                        echo "";
                      }
                    }
                    /*if ($img['imgDetail'] == 1) {
                    echo "<div class='form-row' style='text-align: left'>
                    <div class='form-group col-lg-4'>
                    <td class='nth-child'><img src=" . $img['img'] . " style=\"width: 200px; height: 200px;\"  alt=''/></td><br>
                    <td>Front</td>
                    </div>
                    </div>";
                  } //driver's side photos 3 imgs contained in <div class='form-row' style='text-align: center'> closing tag in "4"
                  elseif ($img['imgDetail'] == 2) {
                  echo "<div class='form-row' style='text-align: left'>";

                  echo "<div class='form-group col-lg-4'>
                  <td class='nth-child'><img src=" . $img['img'] . " style=\"width: 200px; height: 200px;\"  alt=''/></td><br>
                  <td>1</td>
                  </div>";

                  echo "</div>";

                }   elseif ($img['imgDetail'] == 3) {

                if (($img['imgDetail'] = 3) == true){

                echo 'true';

              }else{echo "false";
            }
            echo "<div class='form-row' style='text-align: left'>";

            echo "<div class='form-group col-lg-4'>
            <td class='nth-child'><img src=" . $img['img'] . " style=\"width: 200px; height: 200px;\"  alt=''/></td><br>
            <td>2</td>
            </div>";

            echo "</div>";

          }
          elseif ($img['imgDetail'] == 5) {
          echo "<div class='form-row' style='text-align: left'>";

          echo "<div class='form-group col-lg-4'>
          <td class='nth-child'><img src=" . $img['img'] . " style=\"width: 200px; height: 200px;\"  alt=''/></td><br>
          <td>5</td>
          </div>";

          echo "</div>";

        }
        //closing td tag
        echo "</td>";*/
      }
      ?>
    </div>
    <br>
    <!-- Select Equipment installed -->
    <div class="form-row">
      <div class="form-group col-md-3" style="text-align: left">
        <label for="multiSelectEquipmentRemoved"><b>Installed Equipment</b></label><br>

        <?php
        for ($i = 0; $i < count($equipArray); $i++) {
          if (in_array($equipArray[$i], $recallEquipmentInstalled)) {
            echo '<label for="equipmentRemove"></label>
            <input style="alignment:left" type="checkbox" id="equipmentRemove[]" name="equipmentRemove[]" value="' . $equipArray[$i] . '">' . $equipArray[$i] . '<br>';
          }
        }
        ?>

      </div>
      <div>

        <input class="btn btn-md btn-outline-danger" type="submit" name="remove" id="remove"
        value="Remove Equipment" style="alignment: center">

      </div>

    </div>

    <!-- Select Equipment NOT installed -->
    <div class="form-row">
      <div class="form-group col-md-3" style="text-align: left">
        <b><label for="multiSelectEquipmentAddInstalled">Not Installed Equipment</label></b><br>


        <?php
        for ($i = 0; $i < count($equipArray); $i++) {

          if (!in_array($equipArray[$i], $recallEquipmentInstalled)) {
            echo '<label for="equipmentAdd[]"></label>
            <input style="alignment:left" type="checkbox" id="equipmentAdd[]" name="equipmentAdd[]" value="' . $equipArray[$i] . '"> ' . $equipArray[$i] . '<br>';
          }

        }
        ?>

      </div>
      <div>
        <input class="btn btn-md btn-outline-secondary" type="submit" name="add" id="add"
        value="Add Equipment" style="alignment: center">


      </div>
    </div>




  </form>
</div>
</div>

</body>
<?php } else {
  echo "<h3 style='text-align: center'>You do not have permisson to view this page</h3>";
} ?>

<script>

$(function () {
  $('#dim_driverName').show();
  $('#currentStatus').change(function () {
    if ($('#currentStatus').val() == 'Maintenance')  {
      $('#dim_driverName').hide();
    } else if ($('#currentStatus').val() == 'Stand-By')  {
      $('#dim_driverName').hide();
    }else{
      $('#dim_driverName').show();
    }
  });
});

$(function () {
  $('#dim_deadline').hide();
  $('#currentStatus').change(function () {
    if ($('#currentStatus').val() == 'Deadlined') {
      $('#dim_deadline').show();
    } else {
      $('#dim_deadline').hide();
    }
  });

});
</script>


<footer>
  <!-- indluces closing html tags for body and html-->

  <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
