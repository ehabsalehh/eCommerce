<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);
include "admins/connect.php";
$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}


$tpl ="includes/templates/";
$lang = "includes/languages/";
$func = "includes/functions/";
$css ="layout/css/";
$js ="layout/js/";
// include The Important Files
include $func ."function.php";
include  $lang ."english.php";
include $tpl ."header.php";

//Include Navbar on All Pages  EXpect  The One With Nonavbar variable

?>