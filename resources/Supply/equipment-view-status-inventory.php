<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';


$recallInventoryAll = "SELECT * FROM supply_receiving WHERE unitName = '$unitName' ORDER BY id ASC";
$resultsRecallInventoryAll = $mysqli->query($recallInventoryAll);



?>

<div class="form-group">
  <h4>Inventory Information</h4>
</div>

<?php
if ($resultsRecallInventoryAll->num_rows > 0) {
  echo "<table id='inventory' class='table table-bordered table-hover'>
          <thead>
            <tr>
              <th>Item Name</th>
              <th>Model Name</th>
              <th>Description</th>
              <th>Number on Hand</th>
              <th>Quantity Type</th>
              <th>Manufacturer</th>
              <th>Issue Type</th>
              <th>Initial Issue</th>
            </tr>
          </thead>";

  while (($recallInventory = $resultsRecallInventoryAll->fetch_assoc())) {

    echo "<tr class='nth-child' align='center'>
            <td class='nth-child'>" . $recallInventory['itemName'] . "</td>
            <td class='nth-child'>" . $recallInventory['modelName'] . "</td>
            <td class='nth-child'>" . $recallInventory['itemDescription'] . "</td>
            <td class='nth-child'>" . $recallInventory['itemQuantity'] . "</td>
            <td class='nth-child'>" . ucwords($recallInventory['quantityType']) . "</td>
            <td class='nth-child'>" . ucwords($recallInventory['manufacturerName']) . "</td>
              <td class='nth-child'>" . ucwords($recallInventory['initialIssue']) . "</td>
            <td class='nth-child'>" . ucwords($recallInventory['issueType']) . "</td>";

  }




} else {
  echo "<p align='center'>No Equipment inventory Information</p>";
}
//need </table> to align table in proper area on page (above footer)
echo "</table>";
