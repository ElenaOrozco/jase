<?php
// Secuencia revisada
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {
    
    

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        			
        
        $this->load->model("usuarios_model");
        $data['usuario'] = $this->session->userdata('nombre');   
        $this->load->view('v_pant_principal', $data);
    }
}