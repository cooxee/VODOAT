<?php
/**
 *Description: This class has methods to get the last tag that
 *		authenticated and adds the data to the database
 *		if the tag tries to authenticate for logging
 *
 * @author    Arjun Sharma
 *
 * 
 */
include_once('db.php');
class rfid{
    public $lastid;
    public function __construct(){
        $this->setlast();
    }
    /*
     *sets the last tag that was authenticated in the system
     */
    private function setlast(){
        $myFile         = "test.txt";
        $lines          = file('/var/www/rfid/test.txt');//file in to an array
        $this->lastid   = $lines[0];
    }
    /*
     *add the log of the authenticating tag
     */
    public function add_database($tag_id){
        //echo "recieved tag:". $tag_id;
        $dbConn = new PDO("mysql:host=localhost" . ";dbname=" .DBUSER,DBNAME, DBPASSWD);
	if($dbConn){
                $sql 	= "INSERT INTO vodoat_rfid VALUES('', :tag ,NOW())";              
		$stmt   = $dbConn->prepare($sql);
                $stmt   -> bindParam(':tag', $tag_id);
                $stmt   -> execute();
                $dbConn = null;
		return true;
        }else{
            $dbConn     = null;
            return false;
        }        
    }
    
}