
<!DOCTYPE html>
<html>
<title>ESS</title>

<head>
    <h3 align="center">ESS</h3>
    <br>
    <?php include('navigation.html'); ?>


</head>
<body>

<br>


<div class="member-update">
    <div class="container">

        <div class="alert alert-info" role="alert"> <b>Only use this page to insert information not added through <a href="insert-alarm-report.php">Initiate 340 Page at time of event (+/- 15 Mins)</a></b> </div>
        <form class="member-update" method="post">

            <?php if (isset($successmsg)) { ?>
                <div class="alert alert-success" role="alert"> <?php echo $successmsg; ?> </div><?php } ?>
            <?php if (isset($failuremsg)){ ?>
            <div class="alert alert-danger"
            " role="alert"> <?php echo $failuremsg; ?>
    </div><?php } ?>

    <?php if (isset($emailFailure)) { ?>
        <div class="alert alert-danger" role="alert"> <?php echo $emailFailure; ?> </div><?php } ?>
    <?php if (isset($emailSuccess)){ ?>
    <div class="alert alert-success"
    " role="alert"> <?php echo $emailSuccess; ?> </div><?php } ?>
<?php if (isset($notifyESSContractor)) { ?>
    <div class="alert alert-primary"  " role="alert"> <?php echo $notifyESSContractor; ?> </div><?php } ?>


<?php if (isset($workorderAlreadyCreated)) { ?>
    <div class="alert alert-success"
    " role="alert"> <?php echo $workorderAlreadyCreated; ?>
    </div><?php } ?>

<h2 class="">Insert Manual Alarm Data</h2>

<div class="form-row">
    <div class="form-group col-md-3">
        <label for="inputDate">Date of Alarm</label>
        <input class="form-control" id="inputDate" name="inputDate" title="inputDate" placeholder="Format Date YYYY-MM-DD" required autofocus >
    </div>
    <div class="form-group col-md-3">
        <label for="inputTime">Date of Alarm</label>
        <input class="form-control" id="inputTime" name="inputTime" title="inputTime" placeholder="Format hour - 08:00 or 15:45" required >
    </div>

</div>


<div class="form-row">
    <div class="form-group col-md-3">
        <label for="inputWorkOrderType">Alarm Sensor Type</label>
        <select class="form-control" id="inputWorkOrderType" name="inputWorkOrderType" title="inputWorkOrderType"
                required autofocus>
            <option value="">Type</option>
            <option value="340">340</option>
            <option value="781A">781A</option>

        </select>
    </div>
</div>

<!-- date for the form will be gathered from the server time and location ie automatic. -->
<div class="form-row">

    <!--Replaced with Opensource Weather Data to pull from location. See $weatherArray above.

    <div class="form-group col-md-3">
         <label for="inputWeather">Weather Condition</label>
         <select class="form-control" id="inputWeather" name="inputWeather" title="inputWeather" required>
             <option value="">Type</option>
             <option value="Sunny">Sunny</option>
             <option value="Rain">Rain</option>
             <option value="Wind">Wind</option>
             <option value="Clear">Clear</option>
             <option value="Snow">Snow</option>

         </select>
     </div>-->


   <!-- <div class="form-group col-md-3">
        <label for="inputSensorKind">Sensor Type</label>
        <select class="form-control" id="inputSensorKind" name="inputSensorKind" title="inputSensorKind" required>
            <option value="">Type</option>
            <option value="BMS">BMS</option>
            <option value="Duress">Duress</option>
            <option value="FOSS">FOSS</option>
            <option value="PIR">PIR</option>
            <option value="Tamper">Tamper</option>
            <option value="Other">Other</option>
        </select>
    </div>-->

    <script>


        var fossZones = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
            "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];
        //var insideOutside= ["exterior"];

        var interior = ["BMS", "PIR", "TAMPER", "Video", "Duress", "Other"];

        var exterior = ["FOSS", "Duress", "PIRAMID", "TAMPER", "Video", "Other"];


        var cameraZones = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
            "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59",
            "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "77", "74", "75", "76", "78", "79", "80",
            "81", "82", "83", "88", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "99", "96", "97", "98", "99"];


        var something = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "38", "39", "40",
            "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];

        //var piramid = ["Left", "Right", "Center"];
        var fdbListing = ["FDB 1", "FDB 2", "FDB 3", "FDB 4", "FDB 5", "FDB 6", "FDB 7", "FDB 8", "FDB 9", "FDB 10", "FDB 11", "FDB 12", "FDB 13", "FDB 14", "FDB 15", "FDB 16", "FDB 17", "FDB 18", "FDB 19", "FDB 20",
            "FDB 21", "FDB 22", "FDB 23", "FDB 24", "FDB 25", "FDB 26", "FDB 27", "FDB 28", "FDB 29", "FDB 30", "FDB 31", "FDB 32", "FDB 33", "FDB 34", "FDB 35", "FDB 36", "FDB 38", "FDB 39", "FDB 40",];

        var changeCat1 = function changeCat1(firstList) {
            var newSel = document.getElementById("inputSensorKind");
            //if you want to remove this default option use newSel.innerHTML=""
            newSel.innerHTML = "<option value=\"\">Select</option>"; // to reset the second list everytime
            var opt;

            //test according to the selected value
            switch (firstList.options[firstList.selectedIndex].value) {
                case "Interior":
                    for (var i = 0; len =interior.length, i < len; i++) {
                        opt = document.createElement("option");
                        opt.value = interior[i];
                        opt.text = interior[i];
                        newSel.appendChild(opt);
                    }
                    break;
                case "Exterior":
                    for (var i = 0; len = exterior.length, i < len; i++) {
                        opt = document.createElement("option");
                        opt.value = exterior[i];
                        opt.text = exterior[i];
                        newSel.appendChild(opt);
                    }
                    break;

            }

        };

        var changeCat2 = function changeCat1(secondList) {
            var newSel = document.getElementById("fossZone");
            //if you want to remove this default option use newSel.innerHTML=""
            newSel.innerHTML = "<option value=\"\">Select</option>"; // to reset the second list everytime
            var opt;

            //test according to the selected value
            switch (secondList.options[secondList.selectedIndex].value) {
                case "FOSS":
                    for (var i = 0; len = fossZones.length, i < len; i++) {
                        opt = document.createElement("option");
                        opt.value = fossZones[i];
                        opt.text = fossZones[i];
                        newSel.appendChild(opt);
                    }
                    break;
                case "Video":
                    for (var i = 0; len = cameraZones.length, i < len; i++) {
                        opt = document.createElement("option");
                        opt.value = cameraZones[i];
                        opt.text = cameraZones[i];
                        newSel.appendChild(opt);
                    }
                    break;

                case "FDB":
                    for (var i = 0; len = fdbListing.length, i < len; i++) {
                        opt = document.createElement("option");
                        opt.value = fdbListing[i];
                        opt.text = fdbListing[i];
                        newSel.appendChild(opt);
                    }
                    break;
            }

        }



    </script>

    <div class="form-group col-md-3">
        <label for="inputLocationSelect">Location Type</label>
        <select class="form-control" id="inputLocationSelect" name="inputLocationSelect" title="locationType" onchange="changeCat1(this)" required>
            <option value="">Type</option>
            <option value="Interior">Interior</option>
            <option value="Exterior">Exterior</option>
            <option value="Other">Other</option>

        </select>

    </div>

    <div class="form-group col-md-3">
        <label for="inputSensorKind">Sensor Type</label>
        <select class="form-control" id="inputSensorKind" name="inputSensorKind" title="inputSensorKind" onchange="changeCat2(this)" required>
            <option value="">Select</option>
        </select>
    </div>


    <div class="form-group col-md-3">
        <label for="fossZone">Number Sector/Camera</label>
        <select name="fossZone" id="fossZone" class="form-control" >

            <option value="">Select</option>
        </select>
    </div>


    <div class="form-group col-md-3">
        <label for="inputFindings">Alarm Activation Cause</label>
        <select class="form-control" id="inputFindings" name="inputFindings" title="inputFindings" required>
            <option value="">Type</option>
            <option value="False">False</option>
            <option value="Nuisance">Nuisance</option>
            <option value="Other">Other</option>
        </select>
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="inputAccountName">Account Number</label>
        <input type="text" name="inputAccountName" id="inputAccountName" class="form-control" value=""
               placeholder="Acct Number" required>
    </div>

    <div class="form-group col-md-3">
        <label for="inputBuildingName">Building Number</label>
        <input type="text" name="inputBuildingName" id="inputBuildingName" class="form-control" value=""
               placeholder="Building Number" required>
    </div>

    <div class="form-group col-md-3">
        <label for="inputRoomNumber">Room Number</label>
        <input type="text" name="inputRoomNumber" id="inputRoomNumber" class="form-control" value=""
               placeholder="Room Number" required>
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="inputDutySectionSelect">Duty Section</label>
        <select class="form-control" id="inputDutySectionSelect" name="inputDutySectionSelect" title="dutySection"
                required>
            <option value="NULL">None</option>
            <option value="S1">S1</option>
            <option value="S2">S2</option>
            <option value="S3">S3</option>
            <option value="S3OA">S3OA</option>
            <option value="S3OB">S3OB</option>
            <option value="S3OC">S3OC</option>
            <option value="S3OD">S3OD</option>
            <option value="S3K">S3OK</option>
            <option value="S3T">S3T</option>
            <option value="S4">S4</option>
            <option value="S5">S5</option>
            <option value="SFMQ">SFMQ</option>
            <option value="CC">CC</option>
            <option value="CCF">CCF</option>
            <option value="SFM">SFM</option>
        </select>

    </div>
</div>

<div class="form-row">

    <div class="form-group col-md-9">
        <label for="inputDescriptionField">Description</label>
        <textarea rows="3" cols="50" name="inputDescriptionField" id="inputDescriptionField" class="form-control"
                  placeholder="Description"></textarea>

    </div>


    <!-- discovered by-->


    <br>

    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Add Alarm Data</button>
    <br>

    </form>
</div>
</div>


</body>

<!-- indluces closing html tags for body and html-->
<!-- place below last </div> tag -- indluces closing html tags for body and html-->
<?php
    include __DIR__.'/../../footer.php';?>
