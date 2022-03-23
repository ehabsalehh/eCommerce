<?php
session_start();
if(isset($_SESSION['username'])&& isset($_SESSION['password'])){
    echo "welcome{$_SESSION['username']}";
}else{
    die("session dont eist");
}
setcookie("switch", "on",0,"/");
?>
<form action="./process_upload.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input type="file" name="upload" value="">
<input type="submit" name="submit" vlaue="">
</form>