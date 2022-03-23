
<?php
ob_start();
session_start();
$pagetitle = "Home Page";
include "init.php";?>
<div class="container">
    <div class="row">
        <?php
        $items = getAllFrom('*', 'items','', '', 'Item_ID',);
        foreach ($items as $item){
            echo"<div class='col-sm-6 col-md-3'>";
                echo "<div class='thumbnail item-box'>";
                    echo "<span class='price-tag'>$".$item['Price']."</span>";
                    if($item['Approve'] == 0){
                        echo "<span class='approve-status'> ddd</span>";

                    }
                    
                    echo"<img class='img-responsive ' src='user.png' alt=''/>";
                    echo "<div class='caption'>";
                        echo "<h3><a href ='items.php?itemid=".$item['Item_ID']."'>".$item['Name']."</a></h3>";
                        echo "<p>".$item['Description']."</p>";
                        echo "<div class ='date'>".$item['Add_Date']."</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
            ?>
    </div>
</div>
<?php
 include $tpl ."footer.php";
 ob_end_flush() ;?>