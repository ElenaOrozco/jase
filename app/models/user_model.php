<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    
    
    public function __construct() {
            parent::__construct();
    }

    function _prep_password($password) {
        //return sha1($password . $this->config->item('encryption_key'));
        //se activa codificacion de passwod a sha1. alfredo.
        return sha1($password);
        //return $password;
    }

    public function authenticate($usuario, $pass) {
        
        $sql = "SELECT * FROM catUsuarios WHERE BINARY Usuario = ? AND Password = ? ";
        $query = $this->db->query($sql, array($usuario, $this->_prep_password($pass)));
        
        if ($query->num_rows() != 1) {
            $this->session->set_userdata('error', 1);
            return false;
        }
        $row = $query->row();
       
        $id_usuario = $row->id;
        $nombre = $row->Nombre;              
        // Aqui se va a checar tambien la dependencia en la que trabajaaa ya que el sistema sea multidependencias        
        
        $this->session->set_userdata('loggedin', true);
        $this->session->set_userdata('error', 0);
        $this->session->set_userdata('id', $id_usuario);
        $this->session->set_userdata('nombre', $nombre); 
        $this->session->set_userdata('perfil', $row->idTipo); 
        $this->session->set_userdata('admin', $row->admin);
        $this->session->set_userdata('SuperUsuario', $row->SuperUsuario);
        
        $data = array();
        $data['idUsuario'] = $id_usuario;
        $data['Nombre'] = $nombre;
        $data['Fecha'] = date('Y-m-d h:m:s');
        $data['Server'] = base_url();
        $data['IPClient'] = $_SERVER['REMOTE_ADDR'];
        $data['Browser'] = $_SERVER['HTTP_USER_AGENT'];
        $this->db->insert('log_Users', $data);
        return true;
    }
    
    public function get_usuario() {
        if( !$this->session->userdata('loggedin')){
            return false;
        }
        $id_usuario = $this->session->userdata("id");
        $sql = "
            SELECT * FROM catUsuario WHERE id = ? 
            ";
        $query = $this->db->query($sql,array($id_usuario),1);
        return $query->row_array();
    }
	
	
      
       
}
