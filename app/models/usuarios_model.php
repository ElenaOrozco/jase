<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function cambiar_pass($id, $data){
        $this->db->update('catUsuarios',$data,array('id' => $id));
    }
    public function get_usuario($id_usuario) {
        $this->db->where('id', $id_usuario);
        $query = $this->db->get_where('catUsuarios');
        return $query;
    }
    
    public function addw_submenus_permisos($nivel) {
        $this->db->where('Nivel',$nivel);
        $query=  $this->db->get_where('sisMenuSub');
        $permisos=array();
        foreach ($query->result() as $key => $rowdata) {
            $permisos[] = $rowdata;
        }
        return $permisos;
    }
    public function get_all_permisos($id){
        $this->db->where("idUsuario",$id);
        return $this->db->get_where("catUsuariosPermisos");
    }

    public function addw_menu() {
        
        $query=  $this->db->get('sisMenu');
        foreach ($query->result() as $key => $row) {
            $addw[]=$row;
        }
        return $addw;  
    }

    public function get_preferencias($preferencia) {
        $xml = $this->get_preferenciasXML();
        $xml_preferencias = $xml->documentElement;
        $valor = "";
        if ($xml_preferencias->hasAttribute($preferencia)) {
            $valor = $xml_preferencias->getAttribute($preferencia);
        }
        return $valor;
    }

    public function get_preferenciasXML() {
        $this->load->library('ferfunc');
        $ls_preferenciasXML = $this->ferfunc->display_relativo($this->session->userdata("id"), "catContratistas", "Id", "ComplementoXML", "int", "text");
        if (is_null($ls_preferenciasXML) || $ls_preferenciasXML == NULL || $ls_preferenciasXML == "") {
            // establecer la preferencia por default
            $xml = new DOMDocument("1.0", "UTF-8");
            $xml->resolveExternals = true;
            $xml->formatOutput = true;
            $xml->preserveWhiteSpace = false;
            $xml->recover = true;
            $xml_root = $xml->appendChild($xml->createElement('preferencias'));
            // Alimentar los valores por default
        } else {
            $xml = new DOMDocument("1.0", "UTF-8");
            $xml->resolveExternals = true;
            $xml->formatOutput = true;
            $xml->preserveWhiteSpace = false;
            $xml->recover = true;
            $xml->loadXML($ls_preferenciasXML);
        }
        return $xml;
    }

    public function set_preferencias($preferencia, $valor) {
        $xml = $this->get_preferenciasXML();
        $xml_preferencias = $xml->documentElement;
        $xml_preferencias->setAttribute($preferencia, $valor);
        $ls_preferenciasXML = $xml->saveXML();
        $id = $this->session->userdata("id");

        $data = array(
            'ComplementoXML' => $ls_preferenciasXML
        );
        $this->db->where('Id', $id);
        $this->db->update('catContratistas', $data);
        return true;
    }

    public function restart_permisos($id) {
        $del_sql = "DELETE FROM catUsuariosPermisos WHERE idUsuario = ?";
        $del_query = $this->db->query($del_sql, array($id));
        $permisos = array( 'contratistas', 'catalogos', 'reportes','localidades','municipios','regiones');
        foreach ($permisos as $value) {
            $insert_sql = "INSERT INTO catUsuariosPermisos SET idUsuario = ?, perfil = ?";
            $insert_query = $this->db->query($insert_sql, array($id, $value));
        }
        return 0;
    }

    public function addw_usuarios($full = TRUE) {
        if (!$full) {
            $this->db->where("Estatus",1);
        }
        $this->db->order_by("Nombre","ASC");
        $query = $this->db->get("catUsuarios");
        $addw = array();
        $addw[0] = "No disponible";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $addw[$row->id] = $row->Nombre;
            }
        }
        return $addw;
    }
    
    public function addw_usuarios_correos($full = TRUE) {
        if (!$full) {
            $this->db->where("Estatus",1);
        }
        $this->db->order_by("Nombre","ASC");
        $query = $this->db->get("catUsuarios");
        $addw = array();
        $addw[0] = "No disponible";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $addw[$row->id] = $row->Email;
            }
        }
        return $addw;
    }
    
    public function menus(){
        $this->db->order_by("Nivel");
        return $this->db->get("sisMenu");      
    }
    public function submenus($Nivel){
        $this->db->order_by("Indice");
        return $this->db->get_where("sisMenuSub",array('Nivel' => $Nivel));      
    }
    public function addw_estatus()
    {
        $this->db->where('Modulo',6);
        $query=  $this->db->get_where('sisEstatus');
        $addw=array();
        foreach ($query->result() as $key => $row) {
            $color=$row->LinkColor;
            $estatus=$row->Nombre;
            $addw[$row->Estatus]=array('estatus'=>$estatus,'color'=>$color);
        }
        return $addw;
    }

    public function listado_usuarios() {
//        $this->db->where('Estatus <> 0');
        $query = $this->db->get_where('catUsuarios');
        return $query;
    }

    public function permisos_usuarios($idUsuario) {
        $this->db->where('idUsuario', $idUsuario);
        $query = $this->db->get_where('catUsuariosPermisos');
    }

    public function addw_permisos($idUsuario = 0) {
        $this->db->distinct('Permiso');
        $this->db->select('Permiso');
        $this->db->where('Permiso != "#"');
        if ($idUsuario <> 0)
            $this->db->where_not_in('Permiso NOT IN (Select Perfil from catUsuariosPermisos where Estatus <> 0 and idUsuario='.$idUsuario,NULL,FALSE);
        $query = $this->db->get('sisMenuSub');
        $permisos = array();
        foreach ($query->result() as $key => $rowdata) {
            $permisos[] = $rowdata->Permiso;
        }

        return $permisos;
    }

    public function addw_permisos_usuario($idUsuario) {
        $this->db->where('idUsuario', $idUsuario);
        $this->db->where('Estatus <> 0');
        $query = $this->db->get_where('catUsuariosPermisos');
        $permisos = array();
        foreach ($query->result() as $key => $rowdata) {
            $permisos[] = $rowdata;
        }

        return $permisos;
    }
    
    public function tienePermiso($control,$idUsuario)
    {
        $this->db->where('Perfil',$control);
        $this->db->where('idUsuario',$idUsuario);
        $query = $this->db->get_where('catUsuariosPermisos');
        if($query->num_rows()>0)
            $retorno=true;
        else {
            $retorno=false;
        }
        return $retorno;
    }

    public function setPermiso($data) {
        $retorno = $this->db->insert('catUsuariosPermisos', $data);
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => $registro);
        }
    }

    public function getPermiso($permiso, $idUsuario) {
        $this->db->where('Perfil', $permiso);
        $this->db->where('idUsuario', $idUsuario);
        $retorno = $this->db->get_where('catUsuariosPermisos');
        return $retorno;
    }

    public function unsetPermiso($data) {
        $this->db->delete('catUsuariosPermisos', $data);
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => 0);
        }
    }

    public function baja_usuario($id) {
        $data['Estatus'] = 0;
        $retorno = $this->db->update('catUsuarios', $data, array('id' => $id));

        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => $registro);
        }
    }

    public function datos_usuarios_update($data, $id) {
        $retorno = $this->db->update('catUsuarios', $data, array('id' => $id));

        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => $registro);
        }
    }

    public function datos_usuarios_insert($data,$menu) {
        $retorno = $this->db->insert('catUsuarios', $data);

        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => $registro);
        }
    }
    
    public function usuarioRepetido($login,$password) {
        $this->db->where('usuario',$login);
//        $this->db->where('password',  $password);
        $query=  $this->db->get_where('catUsuarios');
        if($query->num_rows()>0)
            return TRUE;
        else
            return FALSE;
    }
    
    
    
    public function buscarPermiso($idUsuario=0,$permiso='') {
        $this->db->like('Perfil', $permiso);
        $this->db->where('idUsuario',$idUsuario);
        $q=  $this->db->get_where('catUsuariosPermisos');
        if($q->num_rows()>0)
        {
            return TRUE;
        }
        else
            return FALSE;
    }
    
    public function setPermisoMenu($Nivel,$idUsuario) {
        $this->db->where('Nivel',$idUsuario);
        $menu=  $this->db->get_where('sisMenu')->row_array();
        $data = array(
                'idUsuario' => $idUsuario,
                'Perfil' => $menu['Permiso']
            );
            $this->setPermiso($data);
            $submenus=  $this->addw_submenus_permisos($Nivel);
            foreach ($submenus as $key => $value) {
                $data = array(
                'idUsuario' => $idUsuario,
                'Perfil' => $value
            );
                $this->setPermiso($data);
            }
                
    }
    
     public function addw_areas($full = TRUE) {
        if ($full) {
            $query = $this->db->get('catDependenciasFirmas');
        } else {
            $query = $this->db->get_where('catDependenciasFirmas', "Estatus <> 0");
        }
        $addw = array();
        $addw[0] = "No disponible";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $addw[$row->id] = $row->Puesto . ' - ' . $row->Nombre;
            }
        }
        return $addw;
    }

}
