<div class="form-group">
  <div class="row">
    <div class="col-sm-12">
      <label for="selectSection">Duty Section</label>
      <select class="form-control" id="selectSection" name="selectSection" title="selectSection" required>
        <option value="">Select Section</option>
        <?php

        //user FindUser Class to locate logged in memberes unit name for unit selection.
        $findSection = $mysqli->query("SELECT `sectionName` from UnitSections where unitName = '$findUser->unitName'");

        $resultsFindSectionsAssoc = $findSection->fetch_assoc();
        $sectionsArray = array();
        $sectionsArray = explode(',', $resultsFindSectionsAssoc['sectionName']);

        //Section Select
        for ($i = 0; $i < count($sectionsArray); $i++) {
          echo '<label for="selectSection[]"></label>

          <option value="' . $sectionsArray[$i] . '"<br>' . $sectionsArray[$i] . '</option><br>';

        }
        ?>
      </select>
    </div>
  </div>
</div>
