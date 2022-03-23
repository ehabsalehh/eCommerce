<?php
/*
** Items Page
*/
ob_start();
session_start();
$pagetitle = "Items";
if (isset($_SESSION['Username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] :  'manage';
    if($do == 'manage'){//manage Page
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
                                      ORDER BY Item_ID DESC");
        $stmt->execute();
        //Assign To Variable
        $items = $stmt->fetchALL();
        if(!empty($items)){
    ?>
            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>Item_ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Username</td>
                            <td>Control</td>

                        </tr>
                        <?php
                        foreach($items as $item){
                            echo "<tr>";
                            echo "<td>". $item['Item_ID']. "</td>";
                            echo "<td>". $item['Name']. "</td>";
                            echo "<td>". $item['Description']. "</td>";
                            echo "<td>". $item['Price']. "</td>";
                            echo "<td>" . $item['Add_Date']."</td>";
                            echo "<td>" . $item['category_name']."</td>";
                            echo "<td>" . $item['Username']."</td>";
                            echo "<td>
                            <a href='items.php?do=Edit&itemid=". $item['Item_ID']."'
                            class='btn btn-success'>
                            <i class ='fa fa-edit'></i>Edit</a>

                            <a href='items.php?do=Delete&itemid=". $item['Item_ID']."'
                            class='btn btn-danger confirm'>
                            <i class ='fa fa-close'></i>Delete </a>";

                            if($item['Approve'] == 0){
                                echo"<a href='items.php?do=Approve&itemid=". $item['Item_ID']."'
                                class='btn btn-info activate'>
                                <i class ='fa fa-check'></i>Approve</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>

                    </table>
                </div>
                <a href = 'items.php?do=Add' class="btn  btn-sm btn-primary"><i class="fa fa-plus"></i> New Items</a>

            </div>
                    <?php } else {
                        echo"<div class = 'container'>";
                            echo "<div class ='alert alert-info'>There\'s  No Items To Show</div>";
                            echo "<a href = 'items.php?do=Add' class='btn  btn-sm btn-primary'><i class='fa fa-plus'></i> New Items</a>";

                        echo "<div class = 'container'>";
                    } ?>
    <?php
    } elseif($do == 'Add'){//add Categories Page ?>
        <h1 class="text-center">Add New Items</h1>
        
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">
                    <!-- start Name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                     name="name"
                                    class="form-control"
                                    placeholder ="Name Of The Items" />
                        </div>
                    </div>
                    <!--end Name field -->
                    <!--start Description field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                    name="description"
                                     class="  form-control"
                                       placeholder="Decribe The Items" />
                        </div>
                    </div>
                    <!--end Description field -->
                    <!--start price field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                    name="price"
                                     class="  form-control"
                                       placeholder="Price of the item" />
                        </div>
                    </div>
                    <!--end price field -->
                    
                    <!--start Countery field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Countery</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                    name="countery"
                                     class="  form-control"
                                       placeholder="Countery of made" />
                        </div>
                    </div>
                    <!--end countery field -->
                    <!--start Tags field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Tags</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                    name="tags"
                                     class="  form-control"
                                       placeholder="Seprate with Coma(,)" />
                        </div>
                    </div>
                    <!--end Tags field -->
                     <!--start status field -->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name ="status">
                                <option value="0">...</option>
                                <option value="1">New</option>                                
                                <option value="2">Used</option>
                                <option value="3">Very Old</option>

                            </select>
                        
                        </div>
                    </div>
                    <!--end status field -->
                    <!--start members field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name ="member">
                                <option value="0">...</option>
                               <?php
                               $users = getAllFrom("*", "users", "", "",  "UserID" );
                               foreach($users as $user){
                                   echo "<option value = '".$user['UserID'] ."'>".$user['Username']."</option>";
                               }
                                ?>

                            </select>
                        
                        </div>
                    </div>
                    <!--end members field -->
                    <!--start Categories field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Catogery</label>
                        <div class="col-sm-10 col-md-6">
                            <select  name ="category">
                                <option value="0">...</option>
                               <?php
                               $allCat = getAllFrom("*", "categories", "where Parent = 0", "" , "ID" );
                               foreach($allCat as $cat){
                                   echo "<option value = '".$cat['ID'] ."'>".$cat['Name']."</option>";
                                   $childCat = getAllFrom("*", "categories", "where Parent = {$cat['ID']}", "" , "ID" );
                                    foreach($childCat as $child){
                                   echo "<option value = '".$child['ID'] ."'>--".$child['Name']."</option>";
                                }
                               }
                                ?>

                            </select>
                        
                        </div>
                    </div>
                    <!--end Categories field -->
                
                    <!--start submit field -->
                    <div class="form-group form-group-lg">
                        <div class=" col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Items" class="btn btn-primary btn-sm" />
                        </div>
                    </div>
                <!--end submit field -->

            </form>
        </div>
<?php
    } elseif ($do == 'Insert'){// Insert Member page
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Insert Items</h1>";
            echo "<div class = 'container'>";
            //Get The Vaiable From the from
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $countery =$_POST['countery'];
            $tags =$_POST['tags'];            
            $status =$_POST['status'];
            $member =$_POST['member'];
            $cat =$_POST['category'];



    
           // validae the form
           
           $formErrors = array();

        if (empty($name)){
            $formErrors[] = ' Name Cant Be <strong>Emtpy</strong>';

        }
        if (empty($desc)){
            $formErrors[] = ' Description Cant Be <strong>Emtpy</strong>';
        }
        
         if (empty($price)){
            $formErrors[] = ' Price Cant Be <strong>Emtpy</strong>';


        }
        if (empty($countery)){
            $formErrors[] = ' Countery Cant Be <strong>Emtpy</strong>';

        }
        if ($status == 0){
            $formErrors[] = ' You Must Choose The <strong>Status</strong>';

        }
        if (empty($member)){
            $formErrors[] = ' Member Cant Be <strong>Emtpy</strong>';

        }
        if (empty($cat)){
            $formErrors[] = ' Category Cant Be <strong>Emtpy</strong>';

        }
        
        // loop into array and echo it
        foreach($formErrors as $errors){
            echo  '<div class = "alert alert-danger">' .$errors . '</div>' ;
        }
        // check if there no error procced the update operation
        if(empty($formErrors)){
            
             
            //Insert User Info In Database
            
            $stmt = $con->prepare("INSERT INTO
                                    items(Name, Description, Price, Countery_Made, Tags, Status, Add_Date, Member_ID, Cat_ID )
                                    VALUES (:zname, :zdesc, :zprice, :zcountery, :ztags, :zstatus, now(), :zmember, :zcategory)");
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zprice'    => $price,
                    'zcountery' => $countery,
                    'ztags'     =>  $tags,
                    'zstatus'   => $status,
                    'zmember'   => $member,
                    'zcategory'   => $cat,

                ));
                // Echo Success message
                $themsg =  "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Inserted  </div>";
                redirectHome($themsg, 'back');
            }
        

        } else{
            echo "<div class = 'container'>";
            $themsg= "<div class = 'alert alert-danger'>Sorry you Cant Browse This Page</div>";
            redirectHome($themsg);
            echo "</div>";
        }
        echo "</div>";
    } elseif ($do == 'Edit'){
        //Edit Page
        //Check If the Get request id is numeric &Get The integer value of it

       $itemid =isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0;
       $stmt = $con->prepare("SELECT * FROM items WHERE  Item_ID = ?  ");
       //execute query
      $stmt->execute(array($itemid));
      //fetch the data
      $item= $stmt->fetch();
      //The row Count
      $count = $stmt->rowCount();
      
      // if theris such id show the form
      if ($count > 0){//add Categories Page ?>
            <h1 class="text-center"> Edit Items</h1>
            
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid?>"/>
                        <!-- start Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder ="Name Of The Items"
                                        value="<?php echo $item['Name'] ?>" />
                            </div>
                        </div>
                        <!--end Name field -->
                        <!--start Description field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text"
                                        name="description"
                                        class="  form-control"
                                        placeholder="Decribe The Items"
                                        value="<?php echo $item['Description'] ?>" />
                            </div>
                        </div>
                        <!--end Description field -->
                        <!--start price field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text"
                                        name="price"
                                        class="  form-control"
                                        placeholder="Price of the item"
                                        value="<?php echo $item['Price'] ?>" />
                            </div>
                        </div>
                        <!--end price field -->
                        <!--start Countery field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Countery</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text"
                                        name="countery"
                                        class="  form-control"
                                        placeholder="Countery of made"
                                        value="<?php echo $item['Countery_Made'] ?>" />
                            </div>
                        </div>
                        <!--end countery field -->
                        <!--start Tags field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Tags</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text"
                                        name="tags"
                                        class="  form-control"
                                        placeholder="Seprate with Coma(,)"
                                        value="<?php echo $item['Tags'] ?>" />
                            </div>
                        </div>
                    <!--end countery field -->
                        <!--start status field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select  name ="status">
                                    <option value="1"<?php if($item['Status'] == 1){echo "selected";} ?>>New</option>
                                    <option value="2" <?php if($item['Status'] == 2){echo "selected";} ?>>Used</option>
                                    <option value="3" <?php if($item['Status'] == 3){echo "selected";} ?>>Very Old</option>

                                </select>
                            
                            </div>
                        </div>
                        <!--end status field -->
                        <!--start members field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select  name ="member">
                                <?php
                                $users = getAllFrom("*", "users", "", "", "UserID" );
                                foreach($users as $user){
                                    echo "<option value = '".$user['UserID'] ."'";
                                    if($item['Member_ID'] == $user['UserID']){echo "selected";}
                                    echo">".$user['Username']."</option>";
                                }
                                    ?>

                                </select>
                            
                            </div>
                        </div>
                        <!--end members field -->
                        <!--start Categories field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Catogery</label>
                            <div class="col-sm-10 col-md-6">
                                <select  name ="category">
                                  <?php
                                  $cats = getAllFrom("*", "categories", "", "", "ID");
                                foreach($cats as $cat){
                                    echo "<option value = '".$cat['ID'] ."'";
                                    if($item['Cat_ID'] == $cat['ID']){echo "selected";}
                                    echo">".$cat['Name']."</option>";
                                }
                                    ?>

                                </select>
                            
                            </div>
                        </div>
                        <!--end Categories field -->
                    
                        <!--start submit field -->
                        <div class="form-group form-group-lg">
                            <div class=" col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Items" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    <!--end submit field -->

                </form>
                <?php
                $stmt = $con->prepare("SELECT
                                comments.*,  users.Username AS Member
                            FROM
                                comments
                            INNER JOIN
                            users
                            ON
                            users.UserID = comments.User_ID
                            WHERE Item_ID = ?");
        $stmt->execute(array($itemid));
        //Assign To Variable
        $rows = $stmt->fetchALL();
        if(!empty($rows)){
    ?>
        <h1 class="text-center">Manage [<?php echo $item['Name'] ?> ]Comments</h1>
        
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <td>Comment</td>
                    <td>User Name</td>
                    <td>Added Date</td>
                    <td>Control</td>

                </tr>
                <?php
                foreach($rows as $row){
                    echo "<tr>";
                    echo "<td>". $row['Comment']. "</td>";
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
            <?php } ?>

        
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
        echo "<h1 class='text-center'>Update Items</h1>";
        echo "<div class = 'container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Get The Vaiable From the from
            $id = $_POST['itemid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $countery =$_POST['countery'];
            $tags = $_POST['tags'];
            $status =$_POST['status'];
            $cat = $_POST['category'];
            $member =$_POST['member'];
        
           $formErrors = array();

           if (empty($name)){
               $formErrors[] = ' Name Cant Be <strong>Emtpy</strong>';
   
           }
           if (empty($desc)){
               $formErrors[] = ' Description Cant Be <strong>Emtpy</strong>';
           }
           
            if (empty($price)){
               $formErrors[] = ' Price Cant Be <strong>Emtpy</strong>';
   
   
           }
           if (empty($countery)){
               $formErrors[] = ' Countery Cant Be <strong>Emtpy</strong>';
   
           }
           if ($status == 0){
               $formErrors[] = ' You Must Choose The <strong>Status</strong>';
   
           }
           if (empty($member)){
               $formErrors[] = ' Member Cant Be <strong>Emtpy</strong>';
   
           }
           if (empty($cat)){
               $formErrors[] = ' Category Cant Be <strong>Emtpy</strong>';
   
           }
           
           // loop into array and echo it
           foreach($formErrors as $errors){
               echo  '<div class = "alert alert-danger">' .$errors . '</div>' ;
           }
        // check if there no error procced the update operation
        if(empty($formErrors)){
            //Update the Database with The info
            $stmt = $con->prepare( "UPDATE
                                    items
                                     SET
                                      Name = ?,
                                        Description = ?,
                                         Price = ?,
                                          Countery_Made = ?,
                                          Tags = ?,
                                           Status = ?, Cat_ID = ?,
                                            Member_ID = ?
                                              WHERE Item_ID = ?");
            $stmt->execute(array($name, $desc, $price, $countery, $tags, $status, $cat, $member, $id));
            $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Updated </div>";
            redirectHome($themsg,"Back");
        }

        } else{
            echo "div class = 'container'>";
            $themsg =  "<div class ='alert alert-danger'>Sorry you Cant Browse This Page</div>";
            redirectHome($themsg);
            echo "</div>";
        }
        echo "</div>";
        

    } elseif($do == 'Delete'){// Delete Members page
        echo "<h1 class='text-center'>Delete Ittems</h1>";
        echo "<div class = 'container'>";

            //Check If the Get request id is numeric &Get The integer value of it
            $itemid =isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0;
            //Select all data depend on the id
            $check = checkItem('Item_ID', 'items', $itemid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('DELETE FROM items WHERE Item_ID = :zitem');
                $stmt->bindparam(':zitem', $itemid);
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

    } elseif ($do == 'Approve'){
        echo "<h1 class='text-center'> Approve Item</h1>";
        echo "<div class = 'container'>";

            //Check If the Get request id is numeric &Get The integer value of it
            $itemid =isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0;
            //Select all data depend on the id
            $check = checkItem('Item_ID', 'items', $itemid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('UPDATE items SET Approve = 1 WHERE Item_ID = ?');
                $stmt->execute(array($itemid));
                $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Approved </div>";
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
ob_end_flush();
?>