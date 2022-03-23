<?php
$result =  session_start();
if($result){
    echo "session started<hr>";
}else{
    echo "session falled";
}
var_dump($_COOKIE);
var_dump(session_name());
var_dump(session_id());
