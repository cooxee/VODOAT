<?php

/**
 *Description: User obeject for the rfid tag 
 *
 * @author    Arjun Sharma
 *
 * 
 */
class user{
    public $authorized = false;
    public $tag;
    public function __construct(){
        
    }
    /*
     *Constructor takes in the tag_id of the user object
     */
    public function settag($tag_id){
        //echo $tag_id;
        $this->tag = $tag_id;
        $this->authorize();
    }
    /*
     *the method to authorize the rfid tag
     */
    private function authorize(){
        $dbConn = new PDO("mysql:host=localhost" . ";dbname=" .DBUSER,DBNAME, DBPASSWD);
	if($dbConn){
                $sql 	= "SELECT status
                            FROM vodoat_authorized
                            WHERE tag_id=:tag
                            AND  status='y'";              
		$stmt   = $dbConn->prepare($sql);
                $stmt   -> bindParam(':tag', $this->tag);
                $stmt   -> execute();
                $rows 	= $stmt->fetchAll();
                //var_export($rows);
                //echo "the count is".count($rows);
                if(count($rows)>0){
                    $dbConn = null;
                    //echo "hello";
                    $this->authorized = true;
                }else{
                    $dbConn = null;
                }
        }else{
            $dbConn     = null;
            return false;
        }      
    }
    
}