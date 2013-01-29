<?php
/**  	* @package Model
	* @subpackage User Info
	* @category User 
	* @author Arjun Sharma
*/
class User_Model extends CI_Model
{
    public $tag_id 	= "tag_id";// tag number
    
    public $fname   	= "fname";// fname of user
    
    public $lname       = "lname";// last name of user
    
    public $car_model   = "car_model";// car model registered
    
    public $wnumber     = "wnumber";// wumber in databse
    
    public $start_time  = "start_time";// time from which authentication starts
    
    public $end_time    =  "end_time";// time at which autentication ends
    
    public $status   	= "status";// status of user
    
    public $table_name 	= "vodoat_authorized";// table name
    
    function __construct()
    {
        parent::__construct();
    }
    /*
     *get user list
     */
    function getuser($filter='y'){
        $select = array($this->tag_id,$this->car_model,$this->fname, $this->lname);
        $this->db->select($select)
            ->from($this->table_name)
	    ->where($this->status,$filter);               
	$q = $this->db->get();
        $result=$q->result_array();
	return $result;   
    }
    /*
     *getting edit form
     *
     */
    function getedit($tag){
        $select = array($this->tag_id,$this->car_model,$this->fname, $this->lname,$this->end_time,$this->start_time,$this->wnumber);
        $this->db->select($select)
		 ->from($this->table_name)
		 ->where($this->tag_id,$tag);               
	$q = $this->db->get();
        $result=$q->result_array();
	return $result[0];   
    }
    

    function getusertable(){
		$this->load->library('table');
		$this->table->set_heading('Id', 'Tag ID', 'Car Model', 'First Name', 'Last Name','Action');
		$category=$this->getuser();
    }
    /*
     *enable a category
     */
    function enable($tag_id){
	    //enable in the cat table
	    $this->db->where($this->tag_id, $tag_id);
	    return $this->db->update($this->table_name, array($this->status => 'y'));
	    // enable all the associated subcat
    }
    /*
     *disable a user
     */
    function disable($tag_id){
	    //enable in the cat table
	    $this->db->where($this->tag_id, $tag_id);
	    return $this->db->update($this->table_name, array($this->status => 'n'));
    }
    
