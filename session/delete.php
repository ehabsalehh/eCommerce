<?php
session_start();

//unset($_SESSION['password']);
$_SESSION = array();
setcookie(session_name(),"",time()-1,"/");
session_destroy();