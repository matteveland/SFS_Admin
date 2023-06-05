<?php


require_once __DIR__ . '/../../dbconfig/connect.php';
include __DIR__ . '/../../navigation.php';
include('/var/services/web/sfs/Application/data.env');
$unitName = $_SESSION['unitName'];

if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
    //Does not exist. Redirect user back to page-one.php
    echo "<p style='text-align: center''> Please login to an Admin or User account to view this page.</p>";
    echo "<p style='text-align: center' '><a href='/UnitTraining/login_logout/splashpage.php'>Login</a></p>";
    exit;
}

$findESSQrtlyNuisanceTrends = "SELECT DATE(CONCAT(YEAR(reportedTime),'-', 1 + 3*(QUARTER(reportedTime)-1),'-01')) AS quarter_beginning, 
COUNT(*) as Nuisance
FROM alarmData
WHERE (findings = 'Nuisance') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 356 DAY AND now() + INTERVAL 1 DAY)
 GROUP BY DATE(CONCAT(YEAR(reportedTime),'-', 1 + 3*(QUARTER(reportedTime)-1),'-01'))
 ORDER BY DATE(CONCAT(YEAR(reportedTime),'-', 1 + 3*(QUARTER(reportedTime)-1),'-01'))";


$findESSQrtlyFalseTrends = "SELECT DATE(CONCAT(YEAR(reportedTime),'-', 1 + 3*(QUARTER(reportedTime)-1),'-01')) AS quarter_beginningFalse, 
COUNT(*) as ffalse
FROM alarmData
WHERE (findings = 'False') and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 356 DAY AND now() + INTERVAL 1 DAY)
 GROUP BY DATE(CONCAT(YEAR(reportedTime),'-', 1 + 3*(QUARTER(reportedTime)-1),'-01'))
 ORDER BY DATE(CONCAT(YEAR(reportedTime),'-', 1 + 3*(QUARTER(reportedTime)-1),'-01'))";


$resultsFindESSQrtlyNuisanceTrends = mysqli_query($connection, $findESSQrtlyNuisanceTrends);
$resultsFindESSQrtlyFalseTrends = mysqli_query($connection, $findESSQrtlyFalseTrends);


$findESSMonthlyNuisanceTrends= "SELECT MONTHNAME(reportedTime) AS Month, COUNT(findings) AS TotalAlarms FROM alarmData WHERE (findings = 'Nuisance')  and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 356 DAY AND now() + INTERVAL 1 DAY)GROUP BY MONTHNAME(reportedTime), YEAR(reportedTime) ORDER BY YEAR(reportedTime), FIELD(Month,'January','February','March','April', 'May', 'June', 'July', 'August', 'September', 'October', 'November','December')";
$findESSMonthlyFalseTrends ="SELECT MONTHNAME(reportedTime) AS Month, COUNT(findings) AS TotalAlarms FROM alarmData WHERE (findings = 'False')  and unitName = '$unitName' AND (reportedTime BETWEEN now() - INTERVAL 356 DAY AND now() + INTERVAL 1 DAY) GROUP BY MONTHNAME(reportedTime), YEAR(reportedTime) ORDER BY YEAR(reportedTime), FIELD(Month,'January','February','March','April', 'May', 'June', 'July', 'August', 'September', 'October', 'November','December') ";

$resultsFindESSMonthlyNuisanceTrends = mysqli_query($connection, $findESSMonthlyNuisanceTrends);
$resultsFindESSMonthlyFalseTrends = mysqli_query($connection, $findESSMonthlyFalseTrends);
?>


    <html>
    <head>
    </head>
    <title>ESS</title>

    <?php



        echo "<h3 style='text-align:center'>ESS</h3><br>";

    include ('navigation.html');
        echo "<br><h3 style='text-align: center'>Nuisance Alarm Rates</h3><table>";
        if (mysqli_num_rows($resultsFindESSQrtlyNuisanceTrends) > 0) {
            // output data of each row


            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
            print("<tr>");
            echo("<th>Quarter Reported</th>
                <th>Nuisance Totals</th>
                ");

            while ($row = mysqli_fetch_assoc($resultsFindESSQrtlyNuisanceTrends)) {

                $quarter_beginning = $row["quarter_beginning"];
                $Nuisance = $row["Nuisance"];


                echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $quarter_beginning . "</td>
                                    <td>" . $Nuisance . "</td>
                            
                                    ";
                }
                echo " </tr>
                   </tr></table>";


            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
            print("<tr>");
            echo("<th>Month Reported</th>
                <th>Nuisance Totals</th>
                ");

            while ($row = mysqli_fetch_assoc($resultsFindESSMonthlyNuisanceTrends)) {


                $monthNuisance = $row["Month"];
                $totalAlarms = $row["TotalAlarms"];


                echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $monthNuisance . "</td>
                                    <td>" . $totalAlarms . "</td>
                            
                                    ";
            }
            echo " </tr>
                   </tr></table>";


        }else{

        }
        echo "<br><h3 style='text-align: center'>False Alarm Rates</h3>";
        if (mysqli_num_rows($resultsFindESSQrtlyFalseTrends) > 0) {
            // output data of each row

            echo "<b<table>";
            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
            print("<tr>");
            echo("<th>Quarter Reported</th>
                <th>Nuisance Totals</th>
                ");

            while ($row = mysqli_fetch_assoc($resultsFindESSQrtlyFalseTrends)) {

                $quarter_beginningFalse = $row["quarter_beginningFalse"];
                $false = $row["ffalse"];


                echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $quarter_beginningFalse . "</td>
                                    <td>" . $false . "</td>
                            
                                    ";
            }
            echo "</tr></table>";

            echo("<table class='table table-striped' border = \"1\" align='center' style='width: auto'>");
            print("<tr>");
            echo("<th>Month Reported</th>
                <th>Nuisance Totals</th>
                ");

            while ($row = mysqli_fetch_assoc($resultsFindESSMonthlyFalseTrends)) {


                $monthNuisance = $row["Month"];
                $totalAlarms = $row["TotalAlarms"];


                echo "<tr class='nth-child'>
                                    <td class='nth-child'>" . $monthNuisance . "</td>
                                    <td>" . $totalAlarms . "</td>
                            
                                    ";
            }
            echo " </tr>
                   </tr></table>";






}else{
    echo "<h3 align='center'>You do not have permissions to view this page.</h3>
      <div align='center' > <a class='btn btn-primary' href='/UnitTraining/index.html' role='button'>Return to Home Page</a></div>

";


}
    ?>

<body>
<!--Div that will hold the pie chart-->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var jsonData = $.ajax({
            url: "getData.php",
            dataType: "mySQL",
            async: false
        }).responseText;

        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 400, height: 240});
    }

</script>
</head>

<body>
<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
</body>


</body>
    </html>