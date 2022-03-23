<?php
$dsn = "mysql:host=localhost;dbname=shop";
$user ="root";
$pass ="";
$opt = array(
    PDO::MYSQL_ATTR_INIT_COMMAND =>"set NAMES utf8",
);
try{
    $con = new PDO($dsn,$user,$pass,$opt);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Failed To connect ". $e->getmessage();

}
?>