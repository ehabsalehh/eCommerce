<?php
if(!empty($_POST['submit'])){
    if(empty($_POST['username'])|| empty($_POST['email']) || empty($_POST['password'])){
        die("please fill all the form <a href='./register.php'>return</a>");
    }
    if($_POST['password'] !== $_POST['re_password']){
        die("passwords not matchining");
    }
    if(isset($_POST['email'])){
        $filterEmail= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){
             die("This Email Is Not Valid");
        }
    }
    if(strlen($_POST['password'])<6){
        die("password should be contain at least 6 character <a href='./register.php'>return</a>");
    }
    if(strlen($_POST['password'])>20){
        die("password should be contain no more 20 character <a href='./register.php'>return</a>");

    }
        $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);
    require_once('./connect.php');
     $sql = "SELECT *  FROM users WHERE email='{$email}'";
     $result = $db->query($sql);
     if($db->error){
         die("sql error <a href='./register.php'>return</a>");
     }
     if($result->num_rows!==0){
         die("please use another email address<a href='./register.php'>return</a>");
     }
     $result->free();
     $password = md5($password);
    $sql = "INSERT INTO users SET username='{$username}', email='{$email}', password='{$password}'";
    $result = $db->query($sql);
    if($result === true){
        echo "success";
    }else{
        echo "fail";
    }
}


?>
<form action="" method="post">
usernamee:<input type="text" name="username"><br>
email:<input type="text" name="email"><br>
password:<input type="password" name="password"><br>
prepassword:<input type="password" name="re_password"><br>
<input type="submit" name="submit"><br>

</form>