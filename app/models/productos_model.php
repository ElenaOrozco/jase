<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //obtenemos el total de filas para hacer la paginación del buscador
    function productos($buscador) {

        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        $this->db->where("(p.nombre like '%$buscador%' or p.descripcion like '%$buscador%' or c.nombre like '%$buscador%' )");
        $this->db->where("p.deleted_at", NULL);
        $this->db->where("visible", 1);
        $consulta = $this->db->get();
        return $consulta->num_rows();
    }

    function productos_categoria($idCategoria) {

        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        $this->db->where("p.idCategoria", $idCategoria);
        $this->db->where("p.deleted_at", NULL);
        $this->db->where("visible", 1);
        $consulta = $this->db->get();
        return $consulta->num_rows();
    }
 
    //obtenemos todos los posts a paginar con la función
    //total_posts_paginados pasando lo que buscamos, la cantidad por página y el segmento
    //como parámetros de la misma
    function total_posts_paginados($buscador, $por_pagina, $segmento) {
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        $this->db->where("(p.nombre like '%$buscador%' or p.descripcion like '%$buscador%' or c.nombre like '%$buscador%' )");
        $this->db->where("p.deleted_at", NULL);
        $this->db->where("visible", 1);
        $this->db->limit($por_pagina, $segmento);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) {
            $data[] = $fila;
        }
            return $data;
        }
    }

    function total_posts_paginados_categoria($idCategoria, $por_pagina, $segmento) {
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        $this->db->where("p.idCategoria", $idCategoria);
        $this->db->where("p.deleted_at", NULL);
        $this->db->where("visible", 1);
        $this->db->limit($por_pagina, $segmento);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            foreach ($consulta->result() as $fila) {
            $data[] = $fila;
        }
            return $data;
        }
    }

    public function listar_categorias() {
        $this->db->where("deleted_at", NULL);
        $this->db->order_by("id", "DESC");
        return $this->db->get('catCategorias');
        
    }

    public function listar_representantes() {
       
        $this->db->order_by("id", "ASC");
        return $this->db->get('catRepresentantes');
        
    }

    public function listar_ciudades() {
        $this->db->select("Ciudad");
        $this->db->distinct();
        $this->db->order_by("id", "ASC");
        return $this->db->get('catRepresentantes');
        
    }

    public function listar_representantes_ciudad($Ciudad) {
        
        $this->db->where("Ciudad", $Ciudad);
        $this->db->order_by("id", "ASC");
        return $this->db->get('catRepresentantes');
        
    }

    public function listar_subcategorias() {
        $this->db->where("deleted_at", NULL);
        $this->db->order_by("id", "DESC");
        return $this->db->get('catSubCategorias');
        
    }

    public function datos_categoria($id) {
        $this->db->where("id",$id);
        return $this->db->get('catCategorias');
        
    }

    public function datos_producto($id) {
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        $this->db->where("p.id",$id);
        return $this->db->get();
        
    }

    public function get_current_page_records($limit, $start, $buscar, $idCategoria =null ) 
    {
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        if($idCategoria)
            $this->db->where("p.idCategoria", $idCategoria);
        if($buscar){
            $this->db->where("(p.nombre like '%$buscar%' or p.descripcion like '%$buscar%' or c.nombre like '%$buscar%' )");
        }
        $this->db->where("p.deleted_at", NULL);
        $this->db->where("visible", 1);
        $this->db->limit($limit, $start);

        return $this->db->get();
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return false;
    }
     
    public function get_total($buscar, $idCategoria = null) 
    {
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
        if($idCategoria)
        $this->db->where("p.idCategoria", $idCategoria);
        if($buscar){
            $this->db->where("(p.nombre like '%$buscar%' or p.descripcion like '%$buscar%' or c.nombre like '%$buscar%' )");
        }
        $this->db->where("visible", 1);
        $this->db->where("p.deleted_at", NULL);
        return $this->db->get()->num_rows();
    }

    public function listar_productos($idCategoria=NULL) {
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
       
        if($idCategoria)
        $this->db->where("p.idCategoria", $idCategoria);
        $this->db->where("p.deleted_at", NULL);
      
        $this->db->order_by("p.id", "DESC");
        return $this->db->get();
        
    }

    public function buscar($buscar){
        $this->db->select('p.*, c.nombre as categoria');
        $this->db->from('catProductos as p');
        $this->db->join('catCategorias as c', 'c.id= p.idCategoria');
     
        $this->db->like("p.descripcion", $buscar);
        $this->db->where("p.deleted_at", NULL);
        $this->db->where("visible", 1);
        $this->db->order_by("p.id", "DESC");
        return $this->db->get();
    }

    public function listado_productos_slider($limit){
        $this->db->where("imagen !='' and deleted_at is null and visible = 1");
        
        $this->db->limit($limit);
        $this->db->order_by("id", "DESC");
        return $this->db->get('catProductos');
    }


    function subir_categoria($data)
    {
       
        return $this->db->insert('catCategorias', $data);
    }

    function agregar_producto($data)
    {
       
        return $this->db->insert('catProductos', $data);
    }

    public function editar_categoria($data, $id){
    	$this -> db -> trans_start ();
         
        $this->db->where('id', $id);
        $this->db->update('catCategorias', $data); 
         
        $this -> db -> trans_complete ();
         
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
    }

    public function editar_producto($data, $id){
        $this -> db -> trans_start ();
         
        $this->db->where('id', $id);
        $this->db->update('catProductos', $data); 
         
        $this -> db -> trans_complete ();
         
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
    }
}