<?php
$do = isset($_GET['do']) ? $_GET['do'] :  'manage'  ;

//If The Page is Main Page
if($do == 'manage'){
    echo "Welcome You Are In Manage catogery Page";
    echo "<a href = ?do=Insert>ADD New Caogery + </a>";
} elseif($do == 'Add'){
    echo "Welcome You Are In  Add Page";
} elseif ($do == 'Insert'){
    echo "welcome You Are In Insert Page";
} else {
    echo "Error Ther Is No Page With thir Name";
}

?>