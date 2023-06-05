<?php


require_once __DIR__.'/../dbconfig/connect.php';
include __DIR__.'/../navigation.php';
include ('/var/services/web/sfs/Application/data.env');

parse_str($_SERVER['QUERY_STRING'], $query);

$unitName = $_SESSION['unitName'];

$last = mysqli_real_escape_string($connection, $query['last']);
$first = mysqli_real_escape_string($connection, $query['first']);
$middle = mysqli_real_escape_string($connection, $query['middle']);
$rank = mysqli_real_escape_string($connection, $query['rank']);


    //$query = mysqli_real_escape_string($connection, $_GET['query']);
    // gets value sent over search form

    $sqlRank = "SELECT members.rank FROM members WHERE members.rank = '$rank' AND members.lastName = '$last' AND members.firstName = ".$first."";

    $result2 = mysqli_query($connection, $sqlRank);

    while ($row = mysqli_fetch_assoc( ($result2))) {

        $recallRank = $row['rank'];

    }

    $getMember = "SELECT members.* From members
                          WHERE members.lastName = '$last' AND members.firstName = '$first' AND members.rank = '$rank'";

    $result2 = mysqli_query($connection, $getMember);

    while ($row = mysqli_fetch_assoc( ($result2))) {
        $recalldodId = $row['dodId'];
        $fName = $row['firstName'];
        $mName = $row['middleName'];
        $lName = $row['lastName'];
        $recallrank = $row['rank'];
        $recalldutySection = $row['dutySection'];
        $recallafsc = $row['afsc'];


    }

    $getSFMQ = "SELECT * From sfmq
                          WHERE sfmq.lastName = '$last' AND sfmq.firstName = '$first' AND sfmq.rank = '$rank'";

    $resultSFMQ = mysqli_query($connection, $getSFMQ);

    while ($row = mysqli_fetch_assoc( ($resultSFMQ))) {

        $recallDutyPostion = $row['dutyQualPos'];
        $recallPrimCertDate = $row['primCertDate'];
        $recallReCertDate = $row['reCertDate'];
        $recallPhaseIIStart = $row['phase2Start'];
        $recallPhaseIIEnd = $row['phase2End'];
        $recallNewDutyPostion = $row['newDutyQual'];
    }

    $phaseIIStart = strtotime('Y-m-d', $recallPhaseIIStart);
?>
<html>
<head>
    <title>Search Results</title>
</head>
<body>

