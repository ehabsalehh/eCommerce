<?php
ob_start();
 include "init.php";?>
<div class="container">
    <h1 class="text-center">Show Categorey</h1>
    <div class="row">
        <?php
        $pageid = $_GET['pageid'];
        if(isset($pageid) && is_numeric($pageid)){
            $categorey = intval($pageid);
            $items = getAllFrom("*","items","where Cat_ID = {$categorey}", "AND Approve = 1", "Item_ID");
            foreach ($items as $item){
                echo"<div class='col-sm-6 col-md-3'>";
                    echo "<div class='thumbnail item-box'>";
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
    }
            ?>
        
    </div>
    
</div>


<?php include $tpl ."footer.php";

ob_end_flush();?>