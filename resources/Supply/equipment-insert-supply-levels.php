<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site
date_default_timezone_set('America/Los_Angeles');

$unitName = $_SESSION['unitName'];
$section = 'S4';
$count = 0;


if (isset($_POST['submit-insert-equipment-data'])) {

  $inputStockNumber = $mysqli->real_escape_string($_POST['inputNumber']);
  $inputItemName = $mysqli->real_escape_string($_POST['inputItemName']);
  $inputModelName = $mysqli->real_escape_string($_POST['inputModel']);
  $inputManufacturer = $mysqli->real_escape_string($_POST['inputManufacturer']);
  $inputDescription = $mysqli->real_escape_string($_POST['itemDescriptionField']);
  $fmt = new NumberFormatter( 'us_US', NumberFormatter::CURRENCY );
  $inputItemCost = $mysqli->real_escape_string($_POST['inputItemCost']);
  $inputItemCost = $fmt->formatCurrency($inputItemCost, 'USD');
  $inputDateReceived = $mysqli->real_escape_string($_POST['inputDateReceived']);
  $inputQuantity = $mysqli->real_escape_string($_POST['inputQuantity']);
  $inputQuantityType = $mysqli->real_escape_string($_POST['inputQuantityType']);
  $inputIssueType = $mysqli->real_escape_string($_POST['inputIssueType']);
  $inputInitialIssue = $mysqli->real_escape_string($_POST['inputInitialIssue']);

  echo $inputQuantity;

  echo "Select id from supply_receiving WHERE (itemName = '$inputItemName' AND stockNumber = '$inputStockNumber' AND modelName = '$inputModelName')";

  $resultsFindDupes = $mysqli->query("Select id, itemQuantity from supply_receiving WHERE (itemName = '$inputItemName' AND stockNumber = '$inputStockNumber' AND modelName = '$inputModelName') LIMIT 1");

while ($returnResults = $resultsFindDupes->fetch_array()) {

//  $returnID = $resultsFindDupes->fetch_array();
  $_SESSION['id'] = $returnResults[0];
    $_SESSION['returnQuantity'] = $returnResults[1];

  // code...
}
$_SESSION['quantity'] = $inputQuantity + $_SESSION['returnQuantity'];


    if ($resultsFindDupes->num_rows < 1) {

      $insertEquipmentInformation = "INSERT INTO supply_receiving (`id`, `unitName`, `itemName`, `itemDescription`, `itemCost`,
        `itemQuantity`, `quantityType`, `modelName`, `stockNumber`, `manufacturerName`, `dateReceived`,
        `issueType`, `initialIssue`) VALUES (id, '$unitName','$inputItemName', '$inputDescription', '$inputItemCost', '$inputQuantity', '$inputQuantityType', '$inputModelName', '$inputStockNumber', '$inputManufacturer', '$inputDateReceived', '$inputIssueType', '$inputInitialIssue')";

        $resultInputEquipmentInformation = $mysqli->query($insertEquipmentInformation) or die('Database Selection Failed' . mysqli_errno());


        echo $resultInputEquipmentInformation;
        if (!$resultInputEquipmentInformation) {

          $failuremsg = "Equipment Information Was Not Updated - Please try again.";
        } else {

          $successmsg = "Equipment Information Successfully Updated.";
        }
      }else{
        $failuremsg = "Information for $inputItemName already exist in the system. - Do you want to add to existing inventory.";




      }
    }


    if (isset($_POST['addToExisting'])) {

      // code...
      // find item id!

      $returnID =  $_SESSION['id'];


      $inputQuantity = $_SESSION['quantity'];

      echo $inputQuantity;
      $findID = "UPDATE supply_receiving SET itemQuantity = '$inputQuantity' WHERE id = '$returnID'";

      $updateFindID = $mysqli->query($findID);
      var_dump($updateFindID);
      echo "UPDATE `supply_receiving` SET itemQuantity = '$inputQuantity' WHERE id = '$returnID'";
      //$updateInventoryForItem = $mysqli->query($updateFindID);
      $count++;


      if(!$updateFindID){
        $failuremsg = "Quantity was <em>NOT</em> Updated.";

      }else{
        $successmsg = "Quantity was Successfully Updated.";
        header("refresh:1;url=equipment-view-supply-levels.php");

      }
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
                <h5 class="modal-title">Item Successfully Added into Inventory</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <?php if(isset($successmsg)){ ?><div class="alert alert-success" role="alert" style="text-align: center"> <?php echo $successmsg; ?> </div><?php }

                header("refresh:1;url=equipment-view-supply-levels.php");?>

                  <?php if(isset($failuremsg)){ ?><div class="alert alert-danger" role="alert" style="text-align: center"> <?php echo $failuremsg; ?> </div><?php ;
                    echo'<form class="" method="post">
                    <input class="btn btn-success col-md-4" type="submit" name="addToExisting" id="addToExisting" value="Add Equipment"></input>

                    <input  align="center" class="btn btn-danger col-md-6" type="submit" name="DoNotaddToExisting" id="DoNotaddToExisting" value="No"></input>
                    </form>';

                    $count++;

                  } ?>
                  <p style="text-align: center"></p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- success section -->
    <div class="bs-example">
      <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Logging In</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>You will be rerouted to the Equipment page.</p>
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
