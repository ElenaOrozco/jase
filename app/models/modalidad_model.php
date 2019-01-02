<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class modalidad_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregar_m($data) {
        $repetido =  $this->concepto_repetido(strtoupper($data['Modalidad']));

        if( !$repetido['ret'] ){
            $this->db->insert('saaModalidad', $data);
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
        
        } else{
         return array("retorno" => "-1", "error" => 'Modalidad repetida');   
        }
    }

    public function get_listado() {
        
        $sql = 'SELECT * FROM saaModalidad WHERE Estatus=1 ORDER BY id ASC';
        $query = $this->db->query($sql);
        return $query; 
    }

    
       
    
    public function datos_modalidad($id) {
        $sql = 'SELECT * FROM saaModalidad WHERE id = ?';
        $query = $this->db->query($sql, array($id));
        return $query;
    }
    
   
    
    public function agregar($data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido(strtoupper($data['Modalidad']));
        if( !$repetido['ret'] ){
            $this->db->insert('saaModalidad', $data);
            $e = $this->db->_error_message();
            $aff = $this->db->affected_rows();
            $last_query = $this->db->last_query();
            $registro = $this->db->insert_id();
            
            
            if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saaModalidad', 'Data' => $data, 'id' => $registro));
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
                $retorno['mensaje'] = $registro;
                $retorno['retorno'] = 1;
                
            }
        
        } else{
            $retorno['mensaje'] = 'Modalidad repetida';
            $retorno['retorno'] = -1;
           
        }
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        return $retorno;
        

    }
    
    public function datos_modalidad_update($data, $id) {
        
        $this->db->update('saaModalidad', $data, array('id' => $id));
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
//      

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => $id);
        }
    
    }
    /*
    public function datos_modalidad_delete($id) {
        //echo $id;
        //$this->db->where('id', $id);
        //$this->db->update('saatipoproceso');
        $this->db->delete('saaModalidad', array('id' => $id));
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
//        $registro = $this->db->insert_id();
        //$this->db->db_debug = $oldv; 

        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "registro" => $id);
        } 
    } */
    
    public function concepto_repetido($str) {
        $this->db->where('Modalidad', $str);
        $this->db->where('Estatus', 1);
        $query = $this->db->get('saaModalidad');
        if ($query->num_rows() > 0) {
            $concepto = $query->row();
            return array('ret' => true, 'concepto' => $concepto->Modalidad);
        } else
            return array('ret' => false, 'concepto' => 0);
    }
  



    public function addw_modalidades() {
        $query = $this->db->get("saaModalidad");
        $addw = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $addw[$row->id] = $row->Modalidad;
            }
        }
        return $addw;
    }
    
    
    

}

?>

