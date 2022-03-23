<?php
include "connect.php";


$tpl ="includes/templates/";
$lang = "includes/languages/";
$func = "includes/functions/";
$css ="layout/css/";
$js ="layout/js/";
// include The Important Files
include $func ."functions.php";
include  $lang ."english.php";
include $tpl ."header.php";

//Include Navbar on All Pages  EXpect  The One With Nonavbar variable
if (!isset($nonavbar)){include $tpl . "navbar.php";}
?>