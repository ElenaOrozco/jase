<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plantillas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    

    public function listado() {
        
        return $this->db->get('saaModalidad');
        
    }


    public function listar_documentos_modalidad($idModalidad) {
        $this->db->select('*');
        $this->db->from('saaRel_Modalidad_Documentos_Auditoria as rel');
        $this->db->join('saaDocumentos_auditoria as d', 'd.id = rel.idDocumento');
        $this->db->where('rel.idModalidad', $idModalidad);
        //$this->db->where('eliminacion_logica', 0);
        return $this->db->get('');
        
    }

}