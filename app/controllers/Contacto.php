<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends CI_Controller {

	public function __construct() {
        
        parent::__construct();
        
    }

	
	public function index()
	{
		$this->load->model('productos_model');
		$ciudades =  $this->productos_model->listar_ciudades();
		$retorno = array();
		foreach ($ciudades->result() as $ciudad) {
			$datos['ciudad'] = $ciudad->Ciudad;
			$datos['representantes'] =$this->productos_model->listar_representantes_ciudad($ciudad->Ciudad);
			$retorno[] = $datos;
		}
		$data['aDatos'] = $retorno;
		$this->load->view('v_contacto', $data);
	}


	
    public function clean_string($string) {
		$bad = array("content-type","bcc:","to:","cc:","href");
		return str_replace($bad,"",$string);
	}

    private function validar_formulario($error_message){

    	//Verificar que no vengan vacios
    	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    	
    	if(!preg_match($email_exp,$email_from)) {
			$error_message .= 'La dirección de correo proporcionada no es válida.<br />';
		}

		//En esta parte se validan las cadenas de texto
		$string_exp = "/^[A-Za-z .'-]+$/";

		if(!preg_match($string_exp,$first_name)) {
		    $error_message .= 'El formato del nombre no es válido<br />';
		}

		if(!preg_match($string_exp,$last_name)) {
			$error_message .= 'el formato del apellido no es válido.<br />';
		}

		if(strlen($message) < 2) {
			$error_message .= 'El formato del texto no es válido.<br />';
		}

		 
		return $error_message;
		/*
		  if(strlen($error_message) > 0) {

		 

		    die($error_message);

		 

		  }*/
    }

	public function enviar_mensaje(){

		$email_to = "atencionaclientes@noble-jase.com";
		$email_cc = "elena.orozcoch@gmail.com";
		$email_from = $this->input->post('email');
		$message = $this->input->post('message');
		$from = $this->input->post('nombre');

		//Este es el cuerpo del mensaje tal y como llegará al correo
		$email_message = "Contenido del Mensaje.\n\n";

 		$email_message .= "Nombre: ". $this->clean_string($from)."\n";
		$email_message .= "Email: ".  $this->clean_string($email_from)."\n";
		$email_message .= "Mensaje: ".$this->clean_string($message)."\n";

        $config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->load->library('email');
		$this->email->initialize($config);

        $this->email->from( $email_from, $from);
		$this->email->to($email_to); 
		$this->email->cc($email_cc); 
		

		$this->email->subject('Email Pagina Web');
		$this->email->message($email_message);	

		if($this->email->send())
        	
            $this->session->set_flashdata("email_sent","Thank you for sending your message, we will contact you shortly!");
        else
        	$this->session->set_flashdata("email_sent","Lo sentimos, no se pudo enviar tu mensaje!");
       	redirect('contacto', 'refresh');

		
	}
}

 

