<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('permits');                
    }

    public function login($error = 0)
    {
        $data['error'] = $error;
        $data['img_dir'] = base_url().$this->config->item('img_dir');
		$data['meta'] = array(
			array('name' => 'robots', 'content' => 'no-cache'),
			array('name' => 'description', 'content' => 'Sistema Administrativo en linea'),
			array('name' => 'keywords', 'content' => 'facturacion, control, cobranza, almacen, produccion , contabilidad'),
			array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
		); 
		$data['css'] = link_tag(base_url()."css/principal.css");
                $data['script'] = '<script language="JavaScript" type="text/javascript">
         
function on_load_page(){
                  var NAV = new String(navigator.appVersion);
                  //alert("Estas utilizando "+navigator.appName+" "+navigator.appVersion);
                  //alert(NAV.search(".NET"));
                if (NAV.search(".NET") > 0) {
                  alert("Estas usando Internet Explorer, El sistema no funciona en este Navegador, Se recomienda utilizar Google Chrome");
                  var url = "http://www.google.com/intl/es-419/chrome/browser/";
                  window.location.href(url);
                }
            }
            </script>';
        $this->load->view('v_login', $data);
    }
    

    public function authenticate()
    {
        $this->load->model('User_model', '', true);
        if ($this->User_model->authenticate($this->input->post('usuario'), $this->input->post('pass')))
        {
            
            header('Location: '.base_url('admin'));
            
            
        }
        else
        {
            // aqui se tiene que definir el estatus del error del login
            // 1 para error general de usuario y/o nombre se puede guardar el error en la sesion
            
            header('Location: '.site_url().'sessions/login/1');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('loggedin');
        $this->session->sess_destroy();
        header('Location: '.site_url());
    }
    
}