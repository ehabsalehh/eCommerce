<?php
function lang ($pharse){
    static $lang = array(

        //Navbar Links
        'HOME_ADMIN'=> 'Home',
        'CATEGORES' => 'Categores',
        'ITEMS' => 'Items',
        'MEMBERS'=> 'Members',
        'COMMENTING'=> 'commenting',
       
    );
    return $lang [$pharse];
    
}
