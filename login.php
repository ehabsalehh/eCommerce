<?php
session_start();
$pagetitle = "login";
if (isset($_SESSION['user'])){
    header('location: index.php');
};
 include "init.php";
    //Check if user come from HTTP post ReQuest
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['login'])){
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedpass = sha1($pass);
        //Chech If The use Exist In DataBase
            $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ? ");
        $stmt->execute(array($user, $hashedpass));
        $get = $stmt->fetch();
        $count = $stmt->rowCount();
        //If Count> 0 This Mean The DataBase Contain Rescord About This User
            if($count > 0 ) {
            $_SESSION['user'] = $user; //Register Session Name
            $_SESSION['uid'] = $get['UserID']; //Register Session ID
            header('location: index.php'); // Redirect To DashBoard Page
            exit();
            }
        } else {
                $formErrors = array();
                $username = $_POST['username'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $email = $_POST['email']; 

                if(isset($username)){
                    $filterErrors = filter_var($username, FILTER_SANITIZE_STRING);
                    if(strlen($filterErrors)<4){
                        $formErrors[] = "User can\'t Be Less Than 4 Character";
                    }
                }
                if(empty($password)){
                    $formErrors[]= "Sorry Password Must\'t Be Empty";
                }
                if(isset($password) && isset($password2)){
                    if( sha1($password) !== sha1($password2)){
                        $formErrors[]= "Sorry Password Is Not Match";
                    }
            }
            if(isset($email)){
                $filterEmail= filter_var($email, FILTER_SANITIZE_EMAIL);
                if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){
                    $formErrors[] = "This Email Is Not Valid";
                }

            }
            // check if there no error procced the addUser operation
            if(empty($formErrors)){
                // Check  I User Exist In Datbase
                $check = checkItem("Username", "users", $username);
                if($check == 1){
                    $formErrors[] = "Sorry this User Name Is Exist ";
                } else {
                    //Insert User Info In Database
                    
                    $stmt = $con->prepare("INSERT INTO
                                            users(Username, Password, Email, Regstatus, Date)
                                            VALUES (:zuser, :zpass, :zmail, 0, now())");
                        $stmt->execute(array(
                            'zuser' => $username,
                            'zpass' => sha1($password),
                            'zmail' => $email
                        ));
                        // Echo Success message
                        $succesMsg = "Congrates You Are Registerd Now";
                        
                    }
                }

        }
    }

 ?>
<div class="container login-page">
    <h1 class="text-center"><span class="selected" data-class= "login">Login</span> |<span data-class="signup">Signup</span></h1>
    <!-- start Login up Form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type username" required/>
        </div>
        <div class="input-container">
            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type password" required>
        </div>
            <input class="btn btn-info btn-block" name="login" type="submit" value="login"/>
        
    </form>
        <!-- End Login up Form -->
    <!-- start sign up Form -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="input-container">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type username" pattern = ".{4,}" title = "user must\'t be less than 4 character " required  />
    </div>
    <div class="input-container">
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type password" minlength = "4" required />
    </div>
    <div class="input-container">
        <input  class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Type password again" minlength = "4" required />
    </div>
    <div class="input-container">
        <input class="form-control" type="email" name="email"  placeholder="Type Your Email" required />
    </div>
        <input class="btn btn-info btn-block" name="signup" type="submit" value="save"/>
    </form>
    <!-- end sign up Form -->
    <div class="theerror text-center">
        <?php
        if(!empty($formErrors)){
            foreach($formErrors as $error){
                echo '<div class= "alert alert-danger">'.$error.'</div>';
            }
        }
        if(isset($succesMsg)){
            echo '<div class= "alert alert-success">'.$succesMsg.'</div>';
        }
         ?>
        
    </div>

</div>
<?php include $tpl ."footer.php"; ?>