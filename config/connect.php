<?php
require $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/config/dbconfig.php';
//$_SERVER['DOCUMENT_ROOT'] = "/Users/matteveland/code";

/* You should enable error reporting for mysqli before attempting to make a connection */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli = new mysqli($host, $user, $password, $db);

/* Set the desired charset after establishing a connection */
$mysqli->set_charset('utf8mb4');

if ($_SERVER['SERVER_NAME'] = 'localhost'){

    printf("Success... %s\n", $mysqli->host_info);

}else{

    echo "address didnt work";

}

/*
$connection = mysqli_connect($host, $user, $password, $db);


if (!$connection) {
    die("Database Connection Failed" . mysqli_connect_error(). "<br>");
}

$select_db = mysqli_select_db ($connection, $db);

if (!$select_db){
    die("Database Selection Failed" . mysqli_connect_error());



}



if ($conn->connect_errno) {
    die("Database Connection Failed" . mysqli_connect_errno(). "<br>");
}
*/
