
<?php
/*
* Title Function v1.0
**Title Function That can echo Tilte Page in case page
*/
function getTitle(){
    global $pagetitle;
    if(isset($pagetitle)){
        echo $pagetitle;
    } else {
        echo "Default";
    }
}
/*
**Get All Records Function v1.0
**Function To Get All Records  From Database
*/
function getAllFrom($field, $table, $where = Null, $and =NULL, $orderfield, $ordering = 'DESC'){
    global $con;
    $stmt = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
    $stmt->execute();
    $all = $stmt->fetchAll();
    return $all;
}
/*
*home Redirect Function
**themsg = Echo The  Message[errors / success / warning]
***seconds before Redirecting
*/
function redirectHome($themsg, $url = null, $seconds = 3 ){
    if($url === null){
        $url = 'index.php';
        $link= "HomePage";

    } else {
        if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER'] !== '' ){
            $url = $_SERVER['HTTP_REFERER'];
            $link = "PreviousPage";
        } else {
            $url = 'index.php';
            $link = "HomePage";
        }
    }
    echo $themsg;
    echo "<div class = 'alert alert-info'> You Will Be Redirected To  $link After $seconds second.</div> ";
    header("refresh:$seconds;url=$url");
    exit();

}



















function checkUserStatus($user){
    global $con;
    $stmt = $con->prepare("SELECT Username, Regstatus FROM users WHERE Username = ? AND Regstatus = 0 ");
    $stmt->execute(array($user));
    $count = $stmt->rowCount();
    return $count;
}


/*
**Count  Number of Items v1.0
**Function To Count Numbers of items row
**$item = The item to count
**$table = The table To choose from
*/
function countItems($item, $table){
    global $con;
    $stmt = $con->prepare("SELECT COUNT($item) FROM $table ");
    $stmt->execute();
    return $stmt->fetchColumn();
}
/*
**Get Lates Record Function v1.0
**Function To Get Latest item From Database [ users, iems , comment]
**$select = filed to select
**$table =The Table To choose from
**$order =The  Desc orderering
**$limit =number of records t get
*/
function getLatest($select, $table, $order, $limit = 5 ){
        global $con;
        $stmt = $con->prepare("SELECT $select FROM $table ORDER BY  $order DESC  LIMIT $limit");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }