<?php
session_set_cookie_params(3);
$result = session_start();
if($result){
    echo "session started";
}else{
    echo "session not started";
}
$_SESSION['password'] = "123456";