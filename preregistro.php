<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Preregistro extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('preregistro_model');
        $this->load->model('usuarios_model');
        $this->load->library('ferfunc');
       
    }
    
    public function index() {
        
        
        
        $data['usuario']     = $this->session->userdata('nombre');
        $data['idusuario']   = $this->session->userdata('id');
        $data["preregistro"] = $this->session->userdata('preregistro');
        
        $direccion = $this->session->userdata('idDireccion_responsable');
        $data["Editar"] = $this->session->userdata('Editar');
        
        $this->load->view('layouts/header', $data);
        $data["js"] = "listado_preregistro.js";
        if ($data["preregistro"]== 1){
            $data["qListado"]    = $this->preregistro_model->listado_preregistrados($direccion);
            $this->load->view('preregistro/v_pant_listado', $data);
            
        }else {
            $data["admin"] = $this->session->userdata('admin_cid');
            $data["editar_ubicacion"] = $this->session->userdata('editar_ubicacion');
            $data["qListado"]    = $this->preregistro_model->listado_preregistrados_cid();
            $data['qDirecciones']= $this->preregistro_model->listado_direcciones(); 
            $data['qEjercicios']= $this->preregistro_model->listado_ejercicios(); 
           
            $data['qGrupos']= $this->preregistro_model->listado_grupos(); 
            $this->load->view('preregistro/v_pant_listado_cid', $data); 
        }
        $this->load->view('layouts/footer', $data); 
            
            
    }
    
    public function  eliminar_documento($id, $estatus){
        
        
    }
    
     public function ver_ubicaciones_archivo($idArchivo){
         $this->load->model('ubicacion_fisica_model');
         $this->load->model('procesos_model');
         
         $editar_ubicacion = $this->session->userdata('editar_ubicacion');
         $aProcesos = $this->procesos_model->addw_procesos();
         $qRelProcesoUbicacion= $this->ubicacion_fisica_model->listado_ubicaciones_captura($idArchivo);
         $tabla ="";
         
         if ($editar_ubicacion == 1){
            $tabla .= '
                               <div class="col-sm-12 m-b"> 
                                   <a href="#" id="btn-agregar-ubi"  class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-agregar-ubicacion-fisica" onclick="imprimir_procesos('. $idArchivo .')" role="button" ><span class="glyphicon glyphicon-plus-sign"></span> Agregar Ubicación </a>
                                   <a href="#"  id="btn-ubicaciones-libres"   class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-cambiar-ubicacionfisica" role="button" onclick="uf_ver_ubicacion_fisica_libre('. $idArchivo .')"><span class="glyphicon glyphicon-search"></span>  Ubicaciones Libres</a>
                               </div>';
         }
                                     
        $tabla .= '         <table  id="ubicaciones-tabla-'.$idArchivo.'"  class="table-bordered table-condensed table-responsive table-small table-hover" width="100%">
                                    <thead>
                                        <th>Acción</th>
                                        <th>Proceso</th>
                                        <th>Ubicación</th>
                                        
                                       
                                        
                                    </thead>
                                    <tbody>'; 
        if (isset($qRelProcesoUbicacion)) {
            if ($qRelProcesoUbicacion->num_rows() > 0) {               
                foreach ($qRelProcesoUbicacion->result() as $rRelacion) {
                    
                    $url_ot= site_url('impresion/etiqueta_orden_trabajo/'. $idArchivo). ' ' .$rRelacion->idTipoProceso .' '. $rRelacion->idUbicacionFisica; 
                    $url_ot_chica= site_url('impresion/etiqueta_orden_trabajo_chica/'.  $idArchivo . ' ' .$rRelacion->idTipoProceso.' '. $rRelacion->idUbicacionFisica  .' ' . $rRelacion->idRel);
                    $url_eliminar = site_url('archivo/eliminar_relacion_ubicacion/' . $rRelacion->idRel.' '.$idArchivo .' '. $rRelacion->idUbicacionFisica );
                    $confirmar= "¿Desea Eliminar esta ubicacion";


                    $tabla.= "<tr>";

                    $tabla.=    "<td>";
                    $tabla.=         "<div class='btn-group'>";
                    $tabla.=            "<div class='btn-group'>";
                    $tabla.=                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' id='btn-impresion2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='margin-bottom:5px;''>";
                    $tabla.=                     "<span class='glyphicon glyphicon-print'></span>";
                    $tabla.=                "</button>";
                    $tabla.=                "<ul class='dropdown-menu'>";
                    $tabla.=                    "<li>";
                    $tabla.=                        "<a href='". $url_ot. "' target='_blank'>";
                    $tabla.=                           "<span class='glyphicon glyphicon-file'></span> Etiqueta para Archivo de Recepción";
                    $tabla.=                        "</a>";
                    $tabla.=                    "</li>";
                    

                    $tabla.=               "</ul>";
                    $tabla.=            "</div>";
                    
                    if ($editar_ubicacion == 1){
                        $tabla.=            "<a id='btn-tabla-elim' class='btn btn-danger btn-xs del_documento'  title='Eliminar Ubicación' onclick='eliminar_ubicacion(". $rRelacion->idRel .",".$rRelacion->idUbi .")'  ><span class='glyphicon glyphicon-remove'></span></a> ";
                    }
                    
                    $tabla.=        "</div>";


                    $tabla.=     "</td>";
                    $tabla.=    "<td> ". $aProcesos[$rRelacion->idTipoProceso] ."</td>"; 
                   
                    $tabla.=    "<td> ". $rRelacion->Columna . '.' . $rRelacion->Fila.'.' . $rRelacion->C .'.' . $rRelacion->Apartado . '.' .$rRelacion->Posicion."</td>"; 
                   

                    $tabla.=    "</tr>"; 
                        

                                            
                                            
                      
                                    
                                            }
                                        
                                    
                        
                                
                                              
                                    }
                                } 
                        $tabla.=        "</tbody></table>"; 
                                
        $data=array();
        
        //echo $tabla;
        //exit();
        $data["tabla"]=$tabla;
                                
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); 
                                
                                
    }
    
     public function imprimir_procesos($idArchivo){
        $this->load->model('datos_model');
        $this->load->model('procesos_model');
        
        $id = $this->datos_model->get_procesos_archivo($idArchivo);
        $aProcesos = $this->procesos_model->addw_procesos();
        $resultado = "";
        $resultado .= '<option value="6" >TODOS</option>';
         if (isset($id)) {
            if ($id->num_rows() > 0) {               
                foreach ($id->result() as $rId) { 
                    $resultado .= '<option value="'.$rId->idTipoProceso .'" >'. $aProcesos[$rId->idTipoProceso] .'</option>';
                }
            }
         
        }
        
        
        $data=array();
        
        //echo $tabla;
        //exit();
        $data["resultado"]=$resultado;
                                
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        
    }
    
    public function ver_ubicaciones_libres_captura($idArchivo) {
        $this->load->model("ubicacion_fisica_model");
        $this->load->model("rel_archivo_documento_model");
        $this->load->model("datos_model");
        
       
       
            
                $desde = 'A';   // access attributes
                $hasta = 'P';   // access class methods
     
        
        //$desde = 'A';
        //$hasta = 'G';
    
        //echo $desde . ' ' . $hasta;
        //exit();
        $qColumnas=$this->ubicacion_fisica_model->listado_ubicacion_ordenada_por_columna_area($desde, $hasta);
       /* $qUbicacionOcupadaArchivo = $this->ubicacion_fisica_model->ubicacion_ocupada_archivo(366,1717);
        if ($qUbicacionOcupadaArchivo->num_rows() < 0) {
            echo 'Ocupada en archivo';
        }
        else{
            echo 'No';
        }
        exit();*/
         
         $tabla='
         
         
          <table class="table table-striped table-hover table-condensed" id="tabla_scroll">
                            <thead>
                                <tr>                                    
                                                                      
       ';                                    

                  
                                                    foreach ($qColumnas->result() as $rowdata){ 
                                                        $tabla.=' <th scope="col">' .  $rowdata->Columna .'</th>';
                                                     }
                 
        $tabla.='         

                                </tr>
                            </thead>
                            <tbody>
         ';
         
         
                                for( $i= 1 ; $i <= 4 ; $i++ ){
                                     $tabla.= "<tr>";
                                    foreach ($qColumnas->result() as $rowdata){

                                               $qCajas=$this->ubicacion_fisica_model->listado_ubicacion_ordenada_por_caja($rowdata->Columna,$i);
                                               $Ubicaciones_disponibles="";
                                               foreach ($qCajas->result() as $rRow_cajas) { 
                                                   
                                                   $Ubicacion_fisica=$rRow_cajas->Columna .'.'. $rRow_cajas->Fila .'.'. $rRow_cajas->Posicion.'.'. $rRow_cajas->Caja.'.'. $rRow_cajas->Apartado;
                                                   $qUbicacionOcupadaArchivo = $this->ubicacion_fisica_model->ubicacion_ocupada_archivo($rRow_cajas->id,$idArchivo);
                                                   
                                                   if ($rRow_cajas->utilizado==0 || $qUbicacionOcupadaArchivo->num_rows() > 0){
                                                       
                                                        $click="uf_agregar_ubicacion_fisica(".$rRow_cajas->id.",'". $rRow_cajas->Columna .'.'. $rRow_cajas->Fila .'.'. $rRow_cajas->Posicion.'.'. $rRow_cajas->Caja.'.'. $rRow_cajas->Apartado ."')";
                                                        $estilo = "background:#cde7f9;color:#000;";
                                                        $Ubicaciones_disponibles.='<a href="#" style= '.$estilo.' onclick='.$click.'>' . $rRow_cajas->Columna .'.'. $rRow_cajas->Fila .'.'. $rRow_cajas->Posicion.'.'. $rRow_cajas->Caja.'.'. $rRow_cajas->Apartado . '</a>';
                                                   }else {
                                                       
                                                             //$Ubicaciones_disponibles.=$Ubicacion_fisica;
                                                            $estilo = "background:#D8D8D8;color:#000";
                                                            $Ubicaciones_disponibles.= '<a  style= '.$estilo. '>'. $Ubicacion_fisica . '</a>';
                                                        
                                                   }
                                                   
                                                   
                                                   
                                                   
                                                   $Ubicaciones_disponibles.="<br>";
                                               }
                                               
                                                
                                                $tabla.="<td class='text-justify'>" . $Ubicaciones_disponibles .  "</td>";  
                                               
                                               
                                        }
                                    $tabla.= "</tr>";    
                                 }   
       
        $tabla.=' </tbody>
                        </table> ';                        
        
        //exit();
        $data=array();
        $data["ubicacion_fisica_libre"]=$tabla;
                                
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);                      
         
         
    }

    public function ayuda() {
        
        
        
        $data['usuario']     = $this->session->userdata('nombre');
        $data['idusuario']   = $this->session->userdata('id');
        $data["preregistro"] = $this->session->userdata('preregistro');
        $direccion = $this->session->userdata('idDireccion_responsable');
        
        $this->load->view('layouts/header', $data);
        $data["js"] = "listado_preregistro.js";
        
       $this->load->view('preregistro/v_pant_ayuda', $data); 
       
        $this->load->view('layouts/footer', $data); 
            
            
    }
    
    public function agregar_ubicacion_fisica(){
        $this->load->model('ubicacion_fisica_model');
        $this->load->model('datos_model');
        $idArchivo = $this->input->post('idArchivo');
        $idUbicacion =  $this->input->post('idUbicacionFisica');
        $idTipoProceso = $this->input->post('idTipoProceso');
        $retorno ="";
        //Todos los procesos
        if ( $idTipoProceso == 6){
            $qProcesos = $this->datos_model->get_procesos_archivo($idArchivo);
            foreach($qProcesos->result() as $rProcesos){
                $data=array(
                    'idTipoProceso'=> $rProcesos->idTipoProceso,
                    'idUbicacionFisica'=> $idUbicacion,
                    'idArchivo'=>  $idArchivo,
            
                );
         
                $retorno = $this->ubicacion_fisica_model->agregar_ubicacion_fisica($data);
            }
            
        } else {
        
            $data=array(
               'idTipoProceso'=> $this->input->post('idTipoProceso'),
               'idUbicacionFisica'=> $idUbicacion,
               'idArchivo'=>  $idArchivo,

                );

           $retorno = $this->ubicacion_fisica_model->agregar_ubicacion_fisica($data);
        }
        
        
        
        $this->actualizar_estado_ubicacion($idUbicacion, 1);
        echo $retorno["retorno"];
         
    }
    
    public function eliminar_ubicacion($id, $idUbi, $idArchivo){
        $this->load->model('ubicacion_fisica_model');
        
        //echo $id. 'Aqui';
       // exit();
        //$pizza  = "porción1 porción2 porción3 porción4 porción5 porción6";
        
        /*echo $porciones[0] .'idRel'; // porción1 idRelacion
        echo $porciones[1] . 'idArc'; // porción2 idArchivo
        exit();*/
        $Estatus=0;
        $data=array(
            
            'Estatus'=> $Estatus ,
            );
        
        $retorno = $this->ubicacion_fisica_model->datos_relacion_ubicacion_update($data, $id);
        //$retorno = $this->procesos_model->datos_proceso_delete($id);
        //$query = $this->procesos_model->datos_proceso_delete($id);
        if($retorno['retorno'] < 0){
           
        }
        else{
            //checa que no este ocupada esa misma ubicacion en el archivo para liberarla
            $qUbicaciones_libres_de_archivo = $this->ubicacion_fisica_model->datos_relacion_proceso_ubicacion_archivo($idUbi, $idArchivo);
            
            if ($qUbicaciones_libres_de_archivo->num_rows() == 0){
                
                $this->actualizar_estado_ubicacion($idUbi, 2);
            }
            
           
        }
        
        exit();
    }
    
    
    
    //accion: 1 Agregar - 2 Modificar
    public function actualizar_estado_ubicacion($idUbicacion, $accion){
        $this->load->model('ubicacion_fisica_model');
        if ($accion == 1){
            $u =1;
            $data = array(
                'utilizado' => $u,
            );
           
        }
        if ($accion == 2){
            $u =0;
            $data = array(
                'utilizado' => $u,
            );
           
        }
        
        $this->ubicacion_fisica_model->actualizar_estado_ubicacion($data, $idUbicacion);
    }
    
    
    
    public function cambiar_estatus($id, $estatus) {
        
        if ($estatus == 2){
            $data = array(
                "Estatus" => $estatus,
                "fecha_recibido" => date("Y-m-d G:i:s"),
                "idUsuario_Asignado" => $this->session->userdata('id'),
               
            );
        }else {
            $data = array(
                "Estatus" => $estatus,

            );
        }
        
        echo  $this->preregistro_model->cambiar_estatus($id, $data);
            
            
    }
    
    public function cambiar_direccion($id, $idDireccion) {
        
        $data = array(
            "idDireccion" => $idDireccion,
            
            );
         
        echo  $this->preregistro_model->update_preregistro($id, $data);
            
            
    }
    
    public function retornar($id) {
        
        $data = array(
            "Estatus" => 0,
            
            );
         
        echo  $this->preregistro_model->update_preregistro($id, $data);
            
            
    }
    
    public function ot_json() {
        $term = $this->input->post("term");
        $id = $this->input->post("id");
        $this->load->model('preregistro_model');
       
        $aOT = $this->preregistro_model->ot_json($term,$id);
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($aOT, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    
    public function ot_json_usuarios() {
        $term = $this->input->post("term");
        $id = $this->input->post("id");
        $this->load->model('preregistro_model');
       
        $aOT = $this->preregistro_model->ot_json_usuarios($term,$id);
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($aOT, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    /*
    public function editar($id_archivo) {
        
        $data['usuario']     = $this->session->userdata('nombre');
        $data['idusuario']   = $this->session->userdata('id');
        $data["preregistro"] = $this->session->userdata('preregistro');

        $data["idArchivo"]   = $id_archivo;
        $data["aArchivo"]    = $this->preregistro_model->get_datos_archivo($id_archivo)->row_array();
        
        
        $data["js"] = "edicion_preregistro.js";
        $this->load->view('layouts/header', $data);
        $this->load->view('preregistro/v_pant_editar', $data);
        $this->load->view('layouts/footer', $data); 
            
            
    }
     * */
    
    public function asignar_usuario(){
        $idPreregistro = $this->input->post('idPreregistro_asignacion');
        $data['idUsuario_asignado'] = $this->input->post('usuario_asignado');
        
        
        $retorno = $this->preregistro_model->asignar_usuario($idPreregistro, $data);
        
        $mensaje = '
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Exito!</strong> Preregistro Asignado correctamente!
            </div>';
        $mensaje_error = '
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong>No se pudo Asignar el Preregistro!
            </div>';
        
        if ($retorno == 1){
        $this->session->set_flashdata('correcto', $mensaje);
                redirect( site_url("preregistro/"), 'refresh');
        }else{
            $this->session->set_flashdata('correcto', $mensaje_error);
            redirect( site_url("preregistro/"), 'refresh');
        }
        
        
    }

    public function crear_folio() {
        $tipo =  $this->input->post('tipo');
        if($this->session->userdata('preregistro') == 1){
            $data = array(
                "idUsuario_registra" => $this->session->userdata('id'),
                "idDireccion" => $this->session->userdata('idDireccion_responsable'),
                "fecha_registro" => date("Y-m-d G:i:s"),
                "idArchivo" => $this->input->post('idArchivo'),
                "tipo" => $tipo,

            );
        }else {
            $data = array(
                "idUsuario_registra" => $this->session->userdata('id'),
                "idDireccion" => $this->input->post('idDireccion'),
                "tipo" => $tipo,
                "fecha_registro" => date("Y-m-d G:i:s"),
                "idArchivo" => $this->input->post('idArchivo'),
                "Estatus" => 1,

            );
            if($tipo ==1){
                $data['Estatus']= 2;
                $data['fecha_recibido'] = date("Y-m-d G:i:s");
                $data['idUsuario_asignado']=  $this->session->userdata('id');
            }
        }
        
        $Folio = $this->preregistro_model->crear_folio($data);
        
        echo $Folio;
            
            
    }
    
    
    
    public function editar($id) {
        
        $data['usuario']     = $this->session->userdata('nombre');
        $data['idusuario']   = $this->session->userdata('id');
        $data["preregistro"] = $this->session->userdata('preregistro');
        $data["Editar"] = $this->session->userdata('Editar');
        
        /* Traer la cabecera del preregistro
         * 
         */
        $aPreregistro = $this->preregistro_model->get_preregistro($id);
        
        $folio = $aPreregistro['folio'];
        if($folio == NULL) { 
            $folio = $aPreregistro['Direccion'] ; 
        }
        $idArchivo = $aPreregistro['idArchivo'];
        $aArchivo =  $this->preregistro_model->get_datos_archivo($idArchivo)->row_array();
        $modalidad = $aArchivo['idModalidad'];
        $normatividad = $aArchivo['Normatividad'];
        //print_r($aArchivo['idModalidad']);
        //print_r($aArchivo['Normatividad']) ;
        $idPlantilla = $this->preregistro_model->get_plantilla($modalidad, $normatividad);
       
        $data["aArchivo"]    = $aArchivo;
        $data['folio']= $folio;
        $data['idPreregistro'] = $id;
        $data['idPlantilla'] = $idPlantilla;
        
        $data["js"] = "edicion_preregistro.js";
        $this->load->view('layouts/header', $data);
        $this->load->view('preregistro/v_pant_editar', $data);
        $this->load->view('layouts/footer', $data); 
            
            
    }
    
    public function fetch_archivos(){  
         
        $fetch_data = $this->preregistro_model->make_datatables();  
        
        $sub_array[] = '';
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();  
            
            
            $folio = ($row->folio != NULL) ? $row->folio : $row->direccion ; 
            if($row->Estatus == 0){ 
                $estatus =  "Captura";

            } else if ($row->Estatus == 1) { 
                $estatus = "Pendiente Recibir";

            } else{
                $estatus = "Recibido";
            } 
            $sub_array[] = $row->id . '-' .$folio;
            $sub_array[] = $row->OrdenTrabajo;
            $sub_array[] = $row->TipoPreregistro;
            $sub_array[] = $row->fecha_recibido;
            $sub_array[] = $row->Nombre;
            $sub_array[] = $estatus;
             
            
            //if ($editar_ubicacion == 1 && $row->Estatus == 2): 
            $sub_array[] = '
                <a href="' .site_url("impresion/impresion_preregistro"). '/' . $row->id. '/0' .'" class="btn btn-default btn-xs" title="Vista Previa"><span class="glyphicon glyphicon-eye-open"></span></a>
                <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" title="Asignar Ubicacion" onclick="dibujar_tabla_ubicaciones(' . $row->idArchivo .')">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> 
                </a>
                <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal-usuario" title="Asignar Usuario Recepción" onclick="uf_asignar_usuario('. $row->id .')">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> 
                </a>
                ';


             $data[] = $sub_array;  
        }  
        $output = array(  
             "draw"                =>     intval($_POST["draw"]),  
             "recordsTotal"        =>     $this->preregistro_model->get_all_data(),  
             "recordsFiltered"     =>     $this->preregistro_model->get_filtered_data(),  
             "data"                =>     $data 
        );  
        echo json_encode($output);  
    } 
    
    private function get_estatus($estatus){
        if ($estatus == 1){
            $str_estatus = "Terminada";                            
        }else if ($estatus == 2){
            $str_estatus = "En Proceso";
        }else if($estatus == 3){
            $str_estatus = "Teminación por Mutuo";
        }else if ($estatus == 4){
            $str_estatus = "Terminación Anticipada";
        }else if($estatus == 5){
            $str_estatus = "Jurídico";
        }else if ($estatus == 6){
            $str_estatus = "Improcendente";
        }else if($estatus == 0){
            $str_estatus = "";
        }
        return $str_estatus;
    }
    
    private function get_grupo($grupo){
        return $this->preregistro_model->get_grupo($grupo);
        
    }
    
    public function fetch_archivos_ot(){  
        $ejercicio = $this->input->post('ejercicio');
        $estatus   = $this->input->post('estatus');
        $grupo     = $this->input->post('grupo');
    
        //echo "Ejercicio $ejercicio - Estatus $estatus - Grupo $grupo ";
        $str_estatus = $this->get_estatus($estatus);
        
        $fetch_data = $this->preregistro_model->make_datatables_ot($ejercicio, $str_estatus, $grupo);  
        
        $sub_array[] = '';
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            
            $aArchivo = $this->preregistro_model->get_datos_archivo($row->id)->row_array(); 
            $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);
            $total_a_entregar = $this->preregistro_model->get_total_a_entregar($row->id, $idPlantilla);
            $total_recibidos = $this->preregistro_model->get_recibidos($row->id);
            $total_preregistrados = $this->preregistro_model->get_preregistrados($row->id);
            $avance = round(($total_recibidos*100)/$total_a_entregar, 2);
            $sub_array = array();  
            
            
            $sub_array[] = $row->OrdenTrabajo;
            if ($row->idBloqueObra == 6){
                $sub_array[] = '<button class="btn btn-warning">'. $row->EstatusObra .'</button>';
            } else {
                $sub_array[] = '<button class="btn btn-default">'. $row->EstatusObra .'</button>';
            }
            
            $sub_array[] = $total_a_entregar;
            $sub_array[] = $total_preregistrados;
            $sub_array[] = $total_recibidos;
            $sub_array[] = $avance;
             
            
            //if ($editar_ubicacion == 1 && $row->Estatus == 2): 
            $sub_array[] = '
                <!--<a href="' .site_url("impresion/impresion_preregistro"). '/' . $row->id. '/0' .'" class="btn btn-default btn-xs" title="Vista Previa"><span class="glyphicon glyphicon-eye-open"></span></a>-->
                <a href="#" data-toggle="modal" data-target="#modal-faltantes-ot" role="button" class="btn btn-warning btn-xs"  title="Faltantes OT" onclick="open_modal_faltantes('. $row->id.')"><span class="glyphicon glyphicon-list-alt"></span></a>
                ';


             $data[] = $sub_array;  
        }  
        
        
        $output = array(  
             "draw"                =>     intval($_POST["draw"]),  
             "recordsTotal"        =>     $this->preregistro_model->get_all_data_ot($ejercicio, $str_estatus, $grupo),  
             "recordsFiltered"     =>     $this->preregistro_model->get_filtered_data_ot($ejercicio, $str_estatus, $grupo),  
             "data"                =>     $data 
        );  
        
        
        echo json_encode($output); 
        //exit();
    } 
    
    private function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }


    public function reporte_hector($pdf=1){
            $data['titulo'] = "Faltantes OT Recibidas al ". date('d-m-Y');
            $j = 0;

            $tabla= ' 
                <html>
                <head>
                     <meta charset="utf-8">
                    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
                        <title>Reporte de Archivo</title>


                </head>
                <body>
   
                <table  width="100%" border="1">
 
                    <thead>            
                            <tr>
                                <th>Orden de Trabajo</th>   
                                <th>Obra</th>  
                                
                                <th>Normatividad</th>
                                <th>Monto</th>
                                <th>Dirección</th>
                                <th>Faltantes</th>
                           </tr>       
                    </thead> 
                    <tbody>
            ';
            $qArchivos = $this->preregistro_model->get_archivos_totales_filtro_hector();
            //echo $qArchivos->num_rows();
            foreach ($qArchivos->result() as $rArchivo) {
                
               
                $aArchivo = $this->preregistro_model->get_datos_archivo($rArchivo->id)->row_array(); 
                $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);
                $ejecutora  = $aArchivo['Direccion'];
                        
                //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
                if($idPlantilla > 0){

                    $total_a_entregar = $this->preregistro_model->get_total_a_entregar($rArchivo->id, $idPlantilla);
                    $total_recibidos = $this->preregistro_model->get_recibidos($rArchivo->id);
                    
                   
                    $avance = round(($total_recibidos*100)/$total_a_entregar, 2);

                    if($avance > 0){
                        $faltantes = $this->preregistro_model->get_faltantes_hector($rArchivo->id, $idPlantilla);
                        $tabla .= '<tr>';
                            $tabla .= '<th rowspan="'.$faltantes->num_rows().'">'. $aArchivo['OrdenTrabajo'] .'</th>';
                            $tabla .= '<th rowspan="'.$faltantes->num_rows().'">'.  $aArchivo['Obra'].'</th>';
                            $tabla .= '<th rowspan="'.$faltantes->num_rows().'">'. $aArchivo['Normatividad'] .'</th>';
                            $tabla .= '<th rowspan="'.$faltantes->num_rows().'">'. $aArchivo['ImporteContratado'] .'</th>';
                            
                        
                        
                        if ($faltantes->num_rows() > 0){
                            foreach ($faltantes->result() as $row) {
                                if($row->idDireccion == -1){ $direccion = $ejecutora; } else {$direccion =$row->Direccion;}
                                $tabla .= '<th>'. $direccion .'</th>';
                                $tabla .= '<th>'. $row->Nombre .'</th>';
                                $tabla .= '</tr>';
                            }
                            
                        }else{
                            $tabla .= '<th colspan="3"></th>';
                        }
                        
                        
                    }
                }

            }

            $tabla .= '</tbody></table></body></html>';
            $data['reporte'] =  $tabla;
            $this->load->view('preregistro/v_rep_faltantes_ot_general', $data);
       
             
    }

    public function reporte_avances($pdf=1){
            $this->load->model('impresiones_model');
            
            $ejercicio = $this->input->post('ejercicio-modal-avances');
            $estatus = $this->input->post('estatus-modal-avances');
            $grupo = $this->input->post('grupo-modal-avances');
            
            
            $str_estatus = $this->get_estatus($estatus);
          
            
            
            
            $retorno = array();
            
            $aArchivos = array();
            $j = 0;
            $qArchivos = $this->preregistro_model->get_archivos_totales_filtro($ejercicio, $str_estatus, $grupo);
            //echo $qArchivos->num_rows();
            foreach ($qArchivos->result() as $rArchivo) {
                


                $aArchivo = $this->preregistro_model->get_datos_archivo($rArchivo->id)->row_array(); 
                $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);

                //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
                if($idPlantilla > 0){

                    
                    $total_a_entregar = $this->preregistro_model->get_total_a_entregar($rArchivo->id, $idPlantilla);
                    $total_recibidos = $this->preregistro_model->get_recibidos($rArchivo->id);
                    $total_preregistrados = $this->preregistro_model->get_preregistrados($rArchivo->id);
                   
                    $avance = round(($total_recibidos*100)/$total_a_entregar, 2);

                    if($avance > 0){
                        $aArchivo = array(
                            'id' => $aArchivo['id'],
                            'OrdenTrabajo' => $aArchivo['OrdenTrabajo'],
                            'total_a_entregar' =>  $total_a_entregar,
                            'total_recibidos' =>  $total_recibidos,
                            'total_preregistrados' =>  $total_preregistrados,
                            'avance' =>$avance
                        );




                        $aArchivos[$j]= $aArchivo;


                        $j++;
                        
                    }



                    //echo $i. " "  .$rArchivo->id . " $idPlantilla ".$rArchivo->OrdenTrabajo ."DPC $qPorEntregar_DCP/$qRecibidos_DCP DLD $qPorEntregar_DLD/$qRecibidos_DLD DIS $qPorEntregar_DIS/$qRecibidos_DIS DGJ $qPorEntregar_DGJ/$qRecibidos_DGJ DGPOP $qPorEntregar_DGPOP/$qRecibidos_DGPOP Ejecutora $qPorEntregar_Ejecutora/$qRecibidos_Ejecutora Avance $qTotales_a_entregar/$qTotal_Recibidos  Obligados $qTotal_Obligados<br>";
                }

            }
           
            
                 
            
            
            $data['retorno'] = $this->array_sort($aArchivos, 'avance', SORT_DESC);
            $data['totales'] = $j;
            
            $data['ejercicio'] = $ejercicio;
            $data['grupo'] = $this->get_grupo($grupo);
            $data['estatus'] = $str_estatus;
            
            if ($pdf == 1) {
                $this->load->library('mpdf');
               
                $mpdf = new mPDF('utf-8');
                
                $output = $this->load->view('preregistro/v_rep_avances', $data, true);
                $mpdf->WriteHTML($output);
                $mpdf->Output();
                
            } else {
                 
                // var_dump($data['retorno'] );
                $this->load->view('preregistro/v_rep_avances', $data, true);

            }
       
             
    }
    
    public function reporte_faltantes($pdf=1){
            
            
            $ejercicio = $this->input->post('ejercicio-modal-faltantes');
            $estatus = $this->input->post('estatus-modal-faltantes');
            $grupo = $this->input->post('grupo-modal-faltantes');
            $idDirección  = $this->input->post('idDireccion-modal-faltantes');
            $Direccion = $this->input->post('nomDireccion-faltantes');
            
            $str_estatus = $this->get_estatus($estatus);
          
            
            
            
            $retorno = array();
            
            $aArchivos = array();
            $j = 0;
            $documentos = 0;
            $qArchivos = $this->preregistro_model->get_archivos_totales_filtro($ejercicio, $str_estatus, $grupo);
            //echo $qArchivos->num_rows();
            foreach ($qArchivos->result() as $rArchivo) {
                


                $aArchivo = $this->preregistro_model->get_datos_archivo($rArchivo->id)->row_array(); 
                $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);
                $ejecutora  = $aArchivo['idDireccion'];
                        
                //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
                if($idPlantilla > 0){

                    
                    $faltantes = $this->preregistro_model->get_faltantes($rArchivo->id, $idPlantilla, $idDirección);
                    if ($faltantes->num_rows() > 0){
                        $documentos = $documentos + $faltantes->num_rows();
                        //echo "con faltantes " . $aArchivo['id'] ." $idPlantilla " . $aArchivo['OrdenTrabajo'] . "<br>";
                        $aArchivo = array(
                                'id' => $aArchivo['id'],
                                'OrdenTrabajo' => $aArchivo['OrdenTrabajo'],
                                'ejecutora' =>  $ejecutora,
                                'faltantes' =>  $faltantes

                            );

                        $aArchivos[$j]= $aArchivo;
                        $j++;
                    }else{
                        //echo "sin faltantes " . $aArchivo['id'] ." $idPlantilla  " . $aArchivo['OrdenTrabajo']. "<br>";
                    }
                     
                    //echo $i. " "  .$rArchivo->id . " $idPlantilla ".$rArchivo->OrdenTrabajo ."DPC $qPorEntregar_DCP/$qRecibidos_DCP DLD $qPorEntregar_DLD/$qRecibidos_DLD DIS $qPorEntregar_DIS/$qRecibidos_DIS DGJ $qPorEntregar_DGJ/$qRecibidos_DGJ DGPOP $qPorEntregar_DGPOP/$qRecibidos_DGPOP Ejecutora $qPorEntregar_Ejecutora/$qRecibidos_Ejecutora Avance $qTotales_a_entregar/$qTotal_Recibidos  Obligados $qTotal_Obligados<br>";
                }

            }
           
            
                 
            //exit();    
            
            $data['retorno'] = $aArchivos;
            $data['totales'] = $j;
            $data['documentos'] = $documentos;
            $data['Direccion'] = $Direccion;
            $data['ejercicio'] = $ejercicio;
            $data['grupo'] = $this->get_grupo($grupo);
            $data['estatus'] = $str_estatus;
            
            if ($pdf == 1) {
                $this->load->library('mpdf');
               
                $mpdf = new mPDF('utf-8');
                
                $output = $this->load->view('preregistro/v_rep_faltantes', $data, true);
                $mpdf->WriteHTML($output);
                $mpdf->Output();
                
            } else {
                 
                var_dump($data['retorno'] );
                $this->load->view('preregistro/v_rep_faltantes', $data, true);

            }
       
             
    }
    
    public function faltantes_ot($pdf=1){
            
            
       
        $idDireccion  = $this->input->post('idDireccion-modal-faltantes-ot');
        $ot = $this->input->post('idOT-modal-faltantes-ot');
         echo "OT " . $ot;
        if ($idDireccion == 0){
             $this->faltantes_obra($ot);
        }else{
            $estimaciones_faltantes = array();
            $solicitudes_faltantes = array();
            echo "OT " . $ot;

            $aArchivo = $this->preregistro_model->get_datos_archivo($ot)->row_array(); 
            $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);
            $ejecutora  = $aArchivo['idDireccion'];
            $noEstimaciones = $aArchivo['noEstimaciones'];
            //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
            if($idPlantilla > 0){

                $responsable = ($idDireccion == $ejecutora)? -1 : $idDireccion;
                $faltantes = $this->preregistro_model->get_faltantes_ot($ot, $idPlantilla, $idDireccion, $responsable);

                //Faltantes estimaciones 
                $documentos_estimaciones = $this->preregistro_model->get_documentos_estimaciones_ot($ot, $idPlantilla, $idDireccion, $responsable);
                $j = 0;
                if($documentos_estimaciones->num_rows() > 0){
                    for($i = 0 ; $i < $noEstimaciones ; $i++){
                        foreach ($documentos_estimaciones->result() as $row) {
                            $entregados = $this->preregistro_model->get_documentos_estimaciones_entregados($ot, $idDireccion, $row->id, $i+1);
                            if($entregados->num_rows() > 0){

                            }else{

                               $estimaciones_faltantes[] = array(
                                   'noEstimacion' => $i+1,
                                   'documento_estimacion' => $row->Nombre
                               );
                               $j++;
                            }
                        }
                    }
                }

                //Faltantes solicitudes
                $documentos_solicitudes = $this->preregistro_model->get_documentos_solicitudes_ot($ot, $idPlantilla, $idDireccion, $responsable);
                $noSolicitudes  = $this->preregistro_model->get_solicitudes($ot);
                $noSolicitudes = ($noSolicitudes == 0 && $idDireccion == 17)? 1: 0;
                //echo "Direccion $idDireccion Solicitides $noSolicitudes Doc Solicitudes". $documentos_solicitudes->num_rows();
                $h = 0;
                if($documentos_solicitudes->num_rows() > 0){
                    for($i = 0 ; $i < $noSolicitudes ; $i++){
                        foreach ($documentos_solicitudes->result() as $row) {
                            $entregados_solicitudes = $this->preregistro_model->get_documentos_estimaciones_entregados($ot, $idDireccion, $row->id, $i+1);
                            if($entregados_solicitudes->num_rows() > 0){

                            }else{

                               $solicitudes_faltantes[] = array(
                                   'noSolicitud' => $i+1,
                                   'documento_solicitud' => $row->Nombre
                               );
                               $h++;
                            }
                        }
                    }
                }



            }

            $data = array(
                'id' => $aArchivo['id'],
                'OrdenTrabajo' => $aArchivo['OrdenTrabajo'],
                'ejecutora' =>  $ejecutora,
                'faltantes' =>  $faltantes,
                'estimaciones_faltantes' => $estimaciones_faltantes,
                'solicitudes_faltantes' => $solicitudes_faltantes,
                'totales' =>$faltantes->num_rows() + $j +$h,


            ); 

            if($idDireccion == -1){
                $data['Direccion'] = $this->preregistro_model->get_direccion($aArchivo['Direccion']);
            }else{
                $data['Direccion'] = $this->preregistro_model->get_direccion($idDireccion);
            }






            if ($pdf == 1) {
                $this->load->library('mpdf');

                $mpdf = new mPDF('utf-8');

                $output = $this->load->view('preregistro/v_rep_faltantes_ot', $data, true);
                $mpdf->WriteHTML($output);
                $mpdf->Output();

            } else {

                var_dump($idDireccion);
                $this->load->view('preregistro/v_rep_faltantes_ot', $data, true);

            }
        }
       
             
    }
    
    public function faltantes_obra($ot){
        $pdf=1;
        echo " Obra ".$ot;
        $aArchivo = $this->preregistro_model->get_datos_archivo($ot)->row_array(); 
        $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);
        $ejecutora  = $aArchivo['idDireccion'];
        $noEstimaciones = $aArchivo['noEstimaciones'];
        $totales_general = 0;    
        $direcciones_responsables = $this->preregistro_model->get_direcciones_responsables($ot); 
        echo "responsables " .$direcciones_responsables->num_rows();
        foreach ($direcciones_responsables->result() as $resp){
            print_r($resp);
            $idDireccion  = $resp->idDireccion;
            
            $estimaciones_faltantes = array();
            $solicitudes_faltantes = array();
            echo "OT " . $ot;

            
            //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
            if($idPlantilla > 0){

                $responsable = ($idDireccion == $ejecutora)? -1 : $idDireccion;
                $faltantes = $this->preregistro_model->get_faltantes_ot($ot, $idPlantilla, $idDireccion, $responsable);

                //Faltantes estimaciones 
                $documentos_estimaciones = $this->preregistro_model->get_documentos_estimaciones_ot($ot, $idPlantilla, $idDireccion, $responsable);
                $j = 0;
                if($documentos_estimaciones->num_rows() > 0){
                    for($i = 0 ; $i < $noEstimaciones ; $i++){
                        foreach ($documentos_estimaciones->result() as $row) {
                            $entregados = $this->preregistro_model->get_documentos_estimaciones_entregados($ot, $idDireccion, $row->id, $i+1);
                            if($entregados->num_rows() > 0){

                            }else{

                               $estimaciones_faltantes[] = array(
                                   'noEstimacion' => $i+1,
                                   'documento_estimacion' => $row->Nombre
                               );
                               $j++;
                            }
                        }
                    }
                }

                //Faltantes solicitudes
                $documentos_solicitudes = $this->preregistro_model->get_documentos_solicitudes_ot($ot, $idPlantilla, $idDireccion, $responsable);
                $noSolicitudes  = $this->preregistro_model->get_solicitudes($ot);
                $noSolicitudes = ($noSolicitudes == 0 && $idDireccion == 17)? 1: 0;
                //echo "Direccion $idDireccion Solicitides $noSolicitudes Doc Solicitudes". $documentos_solicitudes->num_rows();
                $h = 0;
                if($documentos_solicitudes->num_rows() > 0){
                    for($i = 0 ; $i < $noSolicitudes ; $i++){
                        foreach ($documentos_solicitudes->result() as $row) {
                            $entregados_solicitudes = $this->preregistro_model->get_documentos_estimaciones_entregados($ot, $idDireccion, $row->id, $i+1);
                            if($entregados_solicitudes->num_rows() > 0){

                            }else{

                               $solicitudes_faltantes[] = array(
                                   'noSolicitud' => $i+1,
                                   'documento_solicitud' => $row->Nombre
                               );
                               $h++;
                            }
                        }
                    }
                }



            }

            $subarray = array(
                'id' => $aArchivo['id'],
                'OrdenTrabajo' => $aArchivo['OrdenTrabajo'],
                'ejecutora' =>  $ejecutora,
                'faltantes' =>  $faltantes,
                'estimaciones_faltantes' => $estimaciones_faltantes,
                'solicitudes_faltantes' => $solicitudes_faltantes,
                'totales' =>$faltantes->num_rows() + $j +$h,


            ); 
            
            
            
            $totales_general = $totales_general + $faltantes->num_rows() + $j +$h;

            if($idDireccion == -1){
               $subarray['Direccion'] = $this->preregistro_model->get_direccion($aArchivo['idDireccion']);
            }else{
                $subarray['Direccion'] = $this->preregistro_model->get_direccion($idDireccion);
            }
            
            $reporte[] = $subarray;
        }
        
        
        $data['reporte'] = $reporte;
        $data['OrdenTrabajo']= $aArchivo['OrdenTrabajo'];
        $data['totales'] = $totales_general;

        


        

        if ($pdf == 1) {
            $this->load->library('mpdf');

            $mpdf = new mPDF('utf-8');

            $output = $this->load->view('preregistro/v_rep_faltantes_ot_general', $data, true);
            $mpdf->WriteHTML($output);
            $mpdf->Output();

        } else {

            var_dump($idDireccion);
            $this->load->view('preregistro/v_rep_faltantes_ot_general', $data, true);

        }
       
             
    }
    
    
    public function faltantes_documentos_con_avances($pdf=1){
        
        
        $ejercicio = $this->input->post('ejercicio-modal-avances-df');
        $estatus = $this->input->post('estatus-modal-avances-df');
        $grupo = $this->input->post('grupo-modal-avances-df');
        // 0 o 1 Reporte Auditoría Fisico-Digital  2.-Reporte Auditoría Fisico 3.-Reporte Auditoría Digital
        $tipo = $this->input->post('tipo-modal-avances-df');

        $str_estatus = $this->get_estatus($estatus);

        $qArchivos = $this->preregistro_model->get_archivos_totales_filtro($ejercicio, $str_estatus, $grupo);
        if($tipo == 2){
            $data['titulo'] = "Reporte Auditoría Fisico al ". date('d-m-Y');
           
        }
        else if($tipo == 5){
            $data['titulo'] = "Reporte Auditoría por Documento al ". date('d-m-Y');
            $this->reporte_auditoria_por_documento($ejercicio, $str_estatus, $grupo , $data);
        
        }else if($tipo == 3){
            $data['titulo'] = "Reporte Auditoría Digital al ". date('d-m-Y');
        }else if($tipo == 4){
            $data['titulo'] = "Completadas Auditoría Fisico-Digital al ". date('d-m-Y');
        }else{
            $data['titulo'] = "Reporte Auditoría Fisico-Digital al ". date('d-m-Y');
        }
        
            $j = 0;

            $tabla= ' 
               
                <table  width="100%">
 
                    <thead> 
                        <tr>
                            <th colspan="1"  rowspan="5"><img src="'. site_url('images/logo-secretaria-mini.jpg') . '" /></th>
                            <th colspan="5" class="idTituloAzul"></th>

                        </tr>
                        <tr><th colspan="5" class="idTituloAzul"> ' .$data['titulo'].'</th></tr>
                        <tr><th colspan="5" class="idTituloAzul"></th></tr>
                        <tr><th colspan="5" class="idTituloAzul"></th></tr>
                        <tr><th colspan="5" class="idTituloAzul"></th></tr>
                        <tr><th colspan="6" class="idTituloAzul"></th></tr>
                    
                        <tr>
                            <th id="idborder_titulo" >Orden de Trabajo</th>   
                            <th id="idborder_titulo">Obra</th>  

                            <th id="idborder_titulo">Normatividad</th>
                            <th id="idborder_titulo">Monto</th>
                            <th id="idborder_titulo">Dirección</th>
                            <th id="idborder_titulo">Faltantes</th>
                       </tr>       
                    </thead> 
                    <tbody>
            ';
           
            foreach ($qArchivos->result() as $rArchivo) {
                
               
                $aArchivo = $this->preregistro_model->get_datos_archivo($rArchivo->id)->row_array(); 
                $idPlantilla =  $this->preregistro_model->get_plantilla($aArchivo['idModalidad'], $aArchivo['Normatividad']);
                $ejecutora  = $aArchivo['Direccion'];
                        
                //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
                if($idPlantilla > 0){

                    
                        
                        //$estimaciones = $this->preregistro_model->get_faltantes_hector_estimaciones($rArchivo->id, $idPlantilla, $tipo);
                        
                         
                        if($tipo != 4){
                            $faltantes = $this->preregistro_model->get_faltantes_hector($rArchivo->id, $idPlantilla, $tipo);
                            if ($faltantes->num_rows() > 0){
                                $tabla .= '<tr>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">'. $aArchivo['OrdenTrabajo'] .'</th>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">'.  $aArchivo['Obra'].'</th>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">'. $aArchivo['Normatividad'] .'</th>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">$'. $aArchivo['ImporteContratado'] .'</th>';
                                foreach ($faltantes->result() as $row) {
                                    if($row->idDireccion == -1){ $direccion = $ejecutora; } else {$direccion =$row->Direccion;}
                                    $tabla .= '<th id="idborder" align="left">'. $direccion .'</th>';
                                    $tabla .= '<th id="idborder"  align="left">'. $row->Nombre .'</th>';
                                    $tabla .= '</tr>';
                                }

                            }
                        }
                        else{
                            $faltantes = $this->preregistro_model->get_faltantes_hector($rArchivo->id, $idPlantilla,0);
                            if ($faltantes->num_rows()== 0 && $idPlantilla != 8 && $idPlantilla != 1 && $idPlantilla != 11) {
                                $tabla .= '<tr>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">'. $aArchivo['OrdenTrabajo'] .'</th>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">'.  $aArchivo['Obra'].'</th>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">'. $aArchivo['Normatividad'] .'</th>';
                                $tabla .= '<th id="idborder" rowspan="'.$faltantes->num_rows().'">$'. $aArchivo['ImporteContratado'] .'</th>';
                               
                                $tabla .= '<th id="idborder" colspan ="2" align="left"> Completada para Auditoría</th>';
                                
                                $tabla .= '</tr>';
                                

                            }
                            
                        }
                        
                        
                    
                }

            }

            $tabla .= '</tbody></table></body></html>';
            $data['reporte'] =  $tabla;
            $this->load->view('preregistro/v_rep_auditoria', $data);
       
       
             
    }
    
    
    public function reporte_auditoria_documento($pdf=1){
        
        /*
        $ejercicio = $this->input->post('ejercicio-modal-avances-df');
        $estatus = $this->input->post('estatus-modal-avances-df');
        $grupo = $this->input->post('grupo-modal-avances-df');
        // 0 o 1 Reporte Auditoría Fisico-Digital  2.-Reporte Auditoría Fisico 3.-Reporte Auditoría Digital
        $tipo = $this->input->post('tipo-modal-avances-df');

        $str_estatus = $this->get_estatus($estatus);
        */
        $ejercicio = 2017;
        $str_estatus = "";
        $grupo = 6;
        $qDirecciones= $this->preregistro_model->get_direcciones_responsables_general($ejercicio, $str_estatus, $grupo);
        
        $data['titulo'] = "Reporte Auditoría por Documento al ". date('d-m-Y');
         
       
            $j = 0;

            $tabla= ' 
               
                <table  width="100%" border="1">
 
                    <thead> 
                        <tr>
                            <th colspan="1"  rowspan="5"><img src="'. site_url('images/logo-secretaria-mini.jpg') . '" /></th>
                            <th colspan="2" class="idTituloAzul"></th>

                        </tr>
                        <tr><th colspan="2" class="idTituloAzul"> ' .$data['titulo'].'</th></tr>
                        <tr><th colspan="2" class="idTituloAzul"></th></tr>
                        <tr><th colspan="2" class="idTituloAzul"></th></tr>
                        <tr><th colspan="2" class="idTituloAzul"></th></tr>
                        <tr><th colspan="3" class="idTituloAzul"></th></tr>
                    
                        <tr>
                            <th id="idborder_titulo" >Direccion</th> 
                            
                            <th id="idborder_titulo" >Monto</th> 
                            <th id="idborder_titulo">Documento</th>  
                            <th id="idborder_titulo">OT</th>
                           
                           
                       </tr>       
                    </thead> 
                    <tbody>
            ';
           
            foreach ($qDirecciones->result() as $row) {
                
               
                echo $row->id.$row->Nombre ."<br>";
                    if($row->id != -1){
                        $retorno = $this->preregistro_model->get_faltantes_hector_direccion($ejercicio, $grupo, $row->id);
                        
                        
                        
                        $tabla .= '<tr>';
                        $tabla .= '<th id="idborder" rowspan="'.$retorno ->num_rows().'">'. $row->Abreviatura .'</th>';
                        $monto = 0;
                        $tabla2="";
                        $j = 0;
                        $total = 0;
                        $ot = array();
                        foreach ($retorno->result() as $r) {
                                    if ($j == 0) { $ant = $r->Nombre;}
                    
                                    $j++;
                                    echo "Nombre " . $r->Nombre . "<br>";
                                    
                                    if($ant ==  $r->Nombre){
                                        $total++;
                                        $ot[] = $r->OrdenTrabajo;
                                        echo "Sumo $total<br>";
                                    }else{
                                        if ($j > 1) { $tabla2 .= '<tr>';}
                                        echo "Total $total ". $r->id ." - ". $ant. "<br>";
                                        $tabla2 .= '<th id="idborder" align="left" rowspan = "'. $total.'">'.  $ant.'</th>';
                                        foreach ($ot as $value) {
                                            $tabla2 .= '<th id="idborder" align="left" rowspan = "'. $value.'">'.  $ant.'</th>';
                                            $tabla2 .= '</tr>';
                                        }
                                        $nuevo = array();
                                        $ot = $nuevo;
                                        
                                        $total = 1;
                                    }
                                    
                                    //$tabla3 .= '<th id="idborder" align="left">'.  $r->OrdenTrabajo.'</th>';

                                    
                                $monto = $monto + $r->ImporteContratado;
                                $ant =  $r->Nombre;
                               


                           
                            

                        }
                        echo $monto. "<br><hr>";
                        $tabla .= '<th id="idborder" rowspan="'.$retorno ->num_rows().'">$'. $monto.'</th>';
                        $tabla .= $tabla2;
                    }
                   
            }
            
            $tabla .= '</tbody></table></body></html>';
            echo $tabla;
            /*
            $data['reporte'] =  $tabla;
            $this->load->view('preregistro/v_rep_auditoria', $data);
             * *
             */

            

            

       
             
    }
    
    public function editar_plantilla($id) {
        
        $data['usuario']     = $this->session->userdata('nombre');
        $data['idusuario']   = $this->session->userdata('id');
        $data["preregistro"] = $this->session->userdata('preregistro');
        $data["Editar"] = $this->session->userdata('Editar');
        
        if($data["preregistro"] == 0 && $data["Editar"] == 1){
            /* Traer la cabecera del preregistro
             * 
             */
           
            $aArchivo =  $this->preregistro_model->get_datos_archivo($id)->row_array();
            $modalidad = $aArchivo['idModalidad'];
            $normatividad = $aArchivo['Normatividad'];

            $idPlantilla = $this->preregistro_model->get_plantilla($modalidad, $normatividad);
           
            //Traer los Documentos de la Plantilla o el Archivo
            $data['qDocumentos'] = $this->preregistro_model->get_documentos_plantilla($idPlantilla, $id); 
            $data['qProcesos']=$this->preregistro_model->listado_procesos($idPlantilla);  
            $data['qSubProcesos']=$this->preregistro_model->listado_subprocesos($idPlantilla);  
            $data['qDirecciones']=$this->preregistro_model->listado_direcciones(); 
            $data["aArchivo"]    = $aArchivo;
            //$data['url_Anterior'] = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('preregistro'); 
            $data["js"] = "edicion_plantilla_preregistro.js";
            $this->load->view('layouts/header', $data);
            $this->load->view('preregistro/v_pant_editar_plantilla', $data);
            $this->load->view('layouts/footer', $data); 
        }
            
            
    }
    
      
    public function datos_proceso() {
        $id = $this->input->post('id');
        $query = $this->preregistro_model->datos_proceso($id);
        echo json_encode($query->row_array());
    }
    
    public function datos_subproceso() {
        $id = $this->input->post('id');
        $query = $this->preregistro_model->datos_subproceso($id);
        echo json_encode($query->row_array());
    }
    
    public function datos_direccion() {
        $id = $this->input->post('id');
        $query = $this->preregistro_model->datos_direccion($id);
        echo json_encode($query->row_array());
    }
    
    public function agregar_documento_archivo() {
       
         
        $idArchivo= $this->input->post('idCatalogo');
        $data=array(
            'Nombre'       =>  strtoupper($this->input->post('Nombre_doc')),
            'Ordenar'      =>  $this->input->post('Orden_doc'),
            'idProceso'    =>  $this->input->post('idProceso_doc'),
            'idSubProceso' =>  $this->input->post('idSubProceso_doc'),
            'idDireccion'  =>  $this->input->post('idDireccion_doc'),
            'idArchivo'    =>  $idArchivo,
            'Estatus'      =>  0,
        );
        $retorno=  $this->preregistro_model->agregar_documento_archivo($data);
        if($retorno['retorno']<0)
            header('Location:'.site_url('preregistro/editar_plantilla/'.$idArchivo . '/'.$retorno['error']));
        else
            header('Location:'.site_url('preregistro/editar_plantilla/'.$idArchivo)); 
    }
    
    public function preregistrar() {
        
        $tipo_documento = $this->input->post('tipo_documento');
        $idPreregistro  = $this->input->post('idPreregistro');
        $idDocumento    = $this->input->post('idDocumento');
        $valor          = $this->input->post('valor');
        
       
        echo $this->preregistro_model->preregistrar($tipo_documento, $idPreregistro, $idDocumento, $valor);
    }
    
    
    public function preregistrar_observacion() {
        
        $idPreregistro  = $this->input->post('idPreregistro');
        $idDocumento    = $this->input->post('idDocumento');
        $observacion    = $this->input->post('observacion');
        
        print_r($observacion);
        echo $this->preregistro_model->preregistrar_observacion($idPreregistro, $idDocumento, $observacion);
    }
    
    public function traer_procesos() {
        $idPreregistro= $this->input->post('idPreregistro');
        $idPlantilla= $this->input->post('idPlantilla');
        $idArchivo = $this->input->post('idArchivo');
        
        
        $data['qProcesos']        = $this->preregistro_model->get_procesos_plantilla($idPreregistro, $idPlantilla)->result();
        $data['qSubProcesos']     = $this->preregistro_model->traer_subprocesos_de_archivo($idPreregistro, $idPlantilla)->result();
        $data['qDocumentos']      = $this->preregistro_model->traer_documentos_de_archivo($idPlantilla, $idArchivo)->result();
        $data['qPreregistrados']  = $this->preregistro_model->traer_preregistrados($idPreregistro)->result();
        
        
        $aPreregistro  = $this->preregistro_model->traer_preregistro($idPreregistro);
        
        $data['noSolicitudes']    = $aPreregistro['noSolicitudes'];
        $data['noEstimaciones']   = $aPreregistro['noEstimaciones'];
        $data['doc_Estimaciones'] = $this->preregistro_model->traer_doc_estimaciones($idPlantilla)->result();
        $data['doc_Solicitudes']  = $this->preregistro_model->traer_doc_solicitudes($idPlantilla)->result();
        
        $data['pre_Estimaciones']  = $this->preregistro_model->traer_preregistrados_estimaciones($idPreregistro)->result();
        $data['pre_Solicitudes']  = $this->preregistro_model->traer_preregistrados_solicitudes($idPreregistro)->result();
        
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); 
    }
    
    public function agregar_estimaciones() {
        
        
        $idPreregistro  = $this->input->post('idPreregistro');
        $no          = $this->input->post('no');
        $idPlantilla = $this->input->post('idPlantilla');
       
        $resultado = $this->preregistro_model->agregar_estimaciones($idPreregistro, $no);
        if ($resultado > 0){
            $documentos = $this->preregistro_model->traer_doc_estimaciones($idPlantilla);
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($documentos->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);  
        
        } else {
        echo $resultado ;
        }
        
    }
    
    public function agregar_solicitudes() {
        
        
        $idPreregistro  = $this->input->post('idPreregistro');
        $no          = $this->input->post('no');
        $idPlantilla = $this->input->post('idPlantilla');
       
        $resultado = $this->preregistro_model->agregar_solicitudes($idPreregistro, $no);
        if ($resultado > 0){
            $documentos = $this->preregistro_model->traer_doc_solicitudes($idPlantilla);
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');
            echo json_encode($documentos->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);  
        
        } else {
        echo $resultado ;
        }
        
    }
    
    
    public function preregistrar_estimacion() {
        
        $tipo_documento = $this->input->post('tipo_documento');
        $idPreregistro  = $this->input->post('idPreregistro');
        $idDocumento    = $this->input->post('idDocumento');
        $valor          = $this->input->post('valor');
        $noEstimacion   = $this->input->post('noEstimacion');
        
       
        echo $this->preregistro_model->preregistrar_estimacion($tipo_documento, $idPreregistro, $idDocumento, $valor, $noEstimacion);
    }
    
    public function preregistrar_solicitud() {
        
        $tipo_documento = $this->input->post('tipo_documento');
        $idPreregistro  = $this->input->post('idPreregistro');
        $idDocumento    = $this->input->post('idDocumento');
        $valor          = $this->input->post('valor');
        $noSolicitud   = $this->input->post('noSolicitud');
        
       
        echo $this->preregistro_model->preregistrar_solicitud($tipo_documento, $idPreregistro, $idDocumento, $valor, $noSolicitud);
    }
    
    
   
    
    public function preregistrar_observacion_estimacion() {
        
        $tipo_documento = 'observacion';
        $idPreregistro  = $this->input->post('idPreregistro');
        $idDocumento    = $this->input->post('idDocumento');
        $valor          = $this->input->post('observacion');
        $noEstimacion = $this->input->post('noEstimacion');
        
       
        echo $this->preregistro_model->preregistrar_estimacion($tipo_documento, $idPreregistro, $idDocumento, $valor, $noEstimacion);
    }
    
     public function preregistrar_observacion_solicitud() {
        
        $tipo_documento = 'observacion';
        $idPreregistro  = $this->input->post('idPreregistro');
        $idDocumento    = $this->input->post('idDocumento');
        $valor          = $this->input->post('observacion');
        $noSolicitud = $this->input->post('noSolicitud');
        
       
        echo $this->preregistro_model->preregistrar_solicitud($tipo_documento, $idPreregistro, $idDocumento, $valor, $noSolicitud);
    }
    
    public function traer_subprocesos_de_archivo(){
        $idPreregistro= $this->input->post('idPreregistro');
        $idPlantilla= $this->input->post('idPlantilla');
       
        
        
        $qSubProcesos = $this->preregistro_model->traer_subprocesos_de_archivo($idPreregistro, $idPlantilla);
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($qSubProcesos->result(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    public function traer_documentos_de_archivo(){
        $idPreregistro= $this->input->post('idPreregistro');
        $idPlantilla= $this->input->post('idPlantilla');
        
        $data['Documentos'] = $this->preregistro_model->traer_documentos_de_archivo($idPlantilla)->result();
        $data['Preregistrados'] =  $this->preregistro_model->traer_preregistrados($idPreregistro)->result();
        
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    
    public function avances_direccion($pdf=1){
            $this->load->model('impresiones_model');
            
            $ejercicio = $this->input->post('ejercicio-modal');
            $estatus = $this->input->post('estatus-modal');
            $grupo = $this->input->post('grupo-modal');
            
            
            $str_estatus = $this->get_estatus($estatus);
          
            
            $qDireccionesEjecutoras = $this->impresiones_model->get_ejecutoras_filtro($ejercicio, $str_estatus, $grupo);
            
            
            $retorno = array();
            $aEjecutora = array();
            $aArchivos = array();
            if (isset($qDireccionesEjecutoras)){
                if ($qDireccionesEjecutoras->num_rows() > 0) {
                    $i = 0;
                    foreach ($qDireccionesEjecutoras->result() as $row) {
                       echo "<br>$row->idDireccion". $row->Nombre ."<br>";
                        
                       
                        
                        
                        
                        
                        $j= 1;
                        $aArchivos = array();
                        $qArchivos = $this->impresiones_model->get_archivos_totales_ejecutoras_filtro($row->idDireccion, $ejercicio, $str_estatus, $grupo);
                        foreach ($qArchivos->result() as $rArchivo) {
                            //echo $i. " " .$rArchivo->OrdenTrabajo ."<br>";
                           
                            
                            $idPlantilla = $this->impresiones_model->get_plantilla($rArchivo->id);
                            
                            //Si existe la Plantilla ya que la 001-17 No tiene Plantilla
                            if($idPlantilla > 0){
                                
                                /* Total de Documentos que se tienen que entregar de cada Archivo*/
                                $qPorEntregar_DCP = $this->impresiones_model->get_a_entregar($rArchivo->id, $idPlantilla, 14);
                                $qPorEntregar_DLD = $this->impresiones_model->get_a_entregar($rArchivo->id, $idPlantilla, 16);
                                $qPorEntregar_DIS = $this->impresiones_model->get_a_entregar($rArchivo->id, $idPlantilla, 15);
                                $qPorEntregar_DGJ = $this->impresiones_model->get_a_entregar($rArchivo->id, $idPlantilla, 7);
                                $qPorEntregar_DGPOP = $this->impresiones_model->get_a_entregar($rArchivo->id, $idPlantilla, 4);
                                $qPorEntregar_Ejecutora = $this->impresiones_model->get_a_entregar($rArchivo->id, $idPlantilla, -1);
                                
                                /* Total de Documentos Recibidos de cada Archivo*/
                                $qRecibidos_DCP = $this->impresiones_model->get_recibidos($rArchivo->id, 14);
                                $qRecibidos_DLD = $this->impresiones_model->get_recibidos($rArchivo->id, 16);
                                $qRecibidos_DIS = $this->impresiones_model->get_recibidos($rArchivo->id, 15);
                                $qRecibidos_DGJ = $this->impresiones_model->get_recibidos($rArchivo->id, 7);
                                $qRecibidos_DGPOP = $this->impresiones_model->get_recibidos($rArchivo->id, 4);
                                $qRecibidos_Ejecutora = $this->impresiones_model->get_recibidos($rArchivo->id, $row->idDireccion);
                                
                                $qTotal_Obligados = $qPorEntregar_DCP +  $qPorEntregar_DLD + $qPorEntregar_DIS + $qPorEntregar_DGJ +$qPorEntregar_DGPOP +  $qPorEntregar_Ejecutora;
                                $qTotal_Recibidos = $qRecibidos_DCP +  $qRecibidos_DLD + $qRecibidos_DIS + $qRecibidos_DGJ +$qRecibidos_DGPOP +  $qRecibidos_Ejecutora;
                                $qTotales_a_entregar = $this->impresiones_model->get_total_a_entregar($rArchivo->id, $idPlantilla);
                                
                                $aArchivo = array(
                                    'id' => $rArchivo->id,
                                    'OrdenTrabajo' => $rArchivo->OrdenTrabajo,
                                    'qPorEntregar_DCP' => $qPorEntregar_DCP,
                                    'qPorEntregar_DLD' => $qPorEntregar_DLD,
                                    'qPorEntregar_DIS' => $qPorEntregar_DIS,
                                    'qPorEntregar_DGJ' => $qPorEntregar_DGJ,
                                    'qPorEntregar_DGPOP' => $qPorEntregar_DGPOP,
                                    'qPorEntregar_Ejecutora' => $qPorEntregar_Ejecutora,
                                    'qRecibidos_DCP' => $qRecibidos_DCP,
                                    'qRecibidos_DLD' => $qRecibidos_DLD,
                                    'qRecibidos_DIS' => $qRecibidos_DIS,
                                    'qRecibidos_DGJ' => $qRecibidos_DGJ,
                                    'qRecibidos_DGPOP' => $qRecibidos_DGPOP,
                                    'qRecibidos_Ejecutora' => $qRecibidos_Ejecutora,
                                    'Contrato' =>$rArchivo->Contrato,
                                    'Obra' =>$rArchivo->Obra,
                                    'Modalidad' =>$rArchivo->Modalidad,
                                    'Normatividad' =>$rArchivo->Normatividad,
                                    'Direccion' =>$rArchivo->Direccion,
                                    'ImporteContratado'=>$rArchivo->ImporteContratado,
                                    'qTotal_Obligados' =>  $qTotal_Obligados,
                                    'qTotales_Recibidos' =>  $qTotal_Recibidos,
                                    'qTotales_a_entregar' =>  $qTotales_a_entregar,
                                    'idPlantilla' =>$idPlantilla
                                );
                                    
                         
                                
                              
                                $aArchivos[$j]= $aArchivo;
                                
                                
                                $j++;
                                
                                
                                
                                //echo $i. " "  .$rArchivo->id . " $idPlantilla ".$rArchivo->OrdenTrabajo ."DPC $qPorEntregar_DCP/$qRecibidos_DCP DLD $qPorEntregar_DLD/$qRecibidos_DLD DIS $qPorEntregar_DIS/$qRecibidos_DIS DGJ $qPorEntregar_DGJ/$qRecibidos_DGJ DGPOP $qPorEntregar_DGPOP/$qRecibidos_DGPOP Ejecutora $qPorEntregar_Ejecutora/$qRecibidos_Ejecutora Avance $qTotales_a_entregar/$qTotal_Recibidos  Obligados $qTotal_Obligados<br>";
                            }
                            $i++;
                        }
                        //var_dump($aArchivos) ;
                        $aEjecutora['idDireccion'] = $row->idDireccion;
                        $aEjecutora['Nombre'] = $row->Nombre;
                        $aEjecutora['Abreviatura'] = $row->Abreviatura;
                        $aEjecutora['aArchivos'] = $aArchivos;
                        

                        $retorno[] = $aEjecutora;   
                        
                    }
                    
                    
                    
                    
                }
            }
            
            $data['retorno'] = $retorno;
            $data['totales'] = $i;
            $data['ejercicio'] = $ejercicio;
            $data['grupo'] = $this->get_grupo($grupo);
            $data['estatus'] = $str_estatus;
            if ($pdf == 1) {
                $this->load->library('mpdf');
               
                $mpdf = new mPDF('utf-8');
                
                $output = $this->load->view('preregistro/v_rep_ejercicio_fiscal', $data, true);
                $mpdf->WriteHTML($output);
                $mpdf->Output();
                
            } else {
                 foreach ($retorno as $row){
                    echo "Nuevo ";
                    echo $row['idDireccion'] ." ";
                    echo $row['Nombre'] ."<br> ";
                    


                    foreach ($row['aArchivos'] as $rArchivo){
                        
                        echo $rArchivo['id'] ." ";
                        echo $rArchivo['OrdenTrabajo'] ." " .$rArchivo['idPlantilla']." " .
                        
                                "DPC " .$rArchivo['qPorEntregar_DCP'] ." / " .$rArchivo['qRecibidos_DCP']. 
                                "DLD " .$rArchivo['qPorEntregar_DLD'] ." / " .$rArchivo['qRecibidos_DLD'].
                                "DIS " .$rArchivo['qPorEntregar_DIS'] ." / " .$rArchivo['qRecibidos_DIS']. 
                                "DGJ " .$rArchivo['qPorEntregar_DGJ'] ." / " .$rArchivo['qRecibidos_DGJ'].
                                "DGPOP ".$rArchivo['qPorEntregar_DGPOP'] ." / " .$rArchivo['qRecibidos_DGPOP']. 
                                "Ejecutora " . $rArchivo['qPorEntregar_Ejecutora'] ." / " .$rArchivo['qRecibidos_Ejecutora']. 
                                "Avance " .$rArchivo['qTotales_a_entregar'] ."/" .$rArchivo['qTotales_Recibidos'] .
                                "Obligados"  . $rArchivo['qTotal_Obligados'] ."<br>";
                      


                    }




                }
            }
            
          
            
            
             
    }
    
    public function rep_avances_direccion_periodo($pdf=0){
            
            
            $ejercicio = $this->input->post('ejercicio-modal-avances-direccion');
            $estatus = $this->input->post('estatus-modal-avances-direccion');
            $grupo = $this->input->post('grupo-modal-avances-direccion');
            $fecha_inicio = $this->input->post('fecha-inicio-modal-avances-direccion');
            $fecha_final = $this->input->post('fecha-final-modal-avances-direccion');
            
            $str_estatus = $this->get_estatus($estatus);
            $qTotales_Entregados = 0;
            $qEntregados_DCP = 0;
            $qEntregados_DLD = 0;
            $qEntregados_DIS = 0;
            $qEntregados_DGJ = 0;
            $qEntregados_DGPOP =0;
            $qEntregados_Ejecutora = 0;
            $aArchivos = array();
            $i = 0;
            $qDireccionesEjecutoras = $this->preregistro_model->get_ejecutoras_periodo($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final);
            //echo "<br><br><br><br><br><br><br><br>";
            if (isset($qDireccionesEjecutoras)){
                if ($qDireccionesEjecutoras->num_rows() > 0) {
                    $i = 0;
                    foreach ($qDireccionesEjecutoras->result() as $row) {
                       //echo "<br>$row->idDireccion". $row->Nombre ."<br>";
                        
                       
                       
                        $qArchivos = $this->preregistro_model->get_archivos_periodo($row->idDireccion, $ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final);
                        foreach ($qArchivos->result() as $rArchivo) {
                            //echo "<br> $i - " .$rArchivo->OrdenTrabajo ."<br>";
                           
                            
                            $idPlantilla = $rArchivo->idPlantilla;
                            $idArchivo = $rArchivo->id;
                            
                            
                                
                            /* Total de Documentos Entregados de cada Archivo-Direccion*/
                            $qEntregados_DCP = $qEntregados_DCP + $this->preregistro_model->get_recibidos_periodo($idArchivo, 14 , $fecha_inicio, $fecha_final);
                            $qEntregados_DLD = $qEntregados_DLD + $this->preregistro_model->get_recibidos_periodo($idArchivo, 16 , $fecha_inicio, $fecha_final);
                            $qEntregados_DIS = $qEntregados_DIS + $this->preregistro_model->get_recibidos_periodo($idArchivo, 15 , $fecha_inicio, $fecha_final);
                            $qEntregados_DGJ = $qEntregados_DGJ + $this->preregistro_model->get_recibidos_periodo($idArchivo, 7 , $fecha_inicio, $fecha_final);
                            $qEntregados_DGPOP = $qEntregados_DGPOP + $this->preregistro_model->get_recibidos_periodo($idArchivo, 4 , $fecha_inicio, $fecha_final);
                            $qEntregados_Ejecutora = $this->preregistro_model->get_recibidos_periodo($idArchivo, -1 , $fecha_inicio, $fecha_final);

                           
                            $qTotales_Entregados = $qTotales_Entregados + $qEntregados_DCP +  $qEntregados_DLD + $qEntregados_DIS +  $qEntregados_DGJ  + $qEntregados_DGPOP;
                            $i++;
                            //echo "qEntregados_DCP $qEntregados_DCP qEntregados_DLD $qEntregados_DLD  qEntregados_DIS $qEntregados_DIS qEntregados_DGJ $qEntregados_DGJ qEntregados_DGPOP $qEntregados_DGPOP qEntregados_Ejecutora $qEntregados_Ejecutora";
                        }
                        $ejecutoras[] = array(
                            'idDireccion' => $row->idDireccion,
                            'Direccion' => $row->Nombre,
                            'Entregados' =>  $qEntregados_Ejecutora,
                        );
                        $qTotales_Entregados = $qTotales_Entregados + $qEntregados_Ejecutora;
                        //echo "qEntregados_Ejecutora Total $qEntregados_Ejecutora qTotales_Entregados $qTotales_Entregados<br>";
                        $qEntregados_Ejecutora = 0;
                    } 
                    
                }
            }
            //echo "<br><br><br><br><br><br><br><br>";
            $data['qTotales_Entregados'] = $qTotales_Entregados;
            $data['qEntregados_DCP'] = $qEntregados_DCP;
            $data['qEntregados_DLD'] = $qEntregados_DLD;
            $data['qEntregados_DIS'] = $qEntregados_DIS;
            $data['qEntregados_DGJ'] = $qEntregados_DGJ;
            $data['qEntregados_DGPOP'] = $qEntregados_DGPOP;
            $data['qEjecutoras'] = $ejecutoras;
            $data['fecha_inicio'] = $fecha_inicio;
            $data['fecha_final'] = $fecha_final;
            $data['totales'] = $i;
            $data['ejercicio'] = $ejercicio;
            $data['grupo'] = $this->get_grupo($grupo);
            $data['estatus'] = $str_estatus;
            if ($pdf == 1) {
                $this->load->library('mpdf');
               
                $mpdf = new mPDF('utf-8');
                
                $output = $this->load->view('preregistro/v_rep_avances_direccion', $data, true);
                $mpdf->WriteHTML($output);
                $mpdf->Output();
                
            } else {
                $data['usuario']     = $this->session->userdata('nombre');
                $data['idusuario']   = $this->session->userdata('id');
                $data["preregistro"] = $this->session->userdata('preregistro');
                $data["js"] = "rep_avances_direccion.js";
                $this->load->view('layouts/header', $data);
                $this->load->view('preregistro/v_rep_avances_direccion', $data);
                $this->load->view('layouts/footer', $data);
                 
            }
            
          
            
            
             
    }
    
    
    
    public function avances(){
        $ejercicio = $this->input->post('ejercicio-modal-avances-direccion');
        $estatus = $this->input->post('estatus-modal-avances-direccion');
        $grupo = $this->input->post('grupo-modal-avances-direccion');
        $inicio = $this->input->post('fecha-inicio-modal-avances-direccion');
        $final = $this->input->post('fecha-final-modal-avances-direccion');
        
        $fecha_final =  strtotime ( '+1 day' , strtotime ( $final ) );
        $fecha_inicio =  strtotime ( '-1 day' , strtotime ( $inicio ) );
        $fecha_final =  date ( 'Y-m-d' , $fecha_final );
        $fecha_inicio = date ( 'Y-m-d' , $fecha_inicio );
        
        //0 1 Avances Personal 2 Avances OT
        $reporte = $this->input->post('reporte-modal-avances-direccion');
        
        if($reporte == 2){
            $this->avances_direccion_periodo($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final);
        }else{
            $this->avances_personal($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final);
        }
        
    }


    public function avances_direccion_periodo($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final){
        
        
        $str_estatus = $this->get_estatus($estatus);
        $qDireccionesEjecutoras = $this->preregistro_model->get_ejecutoras_periodo($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final);
        $qDireccionesObligadas = $this->preregistro_model->get_obligadas_periodo($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final);
        
        
        $qDireccionesEjecutorasTotales = $this->preregistro_model->get_ejecutoras($ejercicio, $str_estatus, $grupo);
        $qDireccionesObligadasTotales = $this->preregistro_model->get_obligadas($ejercicio, $str_estatus, $grupo);
        
        echo '<br><br><br><br>';
        foreach($qDireccionesEjecutorasTotales->result() as $row){
            
            $retorno[] = array(
                'idDireccion' => $row->idDireccion,
                'Nombre' => $row->Nombre,
                'Abreviatura' => $row->Abreviatura,
                'entregados_totales' => $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion),
                'entregados_obligados' => $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion, 1),
                'preregistrados_direccion' => $this->preregistro_model->get_preregistrados_direccion($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion),
            );
            echo '<br>'.$row->Abreviatura . "Ejectutora ".  $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion,0);
            
        }
        
        foreach($qDireccionesObligadasTotales->result() as $row){
            
            $retorno[] = array(
                'idDireccion' => $row->idDireccion,
                'Nombre' => $row->Nombre,
                'Abreviatura' => $row->Abreviatura,
                'entregados_totales' => $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion),
                'entregados_obligados' => $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion, 0),
                'preregistrados_direccion' => $this->preregistro_model->get_preregistrados_direccion($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion),
            );
            echo '<br>'.$row->Abreviatura . " Obligada " . $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion,0);
            
           
        }
        
         
        /*
        foreach($qDireccionesEjecutorasTotales->result() as $row){
            //$entregados_totales = $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, 0,0, $row->idDireccion);
            //$entregados_obligados = $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, 0, 0, $row->idDireccion, 1);
            
            $por_entregar = $this->preregistro_model->get_totales_a_entregar($ejercicio, $str_estatus, $grupo, "Ejecutora", 1);
            $retorno_general[] = array(
                'idDireccion' => $row->idDireccion,
                'Nombre' => $row->Nombre,
                'Abreviatura' => $row->Abreviatura,
                //'entregados_totales' => $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, 0,0, $row->idDireccion),
                //'entregados_obligados' => $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, 0, 0, $row->idDireccion, 1),
                'por_entregar' => $por_entregar,
            );
            echo "Ejecutora" .$row->Abreviatura.$por_entregar;
           
        }
        
        foreach($qDireccionesObligadasTotales->result() as $row){
            //$entregados_totales = $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, 0,0, $row->idDireccion);
            //$entregados_obligados = $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, 0, 0, $row->idDireccion, 0);
            $por_entregar = $this->preregistro_model->get_totales_a_entregar($ejercicio, $str_estatus, $grupo, $row->Abreviatura, 0);
            $retorno_general[] = array(
                'idDireccion' => $row->idDireccion,
                'Nombre' => $row->Nombre,
                'Abreviatura' => $row->Abreviatura,
                //'entregados_totales' => $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, 0, 0, $row->idDireccion),
                //'entregados_obligados' => $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, 0, 0, $row->idDireccion, 0),
                'por_entregar' => $por_entregar,
            );
            echo "Obligada" .$row->Abreviatura.$por_entregar;
            
           
        }
         * */
        
        
        
        $data['fecha_inicio'] = $inicio;
        $data['fecha_final'] = $final;
        $data['ejercicio'] = $ejercicio;
        $data['grupo'] = $this->get_grupo($grupo);
        $data['estatus'] = $str_estatus;
        $data['retorno'] = $retorno;
        //$data['retorno_general'] = $retorno_general;
        $data['usuario']     = $this->session->userdata('nombre');
        $data['idusuario']   = $this->session->userdata('id');
        $data["preregistro"] = $this->session->userdata('preregistro');
        $data["js"] = "rep_avances_direccion.js";
        $this->load->view('layouts/header', $data);
        $this->load->view('preregistro/v_rep_avances_direccion', $data);
        $this->load->view('layouts/footer', $data);
        
    }
    
    
    public function avances_personal($ejercicio, $estatus, $grupo, $fecha_inicio, $fecha_final, $pdf= 1){
        
        
        $str_estatus = $this->get_estatus($estatus);
        $qPersonal = $this->preregistro_model->get_personal_trabajo($fecha_inicio, $fecha_final);
        
        
        foreach($qPersonal->result() as $row){
            
            $retorno[] = array(
                
                'Nombre' => $row->Nombre,
                'No_preregistros_preregistrados' => $row->Abreviatura,
                'No_documentos_preregistrados' => $this->preregistro_model->get_entregados_direccion_totales($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion),
                'No_preregistros_recibidos' => $this->preregistro_model->get_entregados_direccion_obligados($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion, 1),
                'No_documentos_recibidos' => $this->preregistro_model->get_preregistrados_direccion($ejercicio, $str_estatus, $grupo, $fecha_inicio, $fecha_final, $row->idDireccion),
            );
            
        }
        
        
        
        
        
        $data['fecha_inicio'] = $inicio;
        $data['fecha_final'] = $final;
        $data['ejercicio'] = $ejercicio;
        $data['grupo'] = $this->get_grupo($grupo);
        $data['estatus'] = $str_estatus;
        $data['retorno'] = $retorno;
        if ($pdf == 1) {
            $this->load->library('mpdf');

            $mpdf = new mPDF('utf-8');

            $output = $this->load->view('preregistro/v_rep_avances_personal', $data, true);
            $mpdf->WriteHTML($output);
            $mpdf->Output();

        }else{
            $this->load->view('preregistro/v_rep_avances_personal', $data);
        }
        
    }
    
}