<?php

define('DB_SERVER', 'pro.softmed.com.tr');
define('DB_USERNAME', 'softmed_user');
define('DB_PASSWORD', 'Yymsfkqx2247923@');
define('DB_DATABASE', 'softmedistekler2');
define("BASE_URL", ""); 

function getDB() 
{
	$dbhost = DB_SERVER;
	$dbuser = DB_USERNAME;
	$dbpass = DB_PASSWORD;
	$dbname = DB_DATABASE;
	try {
    	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
	    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	return $dbConnection;
    }
    catch (PDOException $e) {
        echo 'Bağlanti sağlanamadi: ' . $e->getMessage();
	}
}


function KarakterDuzelt($veri) {
    if (empty($veri)) return $veri;
    

    if (!mb_detect_encoding($veri, 'UTF-8', true)) {
        $veri = utf8_encode($veri);
    }
    // First handle the specific mappings from your original function
    $search = array("Ð","Þ","Ý","Ý","Þ","Ð","ð","ý","þ");
    $replace = array("Ğ","Ş","İ","İ","Ş","Ğ","ğ","ı","ş");

    $veri = str_replace("ð", "ğ", $veri);
    $veri = str_replace("Ð", "Ğ", $veri);
    $veri = str_replace($search, $replace, $veri);
    
    
    
    return $veri;
}
?>
