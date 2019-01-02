<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presupuesto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listado_conceptos($idObra) {
        $this->db->where("Estatus", 1);
        $this->db->where("idObra", $idObra);
        $this->db->order_by("id", "DESC");
        return $this->db->get('catObrasPresupuesto');
        
    }

    public function totalizar_presupuesto($idObra){
    	$this->db->select("SUM(preciounitario * cantidad) as total");
    	$this->db->where("idObra", $idObra);
        $total = $this->db->get('catObrasPresupuesto')->row_array();

        return $total['total'];

    }
}