<?php

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="UTF-8">
  <title>Import Actions</title>
</head>
<body>
  <h1 style=text-align:center>Import Actions</h1>
  <p style=text-align:center>Please select from the dropdown menu the item you would like to import.</p>
  <!--/../UnitTraining/import/types/importActions.php -->
  <form action="importActions.php" method="POST" enctype="multipart/form-data" align="center">

    <div class="form-row">
      <div style="text-align:center; margin: auto"  class="form-group col-md-4">
        <label for="unitNameDropDown">Item to import</label>
        <select onchange="imgChange(this)" class="form-control" id="importType" name="importType" required >


          <option value="">None</option>
          <option value="appointment">Appointments</option>
          <option value="cbt">CBT Listing</option>
          <option value="decs">Dec Status</option>
          <option value="epr">EPR Status</option>
          <option value="gtc">Government Travel Card</option>
          <option value="ioaDocs">IOA Documents</option>
          <option value="leaveAudit">Leave Audit</option>
          <option value="pimr">PIMR</option>
          <option value="useOrLose">Use or Lose Balance</option>
          <option value="sponsor">Sponsorship</option>

        </select>
      </div>

    </div><br>

    <div style="text-align:center; margin: auto">



      <!-- File Button -->
      <div class="form-group">
        <label class="exampleInputFile">Select File</label>
        <input type="file" name="file" id="file" class="input-large">
        <br>



        <!-- Button -->
        <br>
        <label for="uploadImport"></label>

        <div class="form-group">
          <button type="submit" id="submit" name="uploadImport" class="btn btn-primary button-loading" onclick="confirmUpload(this)"; data-loading-text="Loading...">Import Data</button>
        </div>

      </div>

      <!--<input class="btn btn-md btn-primary" type="submit" name="uploadImport" id="uploadImport" value="Upload File">-->


      <div id="importImgDiv">
        <p style="align:center">Columns need to match below to ensure successfull upload. If column is unknown, leave empty...i.e. id </p>
        <img id="importImg">
      </div>

    </div>
  </form>



</body>
</html>
