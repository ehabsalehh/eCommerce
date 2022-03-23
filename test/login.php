<?php
if(!empty($_POST['submit'])){
    if(empty($_POST['email']) || empty(['passsword'])){
        die("please fill all the form <a href='./login.php'>return</a>");
    }
    $email = addslashes($_POST['email']);
    $password= addslashes($_POST['password']);
    require_once("./connect.php");
    $sql = "select * from users where email='{$email}'";
    $result =$db->query($sql);
    if($db->error){
        die("retrive falled");
    }
    if($result->num_rows === 0){
        die("email not found");
    }
    $password = md5($password);
    $array = $result->fetch_array();
    $result->free();
    $db->close();
    if($password === $array['password']){
        setcookie("id",$array['userID'],0,"/");
        $secuirety = md5($array['userID'].$array['password']."one_plus_one_three");
        setcookie("security",$secuirety,0,"/");
        //echo"<scirpt>window.location.href='./index.php'</scirpt>";
        header('location: index.php'); // Redirect To DashBoard Page
    }else{
        echo "wrong password <a href='./login.php'>login</a>";
    }
}
?>
<form action="" method="post">
email:<input type="text" name="email"><br>
password:<input type="password" name="password"><br>
<input type="submit" name="submit"><br>

</form>
