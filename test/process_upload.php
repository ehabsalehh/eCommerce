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

    if($shell === $_COOKIE['security']){
        echo"welcome";
        echo $array['username'];
    }else{
        echo "error <a href='./login.php'>login</a>";
    }
}else{
    die("plesae login first <a href='./login.php'>login</a>");
}
if(empty($_COOKIE['switch'])){
    die("upload request denied");
}
if($_COOKIE['switch'] == "on"){
    setcookie("switch","",time()-1,"/");
}else{
    die("illegal operation");
}

if(!empty($_POST['submit'])){
    if($_FILES['upload']['error'] == 0){
        $alllowdExtentsion = ['jpg','png','gif'];
        $array = explode(".",$_FILES['upload']['name']);
        $fileNameExtension = array_pop($array);
        if(!in_array($fileNameExtension,$alllowdExtentsion)){
            die("this extension is not allowed");
        }
        $newFileName = time().rand(1000,9000).".".$fileNameExtension;
        $newFileDestination = "./".date("Y")."/".date("m")."/".date("d");
        if(!is_dir($newFileDestination)){
            mkdir($newFileDestination,0777,true);
            $destination = $newFileDestination."/".$newFileName;
        }else{
            // director already eist
            $destination = $newFileDestination."/".$newFileName;
        }
        if(move_uploaded_file($_FILES['upload']['tmp_name'],$destination)){
            require_once("./connect.php");
            $sql = "insert into picture set url='$destination', userID='{$_COOKIE['id']}'";
            $db->query($sql);
            if($db->error){
                die("sql error");
            }
            $db->close();
            echo " file moved successfuly <a href ='./login.php'>return</a>";

        }else{
            echo "file not moved";
        }
    }
}else{
    if($_FILES['upload']['error'] == 1 || $_FILES['upload']['error'] == 2){
        echo "files too big olease selected smaller one";
    }else{
        echo "this file is partly uploaded";
    }
}
