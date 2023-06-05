<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
        <label for="selectPosition">Position Selection</label>
        <select class="form-control" id="selectPosition" name="selectPosition" title="selectPosition" required>
            <option value="">Select Position</option>
            <?php
            $findPosition = $mysqli->query("SELECT `positions` from sfmq_positions where unitName = '$unitName'");

            $resultsFindPositionsAssoc = $findPosition->fetch_assoc();
            $positionsArray = array();
            $positionsArray = explode(',', $resultsFindPositionsAssoc['positions']);

            //Position Select
            for ($i = 0; $i < count($positionsArray); $i++) {
                echo '<label for="selectPosition[]"></label>
                <option value="' . $positionsArray[$i] . '"<br>' . $positionsArray[$i] . '</option><br>';
            }
            ?>
        </select>
    </div>
</div>
</div>
