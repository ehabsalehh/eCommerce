<?php
ob_start();// output Buffering Start
session_start();
if (isset($_SESSION['Username'])) {
  $pagetitle = "Dashboard";
  include "init.php";
 $numUsers = 4; //Need four records
 $latestUser = getLatest('*', 'users', 'UserID', $numUsers);// Get last four records
 $NumItems = 4;
 $latestItems = getLatest('*', 'items','Item_ID', $NumItems );//Get last four Items
 $numComments = 4;
 $latestComment = getLatest('*', 'comments', 'C_ID', $numComments );//Get last four comments
  ?>
  <!--start DashBoard page -->
 <div class="container text-center Home-stats">
   <h1>Dashboard</h1>
   <div class="col-md-3">
      <div class="stat st-member">
        <div class="info">
          <i class="fa fa-users"></i>
        Total Members
        <span> <a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
        </div>
        
      </div>
     
   </div>
   <div class="col-md-3">
     <div class="stat st-pending">
       <i class="fa fa-user-plus"></i>
       <div class="info">
       Pending Members
       <span><a href="members.php?do=manage&page=pending"><?php echo checkItem("Regstatus", "users", 0) ?></a></span>
       </div>
       
     </div>
   </div>
   <div class="col-md-3">
     <div class="stat st-item">
       <i class="fa fa-tag"></i>
       <div class="info">
        Total Items
        <span> <a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a></span>

       </div>

       

     </div>
   </div>
   <div class="col-md-3">
     <div class="stat st-comment">
       <i class= "fa fa-comments"></i>
       <div class="info">
       Total Comments
       <span><a href="comments.php"><?php echo countItems('C_ID', 'comments') ?></a></span>
       </div>
      
     </div>
   </div>
 </div>
 <div class="container latest">
   <div class="row">
     <div class="col-sm-6">
       <div class="panel panel-default">
         <div class="panel-heading">
           <i class="fa fa-users"></i> Latest<?php echo $numUsers?> Registerd users
           <span class="toggle-info pull-right">
             <i class="fa fa-plus fa-lg"></i>
           </span>
         </div>
           <div class="panel-body">
             <ul class="list-unstyled latest-users">
             <?php
             if(!empty($latestUser)){
              foreach($latestUser as $user){
                echo'<li>';
                    echo $user['Username'];
                    echo '<a href ="members.php?do=Edit&userid=' .$user['UserID']. '">';
                      echo '<span class ="btn btn-success pull-right">';
                          echo '<i class ="fa fa-edit"></i>EDit';
                          if($user['Regstatus'] == 0){
                            echo"<a href='members.php?do=Activate&userid=". $user['UserID']."'
                            class='btn btn-info pull-right activate'>
                            <i class ='fa fa-edit'></i>Activate</a>";
                        }
                      echo '</span>';
                    echo'</a>';
                  echo '</li>';
              }
            } else {
              echo "There No User To Show";
            }
             ?>
             </ul>
           </div>
       </div>
     </div>
     <div class="col-sm-6">
       <div class="panel panel-default">
         <div class="panel-heading">
           <i class="fa fa-tags">Latest<?php echo $NumItems?></i> Approved Items
           <span class="toggle-info pull-right">
             <i class="fa fa-plus fa-lg"></i>
           </span>
         </div>
           <div class="panel-body">
           <ul class="list-unstyled latest-users">
             <?php
             if(!empty($latestItems)){
              foreach($latestItems as $item){
                echo'<li>';
                    echo $item['Name'];
                    echo '<a href ="items.php?do=Edit&itemid=' .$item['Item_ID']. '">';
                      echo '<span class ="btn btn-success pull-right">';
                          echo '<i class ="fa fa-edit"></i>EDit';
                          if($item['Approve'] == 0){
                            echo"<a href='items.php?do=Approve&itemid=". $item['Item_ID']."'
                            class='btn btn-info pull-right activate'>
                            <i class ='fa fa-check'></i>Approve</a>";
                        }
                      echo '</span>';
                    echo'</a>';
                  echo '</li>';
              }
            } else {
              echo "There No Items To Show";
            }
             ?>
             </ul>
           </div>
       </div>
     </div>
   </div>
   <div class="row">
     <div class="col-sm-6">
       <div class="panel panel-default">
         <div class="panel-heading">
           <i class="fa fa-comments-o"></i> Latest<?php echo $numComments; ?> Comments
           <span class="toggle-info pull-right">
             <i class="fa fa-plus fa-lg"></i>
           </span>
         </div>
         <div class="panel-body">
         <?php
         $stmt = $con->prepare("SELECT
                                comments.*, users.Username AS Member
                            FROM
                                comments
                            INNER JOIN
                            users
                            ON
                            users.UserID = comments.User_ID
                            ORDER BY C_ID DESC
                            LIMIT $numComments
                             "
                            );
        $stmt->execute();
        //Assign To Variable
        $comments = $stmt->fetchALL();
        if(!empty($comments)){
          foreach($comments as $comment){
            echo "<div class= 'comment-box'>";
              echo "<span class= 'member-n'>" .$comment['Member'] ."</span>";
              echo "<p class= 'member-c'>" .$comment['Comment'] ."</p>";
            echo "</div>";
          }
        } else {
          echo "There No Comment To Show" ;
        }
        ?>
           </div>
       </div>
     </div>
   </div>
 </div>
<!-- End DashBoard page-->
  <?php
  include $tpl ."footer.php";

} else{
	header('location: index.php');
	exit();
}
ob_end_flush(); //Relase The Output
?>