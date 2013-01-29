<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**  	* @package Controller
	* @subpackage admin control
	* @category Category
	* @author Arjun Sharma
*/
class Admin_Controller extends MY_Controller {
	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','user');
	}

	public function index()
	{
		$data = $this->user->request_fancy_table();
		$this->chat_pat('admin',$data);	
	}
	/*
	 *Getting form for adding user
	 */
	public function add_user(){
		$data = $this->user->get_adduser();
		$form = $this->load->view('/forms/adduser',$data);
		echo $form;
		return;
		//$this->chat_pat('/forms/adduser',$data);
	}
	/*
	 * For saving the new  user
	 *
	 */
	public function save_user(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="feedback_box error">', '</div>');
		$this->form_validation->set_rules('tag_id', 'tag_id', 'required');
		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('car_model', 'Car Model', 'required');
		$this->form_validation->set_rules('start_time', 'Start Time', 'required');
		$this->form_validation->set_rules('end_time', 'End Time', 'required');
		$data = $this->input->post();
		if ($this->form_validation->run() == FALSE)
		{
			$this->setmessage("Something Went Wrong");
			//$this->index();
			redirect('admin_controller');
		}else{
			$result = $this->user->saveuser($data);
			if($result){
				$this->setmessage("Successfully Saved User");
			}else{
				$this->setmessage("Something went wrong while saving data");
			}
			redirect('admin_controller');
		}
		
	}
	/*
	 *Updating the user
	 */
	public function update_user(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="feedback_box error">', '</div>');
		$this->form_validation->set_rules('tag_id', 'tag_id', 'required');
		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('car_model', 'Car Model', 'required');
		$this->form_validation->set_rules('start_time', 'Start Time', 'required');
		$this->form_validation->set_rules('end_time', 'End Time', 'required');
		$data = $this->input->post();
		if ($this->form_validation->run() == FALSE)
		{
			$this->setmessage("Something Went Wrong");
			//$this->index();
			redirect('admin_controller');
		}else{
			$result = $this->user->updateuser($data);
			if($result){
				$this->setmessage("Successfully Updated User");
			}else{
				$this->setmessage("Something went wrong while updating data");
			}
			redirect('admin_controller');
		}
		
	}
	
	/*
	 *Disable the user
	 */
	
	public function user_disable(){
		$item 	= $this->uri->segment(3);
		if($this->user->disable($item)){
			$this->setmessage("Successfully Disabled");
		}else{
			$this->setmessage("Failed to Disable");
		}
		redirect('admin_controller');
	}
	/*
	 *enable the user
	 */
	public function user_enable(){
		$item 	= $this->uri->segment(3);
		if($this->user->enable($item)){
		    $this->setmessage("Successfully Enabled");
		}else{
		     $this->setmessage("Failed to Enable");	
		}
		redirect('admin_controller');
	}
	/*
	 *disable the user
	 */
	public function user_delete(){
		$item 	= $this->uri->segment(3);
		if($this->user->delete($item)){
			$this->setmessage("Successfully Deleted User");
		}else{
			$this->setmessage("Failed to Delete");
		}
		redirect('admin_controller');
	}
	/*
	 *get form to edit the user
	 */
	public function edit_user(){
		$item = $this->uri->segment(3);
		log_message('error',$item);
		$data = $this->user->get_edituser($item);
		$form = $this->load->view('/forms/adduser',$data);
		echo $form;
		return;
		
	}
	
	
	
}