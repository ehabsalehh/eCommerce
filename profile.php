
<?php
ob_start();
session_start();
$pagetitle = "Profile";
include "init.php";
if(isset($_SESSION['user'])){
    $getUser = $con->prepare('SELECT *  FROM users WHERE Username = ?');
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    $Userid = $info['UserID'];
    ?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class=" panel panel-primary">
                <div class="panel-heading">
                    My information
                </div>
                <div class="panel panel-body">
                    <ul class="list-unstyled">
                   <li>
                       <i class="fa fa-unlock alt fa-fw"></i>
                       <span> Login Name</span>:<?php echo $info['Username'] ?>
                    </li>
                   <li>
                   <i class="fa fa-envelope-o alt fa-fw"></i>
                       <span> Email</span>:<?php echo $info['Email'] ?>
                    </li>
                   <li>
                   <i class="fa fa-user fa-fw"></i>
                       <span>FullName</span>:<?php echo $info['Fullname'] ?>
                    </li>
                    <li>
                       <i class="fa fa-calendar fa-fw"></i>
                        <span> Register Date</span> :<?php echo $info['Date'] ?>
                    </li>
                    <li>
                       <i class="fa fa-tags fa-fw"></i>
                        <span> Categorey</span>:
                    </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>
    <div id="my-ads" class="my-ads block">
        <div class="container">
            <div class=" panel panel-primary">
                <div class="panel-heading"> My Items</div>
                <div class="panel panel-body">
                    <?php
                    $items = getAllFrom("*", "items","where Member_ID = $Userid", "", "Item_ID" );
                    if(!empty($items)){
                        echo "<div class='row'>";
                        foreach ($items as $item){
                            echo"<div class='col-sm-6 col-md-3'>";
                                echo "<div class='thumbnail item-box'>";
                                if($item['Approve'] == 0) {echo "<span class='approve-status'>Waiting Approval</span>";}
                                    echo "<span class='price-tag'>$".$item['Price']."</span>";
                                    echo"<img class='img-responsive' src='user.png' alt=''/>";
                                    echo "<div class='caption'>";
                                        echo "<h3><a href ='items.php?itemid=".$item['Item_ID']."'>".$item['Name']."</a></h3>";
                                        echo "<p>".$item['Description']."</p>";
                                        echo "<div class ='date'>".$item['Add_Date']."</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        
                        }
                        echo "</div>";
                    } else {
                        echo "There No Item\'s To Show <a href ='new-ads.php'>Create New Ads</a>";
                    }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-comments block">
        <div class="container">
            <div class=" panel panel-primary">
                <div class="panel-heading">Latest Comments </div>
                <div class="panel panel-body">
                    <?php
                    $comments = getAllFrom("Comment", "comments", "where User_ID = $Userid", "","C_ID","DESC" );
                    if(!empty($comments)){
                        foreach($comments as $comment){
                            echo "<p>". $comment['Comment']."</p>";
                        }
                    } else {
                        echo "there\'s No Comment To Show";
                    }
                     ?>
                </div>
            </div>
        </div>
    </div>

<?php } include $tpl ."footer.php";
ob_end_flush(); ?>