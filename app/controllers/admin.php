<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
        
        parent::__construct();
        
    }

	
	public function index()
	{
		
		 if (!$this->session->userdata('loggedin'))
        {
            
            redirect('sessions/login','refresh');
        }else{
        	$this->load->view('v_pant_principal');
        }

	}
}