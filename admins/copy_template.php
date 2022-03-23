<?php
/*
**
*/
ob_start();
session_start();
$pagetitle = "";
if (isset($_SESSION['Username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] :  'manage';
    if($do == 'manage'){
        echo "Welcome You Are In Manage catogery Page";
        echo "<a href = ?do=Insert>ADD New Caogery + </a>";
    } elseif($do == 'Add'){
        echo "Welcome You Are In  Add Page";
    } elseif ($do == 'Insert'){
        echo "welcome You Are In Insert Page";
    } elseif ($do == 'Edit'){

    } elseif ($do == 'Update'){

    } elseif($do == 'Delete'){

    } elseif ($do == 'Activate'){

    }
    include $tpl ."footer.php";
} else{
	header('location: index.php');
    exit();
}
ob_end_flush();
?>