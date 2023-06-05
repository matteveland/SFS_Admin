<div class="form-group" data-select2-id="29">
  <label>Unit</label>
  <select class="form-control select2bs4 select2-hidden-accessible" id="unitNameDropDown" name="unitNameDropDown" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
    <option>Select Unit</option>
    <?php
    $recallUnits = $mysqli->query("SELECT unitName FROM UnitSections WHERE unitName != 'Master Listing' ORDER BY unitName ASC");

    foreach ($recallUnits as $units) {
      echo "<option value=\"" . $units['unitName'] . "\"";
      echo ">" . $units['unitName'] . "</option>\n";
    }



    ?>

  </select>
</div>
