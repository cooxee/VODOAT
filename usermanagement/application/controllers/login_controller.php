<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller extends MY_Controller {
/**  	* @package Controller
	* @subpackage login control
	* @category authentication
	* @author Arjun Sharma
*/	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model','login');
		
	}

	public function index()
	{
		$this->chat_pat('index');
		
	}
	
	/*
	 *method for authenticating the user
	 *
	 */
	
	public function login(){
		$username = strtolower($this->input->post('username'));
		$password = $this->input->post('password');
		$this->form_validation->set_error_delimiters("<div class='feedback_box error' style='margin-left:300px;'>", '</div>');
		$this->form_validation->set_rules('username', 'username', 'trim|required|exact_length[8]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE) {
			$auth= $this->login->login($username, $password);
			if($auth) {
				//$usertype = 'admin';
				$username = $username;
				$this->session->set_userdata('username', $username);
				//$this->session->set_userdata('fullname', $fullname);
				$this->session->set_userdata('usertype', 'admin');
				$this->setmessage('Successfully logged In ');
				redirect(admin_controller/index);
			} else {
				$data['message'] = "Invalid Username or Password";
				$this->chat_pat('index', $data);
			}
		} else {
			$this->chat_pat('index');
		}
	}
	/*
	 *for logging out
	 */
	function logout()
	{
		$this->session->sess_destroy();
		$this->setmessage('Successfully logged out ');
		redirect('');//$this->load->view('index');
	}
}

