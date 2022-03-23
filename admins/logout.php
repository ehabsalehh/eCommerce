<?php
session_start();
session_unset(); //Unset The Data
session_destroy(); //Destroy The Data
header('location: index.php');
exit();