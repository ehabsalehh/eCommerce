<?php 
$sort = "ASC";
        $sort_array = array('ASC', 'DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
            $sort = $_GET['sort'];
        }
        $cats = getAllFrom("*", "categories", "where Parent = 0", "Ordering", "$sort");
       ?>
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
                                echo "<a href = 'categories.php?do=Edit&catid=".$cat['ID']."'class = 'btn btn-xs btn-primary'><i class ='fa fa-edit'></i>Edit </a>";
                                echo "<a href = 'categories.php?do=Delete&catid=".$cat['ID']."'class = 'btn btn-xs btn-danger'><i class ='fa fa-close'></i>Close </a>";
                            echo "</div>";
                            echo "<h3>". $cat['Name'] .'<h3/>';
                              echo "<div class = 'full-view'>";
                            echo '<p>';
                            if ($cat['Description'] == ""){
                                echo "This Categoery Has No Description ";}else{echo $cat['Description']; } echo'<p/>';
                            if ($cat['Visibility'] == 1){
                                echo '<span class = "visibilty><i class ="fa fa-eye"></i>Hidden<span/>';}
                            if ($cat['Allow_Comment'] == 1){
                                echo  '<sapn class ="commenting"><i class ="fa fa-edit"></i>Comment Disabled</sapn>';}
                            if ($cat['Allow_Ads'] == 1){
                                echo '<span class = "advertises"><i class ="fa fa-close"></i>Ads Disabled</span>';}
                            echo "<div/>";
                        echo "</div>";
                        echo "<hr>";

                    }
                     ?>
                </div>
            </div>
            <a href="categories.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add Categorey</a>


        </div>
        