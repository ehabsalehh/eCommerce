
<?php
ob_start();
session_start();
$pagetitle = "Create New Items";
include "init.php";
if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD']== 'POST'){
        $formErrors = array();
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $countery = filter_var($_POST['countery'], FILTER_SANITIZE_STRING);
        $tags = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
        $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

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
    
        if (empty($category)){
            $formErrors[] = ' Category Cant Be <strong>Emtpy</strong>';

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
                    'ztags'     =>   $tags,
                    'zstatus'   => $status,
                    'zmember'   => $_SESSION['uid'],
                    'zcategory'   => $category,
                ));
                // Echo Success message
                if($stmt){
                    $succesMsg = "Item Has Been Added";
                }
            }
    }
    ?>
    <h1 class="text-center"><?php echo $pagetitle ?></h1>
    <div class="new-ads block">
        <div class="container">
            <div class=" panel panel-primary">
                <div class="panel-heading">
                    <?php  echo $pagetitle?>
                </div>
                <div class="panel panel-body">
                    <div class='row'>
                        <div class="col-md-8">
                            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="form-group form-group-lg">
                                    <!-- start Name field -->
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" required
                                            pattern=".{4,}"
                                            title="This Field Required At Least 4 Character"
                                            name="name"
                                            class="form-control live"
                                            
                                            placeholder ="Name Of The Items"
                                            data-class=".live-title" />
                                    </div>
                                </div>
                                <!--end Name field -->
                                <!--start Description field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" required
                                                pattern=".{10,}"
                                                title="This Field Required At Least 10 Character"
                                                name="description"
                                                class=" form-control live"
                                                
                                                placeholder="Decribe The Items"
                                                data-class=".live-desc"
                                                 />
                                    </div>
                                </div>
                                <!--end Description field -->
                                <!--start price field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Price</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" required
                                                name="price"
                                                class= "form-control live"
                                                placeholder="Price of the item"
                                                data-class=".live-price" />
                                    </div>
                                </div>
                                <!--end price field -->
                                <!--start Countery field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Countery</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="text" required
                                                name="countery"
                                                class="  form-control"
                                                placeholder="Countery of made" />
                                    </div>
                                </div>
                                <!--end countery field -->
                                <!--start Tags field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Tags</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text"
                                            name="tags"
                                            class="  form-control"
                                            placeholder="Seprate with Coma(,)"
                                             />
                                </div>
                            </div>
                    <!--end countery field -->
                                <!--start status field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select  name ="status" required>
                                            <option value="">...</option>
                                            <option value="1">New</option>                                
                                            <option value="2">Used</option>
                                            <option value="3">Very Old</option>

                                        </select>
                                    </div>
                                </div>
                                <!--end status field -->
                                <!--start Categories field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label">Catogery</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select  name ="category" required>
                                            <option value="">...</option>
                                        <?php
                                        $cats = getAllFrom('*','categories','','', 'ID');
                                        foreach($cats as $cat){
                                            echo "<option value = '".$cat['ID'] ."'>".$cat['Name']."</option>";
                                        }
                                            ?>

                                        </select>
                                    
                                    </div>
                                </div>
                                <!--end Categories field -->
                            
                                <!--start submit field -->
                                <div class="form-group form-group-lg">
                                    <div class=" col-sm-offset-3 col-sm-9">
                                        <input type="submit" value="Add Items" class="btn btn-primary btn-sm" />
                                    </div>
                                </div>
                            <!--end submit field -->

                        </form>

                        </div>
                        <div class="col-md-4">
                        <div class='thumbnail item-box live-preview'>
                            <span class='price-tag'>
                                $<span class="live-price">0</span>
                            </span>
                            <img class='img-responsive' src='user.png' alt=''/>
                            <div class='caption'>
                                <h3 class="live-title">Title</h3>
                                <p class="live-desc">Description</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php
                    if(!empty($formErrors)){
                        foreach($formErrors as $error){
                            echo "<div class='alert alert-danger'>".$error."</div>";
                        }
                    }
                    if(isset($succesMsg)){
                        echo '<div class= "alert alert-success">'.$succesMsg.'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    

<?php } include $tpl ."footer.php";
ob_end_flush(); ?>
