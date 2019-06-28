<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nosotros extends CI_Controller {

	public function __construct() {
        
        parent::__construct();
        
    }

	
	public function index()
	{
		$this->load->model('productos_model');
		$data['categorias'] = $this->productos_model->listar_categorias();
		$this->load->view('v_nosotros', $data);
	}
}