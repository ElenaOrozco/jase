<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documentos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listado() {
        $this->db->where("Estatus", 1);
        $this->db->order_by("id", "DESC");
        return $this->db->get('saaDocumentos');
        
    }
    public function datos_documento($id) {
        $this->db->where("id", $id);
        return $this->db->get('saaDocumentos')->row_array();
    }
    
    public function addw_documento() {
        $query=  $this->db->get('saaDocumentos');
        $addw[0]="No disponible";
        foreach ($query->result() as $row) {
            $addw[$row->id]=$row->Nombre;
        }
        return $addw;
    }

    public function agregar($data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido(strtoupper($data['Nombre']));
        if( !$repetido['ret'] ){
            $this->db->insert('saaDocumentos', $data);
            $e = $this->db->_error_message();
            $aff = $this->db->affected_rows();
            $last_query = $this->db->last_query();
            $registro = $this->db->insert_id();
            
            
            if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saaDocumentos', 'Data' => $data, 'id' => $registro));
            }
            if ($aff < 1) {
                if (empty($e)) {
                    $retorno['mensaje'] = "No se realizaron cambios";
                }
                // si hay debug
                $e .= "<pre>" . $last_query . "</pre>";
                $retorno['mensaje'] = $e;
                $retorno['retorno'] = -1;
            } else {
                $retorno['mensaje'] = "Registro agregado";
                $retorno['retorno'] = 1;
                
            }
        
        } else{
            $retorno['mensaje'] = 'Documento repetido';
            $retorno['retorno'] = -1;
           
        }
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        return $retorno;
        

    }

    public function editar($id, $data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido(strtoupper($data['Nombre']));
        if( !$repetido['ret'] ){
            $this->db->where("id", $id);
            $this->db->update('saaDocumentos', $data);
            $e = $this->db->_error_message();
            $aff = $this->db->affected_rows();
            $last_query = $this->db->last_query();
            
            if ($aff < 1) {
                if (empty($e)) {
                    $retorno['mensaje'] = "No se realizaron cambios";
                }
                // si hay debug
                $e .= "<pre>" . $last_query . "</pre>";
                $retorno['mensaje'] = $e;
                $retorno['retorno'] = -1;
            } else {
                $retorno['mensaje'] = "Registro Actualizado";
                $retorno['retorno'] = 1;
                
            }
        
        } else{
            $retorno['mensaje'] = 'Documento repetido';
            $retorno['retorno'] = -1;
           
        }
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        return $retorno;
        

    }

    public function eliminar($id, $data) {

        $this->db->trans_start();
        $retorno = array();
       
        $this->db->where("id", $id);
        $this->db->update('saaDocumentos', $data);
        
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        $retorno['retorno'] = ($this->db->trans_status() === FALSE)? -1: 1;
        
        return $retorno;
        

    }

    public function concepto_repetido($str) {
        $this->db->where('Nombre', $str);
        $this->db->where('Estatus', 1);
        $query = $this->db->get('saaDocumentos');
        if ($query->num_rows() > 0) {
            $concepto = $query->row();
            return array('ret' => true, 'concepto' => $concepto->Nombre);
        } else
            return array('ret' => false, 'concepto' => 0);
    }
    
    
    
    public function log_save($cambios) {
            $this->load->model("control_usuarios_model");
            return $this->control_usuarios_model->log_save($cambios);
    }
    
    public function log_new($cambios) {
            $this->load->model("control_usuarios_model");
            return $this->control_usuarios_model->log_new($cambios);
    }

}

?>


