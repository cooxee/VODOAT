<?php
/**  	* @package Model
	* @subpackage Login
	* @category authentication
	* @author Arjun Sharma
*/
class Login_Model extends CI_Model
{
    public $username 	= "user_name"; //field in database
    
    public $passwd   	= "user_password";//passwd field in databse
    
    public $status   	= "user_status";// if enabled or disabled in databse
    
    public $table_name 	= "vodoat_user";// table name
    
    function __construct()
    {
        parent::__construct();
	$this->load->helper('security');// for encrypting the password
    }
    /*
     *for user validation
     */
    function login($username, $password){
	log_message('error', $username." ".$password);
        $select = array($this->status);
        $this->db->select($select)
            ->where($this->username,$username)
	    ->where($this->passwd, do_hash($password))
	    ->where($this->status, 'y')
            ->from($this->table_name);                
	$q = $this->db->get();
        $result=$q->result_array();
        if(count($result)>0){
	    return true;
	}else{
	    return false;
	}
    }
    
    
    
}