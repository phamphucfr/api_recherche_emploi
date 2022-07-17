<?php

require_once ('database.php');

class dbConnexion {
    // Attributs
    private static $url = "mysql:host=".db::HOST.":".db::PORT.";dbname=".db::NAME.";charset=utf8";
    private static $user = db::USER;
    private static $pass = db::PASS;
    
    static function connect(){
        return new PDO(dbConnexion::$url, dbConnexion::$user, dbConnexion::$pass, 
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]
    );
    }
}
?>