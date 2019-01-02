<?php


class Control_usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addw_Usuarios() {
        $query = $this->db->get('catUsuarios');
        $addw[0] = 'No Disponible';
        foreach ($query->result() as $rowdata) {
            $addw[$rowdata->id] = $rowdata->Nombre;
        }
        return $addw;
    }
    
    public function addw_tipos() {
        $query = $this->db->get('saatipo_usuarios');
        $addw[0] = 'No Disponible';
        foreach ($query->result() as $rowdata) {
            $addw[$rowdata->id] = $rowdata->Tipo;
        }
        return $addw;
    }


    public function listado() {
        $this->db->select("u.*, t.Tipo");
        $this->db->from("catUsuarios as u");
        $this->db->join("saatipo_usuarios as t", "u.idTipo = t.id", "left");
        $this->db->where("u.Estatus", 1);
        $this->db->order_by("id", "desc");
        return $this->db->get();
       
    }

    public function listado_tipos(){
        $this->db->where("Estatus",0);
        return $this->db->get("saatipo_usuarios");
    }
    
    
    

    
    
    
    
   
    
    public function datos_usuario($id) {
        $sql = 'SELECT * FROM catUsuarios
        WHERE id = ?';
        $query = $this->db->query($sql, array($id));
        return $query;
    }
    
    public function datos_usuario_insert($data) {
        $this->db->insert('catUsuarios', $data);
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
        $registro = $this->db->insert_id();
        //$this->db->db_debug = $oldv; 

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

    public function datos_usuario_update($data, $id) {
        $this->db->update('catUsuarios', $data, array('id' => $id));
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();

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
    }

    public function datos_usuario_delete($id) {
        $this->db->delete('catUsuarios', array('id' => $id));
        $e = $this->db->_error_message();
        $aff = $this->db->affected_rows();
        $last_query = $this->db->last_query();
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
    }
    
    public function menu_usuarios(){
        $menuUsuario = $this->db->get('saaMenu');
        return $menuUsuario;
    }
    
    public function menu_usuarios_sub($idModulo){
        $this->db->where('idModulo',$idModulo);
        $menuUsuarioSub = $this->db->get('saaMenuSub');
        return $menuUsuarioSub;
    }
    
    public function menus_subs(){
        $menuUsuarioSub = $this->db->get('saaMenuSub');
        return $menuUsuarioSub;
    }
    
    public function insert_permisos_nuevo($data){
        $this->db->insert('saaUsuarioPermisos', $data);
    }
    
    public function todos_los_usuarios(){
        $tUsuarios = $this->db->get('catUsuarios');
        return $tUsuarios;
    }
    
    public function permiso_especifico($idUsuario, $Permiso){
        $query = 'SELECT * FROM saaUsuarioPermisos WHERE idUsuario='.$idUsuario.' AND Permiso="'.$Permiso.'"';
        $data = $this->db->query($query);
        return $data;
    }

    
    public function update_permisos($id,$data){
        $this->db->where('id',$id);
        $this->db->update('saaUsuarioPermisos',$data);
        return $this->db->affected_rows();
    }

    public function agregar_tipo($data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido(strtoupper($data['Tipo']));
        if( !$repetido['ret'] ){
            $this->db->insert('saatipo_usuarios', $data);
            $e = $this->db->_error_message();
            $aff = $this->db->affected_rows();
            $last_query = $this->db->last_query();
            $registro = $this->db->insert_id();
            
            
            if (!empty($registro)) {
                $this->log_new(array('Tabla' => 'saatipo_usuarios', 'Data' => $data, 'id' => $registro));
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
                $retorno['mensaje'] = "Registro ingresado correctamente";
                $retorno['retorno'] = 1;
                
            }
        
        } else{
            $retorno['mensaje'] = 'Tipo de usuario repetido';
            $retorno['retorno'] = -1;
           
        }
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        return $retorno;
        

    }

    public function editar_tipo($id, $data) {

        $this->db->trans_start();
        $retorno = array();
        $repetido =  $this->concepto_repetido(strtoupper($data['Tipo']));
        if( !$repetido['ret'] ){
            $this->db->where("id", $id);
            $this->db->update('saatipo_usuarios', $data);
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
                $retorno['mensaje'] = "Registro editado correctamente";
                $retorno['retorno'] = 1;
                
            }
        
        } else{
            $retorno['mensaje'] = 'Tipo de usuario repetido';
            $retorno['retorno'] = -1;
           
        }
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        return $retorno;
        

    }

    public function eliminar_tipo($id, $data) {

        $this->db->trans_start();
        $retorno = array();
       
        $this->db->where("id", $id);
        $this->db->update('saatipo_usuarios', $data);
        
        $this->db->trans_complete();

        $retorno['transaccion'] = ($this->db->trans_status() === FALSE)? -1: 1;
        $retorno['retorno'] = ($this->db->trans_status() === FALSE)? -1: 1;
        
        return $retorno;
        

    }

    public function concepto_repetido($str) {
        $this->db->where('Tipo', $str);
        $this->db->where('Estatus', 0);
        $query = $this->db->get('saatipo_usuarios');
        if ($query->num_rows() > 0) {
            $concepto = $query->row();
            return array('ret' => true, 'concepto' => $concepto->Tipo);
        } else
            return array('ret' => false, 'concepto' => 0);
    }
    
    public function avisos($id) {
        $sql= "SELECT 
                * 
              FROM
                `fondoAvisos` 
              WHERE (
                  `fondoAvisos`.`FechaLimite` IS NULL 
                  or `fondoAvisos`.`FechaLimite` = '0000-00-00'
                  OR `fondoAvisos`.`FechaLimite` >= NOW()
                )                 
                AND (
                  `fondoAvisos`.`DirigidoA` IN (0,2)                   
                )
                AND `fondoAvisos`.`Estatus` = 1 
                ORDER BY `fondoAvisos`.`FechaHora` DESC
                ";
        $qAvisos = $this->db->query($sql,array($id));
        if ($qAvisos->num_rows() <= 0){
             return FALSE;
        } else {
            return $qAvisos;
        }       
    }
    
    
    
    public function log_save($cambios) {
        $data = array();
        $datos = $this->db->get_where($cambios['Tabla'], array('id' => $cambios['id']));
        // si no hay es que es nuevo        
        $aDatos = $datos->row_array();
        $data['DatosAnterior'] = '';
        foreach ($aDatos as $key => $valor) {
            $data['DatosAnterior'] .= '[' . $key . '] => ' . $valor . ',';
        }
        $data['DatosNuevos'] = '';
        foreach ($cambios['Data'] as $key => $valor) {
            $data['DatosNuevos'] .= '[' . $key . '] => ' . $valor . ',';
        }
        $data['idUsuario'] = $this->session->userdata('id');
        $data['Tabla'] = $cambios['Tabla'];
        $data['idCambiado'] = $cambios['id'];
        $data['Nombre'] = $this->session->userdata('nombre');
        $data['Fecha'] = date('Y-m-d h:m:s');
        $data['Server'] = base_url();
        $data['IPClient'] = $_SERVER['REMOTE_ADDR'];
        $data['Browser'] = $_SERVER['HTTP_USER_AGENT'];
        $this->db->insert('sisHistorico_archivo', $data);
        return 1;
    }
    
    
    
    
    
    public function log_new($datos){
        $data = array();
        /*
        $data['DatosNuevos'] = '';
        foreach($datos['Data'] as $key => $valor){
            $data['DatosNuevos'] .= '['.$key.'] => '.$valor.',';
        }
        */
        $data['DatosNuevos'] = json_encode($datos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        $data['idUsuario'] = $this->session->userdata('id');
        $data['Nombre'] = $this->session->userdata('nombre');
        $data['Fecha'] = date('Y-m-d h:i:s');
        $data['Server'] = base_url();
        $data['IPClient'] = $_SERVER['REMOTE_ADDR'];
        $data['Browser'] = $_SERVER['HTTP_USER_AGENT'];
        $data['Tabla'] = $datos['Tabla'];
        $data['idCambiado'] = $datos['id'];

        $this->db->insert('sisHistorico_archivo', $data);
        return 1;
    }
    
    
    
     
    
    
    
    
    
    
}