    /*
     *deleted a user
     */
    function delete($tag_id){
	    //enable in the cat table
	    $this->db->where($this->tag_id, $tag_id);
	    return $this->db->update($this->table_name, array($this->status => 'd'));
    }
    /*
     *get the user table
     *
     */
    function table($filter='enable'){
	    $return= array();
	    $list 					= ($filter == 'enable') ? $this->getuser('y') : $this->getuser('n');
	    $i						= 1;
	    foreach($list as $item){
		    $edit['text']		 	= 'Edit';
		    $edit['href']		 	= '/admin_controller/user_edit/'.$item[$this->tag_id];
		    $edit['attr']			= array(
									    'class' => 'edit_user',
									    'is_ajax' => 'yes'
								    );
		    if($filter=='disable'){
			    $enable['text'] 	= 'Enable';
			    $enable['href'] 	= '/admin_controller/user_enable/'.$item[$this->tag_id];
			    $enable['attr']		= array(
									    'class' => 'enable_user',
									    'is_ajax' => 'no'
								    );
			    $disable['text'] 	= 'Delete';
			    $disable['href'] 	= '/admin_controller/user_delete/'.$item[$this->tag_id];
			    $disable['attr']		= array(
									    'class' => 'delete_user',
									    'is_ajax' => 'no'
								    );
			    $item['link']		= anchor($edit['href'], $edit['text'], $edit['attr']).' '.
								      anchor($enable['href'], $enable['text'], $enable['attr']).' '.
								      anchor($disable['href'], $disable['text'], $disable['attr']);
				    
		    }else if($filter == 'enable'){
			    $disable['text'] 	= 'Disable';
			    $disable['href'] 	= '/admin_controller/user_disable/'.$item[$this->tag_id];
			    $disable['attr']		= array(
									    'class' => 'disable_user',
									    'is_ajax' => 'no'
								    );
			    $item['link']		= anchor($edit['href'], $edit['text'], $edit['attr']).' '.
								      anchor($disable['href'], $disable['text'], $disable['attr']);
		    }
			    //$item['id']=$i++;
			    $return[]= $item;
		    //log_message('error','this is the place'. var_export($item,true));
	    }
	    return $return;
    }
    /*
     *gets the table
     *
     */
    public function request_fancy_table(){
		$this->load->library('table');
		 $form_args = array(
			'name'  =>	'manage_use',
 			'id'	=>  	'manage_use'
		);
		 $this->table->set_template(array('table_open'=> "<table class='data_table'>")); 
		$ecategories 					= $this->table('enable');
		$dcategories 					= $this->table('disable');
		$this->table->set_heading('Tag ID', 'Car Model', 'First Name', 'Last Name', 'Action');
		$return=array();
		$return['open']				    = form_open('', $form_args);
		if(count($ecategories)>0){
		$return['enabletable']			= $this->table->generate($ecategories);
		}
		$this->table->clear();
		log_message('error',count($dcategories));
		if(count($dcategories)>0){
		    $this->table->set_heading('Tag ID', 'Car Model', 'First Name', 'Last Name','Action');
		    $return['disabletable']			= $this->table->generate($dcategories); 
		}
			
		$return['close']                = form_close();
		//$return['addcategory'] 			= $this->request_addcategory();
		return $return;
    }
    /*
     *
     *gets add user form
     */
    public function get_adduser(){
	$tomorrow = mktime(0, 0, 0, date("y"), date("m"), date("d")+1);
	$form_args = array(
			'name'  	=>	'add_user',
 			'id'		=>  	'add_user',
			'is_ajax' 	=>      'yes'
			);
	$tag_args = array(
			'name'	=>	'tag_id',
			'id'	=> 	'tag_id',
			'required' =>    '',
			);
	$fname_args = array(
			'name'	=>	'fname',
			'id'	=> 	'fname',
			'required' =>    '',
			);
	$lname_args = array(
			'name'	=>	'lname',
			'id'	=> 	'lname',
			'required' =>    '',
			);
	$carname_args = array(
			'name'	=>	'car_model',
			'id'	=> 	'car_model',
			'required' =>    '',
			);
	$starttime_args = array(
			'name'	=>	'start_time',
			'id'	=> 	'start_time',
			'class' => 	'dp',
			'value' =>	date('Y-m-d'),
			'required' =>    '',
			);
	$endtime_args = array(
			'name'	=>	'end_time',
			'id'	=> 	'end_time',
			'class' =>	'dp',
			'value' =>	date("Y-m-d", $tomorrow),
			'required' =>    '',
			);
	$wnumber_args = array(
			'name'	=>	'wnumber',
			'id'	=> 	'wnumber',
			'required' =>    '',
			);
	//$js = 'h = "aa" required';
	$return['open']   		= form_open('/admin_controller/save_user', $form_args);
	$return['tag_id']['label'] 	= form_label('Tag Number: ', $tag_args['id']);
	$return['tag_id']['input']	= form_input($tag_args);
	$return['fname']['label'] 	= form_label('First Name: ', $fname_args['id']);
	$return['fname']['input']	= form_input($fname_args);
	$return['lname']['label'] 	= form_label('Last Name: ', $lname_args['id']);
	$return['lname']['input']	= form_input($lname_args);
	$return['wnumber']['label'] 	= form_label('Wnumber: ', $wnumber_args['id']);
	$return['wnumber']['input']	= form_input($wnumber_args);
	$return['carmodel']['label'] 	= form_label('Carmodel: ', $carname_args['id']);
	$return['carmodel']['input']	= form_input($carname_args);
	$return['start_time']['label'] 	= form_label('Start Date: ', $starttime_args['id']);
	$return['start_time']['input']	= form_input($starttime_args);
	$return['end_time']['label'] 	= form_label('End Date: ', $endtime_args['id']);
	$return['end_time']['input']	= form_input($endtime_args);
	$return['submit']		= form_submit('mysubmit', 'Add User');
	$return['close']		= form_close();    
	return $return;
    }
    /*
     *gets edit user form
     *
     */
     public function get_edituser($tag){
	$data = $this->getedit($tag);
	log_message('error',var_export($data,true));
	$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
	$form_args = array(
			'name'  	=>	'add_user',
 			'id'		=>  	'add_user',
			'is_ajax' 	=>      'yes'
			);
	$tag_args = array(
			'name'	=>	'tag_id',
			'id'	=> 	'tag_id',
			'required' =>    '',
			'value'	   =>    $data['tag_id'],
			);
	$fname_args = array(
			'name'	=>	'fname',
			'id'	=> 	'fname',
			'required' =>    '',
			'value'	   =>    $data['fname'],
			);
	$lname_args = array(
			'name'	=>	'lname',
			'id'	=> 	'lname',
			'required' =>    '',
			'value'	   =>    $data['lname'],
			);
	$carname_args = array(
			'name'	=>	'car_model',
			'id'	=> 	'car_model',
			'required' =>    '',
			'value'	   =>    $data['car_model'],
			);
	$starttime_args = array(
			'name'	=>	'start_time',
			'id'	=> 	'start_time',
			'class' => 	'dp',
			'required' =>    '',
			'value'	   =>    $data['start_time'],
			);
	$endtime_args = array(
			'name'	=>	'end_time',
			'id'	=> 	'end_time',
			'class' =>	'dp',
			//'value' =>	date("Y-d-m", $tomorrow),
			'required' =>    '',
			'value'	   =>    $data['end_time'],
			);
	$wnumber_args = array(
			'name'	=>	'wnumber',
			'id'	=> 	'wnumber',
			'required' =>    '',
			'value'	   =>    $data['wnumber'],
			);
	//$js = 'h = "aa" required';
	$return['open']   		= form_open('/admin_controller/update_user', $form_args);
	$return['tag_id']['label'] 	= form_label('Tag Number: ', $tag_args['id']);
	$return['tag_id']['input']	= form_input($tag_args);
	$return['fname']['label'] 	= form_label('First Name: ', $fname_args['id']);
	$return['fname']['input']	= form_input($fname_args);
	$return['lname']['label'] 	= form_label('Last Name: ', $lname_args['id']);
	$return['lname']['input']	= form_input($lname_args);
	$return['wnumber']['label'] 	= form_label('Wnumber: ', $wnumber_args['id']);
	$return['wnumber']['input']	= form_input($wnumber_args);
	$return['carmodel']['label'] 	= form_label('Carmodel: ', $carname_args['id']);
	$return['carmodel']['input']	= form_input($carname_args);
	$return['start_time']['label'] 	= form_label('Start Date: ', $starttime_args['id']);
	$return['start_time']['input']	= form_input($starttime_args);
	$return['end_time']['label'] 	= form_label('End Date: ', $endtime_args['id']);
	$return['end_time']['input']	= form_input($endtime_args);
	$return['submit']		= form_submit('mysubmit', 'Update User');
	$return['close']		= form_close();    
	return $return;
    }
    
    /*
    *saves the user
    */
    public function saveuser($data){
	foreach($data as $key => $item){
		    if($key != 'mysubmit'){
			$sqldata[$key] = $item; 
		    }	    
	}
	$sqldata['status'] = 'y';
	return $this->db->insert($this->table_name,$sqldata);
	
    }
    /*
     *
     *updates the user
     */
    public function updateuser($data){
	foreach($data as $key => $item){
		    if($key != 'mysubmit'){
			if($key != 'tag_id'){
			    $sqldata[$key] = $item;
			}
		    }	    
	}
	$sqldata['status'] = 'y';
	$this->db->where($this->tag_id, $data['tag_id']);
	return $this->db->update($this->table_name, $sqldata); 
    }
    
}