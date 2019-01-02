<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Preregistro_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    
    public function ot_json($term = null, $id = null){
        $aRow = array();
        $return_arr = array();            
        if (!empty($term) || !empty($id)){
            if ($id > 0){


                $this->db->select("id,OrdenTrabajo");
                
                $this->db->order_by("OrdenTrabajo", "ASC");
                $query2 = $this->db->get_where("saaArchivo",array("id" => $id),100);
                

            }else{
               
                $this->db->select("id,OrdenTrabajo");
                $this->db->like("OrdenTrabajo",$term);
                $this->db->order_by("OrdenTrabajo", "ASC");
                
                $query2 = $this->db->get("saaArchivo",100);                    
            }

            if ($query2->num_rows() > 0){


                foreach ($query2->result() as $row ){
                    $aRow["id"] = $row->id;
                    $aRow["text"] = $row->OrdenTrabajo;
                    $return_arr["results"][] = $aRow;
                }
            }else{
                $aRow["id"] = "newremit";
                $aRow["text"] = 'No se encontro OT';
                $return_arr["results"][] = $aRow;
            }
        }else{
            $aRow["id"] = "";
            $aRow["text"] = "";
            $return_arr["results"][] = $aRow;
        } 
        return $return_arr; 
    }
    
    public function ot_json_usuarios($term = null, $id = null){
        $aRow = array();
        $return_arr = array();            
        if (!empty($term) || !empty($id)){
            if ($id > 0){
                $where = "id=$id AND preregistro = 0 AND recibe = 1";
                $this->db->select("id,Nombre");
                
                $this->db->order_by("Nombre", "ASC");
                $query2 = $this->db->get("catUsuarios",10);
                

            }else{
                $where = "Nombre LIKE '%$term%' AND preregistro = 0 AND recibe = 1";
                $this->db->select("id,Nombre");
                $this->db->where($where);
                $this->db->order_by("Nombre", "ASC");
                
                $query2 = $this->db->get("catUsuarios",10);                    
            }

            if ($query2->num_rows() > 0){


                foreach ($query2->result() as $row ){
                    $aRow["id"] = $row->id;
                    $aRow["text"] = $row->Nombre;
                    $return_arr["results"][] = $aRow;
                }
            }else{
                $aRow["id"] = "newremit";
                $aRow["text"] = 'No se encontro Usuario';
                $return_arr["results"][] = $aRow;
            }
        }else{
            $aRow["id"] = "";
            $aRow["text"] = "";
            $return_arr["results"][] = $aRow;
        } 
        return $return_arr; 
    }
    
    public function crear_folio($data){
        
        
        $this -> db -> trans_start (); 
           
           $this->db->insert('saaPreregistro', $data);
           $id = $this->db->insert_id();
           
           
           $idDireccion = $data['idDireccion'];
           
           $this->db->where('idDireccion', $idDireccion);
           $preregistros =  $this->db->get('saaPreregistro')->num_rows(); 
           
           $this->db->where('id', $idDireccion);
           $direccion = $this->db->get('catDirecciones')->row_array();
          
           $sub =  $direccion['Abreviatura'];
           
           
           
            /*Generar Folio */
            $long_max = 5;
            $longitud = strlen($preregistros);
           
            $numero_folio = "";
            if($long_max > $longitud){
                for($i = $longitud; $i < $long_max ; $i++ ){
                    $numero_folio.= "0";
                }
            } 
            $numero_folio.= $preregistros;
            $folio = "$sub-$numero_folio";
            $data_folio['folio'] = $folio;
           
            $this->db->where('id', $id);
            $this->db->update('saaPreregistro', $data_folio);
           
        
        $this -> db -> trans_complete ();
        
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : $id;
    }

    public function get_preregistro($id){
       
        $this->db->select('p.* ,d.Nombre as Direccion');
        $this->db->from('saaPreregistro AS p');
        $this->db->join('catDirecciones AS d', 'd.id = p.idDireccion');       
        $this->db->where('p.id', $id);
        
        return $this->db->get()->row_array();
    }
    
    public function get_documentos_plantilla($idPlantilla, $id) {
        
        $this->db->select('d.*, s.Nombre AS Proceso, sub.Nombre AS SubProceso,  dir.Nombre AS Direccion');
        $this->db->from('saaDocumentos_Obra AS d');
        $this->db->join('saaTipoProceso AS s', 's.id = d.idProceso');
        $this->db->join('saaSubProceso AS sub', 'sub.id = d.idSubProceso');
        $this->db->join('catDirecciones AS dir', 'dir.id = d.idDireccion');
        $this->db->where("d.Estatus = 0 AND (idPlantilla = $idPlantilla OR idArchivo = $id) ");
       
        $this->db->order_by('d.Ordenar ASC');
        return $this->db->get();
    }
    public function listado_procesos($id){

        $this->db->select('t.id, t.Nombre');
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra AS d');
        $this->db->join('saaTipoProceso AS t', 't.id = d.idProceso');
        $this->db->where('idPlantilla', $id);
        return $this->db->get();
    }
    
    public function listado_subprocesos($id){
        $this->db->select('s.id, s.Nombre');
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra AS d');
        $this->db->join('saaSubProceso AS s', 's.id = d.idSubProceso');
        $this->db->where('idPlantilla', $id);
        return $this->db->get();
    }
    
    public function listado_direcciones(){
        
        $this->db->where('Nivel = 0 AND id!= 0');
        return $this->db->get('catDirecciones');
    }
    
    public function listado_ejercicios(){
        $this->db->select('idEjercicio');
        $this->db->distinct();
        return $this->db->get('saaArchivo');
    }
    
    public function listado_estatus(){
        $this->db->select('EstatusObra');
        $this->db->distinct();
        return $this->db->get('saaArchivo');
    }
   
    public function listado_grupos(){
        $this->db->select('b.id, b.Nombre');
        $this->db->distinct();
        $this->db->from('saaArchivo as a');
        $this->db->join('saaBloqueObras as b', 'b.id = a.idBloqueObra');
        $this->db->where('b.Estatus', 1);
        return $this->db->get();
    }
    
    public function datos_proceso($id){
        $this->db->where('id', $id);
        return $this->db->get('saaTipoProceso');
    }
    
    public function datos_subproceso($id){
        $this->db->where('id', $id);
        return $this->db->get('saaSubProceso');
    }
    
    public function datos_direccion($id){
        $this->db->where('id', $id);
        return $this->db->get('catDirecciones');
    }
    
    public function agregar_documento_archivo($data) {
        
        
        $this->db->insert('saaDocumentos_Obra', $data);
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();
        
       
        
        if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saaDocumentos_Obra', 'Data' => $data, 'id' => $registro));
        }

        

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
    
    public function get_datos_archivo($idArchivo){
        $this->db->where('id', $idArchivo);
        return $this->db->get('saaArchivo'); 
    }
    
    public function get_datos_archivo_plantilla($idArchivo){
        $this->db->where('id', $idArchivo);
        return $this->db->get('ArchivoPlantilla'); 
    }
    
    public function guardar_historico($data) {
        $this->db->insert('saaPreregistro_Historico_Documento', $data);
    }
    
    private function eliminar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor, $detalle){
        $aDetalle = $detalle->row_array();
        $idDetalle = $aDetalle['id'];
        
        $this->db->where('id', $idDetalle);
        $this->db->delete('saaPreregistro_Detalles');
        
        /* Actualizar Modificaciones Preregistro */
        if ($this->session->userdata('idPreregistro')== 0){
            $data_modificacion['idPreregistro_Detalle'] = $idDetalle;
            $data_modificacion['Tipo'] = -1;
            $data_modificacion['dato_ant'] = "Original " .$aDetalle['original'] ." Copia " .$aDetalle['copia']. " NA " .$aDetalle['NA'];
            $data_modificacion['idUsuario'] = $this->session->userdata('id');
            $data_modificacion['fecha'] = date("Y-m-d G:i:s");

            $this->guardar_historico($data_modificacion);
        }
    }
    
    private function actualizar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor, $detalle){
        $aDetalle = $detalle->row_array();
        $idDetalle = $aDetalle['id'];
        
        $data[$tipo_documento] = $valor;

        $this->db->where('id', $idDetalle);
        $this->db->update('saaPreregistro_Detalles', $data); 
        
        
        /* Actualizar Modificaciones Preregistro */
        $data_modificacion['idPreregistro_Detalle'] = $idDetalle;
        $data_modificacion['Tipo'] = 2;
        $data_modificacion['Tipo_Cambio'] = $tipo_documento;
        $data_modificacion['dato_ant'] = $aDetalle[$tipo_documento];
        $data_modificacion['dato_nuevo'] = $valor;
        $data_modificacion['idUsuario'] = $this->session->userdata('id');
        $data_modificacion['fecha'] = date("Y-m-d G:i:s");

        $this->guardar_historico($data_modificacion);
                                                   
    }
    
    private function modificar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor, $detalle){
        $aDetalle = $detalle->row_array();       
        $idDetalle = $aDetalle['id'];

        $original = ($tipo_documento == "original")? $valor : $aDetalle['original'];
        $copia = ($tipo_documento == "copia")? $valor : $aDetalle['copia']; 
        $NA = ($tipo_documento == "NA")? $valor : $aDetalle['NA'];

        //echo "$original, $copia, $NA <br>";

        //Eliminar Si no tiene nada seleccionado
        if ($original == "" && $copia == "" && $NA == 0){
            $this->eliminar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor, $detalle);
           
        } else {
            $this->actualizar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor, $detalle);
            
        }
    }

    private function insertar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor){
        $data[$tipo_documento] = $valor;
        $data['idDocumento'] = $idDocumento;
        $data['idPreregistro'] = $idPreregistro;
        $this->db->insert('saaPreregistro_Detalles', $data);
        $id = $this->db->insert_id();
        
        /* Actualizar Modificaciones Preregistro */
        $data_modificacion['idPreregistro_Detalle'] = $id;
        $data_modificacion['Tipo'] = 1;
        $data_modificacion['Tipo_Cambio'] = $tipo_documento;
        $data_modificacion['dato_nuevo'] = $valor;
        $data_modificacion['idUsuario'] = $this->session->userdata('id');
        $data_modificacion['fecha'] = date("Y-m-d G:i:s");

        $this->guardar_historico($data_modificacion);
    }

    
    public function preregistrar($tipo_documento, $idPreregistro, $idDocumento, $valor){
        /*
         * 1. Si existe modificar 
         * 2. Si no existe el Detalle en el Preregistro Insertar
         * 
         */
        
        $this -> db -> trans_start (); 
      
            
            $this->db->select('p.idUsuario_registra ,d.*');
            $this->db->from('saaPreregistro AS p');
            $this->db->join('saaPreregistro_Detalles AS d', 'd.idPreregistro = p.id');       
            $this->db->where('idPreregistro', $idPreregistro);
            $this->db->where('idDocumento', $idDocumento);
            $detalle = $this->db->get();
            
            
            /* 1. Si existe modificar */
            if ($detalle->num_rows() > 0){
                $this->modificar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor, $detalle);
               
            }else {
                /* 2. Si no existe el Detalle en el Preregistro Insertar */ 
                $this->insertar_preregistro($tipo_documento, $idPreregistro, $idDocumento, $valor);
                
            }
            
        
        $this -> db -> trans_complete ();
        
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
        
        
    }
    
    public function  datos_insert($data, $catalogo){
        $this->db->insert($catalogo, $data);
        return $this->db->insert_id();
    }

    public function preregistrar_observacion($idPreregistro, $idDocumento, $observacion){
        $this->db->select('p.idUsuario_registra ,d.*');
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Detalles AS d', 'd.idPreregistro = p.id');       
        $this->db->where('idPreregistro', $idPreregistro);
        $this->db->where('idDocumento', $idDocumento);
        $detalle = $this->db->get();


        /* 1. Si existe modificar */
        if ($detalle->num_rows() > 0){
            $aDetalle = $detalle->row_array();

            $idDetalle = $aDetalle['id'];

            $data['observacion'] = $observacion;

            $this->db->where('id', $idDetalle);
            $this->db->update('saaPreregistro_Detalles', $data); 
            $af = $this->db->affected_rows();

        }else{
            $af = -1;
        }
        
        return ( $af > 0 )?  1 : -1;
    }
    
    public function get_plantilla($modalidad, $normatividad){
        $this->db->where('idModalidad', $modalidad);
        $this->db->where('Normatividad', $normatividad);
        $aPlantilla =  $this->db->get('saaPlatillas')->row_array();
        
        return  (isset($aPlantilla['id']))? $aPlantilla['id']: -1 ;
    }

    public function get_procesos_plantilla($idPreregistro, $idPlantilla){
        
        $this->db->select("d.idProceso , t.Nombre,
            (SELECT COUNT(id) FROM `saaDocumentos_Obra` WHERE idProceso = d.idProceso AND idPlantilla = $idPlantilla) AS total,
            (SELECT COUNT(p.id) FROM `saaPreregistro` AS p  
            INNER JOIN `saaPreregistro_Detalles` AS det ON 
            det.idPreregistro= p.id
            INNER JOIN saaDocumentos_Obra AS o
            ON o.`id` = det.`idDocumento`
            WHERE p.id = ". $idPreregistro ." AND o.idProceso = d.idProceso) AS preregistrados
                ");
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra as d');
        $this->db->join('saaTipoProceso as t', 't.id = d.idProceso');
        $this->db->where('idPlantilla', $idPlantilla);
        $this->db->order_by('t.Ordenar ASC');
        return $this->db->get(); 
             
    }
    

    public function traer_subprocesos_de_archivo($idPreregistro, $idPlantilla){
        $this->db->select("d.idProceso ,d.idSubProceso , t.Nombre,
            (SELECT COUNT(id) FROM `saaDocumentos_Obra` WHERE idSubProceso = d.idSubProceso AND idPlantilla = $idPlantilla) AS total,
            (SELECT COUNT(p.id) FROM `saaPreregistro` AS p  
            INNER JOIN `saaPreregistro_Detalles` AS det ON 
            det.idPreregistro= p.id
            INNER JOIN saaDocumentos_Obra AS o
            ON o.`id` = det.`idDocumento`
            WHERE p.id = ". $idPreregistro ." AND o.idSubProceso = d.idSubProceso) AS preregistrados
                ");
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra as d');
        $this->db->join('saaSubProceso as t', 't.id = d.idSubProceso');
        $this->db->where('idPlantilla', $idPlantilla);
        $this->db->order_by('d.Ordenar ASC');
        return $this->db->get(); 
        
        
        
    }
    
    public function  agregar_estimaciones($idProyecto, $no){
        $data['noEstimaciones'] = $no;
        $this->db->where('id', $idProyecto);
        $this->db->update('saaPreregistro', $data);
        $aff = $this->db->affected_rows();
        
        return $aff;
    }
    
    public function  agregar_solicitudes($idPreregistro, $no){
        $data['noSolicitudes'] = $no;
        $this->db->where('id', $idPreregistro);
        $this->db->update('saaPreregistro', $data);
        $aff = $this->db->affected_rows();
        
        return $aff;
    }
    
    
    
    public function preregistrar_estimacion($tipo_documento, $idPreregistro, $idDocumento, $valor, $noEstimacion){
        /*
         * 1. Si existe modificar 
         * 2. Si no existe el Detalle en el Preregistro Insertar
         * 
         */
        
        $this -> db -> trans_start (); 
      
            
            $this->db->select('p.idUsuario_registra ,e.*');
            $this->db->from('saaPreregistro AS p');
            $this->db->join('saaPreregistro_Estimaciones AS e', 'e.idPreregistro = p.id');       
            $this->db->where('idPreregistro', $idPreregistro);
            $this->db->where('noEstimacion', $noEstimacion);
            $this->db->where('idDocumento', $idDocumento);
            $detalle = $this->db->get();
            
            
            /* 1. Si existe modificar */
            if ($detalle->num_rows() > 0){
                $aDetalle = $detalle->row_array();
                
                $idDetalle = $aDetalle['id'];
                
                $original = ($tipo_documento == "original")? $valor : $aDetalle['original'];
                $copia = ($tipo_documento == "copia")? $valor : $aDetalle['copia']; 
                $NA = ($tipo_documento == "NA")? $valor : $aDetalle['NA'];
                
                //echo "$original, $copia, $NA <br>";
                
                //Eliminar Si no tiene nada seleccionado
                if ($original == "" && $copia == "" && $NA == 0){
                  
                    $this->db->where('id', $idDetalle);
                    $this->db->delete('saaPreregistro_Estimaciones');
                } else {
                
                    $data[$tipo_documento] = $valor;
                    
                    $this->db->where('id', $idDetalle);
                    $this->db->update('saaPreregistro_Estimaciones', $data); 
                }
                
                
            
            }else {
                /* 2. Si no existe el Detalle en el Preregistro Insertar */ 
                $data[$tipo_documento] = $valor;
                $data['idDocumento'] = $idDocumento;
                $data['idPreregistro'] = $idPreregistro;
                $data['noEstimacion'] = $noEstimacion;
                $this->db->insert('saaPreregistro_Estimaciones', $data);
                $registro = $this->db->insert_id();
                
            }
            
        
        $this -> db -> trans_complete ();
        
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
        
        
    }
    
    public function preregistrar_solicitud($tipo_documento, $idPreregistro, $idDocumento, $valor, $noSolicitud){
        /*
         * 1. Si existe modificar 
         * 2. Si no existe el Detalle en el Preregistro Insertar
         * 
         */
        
        $this -> db -> trans_start (); 
      
            
            $this->db->select('p.idUsuario_registra ,s.*');
            $this->db->from('saaPreregistro AS p');
            $this->db->join('saaPreregistro_Solicitudes AS s', 's.idPreregistro = p.id');       
            $this->db->where('idPreregistro', $idPreregistro);
            $this->db->where('noSolicitud', $noSolicitud);
            $this->db->where('idDocumento', $idDocumento);
            $detalle = $this->db->get();
            
            
            /* 1. Si existe modificar */
            if ($detalle->num_rows() > 0){
                $aDetalle = $detalle->row_array();
                
                $idDetalle = $aDetalle['id'];
                
                $original = ($tipo_documento == "original")? $valor : $aDetalle['original'];
                $copia = ($tipo_documento == "copia")? $valor : $aDetalle['copia']; 
                $NA = ($tipo_documento == "NA")? $valor : $aDetalle['NA'];
                
                //echo "$original, $copia, $NA <br>";
                
                //Eliminar Si no tiene nada seleccionado
                if ($original == "" && $copia == "" && $NA == 0){
                  
                    $this->db->where('id', $idDetalle);
                    $this->db->delete('saaPreregistro_Solicitudes');
                } else {
                
                    $data[$tipo_documento] = $valor;
                    
                    $this->db->where('id', $idDetalle);
                    $this->db->update('saaPreregistro_Solicitudes', $data); 
                }
                
                
            
            }else {
                /* 2. Si no existe el Detalle en el Preregistro Insertar */ 
                $data[$tipo_documento] = $valor;
                $data['idDocumento'] = $idDocumento;
                $data['idPreregistro'] = $idPreregistro;
                $data['noSolicitud'] = $noSolicitud;
                $this->db->insert('saaPreregistro_Solicitudes', $data);
                $registro = $this->db->insert_id();
                
            }
            
        
        $this -> db -> trans_complete ();
        
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
        
        
    }
    
    public function get_solicitudes($ot){
        $this->db->select('MAX(p.noSolicitudes) AS noSolicitudes');
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Solicitudes AS s', 's.idPreregistro = p.id');       
        $this->db->where('idArchivo', $ot);
        
        $detalle = $this->db->get()->row_array();
        return (isset($detalle['noSolicitudes'])? $detalle['noSolicitudes']: 0);
    }

    public function traer_documentos_subproceso($idSubProceso){
        
        $this->db->where('idSubProceso', $idSubProceso);
        return $this->db->get('saaDocumentos_Obra'); 
    }
    
    public function traer_preregistro($idProyecto){
        $this->db->where('id', $idProyecto); 
        return $this->db->get('saaPreregistro')->row_array(); 
    }
    
    public function  traer_doc_estimaciones($idPlantilla){
        $this->db->select("d.*, dir.Nombre as Direccion");
        $this->db->from('saaDocumentos_Obra as d');
        $this->db->join('catDirecciones as dir', 'dir.id = d.idDireccion', 'left');
        $this->db->where("idPlantilla = $idPlantilla AND idSubProceso = 11 ");
        
        $this->db->order_by('ordenar ASC');
        return $this->db->get(''); 
    }
    
    public function  traer_doc_solicitudes($idPlantilla){
        $this->db->select("d.*, dir.Nombre as Direccion");
        $this->db->from('saaDocumentos_Obra as d');
        $this->db->join('catDirecciones as dir', 'dir.id = d.idDireccion', 'left');
        $this->db->where("idPlantilla = $idPlantilla AND idSubProceso = 12 ");
        
        $this->db->order_by('ordenar ASC');
        return $this->db->get(''); 
    }

    


    public function traer_documentos_de_archivo($idPlantilla, $idArchivo){
        
        $this->db->select("d.*, dir.Nombre as Direccion");
        $this->db->from('saaDocumentos_Obra as d');
        $this->db->join('catDirecciones as dir', 'dir.id = d.idDireccion', 'left');
        $this->db->where("idSubProceso != 12 and  idSubProceso != 11 AND (idPlantilla = $idPlantilla OR idArchivo = $idArchivo)");
        
        $this->db->order_by('ordenar ASC');
        return $this->db->get(''); 
        
    }
    
    public function make_query(){  
        $this->db->select('p.*, a.OrdenTrabajo, u.Nombre, d.Nombre as direccion');
        $this->db->from('preregistro as p'); 
        $this->db->join('saaArchivo as a', 'a.id = p.idArchivo'); 
        $this->db->join('catUsuarios as u', 'u.id = p.idUsuario_asignado', 'left'); 
        $this->db->join('catDirecciones as d', 'd.id = p.idDireccion', 'left'); 
        
       
        
        
       
           
            
           if(isset($_POST["search"]["value"]))  
           {  
                $search = $_POST["search"]["value"];
                
                $where = "p.Estatus > 0 and (folio like '%$search%' or  
                        a.OrdenTrabajo like '%$search%' or
                        u.Nombre like '%$search%' or 
                        d.Nombre like '%$search%' or p.TipoPreregistro like '%$search%')
                        ";
                //echo $where;
                $this->db->where($where); 
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else 
           {  
                $this->db->order_by('id', 'DESC');  
           }  
            
        
            
           
    } 
    
    public function get_documentos_archivo($idArchivo, $idPlantilla){
        $this->db->where("idSubProceso != 11 AND (idArchivo = $idArchivo OR idPlantilla = $idPlantilla)");
        return  $this->db->get('saaDocumentos_Obra')->num_rows();
    }
    
    public function get_documentos_estimaciones($idArchivo){
        $this->db->select("noEstimaciones");
        $this->db->where("id",  $idArchivo );
        $aEstimaciones = $this->db->get('saaArchivo')->row_array();
        
        return $aEstimaciones['noEstimaciones'] * 5;
    }
    
    public function get_documentos_solicitudes($idArchivo){
        $this->db->select("MAX(noSolicitudes) AS noSolicitides");
        $this->db->where("idArchivo",  $idArchivo );
        $aSolicitudes = $this->db->get('saaPreregistro')->row_array();
        
        //si hay solicitudes se restan las 3 primeras que se vieron en documentos
        return isset($aSolicitudes['noSolicitudes'])? ($aSolicitudes['noSolicitudes'] * 3) -3: 0;
        
    }


    public function  get_total_a_entregar($idArchivo, $idPlantilla){
        $documentos = $this->get_documentos_archivo($idArchivo, $idPlantilla);
        $documentos_estimaciones = $this->get_documentos_estimaciones($idArchivo);
        $documentos_solicitudes  = $this->get_documentos_solicitudes($idArchivo);
        
        return $documentos + $documentos_estimaciones +$documentos_solicitudes;
    }
    
    public function get_recibidos($idArchivo){
        
        $documentos = $this->get_documentos_recibidos($idArchivo);
        $documentos_estimaciones = $this->get_documentos_estimaciones_recibidos($idArchivo);
        $documentos_solicitudes  =  $this->get_documentos_solicitudes_recibidos($idArchivo);
        return $documentos + $documentos_estimaciones+ $documentos_solicitudes;
    }
    
    public function get_documentos_recibidos($idArchivo) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Detalles as d', 'p.id = d.idPreregistro');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('p.Estatus', 2);
        return  $this->db->get()->num_rows();
    }
    
    public function get_documentos_estimaciones_recibidos($idArchivo) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Estimaciones as d', 'p.id = d.idPreregistro');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('p.Estatus', 2);
        return  $this->db->get()->num_rows();
    }
    public function get_documentos_solicitudes_recibidos($idArchivo) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Solicitudes as d', 'p.id = d.idPreregistro');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('p.Estatus', 2);
        return  $this->db->get()->num_rows();
    }
    
     public function get_preregistrados($idArchivo){
        
        $documentos = $this->get_documentos_preregistrados($idArchivo);
        $documentos_estimaciones = $this->get_documentos_estimaciones_preregistradas($idArchivo);
        $documentos_solicitudes  =  $this->get_documentos_solicitudes_preregistradas($idArchivo);
       
        return $documentos + $documentos_estimaciones+ $documentos_solicitudes;
    }
    
    public function get_documentos_preregistrados($idArchivo) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Detalles as d', 'p.id = d.idPreregistro');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('p.Estatus', 2);
        return  $this->db->get()->num_rows();
    }
    
    public function get_documentos_estimaciones_preregistradas($idArchivo) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Estimaciones as d', 'p.id = d.idPreregistro');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('p.Estatus', 2);
        return  $this->db->get()->num_rows();
    }
    public function get_documentos_solicitudes_preregistradas($idArchivo) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Solicitudes as d', 'p.id = d.idPreregistro');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('p.Estatus', 2);
        return  $this->db->get()->num_rows();
    }


    public function get_archivos_totales_filtro_hector(){
        
        $this->db->where('idEjercicio', 2017); 
        $this->db->where('idBloqueObra', 6); 
        $this->db->order_by('ImporteContratado DESC'); 
        
        return $this->db->get('saaArchivo');
           
    }
    
    public function get_archivos_totales_filtro($ejercicio, $estatus, $grupo){
        
        
         
        
        if ($ejercicio > 0 && $ejercicio != 1){
            $this->db->where('idEjercicio', $ejercicio); 
        }
        if ($estatus != ""){
            $this->db->where('EstatusObra', $estatus); 
        }
        if ($grupo > 0){
            $this->db->where('idBloqueObra', $grupo); 
        }
        
        $this->db->order_by('ImporteContratado DESC'); 
        
        return $this->db->get('saaArchivo');
        
        
    }
    
    public function get_grupo($grupo){
        
        $this->db->where('id', $grupo); 
        $aGrupo = $this->db->get('saaBloqueObras')->row_array();
        return (isset($aGrupo['Nombre']) )? $aGrupo['Nombre'] : 0 ;
    }
    
    public function get_faltantes($idArchivo, $idPlantilla, $idDireccion){
        $this->db->select("o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND d.idDocumento = o.id LIMIT 1) AS entregados");
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where("(o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND d.idDocumento = o.id LIMIT 1) = 0
            AND o.idDireccion = $idDireccion ");
        
        return $this->db->get();
    }

    public function get_faltantes_hector($idArchivo, $idPlantilla, $tipo){
        // 0 o 1 Reporte Auditoría Fisico-Digital  2.-Reporte Auditoría Fisico 3.-Reporte Auditoría Digital
        if($tipo == 0 || $tipo ==1){
            $tipo = null;
        }else if($tipo ==2){
            $tipo = 0;
        }else{
            $tipo =1;
        }
        
            
            $condicion = ($tipo == null) ? "": " AND p.tipo = $tipo";
            $select = "o.* , dir.Nombre AS Direccion,
                    (SELECT COUNT(a.idDocumento) AS entregados FROM  (
                    SELECT idDocumento  FROM  `preregistroDetalles` AS d
                        INNER JOIN `saaPreregistro` AS p
                        ON d.idPreregistro = p.id

                        WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo $condicion
                        UNION 
                        SELECT idDocumento FROM  `preregistroEstimaciones` AS e
                        INNER JOIN `saaPreregistro` AS p
                        ON e.idPreregistro = p.id
                        WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo  $condicion
                        UNION 
                        SELECT idDocumento  FROM  `preregistroSolicitudes` AS s
                        INNER JOIN `saaPreregistro` AS p
                        ON s.idPreregistro = p.id
                        WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo $condicion

                    ) AS a 
                    WHERE idDocumento = o.id)AS entregados";
            $where = "o.tipoDocumento = 1 AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) 
                AND 
		(SELECT COUNT(a.idDocumento) AS entregados FROM  (
                    SELECT idDocumento  FROM  `preregistroDetalles` AS d
                        INNER JOIN `saaPreregistro` AS p
                        ON d.idPreregistro = p.id

                        WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo $condicion
                        UNION 
                        SELECT idDocumento FROM  `preregistroEstimaciones` AS e
                        INNER JOIN `saaPreregistro` AS p
                        ON e.idPreregistro = p.id
                        WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo  $condicion
                        UNION 
                        SELECT idDocumento  FROM  `preregistroSolicitudes` AS s
                        INNER JOIN `saaPreregistro` AS p
                        ON s.idPreregistro = p.id
                        WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo $condicion

                    ) AS a 
                    WHERE idDocumento = o.id)= 0";
            /*
            $select  = "o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 0 AND d.idDocumento = o.id LIMIT 1) AS entregados";
            
            $where = "o.tipoDocumento = 1 and idSubProceso != 11 AND idSubProceso != 12 AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 0 AND d.idDocumento = o.id LIMIT 1) = 0
            ";
            
            
        }else if($tipo == 3){
            $select  = "o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 1 AND d.idDocumento = o.id LIMIT 1) AS entregados";
            
            $where = "o.tipoDocumento = 1 and idSubProceso != 11 AND idSubProceso != 12 AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 1 AND d.idDocumento = o.id LIMIT 1) = 0
            ";
        }else{
            $select  = "o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND d.idDocumento = o.id LIMIT 1) AS entregados";
            
            $where = "o.tipoDocumento = 1 and idSubProceso != 11 AND idSubProceso != 12
                AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
                (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
                `saaPreregistro_Detalles` AS d
                ON d.idPreregistro = p.id

                WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND d.idDocumento = o.id LIMIT 1) = 0
            ";
        }
        */
        
        $this->db->select($select);
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where($where);
        $this->db->order_by("Ordenar");
        
       
        return $this->db->get();
    }
    
    
    public function get_faltantes_hector_direccion($ejercicio, $grupo, $idDireccion){
        // 0 o 1 Reporte Auditoría Fisico-Digital  2.-Reporte Auditoría Fisico 3.-Reporte Auditoría Digital
       
            $select = "o.* , a.OrdenTrabajo, a.ImporteContratado,
                    (SELECT COUNT(a.idDocumento) AS entregados FROM  (
                    SELECT idDocumento  FROM  `preregistroDetalles` AS d
                        INNER JOIN `saaPreregistro` AS p
                        ON d.idPreregistro = p.id

                        WHERE p.Estatus =2 
                        UNION 
                        SELECT idDocumento FROM  `preregistroEstimaciones` AS e
                        INNER JOIN `saaPreregistro` AS p
                        ON e.idPreregistro = p.id
                        WHERE p.Estatus =2  
                        UNION 
                        SELECT idDocumento  FROM  `preregistroSolicitudes` AS s
                        INNER JOIN `saaPreregistro` AS p
                        ON s.idPreregistro = p.id
                        WHERE p.Estatus =2 

                    ) AS a 
                    WHERE idDocumento = o.id)AS entregados";
            $where = "a.idEjercicio = $ejercicio  AND a.`idBloqueObra` = $grupo AND (o.idDireccion  =$idDireccion  OR (o.idDireccion  = -1 AND a.`idDireccion` = $idDireccion))
                AND
		(SELECT COUNT(a.idDocumento) AS entregados FROM  (
                    SELECT idDocumento  FROM  `preregistroDetalles` AS d
                        INNER JOIN `saaPreregistro` AS p
                        ON d.idPreregistro = p.id

                        WHERE p.Estatus =2 
                        UNION 
                        SELECT idDocumento FROM  `preregistroEstimaciones` AS e
                        INNER JOIN `saaPreregistro` AS p
                        ON e.idPreregistro = p.id
                        WHERE p.Estatus =2 
                        UNION 
                        SELECT idDocumento  FROM  `preregistroSolicitudes` AS s
                        INNER JOIN `saaPreregistro` AS p
                        ON s.idPreregistro = p.id
                        WHERE p.Estatus =2 
                        
                    ) AS a 
                    WHERE idDocumento = o.id)= 0";
            
        $this->db->select($select);
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('ArchivoPlantilla as a', 'o.idPlantilla = a.`idPlantilla` ');
        $this->db->where($where);
        $this->db->order_by("Ordenar, Nombre");
        
       
        return $this->db->get();
    }
    
    public function get_faltantes_hector_estimaciones($idArchivo, $idPlantilla, $tipo){
        
         if($tipo == 2){
            $select  = "o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Estimaciones` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 0 AND d.idDocumento = o.id LIMIT 1) AS entregados";
            
            $where = "o.tipoDocumento = 1 and idSubProceso = 11  AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Estimaciones` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 0 AND d.idDocumento = o.id LIMIT 1) = 0
            ";
        
        }else if($tipo == 3){
            $select  = "o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Estimaciones` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 1 AND d.idDocumento = o.id LIMIT 1) AS entregados";
            
            $where = "o.tipoDocumento = 1 and idSubProceso = 11  AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Estimaciones` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND p.tipo = 1 AND d.idDocumento = o.id LIMIT 1) = 0
            ";
        }else{
            $select  = "o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
            `saaPreregistro_Estimaciones` AS d
            ON d.idPreregistro = p.id

            WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND d.idDocumento = o.id LIMIT 1) AS entregados";
            
            $where = "o.tipoDocumento = 1 and idSubProceso = 11 
                AND (o.idPlantilla = $idPlantilla OR o.idArchivo = $idArchivo) AND 
                (SELECT COUNT(p.id) FROM  `saaPreregistro` AS p  INNER JOIN 
                `saaPreregistro_Estimaciones` AS d
                ON d.idPreregistro = p.id

                WHERE p.Estatus =2 AND  p.idArchivo = $idArchivo AND d.idDocumento = o.id LIMIT 1) = 0
            ";
        }
        $this->db->select($select);
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where($where);
        
       
        return $this->db->get();
    }
    
    public function get_faltantes_ot($idArchivo, $idPlantilla, $idDireccion, $responsable){
        $this->db->select("o.* , dir.Nombre as Direccion,
            (SELECT COUNT(p.id) FROM saaPreregistro AS p
            INNER JOIN saaPreregistro_Detalles AS d
            ON d.idPreregistro = p.id
            WHERE p.Estatus = 2 AND p.idArchivo = $idArchivo AND p.idDireccion = $idDireccion
            AND d.idDocumento = o.id)AS entregados");
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where("idSubProceso != 11 AND idSubProceso != 12 AND (idPlantilla = $idPlantilla OR idArchivo = $idArchivo) AND idDireccion = $idDireccion


            AND
            (SELECT COUNT(p.id) FROM saaPreregistro AS p
            INNER JOIN saaPreregistro_Detalles AS d
            ON d.idPreregistro = p.id
            WHERE p.Estatus = 2 AND p.idArchivo = $idArchivo AND p.idDireccion = $responsable
            AND d.idDocumento = o.id) = 0");
        
        return $this->db->get();
    }

    
    public function get_documentos_estimaciones_ot($idArchivo, $idPlantilla, $idDireccion, $responsable){

                
        $this->db->select("o.* , dir.Nombre as Direccion");
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where("idSubProceso = 11  AND (idPlantilla = $idPlantilla OR idArchivo = $idArchivo) AND idDireccion = $responsable");

        
        return $this->db->get();
    }
    
    public function get_documentos_estimaciones_total($idArchivo, $idPlantilla){

                
        $this->db->select("o.* , dir.Nombre as Direccion");
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where("idSubProceso = 11  AND (idPlantilla = $idPlantilla OR idArchivo = $idArchivo)");

        
        return $this->db->get();
    }
    
    public function get_direccion($id) {
        
        $this->db->where("id",  $id);
        $aDireccion = $this->db->get('catDirecciones')->row_array();
        
        return $aDireccion['Nombre'];
    }
    
    public function get_documentos_solicitudes_ot($idArchivo, $idPlantilla, $idDireccion, $responsable){

                
        $this->db->select("o.* , dir.Nombre as Direccion");
        $this->db->from('saaDocumentos_Obra as o');
        $this->db->join('catDirecciones as dir', 'dir.id = o.idDireccion');
        $this->db->where("idSubProceso = 12  AND (idPlantilla = $idPlantilla OR idArchivo = $idArchivo) AND idDireccion = $responsable");

        
        return $this->db->get();
    }
    
    public function get_documentos_estimaciones_entregados($idArchivo, $idDireccion, $idDocumento, $noEstimacion){
        
        $this->db->select("d.id");
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Estimaciones AS d', 'd.idPreregistro = p.id');
        $this->db->where("p.Estatus", 2);
        $this->db->where("p.idArchivo", $idArchivo);
        $this->db->where("p.idDireccion", $idDireccion);
        $this->db->where("d.idDocumento" , $idDocumento);
        $this->db->where("d.noEstimacion", $noEstimacion);
        return $this->db->get();
    }
    
    public function get_documentos_solicitudes_entregados($idArchivo, $idDireccion, $idDocumento, $noSolicitud){
        
        $this->db->select("d.id");
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Solicitudes AS d', 'd.idPreregistro = p.id');
        $this->db->where("p.Estatus", 2);
        $this->db->where("p.idArchivo", $idArchivo);
        $this->db->where("p.idDireccion", $idDireccion);
        $this->db->where("d.idDocumento" , $idDocumento);
        $this->db->where("d.noSolicitud", $noSolicitud);
        return $this->db->get();
    }

    
    public function make_query_ot($ejercicio, $estatus, $grupo){ 
        
       
 
        /*$this->db->select('a.id, a.OrdenTrabajo, a.EstatusObra,  a.idBloqueObra,
            (SELECT COUNT(id) FROM `saaDocumentos_Obra` WHERE idArchivo = a.id
            OR idPlantilla = (SELECT p.id FROM `saaArchivo` AS ar
            INNER JOIN `saaPlatillas` AS p 
            ON ar.`idModalidad` = p.idModalidad
            AND ar.`Normatividad` = p.Normatividad
            WHERE a.`idModalidad` = p.idModalidad
            AND ar.id = a.id)) AS doc_totales,

            (SELECT COUNT(DISTINCT d.idDocumento) FROM saaPreregistro AS p
            INNER JOIN `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id
            WHERE p.idArchivo = a.id AND  p.Estatus >0) AS pre,
            
            (SELECT COUNT(DISTINCT d.idDocumento) FROM saaPreregistro AS p
            INNER JOIN `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id
            WHERE p.idArchivo = a.id AND p.Estatus = 2) AS recibidos,
            
            (
            (SELECT COUNT(DISTINCT d.idDocumento) FROM saaPreregistro AS p
            INNER JOIN `saaPreregistro_Detalles` AS d
            ON d.idPreregistro = p.id
            WHERE p.idArchivo = a.id AND p.Estatus = 2)
            *100/
            (SELECT COUNT(id) FROM `saaDocumentos_Obra` WHERE idArchivo = a.id
            OR idPlantilla = (SELECT p.id FROM `saaArchivo` AS ar
            INNER JOIN `saaPlatillas` AS p 
            ON ar.`idModalidad` = p.idModalidad
            AND ar.`Normatividad` = p.Normatividad
            WHERE a.`idModalidad` = p.idModalidad
            AND ar.id = a.id))
            )AS Avance
           ');*/
        
      
        $this->db->select('a.id, a.OrdenTrabajo, a.EstatusObra,  a.idBloqueObra');
          
        $this->db->from('saaArchivo as a'); 
         
        
       
        
        
       
           
            
           if(isset($_POST["search"]["value"]))  
           {  
                //$ejercicio, $estatus, $grupo;
                        
                        
                $search = $_POST["search"]["value"];
                        
                if ($ejercicio == 1){
                    $where = "Estatus like '%$search%' or  
                            OrdenTrabajo like '%$search%' 
                            ";
                } else {
                    if ($ejercicio == 0 ){
                        $fecha_ini = (date('Y')-1) . '-01-01';
                        $fecha_fin = (date('Y')-1) . '-12-31';
                    } else {
                        $fecha_ini = $ejercicio . '-01-01';
                        $fecha_fin = $ejercicio. '-12-31';
                    }
                    $where = "FechaInicio BETWEEN '$fecha_ini' AND '$fecha_fin'  and (Estatus like '%$search%' or  
                            OrdenTrabajo like '%$search%' 

                             )
                            ";
                }
                if ($estatus != ""){
                    $where .= " AND EstatusObra = '$estatus'";
                }
                
                if ($grupo > 0){
                    $where .= " AND idBloqueObra = $grupo";
                }
                //echo $where;
                $this->db->where($where); 
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else 
           {  
                $this->db->order_by('id DESC');  
           }  
            
           
           
    } 
    
    
    function get_filtered_data(){  
        $this->make_query();  
        $query = $this->db->get();  
        return $query->num_rows();
           
            
          
    }       
      
    function get_all_data(){  
        $this->db->select('p.*, a.OrdenTrabajo, u.Nombre, d.Nombre as direccion');
        $this->db->from('saaPreregistro as p'); 
        $this->db->join('saaArchivo as a', 'a.id = p.idArchivo'); 
        $this->db->join('catUsuarios as u', 'u.id = p.idUsuario_asignado', 'left'); 
        $this->db->join('catDirecciones as d', 'd.id = p.idDireccion', 'left');  
        $this->db->where('p.Estatus >', 0);   
        return $this->db->count_all_results();  
    }
    
    function get_filtered_data_ot($ejercicio, $estatus, $grupo){  
        $this->db->select('a.id
           ');
        $this->db->from('saaArchivo as a');  
        if ($ejercicio != 1){
           
            if ($ejercicio == 0 ){
                $fecha_ini = (date('Y')-1) . '-01-01';
                $fecha_fin = (date('Y')-1) . '-12-31';
            } else {
                $fecha_ini = $ejercicio . '-01-01';
                $fecha_fin = $ejercicio. '-12-31';
            }
            $where = "FechaInicio BETWEEN '$fecha_ini' AND '$fecha_fin' 

                     
                    ";
        }
        if ($estatus != ""){
            $where .= " AND EstatusObra = '$estatus'";
        }

        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo";
        }
        //echo $where;
        $this->db->where($where);   
 
        $query = $this->db->get();  
        return $query->num_rows();
           
            
          
    }       
      
    function get_all_data_ot($ejercicio, $estatus, $grupo){  
          $this->db->select('a.id
           ');
        $this->db->from('saaArchivo as a');  
        if ($ejercicio != 1){
           
            if ($ejercicio == 0 ){
                $fecha_ini = (date('Y')-1) . '-01-01';
                $fecha_fin = (date('Y')-1) . '-12-31';
            } else {
                $fecha_ini = $ejercicio . '-01-01';
                $fecha_fin = $ejercicio. '-12-31';
            }
            $where = "FechaInicio BETWEEN '$fecha_ini' AND '$fecha_fin' 

                     
                    ";
        }
        if ($estatus != ""){
            $where .= " AND EstatusObra = '$estatus'";
        }

        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo";
        }
        //echo $where;
        $this->db->where($where);    
        return $this->db->count_all_results();  
    }
    
    
    public function make_datatables(){  
        $this->make_query(); 
        if($_POST["length"] != -1)  
        {  
             $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get(); 

        return $query->result();  
           
    } 
    
    public function make_datatables_ot($ejercicio, $estatus, $grupo){  
        $this->make_query_ot($ejercicio, $estatus, $grupo); 
        if($_POST["length"] != -1)  
        {  
             $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get(); 

        return $query->result();  
           
    }  
    
    public function traer_preregistrados($idPreregistro){
        
        
        $this->db->where('idPreregistro', $idPreregistro);;
        return $this->db->get('saaPreregistro_Detalles'); 
        
    }
    public function traer_preregistrados_estimaciones($idPreregistro){
        
        
        $this->db->where('idPreregistro', $idPreregistro);;
        return $this->db->get('saaPreregistro_Estimaciones'); 
        
    }
    
    public function traer_preregistrados_solicitudes($idPreregistro){
        
        
        $this->db->where('idPreregistro', $idPreregistro);;
        return $this->db->get('saaPreregistro_Solicitudes'); 
        
    }

    
    public function get_total_documentos_proceso($id, $modalidad, $normatividad){
        
        $this->db->select("id");
        $this->db->from('plantilla');
        $this->db->where('idModalidad', $modalidad);
        $this->db->where('Normatividad', $normatividad);
        $this->db->where('idProceso', $id);
        $query = $this->db->get()->num_rows();
        return $query;
    }
    
    
    public function get_total_documentos_proceso_preregistrados($idArchivo, $idProceso, $idDireccion, $modalidad, $normatividad){
          
        $this->db->select("id");
        $this->db->from('plantilla as p');
        $this->db->join('saaRel_Archivo_Preregistro AS pre', 'pre.idRel_Plantilla_Documento = p.id');
        $this->db->where('p.idModalidad', $modalidad);
        $this->db->where('p.Normatividad', $normatividad);
        $this->db->where('pre.idArchivo', $idArchivo);
        $this->db->where('pidProceso', $id);
        $this->db->where('pre.idDireccion_responsable', $idDireccion);
        $query = $this->db->get()->num_rows();
        return $query;
    }
    
    public function actualizar_preregistrados(){
        $prerregistros = $this->db->get('saaRel_Archivo_Preregistro');
        
        $this -> db -> trans_start (); 
        
            foreach($prerregistros->result() as $row) {
                $id_Rel_Archivo_Documento = $row->id_Rel_Archivo_Documento;
                
                //Sacar idDocumento
                $this->db->select('idDocumento');
                $this->db->where('id', $id_Rel_Archivo_Documento);
                $documento = $this->db->get('saaRel_Archivo_Documento');
                if($documento->num_rows() > 0){
                    $aDocumento = $documento->row_array();
                    $idDocumento = $aDocumento['idDocumento'];
                }else {
                    //Buscar en Historico
                    
                    $tabla =  "saaRel_Archivo_Documento";       
                    $this->db->select('DatosAnterior');
                    $this->db->where('Tabla', $tabla);
                    $this->db->where('idCambiado',  $id_Rel_Archivo_Documento);
                    $this->db->where('DatosAnterior is not NULL');
                    $aDatos = $this->db->get('sisHistorico_archivo')->row_array();
                    $idDocumentoAnterior = $aDatos['DatosAnterior'];
                    
                    
                    $array = explode(",", $aDatos['DatosAnterior'] );
                    
                    //saco el numero de elementos
                    $longitud = count($array);
                    
                    $findme = 'idDocumento';
                    //Recorro todos los elementos
                    for($i=0; $i<$longitud; $i++)
                    {
                        //saco el valor de cada elemento
                        
                        $mystring = $array[$i];
                        $pos = strpos($mystring, $findme);

                        // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
                        // porque la posición de 'a' está en el 1° (primer) caracter.
                        if ($pos === false) {
                            
                        }else{
                           
                            echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
                            echo " y existe en la posición $pos";
                            
                            $mystring = str_replace("[", "", $mystring);
                            $mystring = str_replace("]", "", $mystring);
                            $mystring = str_replace("=>", "", $mystring);
                            $mystring = str_replace("idDocumento", "", $mystring);
                            
                            echo "mi string " .$mystring;
                            echo "<br>";
                           
                    
                            $idDocumento = $mystring;
                            echo "<br> idDocumento  <br>". $idDocumento;
                        }
                        
                        

                    }
                    
                    
                }
                
                echo "Preregistro $row->id - Rel-Archivo-Documento $id_Rel_Archivo_Documento - Documento $idDocumento";
                
                
                //Verificar si en la platilla del archivo existe el documento
                $idArchivo = $row->idArchivo;
                $this->db->where('id', $idArchivo);
                $aArchivo = $this->db->get('saaArchivo')->row_array();
                
                $modalidad = $aArchivo['idModalidad'];
                $normatividad = $aArchivo['Normatividad'];
                
                $this->db->select('*');
                $this->db->where('idModalidad', $modalidad);
                $this->db->where('Normatividad', $normatividad);
                $this->db->where('idDocumento', $idDocumento);
                
                $plantilla_documento = $this->db->get('plantilla');
                $registros = $plantilla_documento->num_rows();
                
                if($registros >0){
                    foreach($plantilla_documento->result() as $result){
                    
                        //Insertar idRel_Plantilla_Documento
                        $data['idRel_Plantilla_Documento'] = $result->id;
                    }
                    
                     
                } else {
                    $data['idRel_Plantilla_Documento'] = -1;
                }
                
                
                //idPlantillaDocumento
                
                $this->db->select('id');
                $this->db->where('idModalidad', $modalidad);
                $this->db->where('Normatividad', $normatividad);
                $idPlantilla_Archivo = $this->db->get('saaPlatillas')->row_array();
                
                //Nombre Documento
                
                $this->db->select('Nombre');
                $this->db->where('id', $idDocumento);
                $nombre = $this->db->get('saaDocumentos')->row_array();
                
                //Buscar el id del documento
                $this->db->select('pla.*, d.Nombre');
                $this->db->from('saaRel_Plantilla_Documento AS pla');
                $this->db->join('saaDocumentos AS d', 'd.id = pla.idDocumento');
                $this->db->where('idPlantilla', $idPlantilla_Archivo['id']);
                $this->db->where('Nombre', $nombre['Nombre']);
                $plantilla_array= $this->db->get()->row_array();
                
                $id_documento_plantilla = $plantilla_array['idDocumento'];
                        
               
                
                echo "Modalidad $modalidad - Nomatividad $normatividad -idRelPlantilla ". $data['idRel_Plantilla_Documento'] ."<br>";
                 
                 
                $data['idDocumento'] = $idDocumento;
                $data['idPlantilla_Archivo'] = $idPlantilla_Archivo['id'];
                $data['Nombre_Documento'] = $nombre['Nombre'];
                $data['idDocumento_Plantilla'] = $id_documento_plantilla;
                $id =  $row->id;   
                $this->db->where('id', $id);
                $this->db->update('saaRel_Archivo_Preregistro', $data); 
                
                
            }
        
        
        
        $this -> db -> trans_complete ();
        
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
    }
    
    public function update_saaEstimaciones(){
        //$this->db->where('idArchivo is NULL');
        $estimaciones = $this->db->get('saaEstimaciones');
        foreach($estimaciones ->result() as $row) {
            /*$idArchivo = -1;
            $idRAD =  $row->idRel_Archivo_Documento;
            
            $this->db->where('id',$idRAD);
            $rowRAD = $this->db->get('saaRel_Archivo_Documento');
            
            
            if ($rowRAD->num_rows() > 0){
                $aRAD = $rowRAD->row_array();
                
                $idArchivo = $aRAD['idArchivo'];
            }else {
                $this->db->where('id_Rel_Archivo_Documento', $idRAD);
                $rowRAP = $this->db->get('saaRel_Archivo_Preregistro');
                if ($rowRAP->num_rows() > 0){
                    $aRAP = $rowRAP->row_array();

                    $idArchivo = $aRAP['idArchivo'];
                }else{
                    $idArchivo = -1;
                }
            }
            echo "id $row->id  - idArchivo  $idArchivo -idRAD $idRAD <br>";
            
            $data['idArchivo'] = $idArchivo;
            $this->db->where('id', $row->id);
            $this->db->update('saaEstimaciones', $data); 
            */
            $idSubDocumento = $row->idSubDocumento;
            
            $idArchivo = $row->idArchivo;
            $this->db->where('id', $idArchivo);
            $aArchivo = $this->db->get('saaArchivo')->row_array();

            $modalidad = $aArchivo['idModalidad'];
            $normatividad = $aArchivo['Normatividad'];

            $this->db->select('*');
            $this->db->where('idModalidad', $modalidad);
            $this->db->where('Normatividad', $normatividad);
           

            $aPlantilla = $this->db->get('saaPlatillas')->row_array();
            $idPlantilla = $aPlantilla['id'];
            
            
            if ($idSubDocumento == 3){
                /*Inserto por Archivo en Documentos Obra */
                $data['Nombre'] ="11.1.6 CROQUIS";
                $data['idArchivo'] = $idArchivo;
                $data['idProceso'] = 3;
                $data['idSubProceso'] = 11;
                $data['Ordenar'] = 965;
                $data['idDireccion'] = -1;
                
                $this->db->insert('saaDocumentos_Obra', $data);
                $idDocumento_Nuevo= $this->db->insert_id();
                echo "<br>id insert $idDocumento_Nuevo";
                
                $data_e['idDocumento_Nuevo'] = $idDocumento_Nuevo;
                $this->db->where('id', $row->id);
                $this->db->update('saaEstimaciones', $data_e); 
                
                
            }else{
            
                if ($idSubDocumento == 9){
                    $find = "1 ESTIMACIONES";
                } else if($idSubDocumento == 1){
                    $find = "2 GENERADORES";
                }else if($idSubDocumento == 2){
                    $find = "3 NOTAS";
                }else if($idSubDocumento == 8){
                    $find = "4 CONTROLES";
                }else if($idSubDocumento == 4){
                    $find = "5 MINUTAS";
                }
                

                $this->db->select('id');
                $this->db->where("idPlantilla = $idPlantilla AND Nombre LIKE '%$find%'");
                $aDocumento= $this->db->get('saaDocumentos_Obra');
              
                
                if ($aDocumento->num_rows() >0 ){
                    $aDocumento = $aDocumento->row_array();
                    $idDocumento_Nuevo =  $aDocumento['id'];
                    $data_e['idDocumento_Nuevo'] = $idDocumento_Nuevo;
                    $this->db->where('id', $row->id);
                    $this->db->update('saaEstimaciones', $data_e); 
                    
                }else{
                    echo "<br>Nuevo no  encontrado" ;
                }
                
                echo "<br>$find" ;
            }
            
            echo "id $row->id idPlantilla $idPlantilla  id Archivo $idArchivo <br>";
            
            
            
            
        }
        
    }
    
    public function eliminar_duplicados(){
        $preregistros = $this->db->get('saaPreregistro');
        
        foreach($preregistros->result() as $pre) {
            //echo $pre->id . "Folio 1 - <br>";
            $this->db->where('idPreregistro', $pre->id);
            $this->db->order_by('idDocumento asc');
            $detalles = $this->db->get('saaPreregistro_Detalles');
            
            $doc_ant = "";
             $id_doc_ant = "";
            foreach($detalles->result() as $row) {
                //echo $row->id . "idDetalle 1- <br>";
                $doc_actual = $row->idDocumento;
                if($doc_actual == $doc_ant ){
                    echo $pre->id . "Folio - ";
                    echo $row->id . "idDetalle - ";
                    echo $doc_ant . "Anterior - ";
                    echo $id_doc_ant . "idDetalle Anterior - ";
                    
                    echo $row->idDocumento . " idDocumento <br> ";
                    
                    $this->db->where('id', $id_doc_ant);
                    $this->db->delete('saaPreregistro_Detalles');
                     
                }
                
                $doc_ant = $row->idDocumento;
                $id_doc_ant = $row->id;
                
            }
            
            
        }
    }
    
    
    /*Sacar el idDocumento "El Anterior" */
    public function update_Preregistros(){
        //$this->db->where('idDocumento is NULL');
        $preregistros = $this->db->get('saaRel_Archivo_Preregistro');
        foreach($preregistros ->result() as $row) {
            
            /* Sacar idDocumento   (Anterior) */
            $idRAD =  $row->id_Rel_Archivo_Documento;
            
            $this->db->where('id', $idRAD);
            $rowRAD = $this->db->get('saaRel_Archivo_Documento');
            
            
            if ($rowRAD->num_rows() > 0){
                $aRAD = $rowRAD->row_array();
                
                $idDocumento = $aRAD['idDocumento'];
                
            }else {
               
                $tabla = 'saaRel_Archivo_Documento';
                $this->db->where('Tabla', $tabla);
                $this->db->where('idCambiado',$idRAD);
              
                
                $rowHistorico = $this->db->get('sisHistorico_archivo');
                
                if ($rowHistorico->num_rows() > 0){
                    $aHistorico = $rowHistorico->row_array();
                    
                    if ($aHistorico['DatosAnterior'] != NULL){
                        echo "!= null <br>";
                        $find = $aHistorico['DatosAnterior'];
                    }else{
                        $find = $aHistorico['DatosNuevos'];
                    }
                    
                    $array = explode(",", $find);
                    
                    //saco el numero de elementos
                    $longitud = count($array);
                    
                    $findme = 'idDocumento';
                    //Recorro todos los elementos
                    for($i=0; $i<$longitud; $i++)
                    {
                        //saco el valor de cada elemento
                        
                        $mystring = $array[$i];
                        $pos = strpos($mystring, $findme);

                        // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
                        // porque la posición de 'a' está en el 1° (primer) caracter.
                        if ($pos === false) {
                            
                        }else{
                           
                            echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
                            echo " y existe en la posición $pos";
                            
                            $mystring = str_replace("[", "", $mystring);
                            $mystring = str_replace("]", "", $mystring);
                            $mystring = str_replace("=>", "", $mystring);
                            $mystring = str_replace("idDocumento", "", $mystring);
                            
                            echo "mi string " .$mystring;
                            echo "<br>";
                           
                    
                            $idDocumento = $mystring;
                            echo "<br> idDocumento  <br>". $idDocumento;
                        }
                        
                        

                    }
                    
                }else{
                    $idDocumento = -1;
                }
            }
            
            
            if ( $idDocumento != -1){
                $this->db->where('id', $idDocumento);
                $aDocumento = $this->db->get('saaDocumentos')->row_array();
                $data['Nombre_Documento'] =  $aDocumento['Nombre'];
                
                echo "id $row->id  - idADocumento  $idDocumento -idRAD $idRAD". $aDocumento['Nombre'] ." <br>";
            }else{
                $data['Nombre_Documento'] =  "";
                echo "id $row->id  - idADocumento  $idDocumento -idRAD $idRAD <br> sin Nombre________________________________";
            }
            
            /* Fin Sacar idDocumento   (Anterior) */
            
            /* Sacar idPlantilla   idPlantila_Archivo */
            $idArchivo = $row->idArchivo;
            $this->db->where('id', $idArchivo);
            $aArchivo = $this->db->get('saaArchivo')->row_array();
            
            $modalidad = $aArchivo['idModalidad'];
            $normatividad = $aArchivo['Normatividad'];
            
            $this->db->select('*');
            $this->db->where('idModalidad', $modalidad);
            $this->db->where('Normatividad', $normatividad);
            $aPlantilla = $this->db->get('saaPlatillas')->row_array();
            $idPlantilla = $aPlantilla['id'];
            
            
            echo "idPlantilla $idPlantilla <br>";
            
            /* Fin Sacar idPlantilla   idPlantila_Archivo */
            
            /* Sacar idDocumentoPlantilla   Nuevo */
            
            
            /* Fin Sacar idDocumentoPlantilla   Nuevo */
            
            
             $data['idPlantilla_Archivo'] = $idPlantilla;
            $data['idDocumento'] = $idDocumento;
            $this->db->where('id', $row->id);
            $this->db->update('saaRel_Archivo_Preregistro', $data); 
            
            
            
              
            
        }
        
    }
    
    
    public function update_preregistros_idPlantilla(){
        $this->db->where('idPlantilla_Archivo is NULL');
        $preregistros = $this->db->get('saaRel_Archivo_Preregistro');
        foreach($preregistros ->result() as $row) {
            $idArchivo = $row->idArchivo;
            $this->db->where('id', $idArchivo);
            $aArchivo = $this->db->get('saaArchivo')->row_array();

            

            $this->db->select('*');
            $this->db->where('idModalidad', $modalidad);
            $this->db->where('Normatividad', $normatividad);
           

            $aPlantilla = $this->db->get('saaPlatillas')->row_array();
            $idPlantilla = $aPlantilla['id'];
            echo "idPlantilla $idPlantilla <br>";
            
            
            
            
            $data['idPlantilla_Archivo'] = $idPlantilla;
            $this->db->where('id', $row->id);
            $this->db->update('saaRel_Archivo_Preregistro', $data); 
            
        }
        
    }
    
    public function update_preregistros_idDocumento_Nuevo(){
        //$this->db->where('idDocumento_Plantilla is NULL');
        $this->db->where('idDocumento >', 0);
        $preregistros = $this->db->get('saaRel_Archivo_Preregistro');
        $i =1;
        foreach($preregistros ->result() as $row) {
            $idDocumento = $row->idDocumento;
            
            
            $find = $row->Nombre_Documento;
            $idPlantilla = $row->idPlantilla_Archivo;
            
            
            
            $this->db->select('*');
            $this->db->where("Nombre like '%$find%' and  idPlantilla = $idPlantilla");
            $rNuevo = $this->db->get('saaDocumentos_Obra');
            
            if ($rNuevo->num_rows() > 0){
                $aNuevo = $rNuevo->row_array();
                $idNuevo =  $aNuevo['id'];
                
            }else{
                
                $this->db->select('*');
                $this->db->where("idPlantilla", $idPlantilla);
                $this->db->where("idDocumento", $idDocumento);
                $rRelacion = $this->db->get('saaRel_Documentos_Documentos_Obra');
                if ($rRelacion->num_rows() > 0){
                    $aRelacion = $rRelacion->row_array();
                    $idNuevo =  $aRelacion['idDocumento_Obra'];
                }else{
                
                    $idNuevo = -1;
                }
            }
            
            echo "id $row->id - idDoc $idDocumento - idPlantilla $idDocumento - idNuevo $idNuevo -no $i<br>";
            $data['idDocumento_Plantilla'] = $idNuevo;
            $this->db->where('id', $row->id);
            $this->db->update('saaRel_Archivo_Preregistro', $data); 
           $i++;
        }
        
    }
    
    
    
    
    public function actualizar_preregistrados_usuario(){
        
        
                
        /*Todos las OT con Preregistros */        
        $this->db->select('p.idArchivo, u.idDireccion_responsable');
        $this->db->distinct(); 
        $this->db->from('saaRel_Archivo_Preregistro as p');
        $this->db->join('catUsuarios as u', 'u.id = p.idUsuario_preregistra');
        
        $this->db->order_by('u.idDireccion_responsable asc');
        $ot_con_preregistros = $this->db->get();
        
        $this -> db -> trans_start (); 
        
            foreach($ot_con_preregistros->result() as $row) {
                
                
                /*
                 * 
                 *  Crear preregistro 
                 * 
                */
                
                
                /*
                 *  1. Crear Cabecera
                */
                
                $idArchivo = $row->idArchivo;
                $idDireccion = $row->idDireccion_responsable;
                
                $this->db->select('p.idUsuario_preregistra,  p.fecha_preregistro');
                $this->db->distinct(); 
                $this->db->from('saaRel_Archivo_Preregistro as p');
                $this->db->join('catUsuarios as u', 'u.id = p.idUsuario_preregistra');
                $this->db->where('p.idArchivo', $idArchivo);
                $this->db->where('u.idDireccion_responsable', $idDireccion);
                $this->db->order_by('p.fecha_preregistro DESC');
                $this->db->limit(1);
                $aPreregistro =  $this->db->get()->row_array();
                
                $fecha_registro = $aPreregistro['fecha_preregistro'];
                $idUsuario = $aPreregistro['idUsuario_preregistra'];
                
                
                /* sacar no estimaciones */
               
                $this->db->select('MAX(Numero_Estimacion) AS noEstimaciones');
                $this->db->from('saaEstimaciones AS e');
                $this->db->join('catUsuarios as u', 'u.id = e.idUsuario');
                $this->db->where('e.idArchivo', $idArchivo);
                $this->db->where('u.idDireccion_responsable', $idDireccion);
                
                $aMax = $this->db->get()->row_array();
                $noEstimaciones = $aMax['noEstimaciones'];
                
                
                /*sacar no Solicitudes */
                
                $this->db->select('MAX(Numero_Concepto) AS noSolicitudes');
                $this->db->from('saaRel_Archivo_Documento AS d');
                $this->db->join('saaRel_Archivo_Preregistro AS p', 'p.id_Rel_Archivo_Documento = d.id');
                $this->db->join('catUsuarios as u', 'u.id = p.idUsuario_preregistra');
                $this->db->where('p.idArchivo', $idArchivo);
                $this->db->where('u.idDireccion_responsable', $idDireccion);
                
                $aMax_Solicitud = $this->db->get()->row_array();
                $noSolicitudes = $aMax_Solicitud['noSolicitudes'];  
                
                $cabecera = array(
                    'idArchivo'    => $idArchivo,
                    'idUsuario_registra'    => $idUsuario,
                    'idDireccion'  => $idDireccion,
                    'fecha_registro' => $fecha_registro,
                    'Estatus' => 1,
                            
                );
                
                $cabecera['noEstimaciones'] = $noEstimaciones > 0 ? $noEstimaciones : 0;
                $cabecera['noSolicitudes']  = $noSolicitudes > 0 ? $noSolicitudes : 0;
                
                var_dump($cabecera);
                echo "<br>";
                
                $this->db->insert('saaPreregistro', $cabecera);
                $idPreregistro = $this->db->insert_id();
                
                
                /*
                 *  2. Insertar Detalles Preregistro
                 */
                
                
                $sql = "SELECT RAP.id, RAP.idArchivo, RAP.idPlantilla_Archivo, RAP.idDocumento, d.Nombre , RAP.tipo_documento, RAP.noHojas, RAP.idUsuario_preregistra, dir.id,
                    RAP.idDocumento_Plantilla,
                    (SELECT  GROUP_CONCAT(Motivo SEPARATOR ' - ') FROM `saaObservaciones_Documento` AS obs  WHERE obs.idDocumento = RAP.idDocumento AND RAP.idArchivo = obs.idArchivo AND obs.idUsuario = RAP.idUsuario_preregistra GROUP BY idDocumento  )AS Observacion
                    FROM `saaRel_Archivo_Preregistro` AS RAP
                    INNER JOIN `saaDocumentos` AS d ON d.id = RAP.idDocumento
                    INNER JOIN `catUsuarios` AS u
                    ON u.id = RAP.`idUsuario_preregistra`
                    INNER JOIN `catDirecciones` AS dir
                    ON dir.id = u.idDireccion_responsable
                    WHERE  
                    RAP.eliminacion_logica = 0  AND RAP.idDocumento_Plantilla > 0 AND  RAP.idDocumento !=  114 AND
                    RAP.idDocumento != 334 AND RAP.idDocumento != 120
                    AND RAP.idDocumento != 121 AND RAP.idDocumento != 274
                    AND RAP.idDocumento != 122 AND RAP.idArchivo = $idArchivo AND dir.id = $idDireccion";
                
                $detalles_preregistro = $this->db->query($sql, array($idArchivo, $idDireccion));
                var_dump($detalles_preregistro->result());
                echo "<br><br><hr>";
                
                foreach ($detalles_preregistro->result() as $det){
                    
                    if ($det->tipo_documento == 1){
                        $tipo = "copia";
                    }
                    else if($det->tipo_documento == 2){
                        $tipo = "original";
                    }else{
                        $tipo =  "NA";
                    }
                    if ($det->idDocumento_Plantilla == NULL) echo "NULL id Documento <hr>";
                    $aDetalles_preregistro = array (
                        'idDocumento' => $det->idDocumento_Plantilla,
                        'observacion' => $det->Observacion,
                        'idPreregistro' =>$idPreregistro,
                        $tipo =>$det->noHojas,
                    );
                    
                    $this->db->insert('saaPreregistro_Detalles', $aDetalles_preregistro);
                    $idPreregistro_Detalle = $this->db->insert_id();
                    echo $idPreregistro_Detalle. "idP_detalle<br>";
                    
                    
                }
                
                /*
                 *  3. Insertar Preregistro_Estimaciones
                 */
                $sql_estimaciones = "SELECT DISTINCT
                                Numero_Estimacion,
                                idDocumento_Nuevo,
                                idUsuario,
                                idArchivo,
                                copia,
                                no_aplica,
                                original_recibido,
                                noHojas,
                                fecha_preregistro, fecha_ingreso, preregistro_aceptado, idUsuario_acepta,
                                idUsuario_recibio ,  dir.id AS idDireccion,
                                (SELECT  GROUP_CONCAT(Motivo SEPARATOR ' - ') FROM `saaObservaciones_Estimaciones` AS obs  WHERE obs.idEstimacion = e.id AND e.idArchivo = obs.idArchivo AND obs.idUsuario = e.idUsuario GROUP BY idEstimacion  )AS Observacion
                                FROM `saaEstimaciones`  AS e 
                                INNER JOIN `catUsuarios` AS u
                                ON u.id = e.idUsuario
                                INNER JOIN `catDirecciones` AS dir
                                ON dir.id = u.idDireccion_responsable
                                WHERE
                                (e.copia = 1 OR e.original_recibido = 1 OR e.no_aplica= 1) AND eliminacion_logica = 0
                                AND idArchivo = $idArchivo AND dir.id = $idDireccion";
                $estimaciones = $this->db->query($sql_estimaciones, array($idArchivo, $idDireccion));
                
                foreach ($estimaciones->result() as $est){
                     if ($est->copia == 1){
                        $tipo = "copia";
                    }
                    else if($est->original_recibido == 1){
                        $tipo = "original";
                    }else if ($est->no_aplica == 1){
                        $tipo =  "NA";
                    }
                    
                    $aDetalles_estimaciones= array (
                        'idDocumento' => $est->idDocumento_Nuevo,
                        'observacion' => $est->Observacion,
                        'idPreregistro' =>$idPreregistro,
                        'noEstimacion' => $est->Numero_Estimacion,
                        $tipo =>$est->noHojas,
                    );
                    
                     
                             
                    
                        $this->db->insert('saaPreregistro_Estimaciones', $aDetalles_estimaciones);
                        $idPreregistro_Estimacion = $this->db->insert_id();
                        echo $idPreregistro_Estimacion.  " idP_Estimacion <br>";
                    
                    
                }
                
                /*
                 *  3. Insertar Preregistro_Solicitudes
                 */
                $sql_solicitudes = "SELECT RAP.id, RAP.idArchivo,RAD.Numero_Concepto, RAP.idPlantilla_Archivo, RAP.idDocumento, d.Nombre , RAP.tipo_documento, RAP.noHojas, RAP.idUsuario_preregistra, dir.id,
                    (SELECT id FROM `saaDocumentos_Obra` AS o  WHERE o.`Nombre` = d.Nombre AND o.`idPlantilla` = RAP.idPlantilla_Archivo  )AS Nuevo,
                    (SELECT  GROUP_CONCAT(Motivo SEPARATOR ' - ') FROM `saaObservaciones_Documento` AS obs  WHERE obs.idDocumento = RAP.idDocumento AND RAP.idArchivo = obs.idArchivo AND obs.idUsuario = RAP.idUsuario_preregistra GROUP BY idDocumento  )AS Observacion
                    FROM `saaRel_Archivo_Preregistro` AS RAP
                    INNER JOIN `saaRel_Archivo_Documento`  AS RAD
                    ON RAD.id = RAP.id_Rel_Archivo_Documento
                    INNER JOIN `saaDocumentos` AS d ON d.id = RAP.idDocumento
                    INNER JOIN `catUsuarios` AS u
                    ON u.id = RAP.`idUsuario_preregistra`
                    INNER JOIN `catDirecciones` AS dir
                    ON dir.id = u.idDireccion_responsable
                    WHERE  
                    RAP.eliminacion_logica = 0  AND RAP.idDocumento_Plantilla > 0 AND  
                    (RAP.idDocumento = 334 OR RAP.idDocumento = 120
                    OR RAP.idDocumento = 121 OR RAP.idDocumento = 274
                    OR RAP.idDocumento = 122) AND RAP.idArchivo = $idArchivo AND dir.id = $idDireccion";
                
                $solicitudes = $this->db->query($sql_solicitudes, array($idArchivo, $idDireccion));
                foreach ($solicitudes->result() as $sol){
                    
                    if ($sol->tipo_documento == 1){
                        $tipo = "copia";
                    }
                    else if($sol->tipo_documento == 2){
                        $tipo = "original";
                    }else{
                        $tipo =  "NA";
                    }
                    
                    $aDetalles_s = array (
                        'idDocumento' => $sol->Nuevo,
                        'observacion' => $sol->Observacion,
                        'idPreregistro' =>$idPreregistro,
                        'noSolicitud' => $sol->Numero_Concepto,
                        $tipo =>$sol->noHojas,
                    );
                    
                    $this->db->insert('saaPreregistro_Solicitudes', $aDetalles_s);
                    $idPreregistro_S= $this->db->insert_id();
                    echo $idPreregistro_S. "idSolicitud_detalle<br>";
                    
                    
                }
            }
        
        
        
        $this -> db -> trans_complete ();
        
        return ( $this -> db -> trans_status ()  ===  FALSE )? -1 : 1;
    }

    public function traer_documentos_direccion($idArchivo, $idSubProceso, $direccion){
        $sql= 'SELECT *
                FROM preregistro
                WHERE idArchivo =?
                AND idSubTipoProceso = ?
                AND (direccion_preregistra = ? OR direccion_preregistra IS  NULL)
                AND (eliminacion_logica = 0 OR eliminacion_logica IS NULL)
               ';
        $query = $this->db->query($sql, array($idArchivo, $idSubProceso, $direccion));
        return $query;
    }

    public function traer_documentos_recibidos($idArchivo, $idSubProceso){
        $sql= 'SELECT *
                FROM preregistro
                WHERE idArchivo =?
                AND idSubTipoProceso = ?
                AND (preregistro_aceptado = 1 OR preregistro_aceptado IS NULL )
                AND (eliminacion_logica = 0 OR eliminacion_logica IS NULL)
                ORDER BY Nombre ASC
               ';
        $query = $this->db->query($sql, array($idArchivo, $idSubProceso));
        return $query;
    }
    
    public function traer_documentos_recibidos_PRE_CID($idArchivo, $idSubProceso){
        $sql= 'SELECT *
                FROM preregistro
                WHERE idArchivo =?
                AND idSubTipoProceso = ?
                
                AND (eliminacion_logica = 0 OR eliminacion_logica IS NULL)
                ORDER BY Nombre ASC
               ';
        $query = $this->db->query($sql, array($idArchivo, $idSubProceso));
        return $query;
    }

    public function traer_documentos_revisar($idArchivo, $idSubProceso){
        $sql= 'SELECT *
                FROM preregistro
                WHERE idArchivo =?
                AND idSubTipoProceso = ?
                AND (recibido_cid = 1 OR recibido_cid IS NULL )
                AND (eliminacion_logica = 0 OR eliminacion_logica IS NULL)
               ';
        $query = $this->db->query($sql, array($idArchivo, $idSubProceso));
        return $query;
    }

    public function traer_documentos_finales($idArchivo, $idSubProceso){
        $sql= 'SELECT *
                FROM preregistro
                WHERE idArchivo =?
                AND idSubTipoProceso = ?
                AND (revisado = 1 OR revisado IS NULL )
                AND (eliminacion_logica = 0 OR eliminacion_logica IS NULL)
               ';
        $query = $this->db->query($sql, array($idArchivo, $idSubProceso));
        return $query;
    }
    
    public function retorna_historial($idArchivo, $Proceso, $idUsuario){
        $this->db->select('*');
        $this->db->where('idArchivo', $idArchivo);
        $this->db->where('idTipoProceso', $Proceso);
        $this->db->where('idUsuario', $idUsuario);
        return $this->db->get('saaHistorialBloque'); 
        
        
    }
    
    public function agregar_historial($data){
        $this->db->insert('saaHistorialBloque', $data);
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();

       
        
        if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saaHistorialBloque', 'Data' => $data, 'id' => $registro));
        }
        
        if ($aff < 1) {
            if (empty($e)) {
                $e = "No se realizaron cambios";
            }
            // si hay debug
            $e .= "<pre>" . $last_query . "</pre>";
            return array("retorno" => "-1", "error" => $e);
        } else {
            return array("retorno" => "1", "id_registro" => $registro);
        }
    }
    
    public function  datos_bd_insert($sqldata){
        $this->db->insert('saaRel_Documentos_Documentos_Obra', $sqldata);
    }
    
    public function get_subdocumentos($id, $direccion){
        $sql = 'SELECT `saaEstimaciones`.*, `saaSubDocumentos`.`Nombre`
                FROM `saaEstimaciones` 
                INNER JOIN `saaRel_Archivo_Documento`
                ON `saaEstimaciones`.`idRel_Archivo_Documento` = `saaRel_Archivo_Documento`.id
                INNER JOIN `saaSubDocumentos`
                ON `saaSubDocumentos`.id = `saaEstimaciones`.`idSubDocumento`
                WHERE `saaRel_Archivo_Documento`.idArchivo = ?
                AND `saaEstimaciones`.idDireccion_responsable = ?
                ORDER BY Numero_Estimacion, ordenar_subdocumento ASC';
        $query = $this->db->query($sql, array($id, $direccion));
        return $query;

    }
    
    public function aceptar_estimaciones($idRAD, $direccion, $data){
        $this->db->set($data);
        $this->db->where('idDireccion_responsable', $direccion);
        $this->db->where('idRel_Archivo_Documento', $idRAD);
        $this->db->where('preregistro_aceptado', 0);
        $this->db->where('eliminacion_logica', 0);
        $this->db->where('fecha_preregistro !=', 0);
        $this->db->update('saaEstimaciones');

       
       return  $this->db->affected_rows();
    }
    
    
    public function get_documentos_preregistro($idArchivo, $idDireccion) {
        $this->db->select('id_Rel_Archivo_Documento');
        $this->db->where('idArchivo', $idArchivo);
        $this->db->where('idDireccion_responsable', $idDireccion);
        $this->db->where('eliminacion_logica', 0);
        $this->db->where('preregistro_aceptado', 0);
        $this->db->where('tipo_documento !=', 4);
        return $this->db->get('saaRel_Archivo_Preregistro'); 
        
    }
    
    public function get_subdocumentos_preregistro($idArchivo, $idDireccion) {
        $this->db->select('e.id');
        $this->db->from('saaEstimaciones AS e');
        $this->db->join('saaRel_Archivo_Documento AS rel', 'e.idRel_Archivo_Documento = rel.id');
        $this->db->where('rel.idArchivo', $idArchivo);
        $this->db->where('e.idDireccion_responsable', $idDireccion);
        $this->db->where('e.eliminacion_logica', 0);
        $this->db->where('e.preregistro_aceptado', 0);
        $this->db->where('e.fecha_preregistro !=', 0);
        return $this->db->get(); 
        
    }
    
    
    public function listado_preregistrados($direccion){
        $this->db->select('p.*, a.OrdenTrabajo');
        $this->db->from('saaPreregistro as p'); 
        $this->db->join('saaArchivo as a', 'a.id = p.idArchivo'); 
        $this->db->where('p.idDireccion', $direccion);
        $this->db->where('p.Estatus >=', 0);
        $this->db->where('p.tipo', 0);
        return $this->db->get(); 
    }
    
    public function listado_preregistrados_cid(){
        $f = "IF(p.tipo = 1, 'Digital', 'Fisica')as Tipo" ;
        
        //$this->db->select("p.*, a.OrdenTrabajo, u.Nombre, d.Nombre as direccion, $f");
        $this->db->select('p.*, a.OrdenTrabajo, u.Nombre, d.Nombre as direccion');
        $this->db->from('saaPreregistro as p'); 
        $this->db->join('saaArchivo as a', 'a.id = p.idArchivo'); 
        $this->db->join('catUsuarios as u', 'u.id = p.idUsuario_asignado', 'left'); 
        $this->db->join('catDirecciones as d', 'd.id = p.idDireccion', 'left'); 
        $this->db->where('p.Estatus >', 0); 
        return $this->db->get(); 
    }
    
    public function asignar_usuario($id, $data){
        $this->db->where('id', $id);
        $this->db->update('saaPreregistro', $data); 
        $aff = $this->db->affected_rows();
        return $aff;
    }

    public function cambiar_estatus($id, $data){
       
        $this->db->where('id', $id);
        $this->db->update('saaPreregistro', $data); 
        $aff = $this->db->affected_rows();
        return $aff;
    }
    
    public function update_preregistro($id, $data){
       
        $this->db->where('id', $id);
        $this->db->update('saaPreregistro', $data); 
        $aff = $this->db->affected_rows();
        return $aff;
    }
    
    public function get_ejecutoras($ejercicio, $estatus, $grupo){
        
        $where =""; 
        $this->db->select("a.idDireccion, d.Nombre, d.Abreviatura");
        $this->db->distinct();
        $this->db->from('saaArchivo AS a');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        $where = "a.id > 0"; 
        
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        
        return $this->db->get();
    }
    public function get_ejecutoras_periodo($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final){
        
        $where =""; 
        $this->db->select("a.idDireccion, d.Nombre, d.Abreviatura");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        $where = "fecha_recibido between '$fecha_inicio' AND '$fecha_final' "; 
        
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        return $this->db->get();
    }
    
    public function get_entregados_direccion_totales($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final, $idDireccion) {
        
        $where = "p.idDireccion = $idDireccion"; 
        
        if ($fecha_inicio > 0 && $fecha_final > 0){
            $where .= " AND fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final' and p.Estatus = 2"; 
        }
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Detalles AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        
        $this->db->where($where);
        $documentos =  $this->db->get()->num_rows();
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*, det.noEstimacion");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Estimaciones AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
       
        
        $this->db->where($where);
        $estimaciones =  $this->db->get()->num_rows();
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*, det.noSolicitud");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Solicitudes AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        
        $this->db->where($where);
        $solicitudes =  $this->db->get()->num_rows();
        
        //echo "Direccion $idDireccion documentos $documentos estimaciones $estimaciones solicitudes $solicitudes <br>";
        return $documentos + $estimaciones + $solicitudes;
    }
    
    public function get_preregistrados_direccion($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final, $idDireccion) {
        
        $where = "p.idDireccion = $idDireccion"; 
        
        if ($fecha_inicio > 0 && $fecha_final > 0){
            $where .= " AND fecha_registro BETWEEN '$fecha_inicio' AND '$fecha_final'"; 
        }
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Detalles AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        
        $this->db->where($where);
        $documentos =  $this->db->get()->num_rows();
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*, det.noEstimacion");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Estimaciones AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
       
        
        $this->db->where($where);
        $estimaciones =  $this->db->get()->num_rows();
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*, det.noSolicitud");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Solicitudes AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        
        $this->db->where($where);
        $solicitudes =  $this->db->get()->num_rows();
        
        //echo "Direccion $idDireccion documentos $documentos estimaciones $estimaciones solicitudes $solicitudes <br>";
        return $documentos + $estimaciones + $solicitudes;
    }
    
    public function get_totales_a_entregar_ejecutora($ejercicio, $estatus, $grupo, $idDireccion) {
        
        //Documentos
        $this->db->select("a.id, a.OrdenTrabajo, a.idPlantilla, o.*");
        $this->db->from('ArchivoPlantilla AS a');
        $this->db->join('saaDocumentos_Obra AS o', 'o.idPlantilla = a.idPlantilla');
        $where = "o.idDireccion = -1 AND a.idDireccion =$idDireccion AND o.idSubProceso != 11 AND o.idSubProceso != 12";
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        } 
        
        $this->db->where($where);
        $documentos =  $this->db->get()->num_rows();
        
        $where = "";
        
        //no Estimaciones
        $this->db->select("SUM(noEstimaciones) AS noEstimaciones");
        $this->db->from('saaArchivo');
        $where = "idDireccion = $idDireccion";
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        $aEstimaciones = $this->db->get()->row_array();
        
        $where = "";
        
        //Documentos Estimaciones
        $this->db->select("a.id, a.OrdenTrabajo, a.idPlantilla, o.*");
        $this->db->from('ArchivoPlantilla AS a');
        $this->db->join('saaDocumentos_Obra AS o', 'o.idPlantilla = a.idPlantilla');
        $where = "o.idDireccion = -1 AND a.idDireccion =$idDireccion AND o.idSubProceso = 11";
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        } 
        
        $this->db->where($where);
        $estimaciones =  $this->db->get()->num_rows() * $aEstimaciones['noEstimaciones'];
        
        $where = "";
        //noSolicitudes
        $this->db->select("SUM(noSolicitudes) AS noSolicitudes");
        $this->db->from('SolicitudesArchivo');
        $where = "idDireccion = $idDireccion";
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        $aSolicitudes = $this->db->get()->row_array();
        
        $where = "";
        
        //Solicitudes
        $this->db->select("a.id, a.OrdenTrabajo, a.idPlantilla, o.*");
        $this->db->from('ArchivoPlantilla AS a');
        $this->db->join('saaDocumentos_Obra AS o', 'o.idPlantilla = a.idPlantilla');
        $where = "o.idDireccion = -1 AND a.idDireccion =$idDireccion AND o.idSubProceso = 12";
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        } 
        
        $this->db->where($where);
        $solicitudes =  $this->db->get()->num_rows() * $aSolicitudes['noSolicitudes'];
        
        return $documentos + $estimaciones + $solicitudes;
    }
    
    public function get_archivos_entregar_direccion($ejercicio, $estatus, $grupo, $idDireccion){
        $this->db->select("a.id");
        $this->db->distinct();
        $this->db->from('ArchivoPlantilla AS a');
        $this->db->join('saaDocumentos_Obra AS o', 'o.idPlantilla = a.idPlantilla');
        $where = "o.idDireccion = $idDireccion";
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        } 
        $archivos =  $this->db->get();
        
       
        return $archivos;
    }
    
    public function get_no_solicitudes_archivo($idArchivo) {
        $this->db->select("*");
        $this->db->from('SolicitudesArchivo');
        $this->db->where('id', $idArchivo);
        $aSolicitudes = $this->db->get()->row_array();
        
        return ($aSolicitudes['noSolicitudes'] > 0)? $aSolicitudes['noSolicitudes']: 0  ;
               
    }
    
    public function get_no_estimaciones_archivo($idArchivo) {
        $this->db->select("*");
        $this->db->from('saaArchivo');
        $this->db->where('id', $idArchivo);
        $aEstimaciones = $this->db->get()->row_array();
        
        return ($aEstimaciones['noEstimaciones'] > 0)? $aEstimaciones['noEstimaciones']: 0  ;
               
    }
    
    public function get_documentos_subproceso_archivo_direccion($idArchivo, $idSubProceso, $idDireccion){
        $this->db->select("a.id, a.OrdenTrabajo, a.idPlantilla, o.*");
        $this->db->from('ArchivoPlantilla AS a');
        $this->db->join('saaDocumentos_Obra AS o', 'o.idPlantilla = a.idPlantilla');
       
        
        $this->db->where('a.id', $idArchivo);
        $this->db->where('idSubProceso', $idSubProceso);
        $this->db->where('o.idDireccion', $idDireccion);
        return   $this->db->get()->num_rows();
    }
    
    public function get_documentos_subproceso_direccion($idSubProceso, $idDireccion, $tipo){
        $this->db->select("a.id, a.OrdenTrabajo, a.idPlantilla, o.*");
        $this->db->from('ArchivoPlantilla AS a');
        $this->db->join('saaDocumentos_Obra AS o', 'o.idPlantilla = a.idPlantilla');
        $this->db->where('idSubProceso', $idSubProceso);
        if($tipo == 1){
            $this->db->where('a.idDireccion', $idDireccion);
            $this->db->where('o.idDireccion', -1);
        }else{
            $this->db->where('o.idDireccion', $idDireccion);
        }
        return $this->db->get()->num_rows();
    }
    
    public function get_documentos_archivo_direccion($idPlantilla, $idArchivo,  $idDireccion){ 
        
        $this->db->where("idDireccion = $idDireccion AND (idArchivo = $idArchivo OR idPlantilla = $idPlantilla)");
        return   $this->db->get('saaDocumentos_Obra')->num_rows();
    }


    public function get_no_estimaciones_filtro($ejercicio, $estatus, $grupo, $idDireccion, $tipo){
            if($tipo == 1){
                $where = " a.idDireccion = $idDireccion AND o.idDireccion = -1 AND idSubProceso = 11 AND o.idPlantilla != 1 AND o.idPlantilla != 9 AND o.idPlantilla != 10"; 
            }else{
                $where = " o.idDireccion = $idDireccion AND idSubProceso = 11 AND o.idPlantilla != 1 AND o.idPlantilla != 9 AND o.idPlantilla != 10";  
            }
           
            
            if ($ejercicio > 0){
                $where .= " AND idEjercicio = $ejercicio"; 
            }
            if ($estatus !== ""){
                $where .= " AND EstatusObra = '$estatus'"; 
            }
            if ($grupo > 0){
                $where .= " AND idBloqueObra = $grupo"; 
            }     
            $this->db->select("SUM(noEstimaciones) AS TotalEstimaciones");
            $this->db->from ("(SELECT DISTINCT a.id,a.noEstimaciones FROM saaDocumentos_Obra AS o 
                JOIN ArchivoPlantilla AS a ON o.idPlantilla = a.idPlantilla
                JOIN `catDirecciones` AS d ON `o`.`idDireccion` = `d`.`id` WHERE  $where)a");
            
            $documentos = $this->db->get()->row_array();
            return $documentos['TotalEstimaciones'];
    }
    
    public function get_no_solicitudes_filtro($ejercicio, $estatus, $grupo, $idDireccion, $tipo){
            if($tipo == 1){
                $where = " a.idDireccion = $idDireccion AND o.idDireccion = -1 AND idSubProceso = 12 AND o.idPlantilla != 1 AND o.idPlantilla != 9 AND o.idPlantilla != 10"; 
            }else{
                $where = " o.idDireccion = $idDireccion AND idSubProceso = 12 AND  o.idPlantilla != 1 AND o.idPlantilla != 9 AND o.idPlantilla != 10";  
            }
            if ($ejercicio > 0){
                $where .= " AND idEjercicio = $ejercicio"; 
            }
            if ($estatus !== ""){
                $where .= " AND EstatusObra = '$estatus'"; 
            }
            if ($grupo > 0){
                $where .= " AND idBloqueObra = $grupo"; 
            }     
            $this->db->select("SUM(noSolicitudes) AS TotalSolicitudes");
            $this->db->from ("(SELECT DISTINCT a.id,a.noSolicitudes FROM  saaDocumentos_Obra AS o 
            JOIN ArchivoPlantilla AS a ON o.idPlantilla = a.idPlantilla
            JOIN `catDirecciones` AS d ON `o`.`idDireccion` = `d`.`id` WHERE  $where)a");
            
            $documentos = $this->db->get()->row_array();
            return ($documentos['TotalSolicitudes'] > 0)? $documentos['TotalSolicitudes'] : 0;
    }
    
    public function get_direcciones_responsables($ot){
        $this->db->select("o.idDireccion, d.Nombre, d.Abreviatura");
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra As o');
        $this->db->join('ArchivoPlantilla AS a', 'o.idPlantilla = a.idPlantilla');
        $this->db->join('catDirecciones as d', 'o.idDireccion = d.id');
        
        $this->db->where('a.id', $ot);
        $this->db->group_by('o.idDireccion');
        return $this->db->get();
    }
    
    public function get_direcciones_responsables_general($ejercicio, $estatus, $grupo){
        $this->db->select("d.id, d.Nombre, d.Abreviatura");
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra As o');
        $this->db->join('ArchivoPlantilla AS a', 'o.idPlantilla = a.idPlantilla');
        $this->db->join('catDirecciones as d', 'o.idDireccion = d.id or a.idDireccion = d.id');
        if ($ejercicio > 0){
            $this->db->where('a.idEjercicio', $ejercicio);
                
        }
        if ($estatus !== ""){
            $this->db->where('a.EstatusObra', $estatus);
            
        }
        if ($grupo > 0){
            $this->db->where('a.idBloqueObra', $grupo);
           
        }     
         $this->db->where('d.id >', 0);
        $this->db->group_by('d.Nombre');
        return $this->db->get();
    }
    
    
    public function get_reporte_auditoria_por_documento($ejercicio, $str_estatus, $grupo, $idDireccion){
       

        $this->db->select(" a.id, a.OrdenTrabajo, a.`idDireccion`,  (COUNT(o.id) -
(SELECT COUNT(DISTINCT OrdenTrabajo) AS entregados
FROM  (
SELECT  a.idDireccion AS Ejecutora, a.idEjercicio, a.OrdenTrabajo, a.`idBloqueObra`, p.Estatus AS e, o.*  FROM  `preregistroDetalles` AS d
		INNER JOIN `saaPreregistro` AS p
		ON d.idPreregistro = p.id
		INNER JOIN `saaArchivo` AS a
		ON a.id = p.idArchivo
		INNER JOIN `saaDocumentos_Obra` AS o
		ON o.id = d.idDocumento

UNION 
SELECT  a.idDireccion AS Ejecutora, a.idEjercicio, a.OrdenTrabajo, a.`idBloqueObra`, p.Estatus AS e, o.* FROM  `preregistroEstimaciones` AS d
		INNER JOIN `saaPreregistro` AS p
		ON d.idPreregistro = p.id
		INNER JOIN `saaArchivo` AS a
		ON a.id = p.idArchivo
		INNER JOIN `saaDocumentos_Obra` AS o
		ON o.id = d.idDocumento

UNION 
SELECT  a.idDireccion AS Ejecutora, a.idEjercicio, a.OrdenTrabajo, a.`idBloqueObra`, p.Estatus AS e, o.*  FROM  `preregistroSolicitudes` AS d
		INNER JOIN `saaPreregistro` AS p
		ON d.idPreregistro = p.id
		INNER JOIN `saaArchivo` AS a
		ON a.id = p.idArchivo
		INNER JOIN `saaDocumentos_Obra` AS o
		ON o.id = d.idDocumento
		) AS a
WHERE id = o.id  AND idEjercicio = $ejercicio  AND e = 2 AND idBloqueObra = $grupo
AND (idDireccion  =$idDireccion OR (idDireccion  = -1 AND Ejecutora = $idDireccion)))) AS faltantes, o.* ");
      
        $this->db->from('saaDocumentos_Obra As o');
        $this->db->join('ArchivoPlantilla AS a', 'o.idPlantilla = a.idPlantilla');
        $where = "a.idEjercicio = $ejercicio AND a.`idBloqueObra` = $grupo AND (o.idDireccion  =$idDireccion  OR (o.idDireccion  = -1 AND a.`idDireccion` = $idDireccion))";
        
            $this->db->where($where);
           
             
        
        $this->db->group_by('o.Nombre');
        $this->db->order_by('a.id ASC, o.`Ordenar` ASC');
        return $this->db->get();
    }
    

    

    public function get_totales_a_entregar($ejercicio, $estatus, $grupo, $idDireccion, $tipo) {
            /*Documentos obligados direccion */        
            $select = "SUM(Documentos_$idDireccion)as Documentos, SUM(Estimaciones_$idDireccion) as Estimaciones, SUM(Solicitudes_$idDireccion)as Solicitudes";
            $this->db->select($select); 
            $this->db->from('Tabla_General');
            $where = "id >0";
            if ($ejercicio > 0){
                $where .= " AND idEjercicio = $ejercicio"; 
            }
            if ($estatus !== ""){
                $where .= " AND EstatusObra = '$estatus'"; 
            }
            if ($grupo > 0){
                $where .= " AND idBloqueObra = $grupo"; 
            } 
            $documentos = $this->db->get()->row_array();
            
            
            
        
        return $documentos['Total'];
    }
    
    public function get_entregados_direccion_obligados($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final, $idDireccion, $ejecutora) {
        //Si es Ejecutora
        if($ejecutora == 1){
            $where = "p.idDireccion = $idDireccion AND o.idDireccion = -1"; 
        }else{
            $where = "p.idDireccion = $idDireccion AND o.idDireccion = $idDireccion"; 
        }
        
        if ($fecha_inicio > 0 && $fecha_final > 0){
            $where .= " AND fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final'"; 
        }
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        } 
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Detalles AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        
        
        $this->db->where($where);
        $documentos =  $this->db->get()->num_rows();
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*, det.noEstimacion");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Estimaciones AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        $this->db->where($where);
        $estimaciones =  $this->db->get()->num_rows();
        
        $this->db->select("det.idDocumento, p.idArchivo, p.idDireccion, o.*, det.noSolicitud");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Solicitudes AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        
        $this->db->where($where);
        $solicitudes =  $this->db->get()->num_rows();
        
        return $documentos + $estimaciones + $solicitudes;
    }
    
    public function get_obligadas_periodo($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final){
        
                
        $where =""; 
        $this->db->select("o.idDireccion, (SELECT Nombre FROM catDirecciones WHERE id = o.idDireccion) AS Nombre, "
                . "(SELECT Abreviatura FROM catDirecciones WHERE id = o.idDireccion) AS Abreviatura");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('saaPreregistro_Detalles AS det', 'det.idPreregistro = p.id');
        $this->db->join('saaDocumentos_Obra As o', 'o.id = det.idDocumento');
        $this->db->join('saaArchivo AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        $where = "fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final' AND o.idDireccion != -1"; 
        
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        return $this->db->get();
    }
    
    public function get_obligadas($ejercicio, $estatus, $grupo){
        
        $this->db->select("o.idDireccion, d.Nombre, d.Abreviatura");
        $this->db->distinct();
        $this->db->from('saaDocumentos_Obra As o');
        $this->db->join('ArchivoPlantilla AS a', 'o.idPlantilla = a.idPlantilla');
        $this->db->join('catDirecciones as d', 'o.idDireccion = d.id');
        $where = "o.idDireccion != -1"; 
        
        if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== ""){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        $this->db->group_by('o.idDireccion');
        return $this->db->get();
    }
    

    
    public function get_archivos_periodo($idDireccion, $ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final){
        
        $where =""; 
        $this->db->select("a.*");
        $this->db->distinct();
        $this->db->from('saaPreregistro AS p');
        $this->db->join('ArchivoPlantilla AS a', 'p.idArchivo = a.id');
        $this->db->join('catDirecciones as d', 'a.idDireccion = d.id');
        $where = "fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final' and a.idDireccion = $idDireccion"; 
        
         if ($ejercicio > 0){
            $where .= " AND idEjercicio = $ejercicio"; 
        }
        if ($estatus !== 0){
            $where .= " AND EstatusObra = '$estatus'"; 
        }
        if ($grupo > 0){
            $where .= " AND idBloqueObra = $grupo"; 
        }
        $this->db->where($where);
        return $this->db->get();
    }
    
    public function get_direccion_ejecutora($idArchivo) {
        $this->db->select("idDireccion");
        $this->db->where("id",  $idArchivo );
        $aArchivo = $this->db->get('saaArchivo')->row_array();
        return $aArchivo['idDireccion'];
    }
    
    public function get_recibidos_periodo($idArchivo, $idDireccion, $fecha_inicio, $fecha_final){
        $idDireccion_responsable = ($idDireccion == -1)?  -1: $idDireccion;
        $idDireccion = ($idDireccion == -1)?  $this->get_direccion_ejecutora($idArchivo): $idDireccion;
        
        
        
        $documentos = $this->get_documentos_recibidos_periodo($idArchivo, $idDireccion, $idDireccion_responsable, $fecha_inicio, $fecha_final);
        $documentos_estimaciones = $this->get_documentos_estimaciones_recibidos_periodo($idArchivo, $idDireccion, $idDireccion_responsable, $fecha_inicio, $fecha_final);
        $documentos_solicitudes  =  $this->get_documentos_solicitudes_recibidos_periodo($idArchivo, $idDireccion, $idDireccion_responsable, $fecha_inicio, $fecha_final);
        return $documentos + $documentos_estimaciones+ $documentos_solicitudes;
    }
    
    public function get_documentos_recibidos_periodo($idArchivo, $idDireccion, $idDireccion_responsable, $fecha_inicio, $fecha_final) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Detalles as d', 'p.id = d.idPreregistro');
        $this->db->join('saaDocumentos_Obra as o', 'd.idDocumento = o.id');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('o.idDireccion',  $idDireccion_responsable);
        $this->db->where('p.idDireccion', $idDireccion);
        $this->db->where('p.Estatus', 2);
        $this->db->where("fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final'");
        return  $this->db->get()->num_rows();
    }
    
    public function get_documentos_estimaciones_recibidos_periodo($idArchivo, $idDireccion, $idDireccion_responsable, $fecha_inicio, $fecha_final) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Estimaciones as d', 'p.id = d.idPreregistro');
        $this->db->join('saaDocumentos_Obra as o', 'd.idDocumento = o.id');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('o.idDireccion',  $idDireccion_responsable);
        $this->db->where('p.idDireccion', $idDireccion);
        $this->db->where('p.Estatus', 2);
        $this->db->where("fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final'");
        return  $this->db->get()->num_rows();
    }
    public function get_documentos_solicitudes_recibidos_periodo($idArchivo, $idDireccion, $idDireccion_responsable, $fecha_inicio, $fecha_final) {
        $this->db->select('d.idDocumento');
        $this->db->distinct();
        $this->db->from('saaPreregistro as p');
        $this->db->join('saaPreregistro_Solicitudes as d', 'p.id = d.idPreregistro');
        $this->db->join('saaDocumentos_Obra as o', 'd.idDocumento = o.id');
        $this->db->where('p.idArchivo', $idArchivo);
        $this->db->where('o.idDireccion',  $idDireccion_responsable);
        $this->db->where('p.idDireccion', $idDireccion);
        $this->db->where('p.Estatus', 2);
        $this->db->where("fecha_recibido BETWEEN '$fecha_inicio' AND '$fecha_final'");
        return  $this->db->get()->num_rows();
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