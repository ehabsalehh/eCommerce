<?php
session_start();
$nonavbar = "";
$pagetitle = "login";
include "init.php";
 //Check if user come from HTTP post ReQuest
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
     $username = $_POST['user'];
     $password = $_POST['pass'];
     $hashedpass = sha1($password);
    //Chech If The user Exist In DataBase
     $stmt = $con->prepare("SELECT
                            UserID, Username, Password FROM users WHERE Username = ?
                            AND Password = ? AND GroupID = 1 LIMIT 1 ");
    $stmt->execute(array($username, $hashedpass));
    $row= $stmt->fetch();
    $count = $stmt->rowCount();
    //If Count> 0 This Mean The DataBase Contain Rescord About This User
     if($count > 0 ) {
        $_SESSION['Username'] = $username; //Register Session Name
        $_SESSION['ID'] = $row['UserID']; // Regiser Session Id
        header('location: dashboard.php'); // Redirect To DashBoard Page
        exit();
     }
 }
?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
    <input class ="btn btn-primary btn-block" type="submit" value="login">
</form>
<?php include $tpl ."footer.php"; ?>