<?php
/*
** Mnanage Member's page
*** You can Add \ edit delete members from here
*/
session_start();
$pagetitle = "comments";
if (isset($_SESSION['Username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] :  'manage';
    //Star manage page
    if($do == 'manage'){ //manage Page

        $stmt = $con->prepare("SELECT
                                comments.*, items.Name AS Item_Name, users.Username AS Member
                            FROM
                                comments
                            INNER JOIN
                            items
                            ON
                            items.Item_ID = comments.Item_ID
                            INNER JOIN
                            users
                            ON
                            users.UserID = comments.User_ID
                            ORDER BY C_ID DESC ");
        $stmt->execute();
        //Assign To Variable
        $rows = $stmt->fetchALL();
        if(!empty($rows)){
    ?>
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>ID</td>
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>

                        </tr>
                        <?php
                        foreach($rows as $row){
                            echo "<tr>";
                            echo "<td>". $row['C_ID']. "</td>";
                            echo "<td>". $row['Comment']. "</td>";
                            echo "<td>". $row['Item_Name']. "</td>";
                            echo "<td>". $row['Member']. "</td>";
                            echo "<td>" . $row['Comment_Date']."</td>";
                            echo "<td>
                            <a href='comments.php?do=Edit&comid=". $row['C_ID']."'
                            class='btn btn-success'>
                            <i class ='fa fa-edit'></i>Edit</a>
                            <a href='comments.php?do=Delete&comid=". $row['C_ID']."'
                            class='btn btn-danger confirm'>
                            <i class ='fa fa-close'></i>Delete </a>";
                            if($row['status'] == 0){
                                echo"<a href='comments.php?do=Approve&comid=". $row['C_ID']."'
                                class='btn btn-info activate'>
                                <i class ='fa fa-check'></i>Approve</a>";
                            }
                            echo "</td>";
                            echo "</tr>";


                        }
                        ?>

                    </table>
                </div>

            </div>
                    <?php } else{
                        echo"<div class = 'container'>";
                            echo "<div class ='alert alert-info'>There\'s  No Comment To Show</div>";
                        echo "<div class = 'container'>";
                    } ?>
    <?php

        } elseif($do=='Edit'){ //Edit Page
        //Check If the Get request comid is numeric &Get The integer value of it

       $comid =isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0;
       $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ?");
       //execute query
      $stmt->execute(array($comid));
      //fetch the data
      $row= $stmt->fetch();
      //The row Count
      $count = $stmt->rowCount();
      // if theris such id show the form
      if ($count > 0){?>
        <h1 class="text-center">Edit Comment</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="comid" value="<?php echo $comid ?>"/>
                <!-- start Comment field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-10 col-md-6">
                        <textarea class="form-control" name="comment"><?php echo $row['Comment'] ?></textarea>
                    </div>
                </div>
                <!--end Comment field -->
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
          $themsg = "<div class = 'alert alert-danger'>There No Such Id</div>";
          redirectHome($themsg);
          echo "</div>";

      }
    } elseif ($do == 'Update'){
        echo "<h1 class='text-center'>Update Comment</h1>";
        echo "<div class = 'container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Get The Vaiable From the from
           $comid = $_POST['comid'];
           $comment = $_POST['comment'];

             //Update the Database with The info
           $stmt= $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ? ");
           $stmt->execute(array($comment, $comid));
           //Echo Succes Message
           $themsg =  "<div class ='alert alert-success'>".$stmt->rowCount() ."Recorded Updated</div>";
           redirectHome($themsg, 'back');



           

        } else{
            $themsg =  "<div class ='alert alert-danger'>Sorry you Cant Browse This Page</div>";
            redirectHome($themsg);
            
        }
        echo "</div>";

    } elseif($do == 'Delete'){// Delete Members page
        echo "<h1 class='text-center'>Delete Comment</h1>";
        echo "<div class = 'container'>";

            //Check If the Get request comid is numeric &Get The integer value of it
            $comid =isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0;
            //Select all data depend on the id
            $check = checkItem('C_ID', 'comments', $comid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('DELETE FROM comments WHERE C_ID = :zid');
                $stmt->bindparam(':zid', $comid);
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
    } elseif($do =='Approve'){
        echo "<h1 class='text-center'> Approve Members</h1>";
        echo "<div class = 'container'>";

            //Check If the Get request id is numeric &Get The integer value of it
            $comid =isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0;
            //Select all data depend on the id
            $check = checkItem('C_ID', 'comments', $comid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('UPDATE comments SET status = 1 WHERE C_ID = ?');
                $stmt->execute(array($comid));
                $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Comment Approved </div>";
                redirectHome($themsg,"back");
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