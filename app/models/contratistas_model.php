<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contratistas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listado() {
        $this->db->where("idEstatus", 0);
        $this->db->order_by("id", "DESC");
        return $this->db->get('catContratistas');
        
    }
}