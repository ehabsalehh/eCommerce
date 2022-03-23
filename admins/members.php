<?php
/*
** Mnanage Member's page
*** You can Add \ edit delete members from here
*/
session_start();
$pagetitle = "Members";
if (isset($_SESSION['Username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] :  'manage';
    //Star manage page
    if($do == 'manage'){ //manage Page
        $query = "";
        if (isset($_GET['page']) && $_GET['page'] == 'pending'){
            $query = "AND Regstatus = 0 ";
        }
        //$rows = getAllFrom("*", "users", "where GroupID != 1", "$query", "UserID");
        
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
        $stmt->execute();
        //Assign To Variable
        $rows = $stmt->fetchALL();
        
        if(!empty($rows)){
    ?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table manage-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Avatar</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registerd Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                        foreach($rows as $row){
                            echo "<tr>";
                            echo "<td>". $row['UserID']. "</td>";
                            echo "<td>";
                            if(empty($row['Avatar'])){
                                echo '<img src = "Uploads/Avatar/facebook-avatar.jpg"/>';
                            } else {
                                echo "<img src = 'Uploads/Avatar/".$row['Avatar']."' alt = '' />";
                            }
                            echo "</td>";
                            echo "<td>". $row['Username']. "</td>";
                            echo "<td>". $row['Email']. "</td>";
                            echo "<td>". $row['Fullname']. "</td>";
                            echo "<td>" . $row['Date']."</td>";
                            echo "<td>
                            <a href='members.php?do=Edit&userid=". $row['UserID']."' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>
                            <a href='members.php?do=Delete&userid=". $row['UserID']."' class='btn btn-danger confirm'><i class ='fa fa-close'></i>Delete </a>";
                            if($row['Regstatus'] == 0){
                                echo"<a href='members.php?do=Activate&userid=". $row['UserID']."'
                                class='btn btn-info activate'>
                                <i class ='fa fa-check'></i>Activate</a>";
                            }
                            echo "</td>";
                            echo "</tr>";


                        }
                        ?>

                    </table>
                </div>
                <a href = 'members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Members</a>

            </div>
                <?php } else {
                    echo"<div class = 'container'>";
                        echo "<div class ='alert alert-info'>There\'s  No Members To Show</div>";
                        echo "<a href = 'members.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New Members</a>";
                    echo "<div class = 'container'>";
                } ?>
    <?php } elseif($do == 'Add'){//Add members page ?>
        <h1 class="text-center">Add New Members</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data" >
                <!-- start username field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control"  autocomplete="off" required = "required" placeholder ="Username To login Into Shop" />
                    </div>
                </div>
                <!--end username field -->
                <!--start password field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="password" class=" password form-control" autocomplete="new-password" required = "required" placeholder="Password Must Be Hard & Complex" />
                        <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>
                <!--end password field -->
                <!--start Email field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control" autocomplete="off"  required = "required" placeholder = "Email Must Be Valid"/>
                    </div>
                </div>
                <!--end Email field -->
                <!--start full Name field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control"  autocomplete="off" required = "required" placeholder ="FullName" />
                    </div>
                </div>
                <!--end full Name  field -->
                <!--start  Avatar field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">avatar</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="file" name="avatar" class="form-control" required = "required" autocomplete="off"/>
                    </div>
                </div>
                <!--end Avatar field -->
                <!--start submit field -->
                <div class="form-group form-group-lg">
                    <div class=" col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                    </div>
                </div>
            <!--end submit field -->

        </form>
    </div>
    <?php
        } elseif($do == 'Insert'){
            // Insert Member page
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h1 class='text-center'>Insert Members</h1>";
                echo "<div class = 'container'>";
                // Upload Variables
                  $avatarName = $_FILES['avatar']['name'];
                  $avatarType = $_FILES['avatar']['type'];
                  $avatarTmp = $_FILES['avatar']['tmp_name'];
                 $avatarsize = $_FILES['avatar']['size'];
                //List Of Allowed File To Uploaded
                $avatarAllowedExetnsion = array('jpg', 'png', 'gif');
                //Get Avatar Extension
                $result = explode('.', $avatarName);
                $avatarExetnsion=  strtolower(end($result));
                //Get The Variable From the from
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $email = $_POST['email'];
                $name =$_POST['full'];
                $hashedPass = sha1($_POST['password']);
               // validae the form
               $formErrors = array();
               
              if (strlen($user)< 4 ){
                  $formErrors[] = ' Username Cant Be less than <strong>4 Caharacters</strong>';
              }
              if (strlen($user) > 30 ){
                $formErrors[] = ' Username Cant Be More than <strong>30 Caharacters</strong>';
            }
            if (empty($user)){
                $formErrors[] = ' Username Cant Be <strong>Emtpy</strong>';
    
            }
            if (empty($pass)){
                $formErrors[] = ' Password Cant Be <strong>Emtpy</strong>';
            }
            
             if (empty($name)){
                $formErrors[] = ' Fullname Cant Be <strong>Emtpy</strong>';
            }
            if (empty($email)){
                $formErrors[] = ' Email Cant Be <strong>Emtpy</strong>';
    
            }
            if (!empty($avatarName) && !in_array($avatarExetnsion, $avatarAllowedExetnsion)){
                $formErrors[] = ' This Exetension Is Not <strong>Allowed</strong>';
    
            }
            if (empty($avatarName)){
                $formErrors[] = ' This File IS <strong>Required</strong>';
    
            }
            if ($avatarsize > 4194304 ){
                $formErrors[] = ' Avatar Can\'t Be Larger Than <strong>4MB</strong>';
            }
            // loop into array and echo it
            foreach($formErrors as $errors){
                $themsg =   '<div class = "alert alert-danger">' .$errors . '</div>' ;
                redirectHome($themsg, 'back');

            }
            
            // check if there no error procced the update operation
            if(empty($formErrors)){
                $avatar = rand(0, 1000000) ."_". $avatarName;
                move_uploaded_file($avatarTmp, "Uploads\Avatar\\".$avatar );
                // Check  I User Exist In Datbase
                $check = checkItem("Username", "users", $user);
                if($check == 1){
                    echo "<div class = 'container'>";
                    $themsg =  " <div class ='alert alert-danger'>sorry The User Is Exist</div>";
                    redirectHome($themsg, 'back');
                    echo "</div>";
                } else {
                    //Insert User Info In Database
                    
                    $stmt = $con->prepare("INSERT INTO
                                            users(Username, Password, Email, Fullname, Regstatus, Date, Avatar)
                                            VALUES (:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar)"  );
                        $stmt->execute(array(
                            'zuser' => $user,
                            'zpass' => $hashedPass,
                            'zmail' => $email,
                            'zname' => $name,
                            'zavatar' => $avatar
                        ));
                        // Echo Success message
                        $themsg =  "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Inserted  </div>";
                        redirectHome($themsg, 'back');
                    }
                }
            } else{
                echo "<div class = 'container'>";
                $themsg= "<div class = 'alert alert-danger'>Sorry you Cant Browse This Page</div>";
                redirectHome($themsg);
                echo "</div>";
            }
            echo "</div>";
            
            
        } elseif($do=='Edit'){ //Edit Page
        //Check If the Get request id is numeric &Get The integer value of it

       $userid =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0;
       $stmt = $con->prepare("SELECT * FROM users WHERE  UserID = ? LIMIT 1 ");
       //execute query
      $stmt->execute(array($userid));
      //fetch the data
      $row= $stmt->fetch();
      //The row Count
      $count = $stmt->rowCount();
      // if theris such id show the form
      if ($count > 0){?>
        <h1 class="text-center">Edit Members</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid?>"/>
                <!-- start username field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required = "required" />
                    </div>
                </div>
                <!--end username field -->
                <!--start password field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">password</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>"/>
                        <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont wantToChange" />


                    </div>
                </div>
                <!--end password field -->
                <!--start Email field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required = "required"/>
                    </div>
                </div>
                <!--end Email field -->
                <!--start Full Name field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="full" class="form-control" value="<?php echo $row['Fullname'] ?>" required = "required"/>
                    </div>
                </div>
                <!--end Full Name field -->
                <!--start submit field -->
                <div class="form-group form-group-lg">
                    <div class=" col-sm-offset-2 col-sm-10">
                        <input type="submit" value="save" class="btn btn-primary btn-lg" />
                    </div>
                </div>
            <!--end submit field -->
        </form>
    </div>
    <?php
    //if ther is no such id show error message
      } else {
          echo "<div class = 'container'>";
          $themsg = "<div class = 'alert alert-danger'>Ther No Such Id</div>";
          redirectHome($themsg);
          echo "</div>";

      }
    } elseif ($do == 'Update'){
        echo "<h1 class='text-center'>Update Members</h1>";
        echo "<div class = 'container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Get The Vaiable From the from
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name =$_POST['full'];
            //password Trick
           $pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
           // validae the form
           
           $formErrors = array();
          if (strlen($user)< 4 ){
              $formErrors[] = ' Username Cant Be less than <strong>4 Caharacters</strong>';
          }
          if (strlen($user) > 30 ){
            $formErrors[] = ' Username Cant Be More than <strong>30 Caharacters</strong>';
        }
        if (empty($user)){
            $formErrors[] = ' Username Cant Be <strong>Emtpy</strong>';

        } if (empty($name)){
            $formErrors[] = ' Fullname Cant Be <strong>Emtpy</strong>';
        }
        if (empty($email)){
            $formErrors[] = ' Email Cant Be <strong>Emtpy</strong>';

        }
        // loop into array and echo it
        foreach($formErrors as $errors){
            echo  '<div class = "alert alert-danger">' .$errors . '</div>' ;
        }
        // check if there no error procced the update operation
        if(empty($formErrors)){
            $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
            $stmt2->execute(array($user, $id));
            $count = $stmt2->rowCount();
            if($count == 1){
                echo "<div class ='container'>";
                    $themsg = "<div class = 'alert alert-danger'>sorry This user is exist</div>";
                    redirectHome($themsg, "back");
                echo "</div>";
            } else {
                
                 //Update the Database with The info
                $stmt = $con->prepare( "UPDATE users SET Username = ?, Email = ?, Fullname = ?, Password = ? WHERE UserID = ?");
                $stmt->execute(array($user, $email, $name, $pass, $id));
                $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Updated </div>";
                redirectHome($themsg,"Back");

            }
           /* //Update the Database with The info
            $stmt = $con->prepare( "UPDATE users SET Username = ?, Email = ?, Fullname = ?, Password = ? WHERE UserID = ?");
            $stmt->execute(array($user, $email, $name, $pass, $id));
            $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Updated </div>";
            redirectHome($themsg,"Back");*/
        }

        } else{
            echo "div class = 'container'>";
            $themsg =  "<div class ='alert alert-danger'>Sorry you Cant Browse This Page</div>";
            redirectHome($themsg);
            echo "</div>";
        }
        echo "</div>";

    } elseif($do == 'Delete'){// Delete Members page
        echo "<h1 class='text-center'>Delete Members</h1>";
        echo "<div class = 'container'>";

            //Check If the Get request id is numeric &Get The integer value of it
            $userid =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0;
            //Select all data depend on the id
            $check = checkItem('userid', 'users', $userid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('DELETE FROM users WHERE UserID = :zuser');
                $stmt->bindparam(':zuser', $userid);
                $stmt->execute();
                $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Deleted </div>";
                redirectHome($themsg,"back");
            } else {
                echo "<div class = 'container'>";
                $themsg = "<div class = 'alert alert-danger'> This ID Is Not Exist </div>";
                redirectHome($themsg);
                echo "</div>";
            }
            
      echo "</div>";
    } elseif($do =='Activate'){
        echo "<h1 class='text-center'> Activate Members</h1>";
        echo "<div class = 'container'>";

            //Check If the Get request id is numeric &Get The integer value of it
            $userid =isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0;
            //Select all data depend on the id
            $check = checkItem('userid', 'users', $userid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('UPDATE users SET Regstatus = 1 WHERE UserID = ?');
                $stmt->execute(array($userid));
                $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Activated </div>";
                redirectHome($themsg, "back");
            } else {
                echo "<div class = 'container'>";
                $themsg = "<div class = 'alert alert-danger'> This ID Is Not Exist </div>";
                redirectHome($themsg);
                echo "</div>";
            }
    }
    include $tpl ."footer.php";
} else{
	header('location: index.php');
    exit();
}

