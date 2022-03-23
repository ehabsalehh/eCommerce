
<?php
ob_start();
session_start();
$pagetitle = "Show Items";
include "init.php";
//Check If the Get request id is numeric &Get The integer value of it

$itemid =isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0;
$stmt = $con->prepare("SELECT
                        items.*, categories.Name AS category_name,
                            users.Username
                            FROM
                            items
                            INNER JOIN
                            categories
                                ON
                                categories.ID = items.Cat_ID
                                INNER JOIN
                                users
                                ON
                                users.UserID = items.Member_ID
                          WHERE  Item_ID = ?
                          AND Approve = 1  ");
//execute query
$stmt->execute(array($itemid));
//fetch the data
$count = $stmt->rowCount();
if($count > 0){
$item= $stmt->fetch();
//The row Count
?>
    <h1 class="text-center"><?php echo $item['Name'] ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img class='img-responsive img-thumbnail' src='user.png' alt=''/>
            </div>
            <div class="col-md-9 item-info">
                <h2><?php echo $item['Name'] ?></h2>
                <p><?php echo $item['Description'] ?></p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-calendar fa-fw"></i>
                        <span>Added Date:</span><?php echo $item['Add_Date'] ?>
                    </li>
                    <li>
                        <i class="fa fa-money fa-fw"></i>
                        <span>Price:</span><?php echo $item['Price'] ?>
                    </li>
                    <li>
                        <i class="fa fa-building fa-fw"></i>
                        <span>Made In:</span> <?php echo $item['Countery_Made'] ?>
                    </li>
                    <li>
                        <i class="fa fa-tags fa-fw"></i>
                       <span>Categorey:</span><a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name'] ?></a>
                    </li>
                    <li>
                        <i class="fa fa-users fa-fw"></i>
                        <span>Added By:</span><a href="#"><?php echo $item['Username']?></a>
                    </li>
                    <li class = "tags-items">
                        <span >Tags:</span>
                        <?php
                        $allTags = explode(",", $item['Tags']);
                        foreach($allTags as $tags) {
                            $lowerTag = strtolower($tags);
                            $tag = str_replace(" ", "", $tags);
                            if(!empty($tag)){
                            echo "<a href ='tags.php?name={$lowerTag}'>" .$tag."</a> ";
                            }
                        }

                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="custom-hr">
        <?php if(isset($_SESSION['user'])){ ?>
            <div class="row">
                <div class="col-md-offset-3">
                    <div class="add-comment">
                        <h3>Add Comment</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item['Item_ID'] ?>" method="POST">
                            <textarea name="comment" required></textarea>
                            <input class="btn btn-primary" type="submit" value="add-comment">
                        </form>
                        <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $itemid= $item['Item_ID'];
                            $userid = $_SESSION['uid'];
                            if(!empty($comment)){
                                $stmt = $con->prepare('INSERT INTO
                                comments(comment, status, Comment_Date, Item_ID, User_ID)
                                VALUES (:zcomment, 0, now(), :zitemid, :zuserid)');
                                $stmt->execute(array(
                                    ':zcomment' => $comment,
                                    ':zitemid' =>  $itemid,
                                    ':zuserid' => $userid
                                ));
                                if($stmt){
                                    
                                    echo "<div class='container'>";
                                        echo "<div class='alert alert-success'>Comment Added</div>";
                                    echo "</div>";

                                }
                            } else {
                                echo "<div class='container'>";
                                    echo "<div class='alert alert-danger'>You Must Add Comment First</div>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php }else {
            echo "<a href = 'login.php'>Register To Add Comment</a>";
        } ?>
            <hr class="custom-hr">
                <?php
                            $stmt = $con->prepare("SELECT
                                            comments.*,  users.Username AS Member
                                        FROM
                                            comments
                                        INNER JOIN
                                        users
                                        ON
                                        users.UserID = comments.User_ID
                                        WHERE Item_ID = ?
                                        AND status = 1
                                        ORDER BY
                                        C_ID DESC");
                            $stmt->execute(array($itemid));
                            //Assign To Variable
                            $comments = $stmt->fetchALL();
                        
                foreach($comments as $comment){ ?>
                    <div class="comment-box">
                        <div class = "row">
                            <div class='col-sm-2 text-center'>
                                <img class='img-responsive img-thumbnail img-circle center-block' src='user.png' alt=''/>
                                <?php echo $comment['Member']?>
                            </div>
                            <div class='col-md-10'>
                                <p class="lead"><?php echo $comment['Comment']?></p>
                            </div>
                        </div>
                    </div>
                    <hr class="custom-hr">
                <?php }?>
    </div>
<?php
} else {
    echo "<div class ='container'>";
        $themsg= "<div class='alert alert-danger'>Ther No Such Id Or Item Waiting Approval </div>";
        redirectHome($themsg,'back');
    echo "</div>";
    
}
?>
<?php include $tpl ."footer.php";
ob_end_flush(); ?>