<?php

    echo "<h1 align='center'>Search Results for ";?>

    <?php echo" $rank $last, $first</h1>";

    $sqlImg = "SELECT * FROM members WHERE (lastName = '$last' AND firstName = '$first' AND rank = '$rank') AND imageDetail = '1' AND unitName = '$unitName'";

    $resultImg = mysqli_query($connection, $sqlImg);

    if(mysqli_num_rows($resultImg) > 0) {

        while ($row = mysqli_fetch_assoc($resultImg)) {

            $id = $row['dodId'];

            $sqlImgPath = "SELECT image FROM members WHERE (lastName = '$last' AND firstName = '$first' AND rank = '$rank') AND imageDetail = '1' AND unitName = '$unitName'";

            $resultSQLImgPath = mysqli_query($connection, $sqlImgPath);

            while ($row = mysqli_fetch_assoc($resultSQLImgPath)) {


                $imagePath = $row['image'];
                $imagePathNew = "/UnitTraining/adminpages/$imagePath";

                echo "<div style=\"display: flex; justify-content: center;\">
                           <img src=" . $imagePathNew . " style=\"width: 200px; height: 200px;\" />
                           </div>
                           <br>";


            }

        }


        //echo "<img src='uploads/profile"."$last.$first.$recalldodId.'>";
        /* else {
             echo "false";
             echo "<img src='./uploads/default.jpeg'>";

             echo '
    <div class="container">
                         <div class="form-group col-md-3" align="center">
                             <form method="POST" enctype="multipart/form-data">
                                 Select image to upload:
                                 <input class="btn btn-md btn-secondary" type="file" name="file"/>
                             <br>
                                 <br>
                                 <!--<input class="btn btn-md btn-primary" type="submit" name="imgUpload" id="imgUpload" value="Update Member Photo">-->


                             </form>
                             </div>';

         }*/



    }else{
        echo "<div style=\"display: flex; justify-content: center;\"><img src='/UnitTraining/adminpages/uploads/default.jpeg' align='center' style=\"width: 200px; height: 200px;\"></div>";;

    }


    //$query = mysqli_real_escape_string($connection, $query);
    // makes sure nobody uses SQL injection

    $sql = "SELECT * FROM `members` WHERE members.lastName = '$last' AND members.firstName = '$first' AND members.rank = '$rank'";

    $raw_results = mysqli_query($connection, $sql) or die(mysqli_error($connection));


    if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following

        while($results = mysqli_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop

            //echo "<p>".$results['lastname'].", ".$results['firstname']."</p>";
            // posts results gotten from database(title and text) you can also show id ($results['id'])

            $queryRank = $results['rank'];

            $queryLastName = $results['rank'];
            $queryFirstName = htmlentities($results['lastName'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $queryFirstName = htmlentities($results['lastName'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $queryFirstName = htmlentities($results['lastName'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

            echo '<br>
            <div align="center"> <a class="btn btn-md btn-primary" href="/UnitTraining/adminpages/updateMember.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '">Update Member</a>
    
            </div>
            <br>';

            /* '.$results['firstname'].'*/
            //echo '<a href="dynamic_page.php?id=$result['lastname']'>$result[];
        }

    }
    else{ // if there is no matching rows do following
        echo "No results";
    }


    ?>

    <?php


    // SUpervisor Query

    $sqlSupList = "SELECT *
    FROM members m
    INNER JOIN supList s
    ON  (m.lastName = s.lastName AND m.firstName = s.firstName AND m.middleName = s.middleName)
    WHERE s.lastName = '$last' AND s.firstName = '$first' AND s.rank = '$rank' AND supLastName <> '' 
    ";


    $resultSupList = mysqli_query($connection, $sqlSupList);

    if (mysqli_num_rows($resultSupList)) {
    //($row = mysqli_fetch_array($result) > 1)

        // output data of each row
        echo "<h3 align='center'>Supervisor Information</h3>";
        echo"<table>";
            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Rank</th>");
        print("<th>Last Name</th>");
        print("<th>First Name</th>");
        print("<th>Date Supervision Began</th>");
        print("<th>Feedback Due</th>");


        while($row = mysqli_fetch_assoc($resultSupList)) {

            // echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngtype"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";
            echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $row["superRank"]. "</td>
                                    <td>" . $row["supLastName"]. "</td>
                                    <td>" . $row["supFirstName"]. "</td>
                                    <td>" . $row["supDateBegin"] . "</td>
                                    <td>" . $row["feedbackCompleted"] . "</td>
                                    </tr>
                    </tr>";
        }
    } else {
        echo "<h3 align='center'>Supervisor Information</h3>";
        echo "<p align='center'>Member has no supervisor assigned</p>";
    }
    echo "</table><br>";



    $sqlLeave = "select *
    from members m
    INNER JOIN appointmentRoster a
    ON m.lastName = a.lastName AND m.firstName = a.firstName
    where ((m.lastName = '$last' AND m.firstName = '$first' AND m.rank = '$rank') OR (m.dodId = '$recalldodId'))
    AND (a.title = 'Leave' AND (a.enddate BETWEEN now() - INTERVAL 5 DAY AND now() + INTERVAL 45 DAY ))
    order by a.endDate ASC
    ";
    /*SELECT *
    FROM members m
    INNER JOIN appointmentRoster a
    ON (m.lastName = a.lastName AND m.firstName = a.firstName AND m.middleName = a.middleName)
    where  (m.lastName = '$last' AND m.firstName = '$first' AND m.rank = '$rank') AND  a.title = 'Leave' AND a.enddate BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 30 DAY
    order by a.startdate
    "select *
    from members m
    INNER JOIN appointmentRoster a
    ON m.lastName = a.lastName AND m.firstName = a.firstName
    where (m.dutySection = 'S1' or m.dutySection = 'SFM' OR m.dutySection = 'CCF' or m.dutySection = 'CC' OR m.dutySection = 'IGI') AND a.title = 'Leave' AND (a.enddate BETWEEN now() - INTERVAL 5 DAY AND now() + INTERVAL 45 DAY )
    order by a.endDate ASC";
    */

    $resultLeave = mysqli_query($connection, $sqlLeave);


    if (mysqli_num_rows($resultLeave) > 0) {
    //($row = mysqli_fetch_array($resultappointment) > 1)

        // output data of each row
        echo "<h3 align='center'>Leave</h3>";
        echo"<table>";
            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Start Date</th>");
        print("<th>End Date</th>");
        print("<th>Location City</th>");
        print("<th>Location State</th>");
        echo("<th>Added By</th>");
        echo("<th>Date Added</th>");
        echo("<th>Override</th>");

        while($row = mysqli_fetch_assoc($resultLeave)) {


            echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $row["startdate"]. "</td>
                                    <td>" . $row["enddate"]. "</td>
                                    <td>" . $row["location"]. "</td>
                                    <td>" . $row["installation"] . "</td>
                                    <td>" . $row["addedBy"] . "</td>
                                    <td>" . $row["dateAdded"] . "</td>
                                    <td>" . $row["overRide"] . "</td>
                                    </tr>
                    </tr>";
        }
    } else {
        echo "<h3 align='center'>Leave</h3>";
        echo "<p align='center'>Member has no leave scheduled</p>";
    }


    echo "</table><br>";











    // appointment query
    /*$sqlappointment = "SELECT * FROM members m
    INNER JOIN appointmentRoster a
    ON m.lastName = a.lastName AND m.firstName = a.firstName AND m.middleName = a.middleName and m.dodId = a.dodId
    WHERE a.dodId = '$recalldodId' AND a.lastName = m.lastName
    ";*/

    $sqlappointment = "SELECT *
    FROM members m 
    INNER JOIN appointmentRoster a 
    ON (m.lastName = a.lastName AND m.firstName = a.firstName)
    where (m.lastName = '$last' AND m.firstName = '$first' AND m.rank = '$rank') AND a.startdate BETWEEN now() - INTERVAL 1 DAY AND now() + INTERVAL 30 DAY
    AND NOT a.title = 'Leave'
    order by a.startdate
    ";


    $resultappointment = mysqli_query($connection, $sqlappointment);


    if (mysqli_num_rows($resultappointment) > 0) {
    //($row = mysqli_fetch_array($resultappointment) > 1)

        // output data of each row
        echo "<h3 align='center'>Appointments</h3>";
        echo"<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Last Name</th>");
        print("<th>First Name</th>");
        print("<th>Type</th>");
        print("<th>Date</th>");
        print("<th>Time</th>");
        print("<th>Installation</th>");
        print("<th>Location</th>");
        print("<th>Self Made</th>");


        while($row = mysqli_fetch_assoc($resultappointment)) {


            //list($startDate, $startTime) = explode('T', $row['startdate']);
            //list($endDate, $endTime) = explode('T', $row['enddate']);

            // $array = explode('-', $str, 2);

            // echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngtype"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";

            echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $row["lastName"]. "</td>
                                    <td>" . $row["firstName"]. "</td>
                                    <td>" . $row["title"]. "</td>
                                    <td>". $row["startdate"] ." </td>
                                    <td>" . $row["appointmentTime"]. "</td>
                                    <td>" . $row["installation"]. "</td>
                                    <td>" . $row["location"] . "</td>
                                    <td>" . $row["selfMade"] . "</td>
                                    </tr>
                                    </tr>
                    </tr>";
        }
    } else {
        echo "<h3 align='center'>Appointments</h3>";
        echo "<p align='center'>Member has no appointments scheduled</p>";
    }


    echo "</table>";


    // arming query

    $sqlArming = "SELECT *
    FROM members m
    INNER JOIN armingRoster a
    ON m.lastName = a.lastName AND m.firstName = a.firstName
    WHERE a.lastName = '$last' AND a.firstName = '$first' AND a.rank = '$rank' AND ((a.m4Qual <> '') OR (a.m9Qual <> '') OR (a.baton <> '') OR (a.useOfForce <> '') OR (a.lat <> '') OR (a.smcFired <> '') OR (a.m203Exp <> '') OR (a.m249Exp <> '') OR (a.m240Exp <> '') OR (a.m870Exp <> '') OR (a.taser <> ''))
    ";


    $resultArming = mysqli_query($connection, $sqlArming);

    $now = date('Y-m-d');
    $now30 = date('Y-m-d', strtotime("$now + 30 days"));
    $now60 = date('Y-m-d', strtotime("$now + 60 days"));

    /*
    $sqlDutySection = "SELECT members.*
    FROM members
    WHERE members.dutysection = 's3oa'
    ";*/

    /*$sqlDutySection = "select members.dutySection
    from members

    WHERE members.dutySection = 'S3OC'";*/


    $resultArming = mysqli_query($connection, $sqlArming);

    $now = date('Y-m-d');
    $now30 = date('Y-m-d', strtotime("$now + 30 days"));
    $now60 = date('Y-m-d', strtotime("$now + 60 days"));


    if (mysqli_num_rows($resultArming) > 0) {
    //($row = mysqli_fetch_array($result) > 1)
        echo "<h3 align='center'>Firing Status</h3>";
        echo"<table>";
        echo("<table class='table' border = \"1\" align='center' style='width:auto' >");
        print("<tr>");

        print("<th>Baton</th>");
        print("<th>Use of Force</th>");
        print("<th>Form 2760</th>");
        print("<th>Taser</th>");
        print("<th>M4 Qaul</th>");
        print("<th>M4 Expriry</th>");
        print("<th>M9 Qual</th>");
        print("<th>M9 Expriry</th>");
        print("<th>SMC Fired</th>");
        print("<th>SMC Expriry</th>");
        print("<th>203 Expriry</th>");
        print("<th>249 Expriry</th>");
        print("<th>240 Expriry</th>");
        print("<th>870 Expriry</th>");

        while($row = mysqli_fetch_assoc($resultArming)) {

            // echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngtype"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";

            echo "<tr class='nth-child'>";
            //----------------------------------------------------------------------------------------//

            $batonDate =  $row["baton"];
            $batonDate = date('Y-m-d', strtotime("$batonDate + 365 days"));

            if (($batonDate) < ($now30)){
                $color='red';
            }
            elseif (($batonDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td class='nth-child' style='color:$color'>"; if ($row["baton"]){
                echo $batonDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//

            $useOfForceDate =  $row["useOfForce"];
            $useOfForceDate = date('Y-m-d', strtotime("$useOfForceDate + 365 days"));

            if (($useOfForceDate) < ($now30)){
                $color='red';
            }
            elseif (($useOfForceDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["useOfForce"]){
                echo $useOfForceDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//

            $latDate =  $row["lat"];
            $latDate = date('Y-m-d', strtotime("$latDate + 365 days"));

            if (($latDate) < ($now30)){
                $color='red';
            }
            elseif (($latDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["lat"]){
                echo $latDate;
            }else echo " ";
            echo "</td>";

            //----------------------------------------------------------------------------------------//

            $taserDate =  $row["taser"];
            $taserDate = date('Y-m-d', strtotime("$taserDate + 365 days"));

            if (($taserDate) < $now30){
                $color='red';
            }
            elseif ((!$taserDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'>"; if ($row["taser"]){
                echo $taserDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $m4QualDate =  $row["m4Qual"];
            $m4QualDate = date('Y-m-d', strtotime("$m4QualDate + 365 days"));


            if (($m4QualDate) < $now30){
                $color='red';
            }
            elseif (($m4QualDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'>"; if ($row["m4Qual"]){
                echo $m4QualDate;
            }else echo "";
            echo "</td>";


            //----------------------------------------------------------------------------------------//
            $m4ExpDate =  $row["m4Exp"];
            $m4ExpDate = date('Y-m-d', strtotime("$m4ExpDate + 547 days"));

            if (($m4ExpDate) < ($now30)){
                $color='red';
            }
            elseif (($m4ExpDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'>"; if ($row["m4Exp"]){
                echo $m4ExpDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $m9QualDate =  $row["m9Qual"];
            $m9QualDate = date('Y-m-d', strtotime("$m9QualDate + 365 days"));

            if (($m9QualDate) < ($now30)){
                $color='red';
            }
            elseif (($m9QualDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["m9Qual"]){
                echo $m9QualDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $m9ExpDate =  $row["m9Exp"];
            $m9ExpDate = date('Y-m-d', strtotime("$m9ExpDate + 365 days"));

            if (($m9ExpDate) < ($now30)){
                $color='red';
            }
            elseif (($m9ExpDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["m9Exp"]){
                echo $m9ExpDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $smcFiredDate =  $row["smcFired"];
            $smcFiredDate = date('Y-m-d', strtotime("$smcFiredDate + 365 days"));

            if (($smcFiredDate) < ($now30)){
                $color='red';
            }
            elseif (($smcFiredDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'>"; if ($row["smcFired"]){
                echo $smcFiredDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $smcDue =  $row["smcDue"];
            $smcDue = date('Y-m-d', strtotime("$smcDue + 365 days"));

            if (($smcDue) < ($now30)){
                $color='red';
            }
            elseif (($smcDue) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["smcDue"]){
                echo $smcDue;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $m203ExpDate =  $row["m203Exp"];
            $m203ExpDate = date('Y-m-d', strtotime("$m203ExpDate + 365 days"));

            if (($m203ExpDate) < ($now30)){
                $color='red';
            }
            elseif (($m203ExpDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["m203Exp"]){
                echo $m203ExpDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $m249ExpDate =  $row["m249Exp"];
            $m249ExpDate = date('Y-m-d', strtotime("$m249ExpDate + 365 days"));

            if (($m249ExpDate) < ($now30)){
                $color='red';
            }
            elseif (($m249ExpDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["m249Exp"]){
                echo $m249ExpDate;
            }else echo " ";
            echo "</td>";
            //----------------------------------------------------------------------------------------//
            $m240ExpDate =  $row["m240Exp"];
            $m240ExpDate = date('Y-m-d', strtotime("$m240ExpDate + 365 days"));

            if (($m240ExpDate) < ($now30)){
                $color='red';
            }
            elseif (($m240ExpDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["m240Exp"]){
                echo $m240ExpDate;
            }else echo " ";
            echo "</td>";


            //----------------------------------------------------------------------------------------//
            $m870ExpDate =  $row["m870Exp"];
            $m870ExpDate = date('Y-m-d', strtotime("$m870ExpDate + 365 days"));

            if (($m870ExpDate) < ($now30)){
                $color='red';
            }
            elseif (($m870ExpDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }
            echo    "<td style='color:$color'>"; if ($row["m870Exp"]){
                echo $m870ExpDate;
            }else echo " ";
            echo "</td>";

            echo "</td>
    
    </tr>";
        }



    }else {
        echo "<br>";
        echo "<h3 align='center'>Firing Status</h3>";
        echo "<p align='center'>No Firing Due</p>";
    }
    echo "</table>";


    //CBT List Query
$sqlCBTList = "SELECT *
    FROM members
    INNER JOIN cbtList799
    ON cbtList799.lastName = members.lastName AND cbtList799.firstName = members.firstName
    WHERE members.lastName = '$last' AND members.firstName = '$first' AND members.rank = '$rank'
    ";

    $resultcbt = mysqli_query($connection, $sqlCBTList);


    if (mysqli_num_rows($resultcbt) > 0) {
    //($row = mysqli_fetch_array($result) > 1)

    // output data of each row
        echo "<h3 align='center'>ALDS Training</h3>";
        echo "<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");

        print("<th>DOD Combat Trafficking (Annual)<br>");        // echo ( 10 / ($row_cntResultCountSectionTrafficking / $row_cnt )); echo "</th>";
        print("<th>Cyber Awareness (Annual)</th>");
        print("<th>Force Protection (Annual)</th>");
        print("<th>Green DOT Current (Annual)</th>");
        print("<th>Green DOT Next (Annual)</th>");
        print("<th>CBRN (18 Month)</th>");
        print("<th>CBRN Pretest (18 Month)</th>");
        print("<th>No FEAR Act (Biannual)</th>");
        print("<th>AF CIED (Triannual)</th>");
        print("<th>AF CIED Old (Triannual)</th>");
        print("<th>Religious Freedoms</th>");
        print("<th>SABC (Triannual)</th>");
        print("<th>SABC Hands-On (Triannual)</th>");
        print("<th>LOAC (Triannual)</th>");
        print("<th>EMS (Triannual)</th>");
        print("<th>Risk Management (Triannual)</th>");
        print("<th>Blended Retirement (One-Time)</th>");

        while ($row = mysqli_fetch_assoc($resultcbt)) {

            $now = date('Y-m-d');
            $now30 = date('Y-m-d', strtotime("$now + 30 days"));
            $now60 = date('Y-m-d', strtotime("$now + 60 days"));

            echo    "<tr class='nth-child' align='center'>";


            $trafficingDate =  $row["dodCombatTrafficking"];
            $trafficingDate = date('Y-m-d', strtotime("$trafficingDate + 365 days"));

            if (($trafficingDate) < ($now30)){
                $color='red';
            }
            elseif (($trafficingDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color' class='nth-child'> ". $trafficingDate ."</td>";



            //----------------------------------------------------------------------------------------//
            $cyberAwarenessDate =  $row["cyberAwareness"];
            $cyberAwarenessDate = date('Y-m-d', strtotime("$cyberAwarenessDate + 365 days"));

            if (($cyberAwarenessDate) < ($now30)){
                $color='red';
            }
            elseif (($cyberAwarenessDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $cyberAwarenessDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $forceProDate =  $row["fp"];
            $forceProDate = date('Y-m-d', strtotime("$forceProDate + 365 days"));

            if (($forceProDate) < ($now30)){
                $color='red';
            }
            elseif (($forceProDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $forceProDate ." </td>";
    //----------------------------------------------------------------------------------------//
            $greenDotCurrentDate =  $row["greenDotCurrent"];
            //$greenDotCurrentDate = date('Y-m-d', strtotime("$greenDotCurrentDate + 365 days"));

            if (($greenDotCurrentDate)){
                $color='black';
            }
            elseif ((!$greenDotCurrentDate)) {
                $color = 'goldenrod';
            }else {
                $color = 'red';
            }

            echo    "<td style='color:$color'> ". $greenDotCurrentDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $greenDotNextDate =  $row["greenDotNext"];


            if (($greenDotNextDate)){
                $color='black';
            }
            elseif ((!$greenDotNextDate)) {
                $color = 'goldenrod';
            }else {
                $color = 'red';
            }

            //$greenDotNextDateDue = date('Y-m-d', strtotime("$greenDotNextDate + 365 days"));


            echo    "<td style='color:$color'>"; if ($greenDotNextDate){
                echo $greenDotNextDate;
            }else echo "";
            echo "</td>";


            //----------------------------------------------------------------------------------------//
            $cbrnCBTDate =  $row["cbrnCBT"];
            $cbrnCBTDate = date('Y-m-d', strtotime("$cbrnCBTDate + 547 days"));

            if (($cbrnCBTDate) < ($now30)){
                $color='red';
            }
            elseif (($cbrnCBTDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $cbrnCBTDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $cbrnCBTPretestDate =  $row["cbrnCBTPretest"];
            $cbrnCBTPretestDate = date('Y-m-d', strtotime("$cbrnCBTPretestDate + 547 days"));

            if (($cbrnCBTPretestDate) < ($now30)){
                $color='red';
            }
            elseif (($cbrnCBTPretestDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $cbrnCBTPretestDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $noFEARDate =  $row["noFEAR"];
            $noFEARDate = date('Y-m-d', strtotime("$noFEARDate + 730 days"));

            if (($noFEARDate) < ($now30)){
                $color='red';
            }
            elseif (($noFEARDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $noFEARDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $afCIEDDate =  $row["afCIED"];
            $afCIEDDate = date('Y-m-d', strtotime("$afCIEDDate + 1095 days"));

            if (($afCIEDDate) < ($now30)){
                $color='red';
            }
            elseif (($afCIEDDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $afCIEDDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $afCIED_OldDate =  $row["afCIED_Old"];
            $afCIED_OldDate = date('Y-m-d', strtotime("$afCIED_OldDate + 1095 days"));

            if (($afCIED_OldDate) < ($now30)){
                $color='red';
            }
            elseif (($afCIED_OldDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $afCIED_OldDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $religiousFreedomDate =  $row["religiousFreedom"];
            $religiousFreedomDate = date('Y-m-d', strtotime("$religiousFreedomDate + 1095 days"));

            if (($religiousFreedomDate) < ($now30)){
                $color='red';
            }
            elseif (($religiousFreedomDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $religiousFreedomDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $sabcDate =  $row["sabc"];
            $sabcDate = date('Y-m-d', strtotime("$sabcDate + 1095 days"));

            if (($sabcDate) < ($now30)){
                $color='red';
            }
            elseif (($sabcDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $sabcDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $sabcHandsOnDate =  $row["sabcHandsOn"];
            $sabcHandsOnDate = date('Y-m-d', strtotime("$sabcHandsOnDate + 1095 days"));

            if (($sabcHandsOnDate) < ($now30)){
                $color='red';
            }
            elseif (($sabcHandsOnDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $sabcHandsOnDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $loacDate =  $row["loac"];
            $loacDate = date('Y-m-d', strtotime("$loacDate + 1095 days"));

            if (($loacDate) < ($now30)){
                $color='red';
            }
            elseif (($loacDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $loacDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $emsDate =  $row["ems"];
            $emsDate = date('Y-m-d', strtotime("$emsDate + 1095 days"));

            if (($emsDate) < ($now30)){
                $color='red';
            }
            elseif (($emsDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $emsDate ." </td>";

            //----------------------------------------------------------------------------------------//


            $riskDate =  $row["riskManagement"];
            $riskDate = date('Y-m-d', strtotime("$riskDate + 1095 days"));

            if (($riskDate) < ($now30)){
                $color='red';
            }
            elseif (($riskDate) < $now60) {
                $color = 'goldenrod';
            }else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $riskDate ." </td>";
            //----------------------------------------------------------------------------------------//
            $blendedRetirementDate =  $row["blendedRetirement"];
            //$blendedRetirementDate = date('Y-m-d', strtotime("$blendedRetirementDate + 365 days"));

            if ((!$blendedRetirementDate)){
                $color='red';
            } else {
                $color = 'black';
            }

            echo    "<td style='color:$color'> ". $blendedRetirementDate ." </td>";



            echo "</td>
                    
                                   
                    </tr>";
        }





    }else {
        echo "<br>";
        echo "<h3 align='center'>ADLS Status</h3>";
        echo "<p align='center'>No Training Due</p>";
    }
    echo "</table><br>";


    $sqlCCTK = "select *
        from members m
    INNER join cctkList c
     on m.lastName LIKE c.lastName AND m.firstName LIKE c.firstName
    where (c.lastName LIKE '$last' AND c.firstName LIKE '$first' AND c.grade = '$rank')
    order by m.lastName
    ";

    $result3 = mysqli_query($connection, $sqlCCTK);

    if (mysqli_num_rows($result3) > 0) {
    //($row = mysqli_fetch_array($result) > 1)

    // output data of each row

        echo "<h3 align='center'>CCTK Status</h3>";
        echo "<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Last Name</th>");
        print("<th>First Name</th>");
        print("<th>Status</th>");
        print("<th>Immunizatoins</th>");
        print("<th>Dental</th>");
        print("<th>Lab</th>");
        print("<th>DLC</th>");
        print("<th>PHA</th>");
        print("<th>EQP</th>");
        print("<th>IMR</th>");
        print("<th>Go Red Date</th>");


        while ($row = mysqli_fetch_assoc($result3)) {

            //echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngType"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";


            echo "<tr class='nth-child' align='center'>
                                    <td class='nth-child'>" . $row["lastName"] . "</td>
                                    <td>" . $row["firstName"] . "</td>
                                    <td>" . $row["status"] . "</td>
                                    <td>" . $row["imm"] . "</td>
                                    <td>" . $row["den"] . "</td>
                                    <td>" . $row["lab"] . "</td>
                                    <td>" . $row["dlc"] . "</td>
                                    <td>" . $row["pha"] . "</td>
                                    <td>" . $row["eqp"] . "</td>
                                    <td>" . $row["imr"] . "</td>
                                    <td>" . $row["goRed"] . "</td>
                                    </tr>
                    </tr>";

        }
    } else {
        echo "<h3 align='center'>CCTK Status</h3>";
        echo "<p align='center'>No Training Due</p>";
    }
    echo "</table><br>";


    $sqlSFMQ = "select * 
    from members m
    INNER join sfmq s
     on m.lastName = s.lastName AND m.firstName = s.firstName
    where (s.lastName = '$last' AND s.firstName = '$first' AND s.rank ='$rank') AND ((s.primCertDate <> '') OR (s.phase2Start <> ''))
    ";

    $result4 = mysqli_query($connection, $sqlSFMQ);

    if (mysqli_num_rows($result4) > 0) {
    //($row = mysqli_fetch_array($result) > 1)

    // output data of each row
        echo "<h3 align='center'>Duty Position</h3>";
        echo "<table>";
        echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Last Name</th>");
        print("<th>First Name</th>");
        print("<th>Duty Section</th>");
        print("<th>Duty Position</th>");
        print("<th>Date Certified</th>");
        print("<th>QC within 90 Days</th>");


        while ($row = mysqli_fetch_assoc($result4)) {

            //echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngType"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";

            echo "<tr class='nth-child' align='center'>
                                    <td class='nth-child'>" . $row["lastName"] . "</td>
                                    <td>" . $row["firstName"] . "</td>
                                    <td>" . $row["dutySection"] . "</td>
                                    <td>" . $row["dutyQualPos"] . "</td>
                                    <td>" . $row["primCertDate"] . "</td>
                                    <td>" . $row["nintyDayStart"] . "</td> </tr>
                    </tr>";



        }
    } else {
        echo "<h3 align='center'>Duty Position</h3>";
        echo "<p align='center'>No Certificatoins</p>";
    }
    echo "</table>";


    //misc training
$sqlMiscTrng = "select * 
    from members m
    INNER join micsCerts mi
     on m.dodId = mi.dodId 
    where (m.lastName = '$last' AND m.firstName = '$first' AND m.rank ='$rank')
    ";

$resultSqlMiscTrng = mysqli_query($connection, $sqlMiscTrng);

if (mysqli_num_rows($resultSqlMiscTrng) > 0) {

    while ($row = mysqli_fetch_assoc($resultSqlMiscTrng)) {

        $recallRanger = $row['ranger'];

        //($row = mysqli_fetch_array($result) > 1)

        // output data of each row
        echo "<h3 align='center'>Duty Position</h3>";
        echo "

        <div class='table-responsive-md'>
                <table class='table table-bordered'>
                    <tbody>
                    <thead class='thead-light' style='alignment: left';>
                    <tr>
                        <th scope='col' style='width: auto'; align='center'>Ranger</th>
                        <th scope='col' style='width: auto'>Raven</th>
                        <th scope='col' style='width: auto'>DAGR</th>
                        <th scope='col' style='width: auto'>5 Ton</th>

                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td style='alignment: left; width: auto' >
                            <div class='form-group'>

                                <p>" . $recallRanger . "</p>

                            </div>

                        </td>
                        <td>
                            <div class='form-group'>

                                <input type='text' class='form-control' id='input5ton' name='input5ton' value='<?php echo $recall5ton; ?>' placeholder='YYYY-MM-DD' >

                            </div>

                        </td>
                        <td>
                            <div class='form-group'>

                                <input type='text' class='form-control' id='inputRaven' name='inputRaven' value='<?php echo $recallRaven; ?>' placeholder='YYYY-MM-DD' >

                            </div>

                        </td>

                        <td>

                            <div class='form-group'>

                                <input type='text' class='form-control' id='inputDagr' name='inputDagr' value='<?php echo $recallDagr; ?>' placeholder='YYYY-MM-DD' >

                            </div>
                        </td>
                    </tr>
                    <thead class='thead-light' style='alignment: left';>
                    <tr>
                        <th scope='col' style='width: auto'>row 2</th>
                        <th scope='col' style='width: auto'>row 2</th>
                        <th scope='col' style='width: auto'>row 2</th>
                        <th scope='col' style='width: auto'>row 2</th>

                    </tr>
                    </thead>
                    <td style='alignment: left; width: auto' >
                        <div class='form-group'>
                            <input type='text' class='form-control' id='inputRanger' name='inputRanger' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input type='text' class='form-control' id='input5ton' name='input5ton' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input type='text' class='form-control' id='inputRaven' name='inputRaven' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>

                    </td>
                    <td>
                        <div class='form-group'>
                            <input type='text' class='form-control' id='inputDagr' name='inputDagr' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>
                    </td>
                    </tbody>

                    <thead class='thead-light' style='alignment: left';>
                    <tr>
                        <th scope='col' style='width: auto'>row 3</th>
                        <th scope='col' style='width: auto'>row 3</th>
                        <th scope='col' style='width: auto'>row 3</th>
                        <th scope='col' style='width: auto'>row 3</th>

                    </tr>
                    </thead>
                    <td style='alignment: left; width: auto' >
                        <div class='form-group'>
                            <input type='text' class='form-control' id='inputRanger' name='inputRanger' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input type='text' class='form-control' id='input5ton' name='input5ton' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input type='text' class='form-control' id='inputRaven' name='inputRaven' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>

                    </td>
                    <td>
                        <div class='form-group'>
                            <input type='text' class='form-control' id='inputDagr' name='inputDagr' value='<?php echo $recallItem; ?>' placeholder='YYYY-MM-DD' >
                        </div>
                    </td>
                    </tbody>
                </table>
            </div>";

    }
} else {
    echo "<h3 align='center'>Additional Training</h3>";
    echo "<p align='center'>No Certifications</p>";
}
echo "</table>";


    //fitness portion

$recallMemberFitnessInformation = "select * From fitness
        WHERE lastName = '$last' AND firstName = '$first' AND rank = '$rank' AND unitName = '$unitName'
        ";
$resultRecallMemberFitnessInformation = mysqli_query($connection, $recallMemberFitnessInformation);

if (mysqli_num_rows($resultRecallMemberFitnessInformation) > 0) {
    //($row = mysqli_fetch_array($result) > 1)

                                        echo "<h3 align=\"center\">Fitness Assessment Information</h3>";
                                        echo"<table>";
                                        echo("<table class='table' border = \"1\" align='center' style='width:auto' >");
                                        echo "<thead>
                                            
                                              <tr>  <th scope=\"col\" style='width: auto'>Fitness Assessment Date</th>
                                                <th scope=\"col\" style='width: auto'>Run</th>
                                                <th scope=\"col\" style='width: auto'>Push-Ups</th>
                                                <th scope=\"col\" style='width: auto'>Situps</th>
                                                <th scope=\"col\" style='width: auto'>Waist</th>
                                                <th scope=\"col\" style='width: auto'>Type</th>
                                               </tr>
                                               </thead>
                                           
                                           ";

    while ($row = mysqli_fetch_assoc($resultRecallMemberFitnessInformation)) {

        echo "<tbody>
                <tr>
                <td>" . $row['dueDate'] . "</td>
                <td>" . $row['run'] . "</td>
                    <td>" . $row['pushUps'] . "</td>
                                <td>" . $row['sitUps'] . "</td>
                                <td>" . $row['waist'] . "</td>
                                <td>" . $row['fitness_mockType'] . "</td>
                                </tr>
                                </tbody>
                                ";
    }

} else {
    echo "<h3 align='center'>Fitness Assessment Iformation</h3>";
    echo "<p align='center'>No Fitness Information on file</p>";
}
echo "</table>";
//forms

    echo "<hr>
    <br>
    <h1 align='center'>Forms</h1>";




    /*
    $sqlArming = "SELECT *
    FROM members m
    INNER JOIN armingRoster a
    ON m.lastName = a.lastName AND m.firstName = a.firstName
    WHERE a.lastName = '$last' AND a.firstName = '$first' AND a.rank ='$rank'
    ";


    $result5 = mysqli_query($connection, $sqlArming);

    if (mysqli_num_rows($result5) > 0) {
    //($row = mysqli_fetch_array($result) > 1)

        // output data of each row
        echo "<h3 align='center'>Firing Status</h3>";
        echo"<table>";
            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
        print("<tr>");
        print("<th>Baton</th>");
        print("<th>Form 2760</th>");
        print("<th>Taser</th>");
        print("<th>M4 Qaul</th>");
        print("<th>M4 Expriry</th>");
        print("<th>M9 Qual</th>");
        print("<th>M9 Expriry</th>");
        print("<th>SMC Fired</th>");
        print("<th>SMC Expriry</th>");
        print("<th>203 Expriry</th>");
        print("<th>249 Expriry</th>");
        print("<th>240 Expriry</th>");
        print("<th>870 Expriry</th>");

        while($row = mysqli_fetch_assoc($result5)) {

            // echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngtype"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";

            echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $row["baton"]. "</td>
                                    <td contenteditable=\"true\">" . $row["useOfForce"]. "</td>
                                    <td>" . $row["2760"]. "</td>
                                    <td>" . $row["taser"] . "</td>
                                    <td>" . $row["m4Qual"] . "</td>
                                    <td>" . $row["m4Exp"] . "</td>
                                    <td>" . $row["m9Qual"]. "</td>
                                    <td>" . $row["m9Exp"]. "</td>
                                    <td>" . $row["smcFired"] . "</td>
                                    <td>" . $row["smcDue"] . "</td>
                                    <td>" . $row["203Exp"] . "</td>
                                     <td>" . $row["249Exp"] . "</td>
                                    <td>" . $row["240Exp"] . "</td>
                                    <td>" . $row["870Exp"] . "</td>
                                    </tr>
                    </tr>";
        }
    } else {
        echo "<h3 align='center'>Firing Status</h3>";
        echo "<p align='center'>Member not qualified</p>";
    }
    echo "</table><br>";*/
    ?>

    </body>
    <!-- indluces closing html tags for body and html-->
    <?php include __DIR__.'/../footer.php';?>