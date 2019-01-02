<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function money($cantidad){
        return number_format($cantidad, 2, '.', ',') ;
    }

    public function listado() {
        $this->db->select('poa.*, p.Abreviatura');
        $this->db->from('saaPoa as poa');
        $this->db->join('saaPartidas as p', 'poa.idPartida = p.id');
        $this->db->order_by('poa.id desc');
        return $this->db->get();
        
    }

    public function listar_supervisores() {
        $this->db->where('Estatus', 1);
        $this->db->where('idTipo', 2);
        return $this->db->get('catUsuarios');
        
    }

    public function listado_partidas() {
        $this->db->where('Estatus', 1);
        return $this->db->get('saaPartidas');
        
    }

     public function listado_modalidades() {
        $this->db->where('Estatus', 1);
        return $this->db->get('saaModalidad');
        
    }

    public function listado_obras_poa($idPoa) {
        $this->db->select('o.*, e.Nombre, c.RazonSocial');
        $this->db->from('obras as o');
        $this->db->join('sisEstatusObra as e', 'o.idEstatus = e.id');
        $this->db->join('catContratistas as c', 'o.idContratista = c.id');
        $this->db->where('o.idEstatus >', 0);
        $this->db->where('idPoa', $idPoa);
        return $this->db->get();
        
    }


    public function datos_proyecto($id){
        $this->db->select('poa.*, p.Abreviatura, p.Nombre');
        $this->db->from('saaPoa as poa');
        $this->db->join('saaPartidas as p', 'p.id = poa.idPartida');
        $this->db->where('poa.id', $id);
        return $this->db->get()->row_array();
    }

    public function datos_partida($id){
        $this->db->where('id', $id);
        return $this->db->get('saaPartidas')->row_array();
    }


    public function agregar_partida($data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido("Nombre", strtoupper($data['Nombre']), "saaPartidas");
        if( !$repetido['ret'] ){
            $this->db->insert('saaPartidas', $data);
            $e = $this->db->_error_message();
            $aff = $this->db->affected_rows();
            $last_query = $this->db->last_query();
            $registro = $this->db->insert_id();
            
            
            if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saaPartidas', 'Data' => $data, 'id' => $registro));
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
            $retorno['mensaje'] = 'Partida repetida';
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
    
    public function concepto_repetido($campo, $str, $tabla) {
        $this->db->where($campo, $str);
        $this->db->where('Estatus', 1);
        $query = $this->db->get($tabla);
        if ($query->num_rows() > 0) {
            $concepto = $query->row();
            return array('ret' => true, 'concepto' => $concepto->$campo);
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