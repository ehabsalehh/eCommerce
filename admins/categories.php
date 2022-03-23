<?php
ob_start();
session_start();
$pagetitle = "Categories";
if (isset($_SESSION['Username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] :  'manage';
    if($do == 'manage'){
        $sort = "DESC";
        $sort_array = array('ASC', 'DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
            $sort = $_GET['sort'];
        }
        $cats = getAllFrom("*", "categories", "where Parent = 0", "" ,"Ordering", "$sort"); //Not use
        /*$stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering  $sort ");
        $stmt->execute();
        $cats = $stmt->fetchAll();*/
        if(!empty($cats)){?>
            <h1 class="text-center">Mange Categorey</h1>
            <div class="container Category">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i>
                        Mange Categorey
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i>
                            Ordering:[
                                <a class="<?php if($sort == 'ASC'){echo'active';} ?>" href="?sort=ASC">ASC</a> \
                                <a  class="<?php if($sort == 'DESC'){echo'active';} ?>" href="?sort=DESC">DESC</a> ]
                                <i class="fa fa-eye"></i>
                                View:[
                                    <span class="active" data-view ="full">full</span>\
                                    <span  data-view ="classic">classic</span>]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        foreach($cats as $cat){
                            echo "<div class = 'cat'>";
                                echo "<div class ='hidden-buttons'>";
                                    echo "<a href = 'categories.php?do=Edit&catid=".$cat['ID']."'class = 'btn btn-xs btn-primary'>
                                        <i class ='fa fa-edit'></i>Edit </a>";
                                    echo "<a href = 'categories.php?do=Delete&catid=".$cat['ID']."'class = 'btn btn-xs btn-danger'>
                                        <i class ='fa fa-close'></i>Delete </a>";
                                echo "</div>";
                            echo '<h3>'. $cat['Name'] .'<h3/>';
                                echo "<div class= 'full-view'>";
                                    echo '<p>';
                                    if ($cat['Description'] == ""){
                                        echo "This Categoery Has No Description ";}else{echo $cat['Description']; } echo'<p/>';
                                    if ($cat['Visibility'] == 1){
                                        echo '<span class = "visibilty"><i class = "fa fa-eye"></i>Hidden</span>';}
                                    if ($cat['Allow_Comment'] == 1){
                                        echo  '<sapn class ="commenting"><i class ="fa fa-edit"></i>Comment Disabled</sapn>';}
                                    if ($cat['Allow_Ads'] == 1){
                                        echo '<span class = "advertises"><i class ="fa fa-close"></i>Ads Disabled</span>';}
                                echo "</div>";
                                $childCat = getAllFrom("*", "categories", "where Parent = {$cat['ID']}", "", "ID", "$sort" );
                                    if(!empty($childCat)) {
                                        echo "<h4 class= 'child-cat-head'> child category</h4>";
                                        foreach($childCat as $c){
                                            echo"<ul class = 'list-unstyled child-cat'>";
                                                echo "<li class = 'child-link'>
                                                <a href = 'categories.php?do=Edit&catid=".$c['ID']."'>".$c['Name']."</a>
                                                <a href = 'categories.php?do=Delete&catid=".$c['ID']."'class = 'show-delete'> Delete</a>
                                                </li>";
                                        }
                                echo "</ul>";
                            }
                            echo "</div>";
                            echo "<hr>";
                        }
                        ?>
                    </div>
                </div>
                <a href="categories.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add Categorey</a>
            </div>
        <?php
            
        }else {
            echo"<div class = 'container'>";
            echo "<div class ='alert alert-info'>There\'s  No Categorey To Show</div>";
            echo "<a href='categories.php?do=Add' class='add-category btn btn-primary'><i class='fa fa-plus'></i> Add Categorey</a>
            ";

            echo "<div class = 'container'>";

        }
    } elseif($do == 'Add'){//add Categories Page ?>
            <h1 class="text-center">Add New Category</h1>
            
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                        <!-- start Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control"  autocomplete="off" required = "required" placeholder ="Name Of The Catogery" />
                            </div>
                        </div>
                        <!--end Name field -->
                        <!--start Description field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="  form-control"  placeholder="Decribe The Category" />
                            </div>
                        </div>
                        <!--end Description field -->
                        <!--start Ordering field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="ordering" class="form-control"   placeholder = "Number To Arrange The Category"/>
                            </div>
                        </div>
                        <!--end ordering field -->
                        <!--start Parent field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Parent?</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="parent">
                                    <option value="0">None</option>
                                    <?php
                                    $allPcategorey = getAllFrom("*", "categories","where Parent = 0", "", "ID" , 'Asc' );
                                    foreach($allPcategorey as $cats) {
                                        echo "<option value = '".$cats['ID']."'>".$cats['Name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--end Parent field -->
                        <!--start Visible field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id ="visble-yes" type= "radio"  name= "visibility" value= "0" checked />
                                    <label for ="visble-yes">Yes</label>
                                </div>
                                <div>
                                    <input id ="visble-No" type= "radio"  name= "visibility" value= "1"  />
                                    <label for ="visble-No">No</label>
                                </div>
                                
                                
                            </div>
                        </div>
                        <!--end Visible field -->
                         <!--start Allow Commenting field -->
                         <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Aloow Commenting</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id ="com-yes" type= "radio"  name= "commenting" value= "0" checked />
                                    <label for ="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id ="com-No" type= "radio"  name= "commenting" value= "1"  />
                                    <label for ="com-No">No</label>
                                </div>
                                
                                
                            </div>
                        </div>
                        <!--end Allow Commenting field -->
                         <!--start Allow Adds field -->
                         <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id ="Ads-yes" type= "radio"  name= "Ads" value= "0" checked />
                                    <label for ="Ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id ="Ads-No" type= "radio"  name= "Ads" value= "1"  />
                                    <label for ="Ads-No">No</label>
                                </div>
                                
                                
                            </div>
                        </div>
                        <!--end Allow Addse field -->
                        <!--start submit field -->
                        <div class="form-group form-group-lg">
                            <div class=" col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                            </div>
                        </div>
                    <!--end submit field -->

                </form>
            </div>
    <?php

    } elseif ($do == 'Insert'){
        // Insert }catogery page
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Insert Catogery</h1>";
            echo "<div class = 'container'>";
            //Get The Vaiable From the from
            $name =    $_POST['name'];
            $decs =    $_POST['description'];
            $order  =  $_POST['ordering'];
            $parent =  $_POST['parent'];
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads =     $_POST['Ads'];
    
        // check if there no error procced the update operation
            // Check  If ctogery Exist In Datbase
            //$check = getAllFrom("Name", "categories", "where Name = $name");
            $check = checkItem("Name", "categories", $name);
            if($check == 1){
                echo "<div class = 'container'>";
                $themsg =  " <div class ='alert alert-danger'>sorry The Catogery Is Exist</div>";
                redirectHome($themsg, 'back');
                echo "</div>";
            } else {
            //Insert Catogery Info in Database
            
            $stmt = $con->prepare("INSERT INTO
                                    categories(Name, Description, Ordering, Parent, Visibility, Allow_Comment, Allow_Ads)
                                    VALUES (:zname, :zdesc, :zorder, :zparent, :zvisible, :zcomment, :zads) ");
                $stmt->execute(array(
                    'zname' => $name,
                    'zdesc' => $decs,
                    'zorder' => $order,
                    'zparent' => $parent,
                    'zvisible' => $visible,
                    'zcomment' => $comment,
                    'zads' => $ads
        

                ));
                // Echo Success message
                $themsg =  "<div class = 'alert alert-success'>".$stmt->rowCount(). " Catogery Inserted  </div>";
                redirectHome($themsg, 'back');
            }
        
        } else{
            echo "<div class = 'container'>";
            $themsg= "<div class = 'alert alert-danger'>Sorry you Cant Browse This Page</div>";
            redirectHome($themsg,"Back");
            echo "</div>";
        }
        echo "</div>";
    } elseif ($do == 'Edit'){
         //Check If the Get request id is numeric &Get The integer value of it

       $catid =isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;
       $stmt = $con->prepare("SELECT * FROM categories WHERE  ID = ? ");
       //execute query
      $stmt->execute(array($catid));
      //fetch the data
      $cat= $stmt->fetch();
      //The row Count
      $count = $stmt->rowCount();
      // if there is such id show the form
      if ($count > 0){?>
        
        <h1 class="text-center">Edit Category</h1>
                
        <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="catid" value="<?php echo $catid?>"/>
                <!-- start Name field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control"   required = "required" value="<?php echo $cat['Name'] ?>" />
                    </div>
                </div>
                <!--end Name field -->
                <!--start Description field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="  form-control" value="<?php echo $cat['Description'] ?>" />
                    </div>
                </div>
                <!--end Description field -->
                <!--start Ordering field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="ordering" class="form-control"   value="<?php echo $cat['Ordering'] ?>"/>
                    </div>
                </div>
                <!--end ordering field -->
                <!--start Parent field -->
                <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Parent?</label>
                            <div class="col-sm-10 col-md-6">
                                <select name="parent">
                                    <option value="0">None</option>
                                    <?php
                                    $allPcategorey = getAllFrom("*", "categories","where Parent = 0", "", "ID" , 'Asc' );
                                    foreach($allPcategorey as $c) {
                                        echo "<option value = '".$c['ID']."'";
                                            if($cat['Parent'] == $c['ID']){echo "selected";}
                                        echo ">".$c['Name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--end Parent field -->
                <!--end ordering field -->
                <!--start Visible field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visible</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id ="visble-yes" type= "radio"  name= "visibility" value= "0" <?php if ($cat['Visibility'] == 0){echo "checked";} ?> />
                            <label for ="visble-yes">Yes</label>
                        </div>
                        <div>
                            <input id ="visble-No" type= "radio"  name= "visibility" value= "1" <?php if ($cat['Visibility'] == 1){echo "checked";} ?>  />
                            <label for ="visble-No">No</label>
                        </div>
                        
                        
                    </div>
                </div>
                <!--end Visible field -->
                <!--start Allow Commenting field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Aloow Commenting</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id ="com-yes" type= "radio"  name= "commenting" value= "0" <?php if ($cat['Allow_Comment'] == 0){echo "checked";} ?> />
                            <label for ="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id ="com-No" type= "radio"  name= "commenting" value= "1" <?php if ($cat['Allow_Comment'] ==1){echo "checked";} ?>  />
                            <label for ="com-No">No</label>
                        </div>
                    </div>
                </div>
                <!--end Allow Commenting field -->
                <!--start Allow Adds field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id ="Ads-yes" type= "radio"  name= "Ads" value= "0" <?php if ($cat['Allow_Ads'] == 0){echo "checked";} ?> />
                            <label for ="Ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id ="Ads-No" type= "radio"  name= "Ads" value= "1" <?php if ($cat['Allow_Ads'] == 1){echo "checked";} ?> />
                            <label for ="Ads-No">No</label>
                        </div>
                    </div>
                </div>
                <!--end Allow Addse field -->
                <!--start submit field -->
                <div class="form-group form-group-lg">
                    <div class=" col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                    </div>
                </div>
            <!--end submit field -->

        </form>
    </div> <?php
      } else {
          echo "<div class = 'container'>";
          $themsg = "<div class = 'alert alert-danger'>Ther No Such Id</div>";
          redirectHome($themsg);
          echo "</div>";

      }
         

    } elseif ($do == 'Update'){
        echo "<h1 class='text-center'>Update Categoeries</h1>";
        echo "<div class = 'container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Get The Vaiable From the from
            $id          = $_POST['catid'];
            $name        = $_POST['name'];
            $descs = $_POST['description'];
            $order      = $_POST['ordering'];
            $parent    = $_POST['parent'];
            $visible   = $_POST['visibility'];
            $comment   = $_POST['commenting'];
            $ads       = $_POST['Ads'];

            //Update the Database with The info
            $stmt = $con->prepare( "UPDATE categories SET
                                                    Name = ?,
                                                     Description = ?,
                                                     Ordering = ?,
                                                     Parent = ?,                                                     
                                                     Visibility = ?,
                                                     Allow_Comment = ?,
                                                     Allow_Ads =?
                                                           WHERE ID = ?");
            $stmt->execute(array( $name, $descs, $order, $parent, $visible, $comment, $ads, $id));
            $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Updated </div>";
            redirectHome($themsg,"Back");
        

        } else{
            echo "div class = 'container'>";
            $themsg =  "<div class ='alert alert-danger'>Sorry you Cant Browse This Page</div>";
            redirectHome($themsg);
            echo "</div>";
        }
        echo "</div>";

    } elseif($do == 'Delete'){
        echo "<h1 class='text-center'>Delete Categoery</h1>";
        echo "<div class = 'container'>";
            //Check If the Get request catid is numeric &Get The integer value of it
            $catid =isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;
            //Select all data depend on the id
            //$check = getAllFrom("ID", "categories","where ID = $catid");
            $check = checkItem('ID', 'categories', $catid );
           
            // if theris such ID show the form
            if ($check > 0){
                $stmt =$con->prepare('DELETE FROM categories WHERE ID = :zid');
                $stmt->bindparam(':zid', $catid);
                $stmt->execute();
                $themsg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Recorded Deleted </div>";
                redirectHome($themsg,'back');
            } else {
                echo "<div class = 'container'>";
                $themsg = "<div class = 'alert alert-danger'> This ID Is Not Exist </div>";
                redirectHome($themsg);
                echo "</div>";
            }
            
      echo "</div>";

    }
    include $tpl ."footer.php";
} else{
	header('location: index.php');
    exit();
}
ob_end_flush();
?>