<?php


require_once __DIR__.'/../dbconfig/connect.php';
include __DIR__.'/../navigation.php';

$unitName = $_SESSION['unitName'];
?>
<script>
    function confirmDelete(link) {
        if (confirm("Are you sure? Member will be removed from the database.")) {
            doAjax(link.href, "GET"); // doAjax needs to send the "confirm" field
        }
        return false;
    }
</script>

<head>
    <title>Search results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        div.gallery {
            margin: 5px;
            border: 1px solid #ccc;
            float: left;
            width: 180px;
        }

        div.gallery:hover {
            border: 1px solid #777;
        }

        div.gallery img {
            width: 100%;
            height: auto;
        }

        div.desc {
            padding: 15px;
            text-align: center;
        }
    </style>
</head>



<body>
<h3 align="center">Search Results</h3>
<?php
$query = mysqli_real_escape_string($connection, $_GET['query']);
// gets value sent over search form

$min_length = 1;
// you can set minimum length of the query if you want
if($_SESSION['page_admin']){

    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then

        //$query = htmlspecialchars($connection, $query);
        // changes characters used in html to their equivalents, for example: < to &gt;

        $query = mysqli_real_escape_string($connection, $query);
        // makes sure nobody uses SQL injection

        $sql= "SELECT * FROM `members` WHERE ((`lastName` LIKE '%$query%' OR `firstName` LIKE '%$query%' OR `middleName` LIKE '%$query%' OR `dutySection` LIKE '%$query%') AND (`unitName` = '$unitName') AND NOT `lastName` LIKE 'DELETE%') ORDER BY `lastName`";

        $raw_results = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        // * means that it selects all fields, you can also write: `id`, `title`, `text`
        // articles is the name of our table

        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'

        if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following

            while($results = mysqli_fetch_array($raw_results)){
                // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop

                //echo "<p>".$results['lastname'].", ".$results['firstname']."</p>";
                // posts results gotten from database(title and text) you can also show id ($results['id'])
                if ($results['imageDetail'] == '1'){

                    echo '<div class="row">
              <div class="container">    
              <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '">
              
                 <img class="rounded-circle" src=\'/UnitTraining/adminpages/' . $results['image'] . '\' style="width: 200px; height: 200px;" >
                
                </a>
                <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:blue; margin-left: 20px">' . $results['rank'] . " " . $results['lastName'] . ", " . $results['firstName'] . " " . $results['middleName'] . '</a>
                 <a href="/UnitTraining/adminpages/updateMember.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:#01579b"> Update Member </a>
                 <a href="/UnitTraining/adminpages/delete.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:red"" onclick="return confirmDelete(this);"> Delete Member </a><br>
              <div>
         </div>';

                }else {
                    $defaultImagePath = "/UnitTraining/adminpages/uploads/default.jpeg";
                    echo '<div class="row">
            <div class="container">
            <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '">
             <img class="rounded-circle" src=\'' . $defaultImagePath . '\' style="width: 200px; height: 200px;">
             </a>
             <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:blue; margin-left: 20px">' . $results['rank'] . " " . $results['lastName'] . ", " . $results['firstName'] . " " . $results['middleName'] . '</a>
             <a href="/UnitTraining/adminpages/updateMember.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:#01579b"> Update Member </a>
             <a href="/UnitTraining/adminpages/delete.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:red"" onclick="return confirmDelete(this);"> Delete Member </a><br>
            </div>
          </div>';
                }


                /* '.$results['firstname'].'*/
                //echo '<a href="dynamic_page.php?id=$result['lastname']'>$result[];
            }

        }
        else{ // if there is no matching rows do following
            echo "No results";
        }

    }
    else { // if query length is less than minimum
        echo "<p align='center'>Minimum length is . $min_length</p>";
    }

}else{if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then

    //$query = htmlspecialchars($connection, $query);
    // changes characters used in html to their equivalents, for example: < to &gt;

    $query = mysqli_real_escape_string($connection, $query);
    // makes sure nobody uses SQL injection

    $sql= "SELECT * FROM `members` WHERE ((`lastName` LIKE '%$query%' OR `firstName` LIKE '%$query%' OR `middleName` LIKE '%$query%' OR `dutySection` LIKE '%$query%') AND (`unitName` = '$unitName') AND NOT `lastName` LIKE 'DELETE%') ORDER BY `lastName`";

    $raw_results = mysqli_query($connection, $sql) or die(mysqli_error($connection));

    // * means that it selects all fields, you can also write: `id`, `title`, `text`
    // articles is the name of our table

    // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
    // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
    // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'

    if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following

        while($results = mysqli_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop

            //echo "<p>".$results['lastname'].", ".$results['firstname']."</p>";
            // posts results gotten from database(title and text) you can also show id ($results['id'])
            if ($results['imageDetail'] == '1'){

                echo '<div class="row">
              <div class="container">    
              <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '">
              
                 <img class="rounded-circle" src=\'/UnitTraining/adminpages/' . $results['image'] . '\' style="width: 200px; height: 200px;" >
                
                </a>
                <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:blue; margin-left: 20px">' . $results['rank'] . " " . $results['lastName'] . ", " . $results['firstName'] . " " . $results['middleName'] . '</a>
              <div>
         </div>';

            }else {
                $defaultImagePath = "/UnitTraining/adminpages/uploads/default.jpeg";
                echo '<div class="row">
            <div class="container">
            <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '">
             <img class="rounded-circle" src=\'' . $defaultImagePath . '\' style="width: 200px; height: 200px;">
             </a>
             <a href="/UnitTraining/search/querylink.php?rank=' . $results['rank'] . '&last=' . $results['lastName'] . '&first=' . $results['firstName'] . '&middle=' . $results['middleName'] . '" style="color:blue; margin-left: 20px">' . $results['rank'] . " " . $results['lastName'] . ", " . $results['firstName'] . " " . $results['middleName'] . '</a>
            </div>
          </div>';
            }


            /* '.$results['firstname'].'*/
            //echo '<a href="dynamic_page.php?id=$result['lastname']'>$result[];
        }

    }
    else{ // if there is no matching rows do following
        echo "No results";
    }

}
else { // if query length is less than minimum
    echo "<p align='center'>Minimum length is . $min_length</p>";
}


}

?>
</body>
    <!-- indluces closing html tags for body and html-->
<?php include __DIR__.'/../footer.php';?>