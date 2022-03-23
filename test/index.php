<?php
if(isset($_COOKIE['id'])&& isset($_COOKIE['security'])){
    $id = addslashes($_COOKIE['id']);
    $sql = "select * from users where userID={$id}";
    require_once("./connect.php");
    $result = $db->query($sql);
    if($db->error){
        die("SQl ERROR");
    }
    if($result->num_rows === 0){
        die("illegal operation<a href='./login.php'>login</a>"); 
    }
    //id is real
    $array = $result->fetch_array(); //retireve password
    $result->free();
    $shell = md5($_COOKIE['id'].$array['password']."one_plus_one_three");
    $db->close();
    if($shell === $_COOKIE['security']){
        echo"welcome";
        echo $array['username'];
    }else{
        echo "error <a href='./login.php'>login</a>";
    }
}else{
    die("plesae login first <a href='./login.php'>login</a>");
}
setcookie("switch", "on",0,"/");
?>
<form action="./process_upload.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input type="file" name="upload" value="">
<input type="submit" name="submit" vlaue="">
</form>