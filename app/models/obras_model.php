<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obras_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listado($tipo = null) {
        $this->db->select("o.*, m.Modalidad");
        $this->db->from('obras as o');
        $this->db->join('saaModalidad as m', 'm.id= o.idModalidad', 'left');
        if($tipo == 1){
            $this->db->where('o.idModalidad != 4');
        }
        if ($tipo == 2){
            $this->db->where('o.idModalidad', 4);
        }
        if($tipo == 3){

            $this->db->where('o.recepcion', 1);
        }
        $this->db->order_by("id", "DESC");
        return $this->db->get();
        
    }




    public function listar_obras_ejercicio($Ejercicio) {
        
        $this->db->where('Ejercicio', $Ejercicio);
        return $this->db->get('obras');
        
    }


    public function listar_obras($Estatus) {

        $this->db->select("o.*, m.Modalidad");
        $this->db->from('obras as o');
        $this->db->join('saaModalidad as m', 'm.id= o.idModalidad', 'left');
        $this->db->where('idEstatus <', $Estatus);
        $this->db->order_by("id", "DESC");
        return $this->db->get();
        
    }


    public function listar_obras_contratista($idContratista) {
        
        $this->db->where('idContratista', $idContratista);
        return $this->db->get('obras');
        
    }

    public function datos_obra($id) {
        $this->db->select("o.*, m.Modalidad,c.RazonSocial");
        $this->db->from('obras as o');
        $this->db->join('saaModalidad as m', 'm.id= o.idModalidad', 'left');
        $this->db->join('catContratistas as c', 'c.id= o.idContratista', 'left');
        

        $this->db->where("o.id", $id);
        return $this->db->get()->row_array();
    }


    public function agregar_supervisor($data){
        $data['fecha_asignacion'] = date('Y-m-d');
        $this->db->insert('saaRel_Supervisores_Obras', $data);

    }



    public function datos_documento($idDocumento) {
        $this->db->select("*");
        $this->db->from('saaDocumentosDigitales as dig');
        $this->db->join('saaDocumentos as d', 'd.id= dig.idDocumento');
        $this->db->where("dig.idDocumento", $idDocumento);
        return $this->db->get();
    }
    
    public function addw_obra() {
        $query=  $this->db->get('obras');
        $addw[0]="No disponible";
        foreach ($query->result() as $row) {
            $addw[$row->id]=$row->Nombre;
        }
        return $addw;
    }

    public function get_supervisor_obra($id){
        $this->db->select("rel.*, u.Nombre");
        $this->db->from('saaRel_Supervisores_Obras as rel');
        $this->db->join('catUsuarios as u', "u.id= rel.idSupervisor");
        $this->db->where("rel.idObra", $id);
        $this->db->order_by("rel.fecha_asignacion DESC");
        $this->db->limit(1);
        return $this->db->get()->row_array();
    }


    public function listar_supervisores_obra($id){
        $this->db->select("rel.*, u.Nombre");
        $this->db->from('saaRel_Supervisores_Obras as rel');
        $this->db->join('catUsuarios as u', "u.id= rel.idSupervisor");
        $this->db->where("rel.idObra", $id);
        $this->db->order_by("rel.fecha_asignacion DESC");
       
        return $this->db->get();
    }


    public function listar_supervisores(){
        $this->db->select("u.id, u.Nombre");
        $this->db->where("idTipo", 2);
        $this->db->where("Estatus", 1);
        return $this->db->get('catUsuarios as u');
    }


    public function get_datos_contratista($idContratista){
        $this->db->where("id", $idContratista);
        return $this->db->get("catContratistas")->row_array();
    }

    public function get_datos_supervisor($id){
        $this->db->where("id", $id);
        return $this->db->get('catUsuarios')->row_array();
    }


    public function get_documentos_obra($idObra){
        $this->db->select('d.Nombre, d.Prioridad, rel.*, dig.id as idDigital');
        $this->db->from('saaDocumentos as d')
           
            ->join('saaRel_obras_documentos as rel', 'd.id = rel.idDocumento')
            ->join('saaDocumentosDigitales as dig', 'dig.idRel_obras_documentos = rel.id', 'left')
            ->where('rel.idObra', $idObra)
            ->order_by('d.Prioridad ASC, dig.id DESC');
        
        return $this->db->get();
    }


    public function listar_documentos_obra($idObra){
        $this->db->select('d.Nombre, rel.*');
        $this->db->from('saaDocumentos_auditoria as d')
           
            ->join('saaRel_obras_documentos_auditoria as rel', 'd.id = rel.idDocumento')
           
            ->where('rel.idObra', $idObra)
            ->order_by('d.id DESC');
        
        return $this->db->get();
    }

    public function get_documentos_digitales_obra($idObra){
        $this->db->select('d.Nombre, d.Prioridad, rel.*, dig.id as idDigital');
        $this->db->from('saaDocumentos as d')
           
            ->join('saaRel_obras_documentos as rel', 'd.id = rel.idDocumento')
            ->join('saaDocumentosDigitales as dig', 'dig.idRel_obras_documentos = rel.id')
            ->where('rel.idObra', $idObra);
            
        
        return $this->db->get()->num_rows();
    }

    


    public function agregar($data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido(strtoupper($data['Contrato']));
        if( !$repetido['ret'] ){
            $this->db->insert('obras', $data);
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
    


     public function subir_documento($data){
         
        $this -> db -> trans_start ();
         
         
        $this->db->insert('saaDocumentosDigitales', $data);
        $registro = $this->db->insert_id();
         
        if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saaDocumentosDigitales', 'Data' => $data, 'id' => $registro));
            }
        $this -> db -> trans_complete ();
         
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
        
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


