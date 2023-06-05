<?php
//
//find if user is admin
//
//session_start();
function isUserLogged_in(){

  if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
    //Does not exist. Redirect user back to page-one.php
    header("location:/resources/Admin/Login-Logout/login.php");
    //exit;
  }else {

  }
  /*
  if (isset($_SESSION['page_user'])) {
  //Does not exist. Redirect user back to page-one.php
  //echo "<p style='text-align: center''> You must be have an Admin account to view this page.</p>";
  //echo "<p style='text-align: center' '><a href='homepage.php'>Home Page</p>";
  $nonAdmin == true;

  return $nonAdmin;


  exit;
}else{

$nonAdmin == false;
return $nonAdmin;


}*/


}
function isAdmin($link_address){

  if (isset($_SESSION['page_user'])) {
    //Does not exist. Redirect user back to page-one.php
    echo "<script type=\"text/javascript\">
    alert(\"You do no have permissions to view this page.\");
    window.location = \"$link_address\"
    </script>";
    //$location = "/homepage.php";

    //echo '<meta http-equiv="refresh" content="2; url=' . $location . '">';
    //exit;
  }else {

  }
}

function permissionsToEdit($section, $lastName, $id, $unitName, $link_address){
  global $mysqli;


  $findAccess = $mysqli->query("SELECT specialAccess FROM members WHERE lastName = '$lastName' AND dodId = '$id'");


  //$unitAccessDefualts = $mysqli->query("SELECT accessValues FROM specialAccess WHERE unitName = '$unitName'");

  $memberAccessDefualts = $findAccess->fetch_assoc();
  $memberAccessPermissions = $memberAccessDefualts['specialAccess'];
  $membersAccessArray = explode(', ', $memberAccessPermissions);

  for ($i = 0; $i < count($membersAccessArray); $i++) {

    if ($membersAccessArray[$i] == $section) {

      $access = true;
      $accessGiven = $membersAccessArray[$i];
      break;
    }else {
      $access = false;
    }
  }

  if ($findAccess->num_rows) {

    if (!$access == true) {
      ob_start();
      echo "<script type=\"text/javascript\">
      alert(\"You DO NOT HAVE access to view this page. If you believe you should have access, contact your supervision.\")
      window.location = \"$link_address\"
      </script>";

    }else{
      echo "<script type=\"text/javascript\">
      alert(\"You are accessing a portion of SFS Admin that contains live data. Any change you make are irreversible. Exercise caution.\")
      </script>";

    }
  }else {

    ob_start();
    echo "<script type=\"text/javascript\">
    alert(\"You DO NOT HAVE access to view this page.\")
    window.location = \"$link_address\"
    </script>";

  }
  ob_flush();
}



//
// for sidebar pages
// function to set the menu highlisghts according to page the user ahs navigated to.
//
//
function active($current_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  if($current_page == $url){
    echo 'active'; //class name in css
  }
}


function menuOpenSection(){

  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'section'){
    echo 'menu-open'; //class name in css
  }
}


function menuOpenAlarm(){

  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'alarm'){
    echo 'menu-open'; //class name in css
  }
}
function menuOpenVehicle(){

  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'vehicle'){
    echo 'menu-open'; //class name in css
  }
}
function menuOpenEquipment(){

  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'equipment'){
    echo 'menu-open'; //class name in css
  }
}

function menuOpenAdmin(){

  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if (($url_explode[0] !== 'alarm') AND ($url_explode[0] !== 'vehicle') AND ($url_explode[0] !== 'equipment') AND ($url_explode[0] !== 'section')){
    echo 'menu-open'; //class name in css
  }else{
  }

}


function header_active_alarm(){
  //find the header pages for the link tree
  //$args = func_get_args();
  /** now you can access these as $args[0], $args[1] **/
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'alarm'){
    echo 'active'; //class name in css
  }
  else{
  }
}

function header_active_section(){
  //find the header pages for the link tree
  //$args = func_get_args();
  /** now you can access these as $args[0], $args[1] **/
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);

  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'section'){
    echo 'active'; //class name in css
  }
  else{
  }
}

function header_active_vehicle(){
  //find the header pages for the link tree
  //$args = func_get_args();
  /** now you can access these as $args[0], $args[1] **/
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'vehicle') {

    echo 'active'; //class name in css
  }else{

  }
}

function header_active_equipment(){
  //find the header pages for the link tree
  //$args = func_get_args();
  /** now you can access these as $args[0], $args[1] **/
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  $url_explode =  explode('-', $url);
  if ($url_explode[0] == 'equipment') {

    echo 'active'; //class name in css
  }else{
  }
}

//need to add all the things that arent admin for this to work, otherwise the admin portion of the sidebar will highlight blue.
function header_active_admin(){
  //find the header pages for the link tree
  //  $args = func_get_args();
  /** now you can access these as $args[0], $args[1] **/
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  $url_explode =  explode('-', $url);
  if (($url_explode[0] !== 'alarm') AND ($url_explode[0] !== 'vehicle') AND ($url_explode[0] !== 'equipment') AND ($url_explode[0] !== 'section')){
    echo 'active'; //class name in css
  }else{
  }
}


////
function returnAppointmentMessage($mysqli_query_results, $allArray, $appointmentType){

  var_dump($appointmentType);

  if (!$mysqli_query_results) {

    $_SESSION['allArray'] = $allArray;

    $database_error = "<div class='form-row'>There was an error while inserting your information into the database. Please try again.</div>";

    $duplicate_entry = "<div class='form-row'>You have mulitple appointmenes are the samw time. You need to select <i>override</i> or remove the othe appointment. Please try again.</div>";

    $email_send = "<div class='form-row'>The email reminded did not send a intended. You will not receive an email reminder. If you require an email, conact the system administrator.</div>";

    switch ($appointmentType) {
      case 'database_error':
      //$returnedMessage = $database_error;
      print_r('database_error');
      //  return $returnedMessage;
      // code...
      break;
      case 'duplicate_entry':
      //$returnedMessage = $duplicate_entry;
      print_r('duplicate_entry');
      //return $returnedMessage;
      break;
      case 'email_send_bad':
      print_r('email_send_bad');
      //$returnedMessage = $email_send;
      //  return $returnedMessage;
      break;
      default:
      // code...
      break;
    }

  }else{

    $database_success = "<div class='form-row'>Appointment was successfully added. Thank you.</div>";

    $email_send = "<div class='form-row'>Email successfully send to receipent.</div>";

    switch ($appointmentType) {
      case 'database_good':

      $returnedMessage = $database_error;
      return $returnedMessage;

      // code...
      break;
      case 'email_send_good':
      $returnedMessage = $email_send;
      return $returnedMessage;
      break;
      default:
      // code...
      break;
    }


    $appointmentError = "<div class='form-row'>Information inserted into database.</div>";

  }


}

?>
