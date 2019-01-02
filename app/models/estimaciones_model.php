<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estimaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listar_estimaciones_obra($idObra) {
        $this->db->where("idObra", $idObra);
        $this->db->order_by("id", "DESC");
        return $this->db->get('movEstimaciones');
        
    }
}