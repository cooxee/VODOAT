<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extend the Core Controller 
 */

class MY_Controller extends CI_Controller
{
    public $header 		= "template/header";
    
    public $footer 		= "template/footer";
    
    public $default_view 	= "default_view";
    
    public $data		= array();

    public $view_data = array();
    
    public $do_authentication = true;
    
    public function __construct()
	{    	
        parent::__construct();
        //check if user is already authenticated
        if(!$this->do_authentication){
	    
        }else{
			//$username=;
			//log_message('error',"chai ".strtolower( $this->router->class ) );
			if(!$this->session->userdata('username')){
				$allowed = 'admin_controller';
				log_message('error',"lalala ".var_export($allowed,true) );
				if(!($allowed!= $this->router->class))
				{
					redirect('login_controller');
				}	
			}
		
		}
        
    }
    /*
     *The function takes in the view name and the data
     *adds up the header and footer automatically  
     *
     *
     */
    public function chat_pat($view=null, $data=null, $menu=false)
    {
        $this->data = $data;
        $this->view_data['header'] 		= $this->load->view($this->header, null, true);
    		
    		// Set the footer
    	$this->view_data['footer'] 		= $this->load->view($this->footer, null, true);
		
		
			if($this->session->userdata('usertype')){
			    $this->view_data['menu']	= $this->load->view('template/adminmenu',null, true);
			}else{
			    $this->view_data['menu']	= $this->load->view('template/menu',null, true);	
			}
		
    		// Set the content
		
        $this->view_data['content'] = $this->load->view($view, $this->data, true);
        
        log_message('error', 'Before the chat_pat');
        
        $this->load->view($this->default_view,$this->view_data); 
    
    }
    
    public function setmessage($message){
	$this->session->set_flashdata('result', $message);
    }
    
    
}