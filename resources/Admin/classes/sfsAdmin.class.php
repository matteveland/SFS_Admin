<?php
//require $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/config/dbconfig.php';
include ($_SERVER['DOCUMENT_ROOT'].'/vendor/phpmailer/phpmailer/src/PHPMailer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/vendor/phpmailer/phpmailer/src/SMTP.php');
include ($_SERVER['DOCUMENT_ROOT'].'/vendor/phpmailer/phpmailer/src/Exception.php');
//use PHPMailer\PHPMailer\PHPMailer;

//$unitName = $_SESSION['unitName'];

class FindUser{

  //$unitName = $_SESSION['unitName'];

  private $findUser;
  private $findAdmin;
  public $userName;
  public $lastName;
  public $firstName;
  public $middleName;
  public $admin;
  public $unitName;
  public $dodId;
  public $dutySection;
  //public $specialAccess;
  public $image;
  public $imageDetail;

  public function get_user($findUser, $findAdmin){

    $this->findUser = $findUser;
    $this->findAdmin = $findAdmin;

    global $mysqli;


    if (!$findUser == '' OR NULL) {
      $findAccount = $findUser;
    }else{
    }

    if (!$findAdmin == '' OR NULL) {
      $findAccount = $findAdmin;
    }else {
    }

    $findUserAccount = $mysqli->query("SELECT * From login l inner JOIN members m on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId WHERE '$findAccount' = user_name");

    while ($row = $findUserAccount->fetch_assoc()) {
      $this->userName = $row['user_name'];
      $this->lastName = $row['lastName'];
      $this->firstName = $row['firstName'];
      $this->middleName = $row['middleName'];
      $this->admin = $row['admin'];
      $this->unitName = $row['unitName'];
      $this->dodId = $row['dodId'];
      $this->dutySection = $row['dutySection'];
      $this->image = $row['image'];
      $this->imageDetail = $row['imageDetail'];
      //$this->specialAccess = $row['specialAccess'];
    }
  }
}


class FindMember{

  public $memberLast;
  public $memberID;
  public $uid;
  public $rank;
  public $gender;
  public $lastName;
  public $firstName;
  public $middleName;
  public $afsc;
  public $unitName;
  public $dutySection;
  public $address;
  public $homePhone;
  public $cellPhone;
  public $iv;
  public $birthdate;
  public $govEmail;
  public $prsnlEmail;
  public $image;
  public $imageDetail;
  public $emailOptIn;
  public $specialAccess;

  //public $cipherMethod;
  //public $cellPhoneKey;
  //public $homePhoneKey;
  // $birthdateKey;

  public function find_member($memberID, $memberLast, $unitName){


    $this->dodID = $memberID;
    $this->lastName = $memberLast;
    $this->unitName = $unitName;


    global $mysqli;

    $findMember = $mysqli->query("SELECT * From members WHERE lastName = '$memberLast' AND dodId = '$memberID'");


    $findMemberAdmin = $mysqli->query("SELECT * From login WHERE lastName = '$memberLast' AND dodId = '$memberID'");



    while ($row = $findMember->fetch_array()) {
      $this->userName = $row['id'];
      $this->dodId = $row['dodId'];
      $this->rank = $row['rank'];
      $this->gender = $row['gender'];
      $this->lastName = $row['lastName'];
      $this->firstName = $row['firstName'];
      $this->middleName = $row['middleName'];
      $this->afsc = $row['afsc'];
      $this->unitName = $row['unitName'];
      $this->dutySection = $row['dutySection'];
      $this->address = $row['address'];
      $this->homePhone = $row['homePhone'];
      $this->cellPhone = $row['cellPhone'];
      $this->iv = $row['iv'];
      $this->birthdate = $row['birthdate'];
      $this->govEmail = $row['govEmail'];
      $this->prsnlEmail = $row['PrsnlEmail'];
      $this->image = $row['image'];
      $this->imageDetail = $row['imageDetail'];
      $this->emailOptIn = $row['emailOpt_In'];
      $this->gender = $row['gender'];
      $this->specialAccess = $row['specialAccess'];
    }

    while ($row = $findMemberAdmin->fetch_array()) {
      $this->admin = $row['admin'];

    }
  }
}

class FindSupervisor{

  public $memberLast;
  public $memberID;
  public $lastName;
  public $firstName;
  public $unitName;
  public $supRank;
  public $supFirstName;
  public $supLastName;
  public $dateBegan;
  public $feedback;



  //public $cipherMethod;
  //public $cellPhoneKey;
  //public $homePhoneKey;
  // $birthdateKey;

  public function find_member_supervisor($memberID, $memberLast, $memberFirst){


    $this->dodID = $memberID;
    $this->lastName = $memberLast;
    $this->firstName = $memberFirst;

    global $mysqli;

    $findSupervisor = $mysqli->query("SELECT * From supList s
        INNER JOIN members m
        on m.lastName = s.lastName AND m.firstName = s.firstName
        WHERE m.lastName = '$memberLast' AND m.firstName = '$memberFirst' AND m.dodId = '$memberID'");

    while ($row = $findSupervisor->fetch_array()) {
      $this->dodId = $row['dodId'];
      $this->rank = $row['rank'];
      $this->lastName = $row['lastName'];
      $this->firstName = $row['firstName'];
      $this->unitName = $row['unitName'];
      $this->supRank = $row['superRank'];
      $this->supFirstName = $row['supFirstName'];
      $this->supLastName = $row['supLastName'];
      $this->dateBegan = $row['supDateBegin'];
      $this->feedback = $row['feedbackCompleted'];
    }
  }
}
?>
