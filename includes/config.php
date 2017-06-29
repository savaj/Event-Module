<?php 
use \PDO as PDO;
global $db_host,$db_user,$db_pass,$db_name;
$db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'dbo_event_management' ;

class Database{
	
	public  function connect()
    {
      global $db_host,$db_user,$db_pass,$db_name;
     $dsn = "mysql:dbname=".$db_name.";host=".$db_host;
         return $db= new PDO($dsn,$db_user,$db_pass);
    }
    
}


?>