<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends CI_Controller {

	public function __construct() {
        
        parent::__construct();
        
    }

	
	public function index()
	{
		$some_var = '';
		if ($some_var == '')
		{
		        log_message('error', 'Some variable did not contain a value.');
		}
		else
		{
		        log_message('debug', 'Some variable was correctly set');
		}

		log_message('info', 'The purpose of some variable is to provide some value.');
	}
}


