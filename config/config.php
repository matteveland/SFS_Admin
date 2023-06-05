<?php
session_start();
require ('php.ini');

include_once $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/functions/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/classes/sfsAdmin.class.php';
date_default_timezone_set('America/Los_Angeles');

$home_link = '/homepage.php';
//require __DIR__ . "/../resources/Navigation/navigation.html";
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


$siteTitle = 'SFS Admin';
