<?php


class Control_usuarios extends MY_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->load->library('ferfunc');
        $this->load->model('control_usuarios_model');
    }

    public function index($error='') {
        $this->load->library('ferfunc');
        
        /*if ($this->ferfunc->get_permiso_edicion_lectura($this->session->userdata('id'),"Usuarios","P")==false){
            header("Location:" . site_url('principal'));
        }*/
         

        $data['error']=$error;
        $data['usuario'] = $this->session->userdata('nombre');
        $data['qListado'] = $this->control_usuarios_model->listado();
        $data['qTipos']   = $this->control_usuarios_model->listado_tipos();
       
        $this->load->view('usuarios/v_pant_usuarios', $data);
    }

    

   

    public function get_datos_usuario($id) {
        $this->load->model('control_usuarios_model');
        $query = $this->control_usuarios_model->datos_usuario($id);
        echo json_encode($query->row_array());
    }
    
    
    public function agregar_cat() {
        $this->load->model('control_usuarios_model');
        $administrador = (isset($_POST['txtAdministrador']) && $_POST['txtAdministrador'] == '1')? 1: 0;
        
        
        $data=array(
            'Nombre'=> strtoupper($this->input->post('Nombre')),
            'Usuario'=>  $this->input->post('txtUsuario'),
            'Password'=> sha1($this->input->post('txtPassword')),
            'admin' => $administrador,
            'idTipo' => $this->input->post('idTipo'),
        );
         
        $retorno=  $this->control_usuarios_model->datos_usuario_insert($data);
        
        header("Location:" . site_url('control_usuarios/cambios/'.$retorno['registro']));
        /*
        if($retorno['retorno']<0)
            header('Location:'.site_url('usuarios/index/'.$retorno['error']));
        else
            $this->crear_perfil($retorno['registro']);
            header('Location:'.site_url('usuarios')); 
        */    
    }

    
    
    public function editar_cat($id) {
         
         
        $admin =(isset($_POST['txtAdministrador']) && $_POST['txtAdministrador'] == '1')? 1: 0;
        $data=array(
            'Nombre'=> strtoupper($this->input->post('Nombre')),
            'Usuario'=>  $this->input->post('txtUsuario'),
            'idTipo' => $this->input->post('idTipo'),
            'admin' => $admin,           
                
        );   
        #MAOC Si hay cambios en contraseña
         if (!$this->input->post('Password')==-1){
            $data['Password'] = sha1($this->input->post('txtPassword'));
           
         }
        $retorno=  $this->control_usuarios_model->datos_usuario_update($data,$id);
        
        header("Location:" . site_url('control_usuarios/cambios/'.$id));
        /*
        if($retorno['retorno']<0)
            header('Location:'.site_url('usuarios/index/'.$retorno['error']));
        else
            header('Location:'.site_url('usuarios')); 
         * 
         */
    }
    
    public function eliminar_cat($id) {
        $this->load->model('control_usuarios_model');
         
        //$retorno=  $this->control_usuarios_model->datos_usuario_delete($id);
        
         $data=array(
                'Estatus'=> 0,
         );
       
        $retorno=  $this->control_usuarios_model->datos_usuario_update($data,$id);
        
        if($retorno['retorno']<0)
            header('Location:'.site_url('control_usuarios/index/'.$retorno['error']));
        else
            header('Location:'.site_url('control_usuarios')); 
    }
    
     public function cambios($id) {
        
         $this->actualiza_perfil($id);
         
        //$data['permiso'] = $this->ferfunc->get_permiso($this->session->userdata('id'), 'procesos');
        $data['usuario'] = $this->session->userdata('nombre');
        
        
        $this->load->model('control_usuarios_model');
        $data['qTipos']   = $this->control_usuarios_model->listado_tipos();
        $data['qUsuario']=$this->control_usuarios_model->datos_usuario($id)->row_array();
        $tModulos = $this->control_usuarios_model->menu_usuarios();
        
        $data['menu'] = '';
        foreach($tModulos->result() as $itemM):
                $data['menu'] .= '<div class="box box-primary box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="panel-title">'. $itemM->Modulo .' </h3>
                                        <div class="box-tools pull-right">
                                          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div>
                                    <div class="box-body">';

                    $tSubModulos = $this->control_usuarios_model->menu_usuarios_sub($itemM->id);
                    foreach ($tSubModulos->result() as $itemSM):
                        $data['menu'] .= '<label class="text-primary">SUB MODULO: '.$itemSM->Permiso.'</label><br />';
                            $tPU = $this->control_usuarios_model->permiso_especifico($id, $itemSM->Permiso);
                            if($tPU->num_rows() > 0){
                                $ps = $tPU->row();
                                $paqPermisos= $ps->Permisos;
                                $pid = $ps->id;
                                $data['menu'] .= '<form name="form<?= $pid ?>" class="myFormulario">';
                                    if($ps->Estatus == 0){
                                        $checkedP = '';
                                        $checkedC = '';
                                        $checkedE = '';
                                        $checkedN = '';
                                        $checkedR = '';
                                    }
                                    else{
                                        $explodePermisos = explode(',',$paqPermisos);
                                        if($explodePermisos[0]=='P'){
                                            $checkedP = 'checked';
                                        }else{
                                            $checkedP = '';
                                        }
                                        if($explodePermisos[1]=='C'){
                                            $checkedC = 'checked';
                                        }else{
                                            $checkedC = '';
                                        }      
                                        if($explodePermisos[2]=='E'){
                                            $checkedE = 'checked';
                                        }else{
                                            $checkedE = '';
                                        }                                         
                                        if($explodePermisos[3]=='N'){
                                            $checkedN = 'checked';
                                        }else{
                                            $checkedN = '';
                                        }
                                        if($explodePermisos[4]=='R'){
                                            $checkedR = 'checked';
                                        }else{
                                            $checkedR = '';
                                        } 
                                        
                                        
                                    }
                                    
                                    
                                    if($ps->Estatus == 0){
                                        $checked_enviar='';
                                    }else{
                                        if($ps->enviar_solicitud==1){
                                            $checked_enviar = 'checked';
                                        }else{
                                            $checked_enviar = '';
                                        } 
                                    }
                                    
                                    $data['menu'] .= '<div id="radios'.$id.'">
                                                        <input type="checkbox" name="todo'.$pid.'" id="radioTodo'.$pid.'" class="radioTodo" onchange="marcar(this,' .$pid .')">
                                              
                                                        <label class="text-primary">Habilitar Todo</label></div><br />';
                                    $data['menu'] .= '<input type="hidden" name="identificador"   value="'.$ps->id.'">';
                                    $data['menu'] .= '<input type="hidden" name="idUsuario"  value="'.$id.'" >'; 
                                    $data['menu'] .= 'PRESENTAR:<input class="radioTodo'.$pid.'" type="checkbox" name="checkP" value="P" '.$checkedP.'> ';
                                    $data['menu'] .= 'CREAR:<input  class="radioTodo'.$pid.'" type="checkbox" name="checkC" value="C" '.$checkedC.'> ';
                                    $data['menu'] .= 'EDITAR:<input  class="radioTodo'.$pid.'" type="checkbox" name="checkE" value="E"'.$checkedE.'> ';
                                    $data['menu'] .= 'ELIMINAR:<input  class="radioTodo'.$pid.'" type="checkbox" name="checkN" value="N"'.$checkedN.'> ';
                                    $data['menu'] .= 'REPORTES:<input  class="radioTodo'.$pid.'" type="checkbox" name="checkR" value="R"'.$checkedR.'>';
                                    //$data['menu'] .= 'ENVIAR SOLICITUD:<input id="check_enviar" type="checkbox" name="check_enviar" value="1"'.$checked_enviar.'>';
                                    $data['menu'] .= '<button class="btn btn-primary btn-xs"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>';
                                $data['menu'] .= '</form>';
                            }

                        $data['menu'] .= '<hr>';
                    endforeach;
                    $data['menu'] .= '</div>
                          </div>';
            endforeach;
            /*foreach($tModulos->result() as $itemM):
                $data['menu'] .= '<label class="text-success">MODULO: '.$itemM->Modulo.'</label><br />';
                    $tSubModulos = $this->control_usuarios_model->menu_usuarios_sub($itemM->id);
                    foreach ($tSubModulos->result() as $itemSM):
                        $data['menu'] .= '<label class="text-primary">SUB MODULO: '.$itemSM->Permiso.'</label><br />';
                            $tPU = $this->control_usuarios_model->permiso_especifico($id, $itemSM->Permiso);
                            if($tPU->num_rows() > 0){
                                $ps = $tPU->row();
                                $paqPermisos= $ps->Permisos;
                                $pid = $ps->id;
                                $data['menu'] .= '<form name="form" action="'.site_url('control_usuarios/guardar_permisos/').'" method="post">';
                                    if($ps->Estatus == 0){
                                        $checkedP = '';
                                        $checkedC = '';
                                        $checkedE = '';
                                        $checkedN = '';
                                        $checkedR = '';
                                    }
                                    else{
                                        $explodePermisos = explode(',',$paqPermisos);
                                        if($explodePermisos[0]=='P'){
                                            $checkedP = 'checked';
                                        }else{
                                            $checkedP = '';
                                        }
                                        if($explodePermisos[1]=='C'){
                                            $checkedC = 'checked';
                                        }else{
                                            $checkedC = '';
                                        }      
                                        if($explodePermisos[2]=='E'){
                                            $checkedE = 'checked';
                                        }else{
                                            $checkedE = '';
                                        }                                         
                                        if($explodePermisos[3]=='N'){
                                            $checkedN = 'checked';
                                        }else{
                                            $checkedN = '';
                                        }
                                        if($explodePermisos[4]=='R'){
                                            $checkedR = 'checked';
                                        }else{
                                            $checkedR = '';
                                        } 
                                        
                                        
                                    }
                                    
                                    
                                    if($ps->Estatus == 0){
                                        $checked_enviar='';
                                    }else{
                                        if($ps->enviar_solicitud==1){
                                            $checked_enviar = 'checked';
                                        }else{
                                            $checked_enviar = '';
                                        } 
                                    }
                                    
                                    $data['menu'] .= '<div id="radios'.$id.'"><input type="radio" name="todo" id="radioTodo" onclick="marcar(check'.$pid.')"; ><label class="text-primary">Habilitar todo</label>';
                                    $data['menu'] .= '<input type="radio" name="todo" id="radioNada" onclick="desmarcar(check'.$pid.')"><label class="text-default">Deshabilitar</label></div><br />';
                                    $data['menu'] .= '<input type="hidden" name="identificador" value="'.$ps->id.'" size="1">';
                                    $data['menu'] .= '<input type="hidden" name="idUsuario" value="'.$id.'" size="1">'; 
                                    $data['menu'] .= 'PRESENTAR:<input id="check'.$pid.'" type="checkbox" name="checkP" value="P" '.$checkedP.'> ';
                                    $data['menu'] .= 'CREAR:<input id="check'.$pid.'" type="checkbox" name="checkC" value="C" '.$checkedC.'> ';
                                    $data['menu'] .= 'EDITAR:<input id="check'.$pid.'" type="checkbox" name="checkE" value="E"'.$checkedE.'> ';
                                    $data['menu'] .= 'ELIMINAR:<input id="check'.$pid.'" type="checkbox" name="checkN" value="N"'.$checkedN.'> ';
                                    $data['menu'] .= 'REPORTES:<input id="check'.$pid.'" type="checkbox" name="checkR" value="R"'.$checkedR.'>';
                                    $data['menu'] .= 'ENVIAR SOLICITUD:<input id="check_enviar" type="checkbox" name="check_enviar" value="1"'.$checked_enviar.'>';
                                    $data['menu'] .= '<input type="submit" class="btn btn-primary btn-xs">';
                                $data['menu'] .= '</form>';
                            }
                        $data['menu'] .= '<hr>';
                    endforeach;
            endforeach;*/
        
      
        
        $data['addw_tipos'] = $this->control_usuarios_model->addw_tipos();
        $this->load->view('usuarios/v_pant_usuarios_edicion', $data);
    }
    
    
    public function crear_perfil($idUsuario){
        $this->load->model('control_usuarios_model');
        $tSubModulos = $this->control_usuarios_model->menus_subs();
            foreach ($tSubModulos->result() as $keyS):
                $permisos =array(
                    'idUsuario' => $idUsuario,
                    'Permiso' => $keyS->Permiso,
                    'Estatus' => 0,
                    'Permisos' => 'O,O,O,O,O'
                );
            $this->control_usuarios_model->insert_permisos_nuevo($permisos);
            endforeach;
    }

    
    public function guardar_permisos(){
        
        $this->load->model('control_usuarios_model');
        
        $identificador =  $this->input->post('identificador');
        $idUsuario = $this->input->post('idUsuario');
        if($this->input->post('checkP') == 'P'){
            $per[]=$this->input->post('checkP');
        }else{
            $per[]= 'O';
        }
        if($this->input->post('checkC') == 'C'){
            $per[]=$this->input->post('checkC');
        }else{
            $per[]= 'O';
        }
        if($this->input->post('checkE') == 'E'){
            $per[]=$this->input->post('checkE');
        }else{
            $per[]= 'O';
        }
        if($this->input->post('checkN') == 'N'){
            $per[]=$this->input->post('checkN');
        }else{
            $per[]= 'O';
        }
        if($this->input->post('checkR') == 'R'){
            $per[]=$this->input->post('checkR');
        }else{
            $per[]= 'O';
        }
        $permisos = implode(',',$per);
        if($permisos == 'O,O,O,O,O'){
            $estatus =0;
        }else{
            $estatus =1;
        }
        
        
        
        if($this->input->post('check_enviar') == 1){
            $check_enviar=$this->input->post('check_enviar');
        }else{
            $check_enviar= 0;
        }
        
        
        $paquete = array(
            'enviar_solicitud' => $check_enviar,
            'Estatus' => $estatus,
            'Permisos' => $permisos
        );
        echo $this->control_usuarios_model->update_permisos($identificador,$paquete);
        //$this->cambios($idUsuario);

    }
    
    /*
     * CUANDO SE AGREGUE UN NUEVO MODULO O SUBMODULO DEL SISTEMA
     * ESTA FUNCION CREARA LOS PERMISOS POR DEFECTO EN TODOS LOS USUARIOS
     * usuarios/nuevo_menu/Nombre_permiso
     */
    
    public function nuevo_menu($Permiso){
        $this->load->model('control_usuarios_model');
        $tUsuarios = $this->control_usuarios_model->todos_los_usuarios();
        foreach($tUsuarios->result() as $keyUser):
            $paquete = array(
                'idUsuario' => $keyUser->id,
                'Permiso' => $Permiso,
                'Estatus' => 0,
                'Permisos' => 'O,O,O,O,O'
            );
        $this->control_usuarios_model->insert_permisos_nuevo($paquete);
        endforeach;
        
    }
    
    
     public function actualiza_perfil($idUsuario){
        $this->load->model('control_usuarios_model');
        $tSubModulos = $this->control_usuarios_model->menus_subs();
            foreach ($tSubModulos->result() as $keyS):
                $qPermiso=$this->control_usuarios_model->permiso_especifico($idUsuario,$keyS->Permiso);
                if ($qPermiso->num_rows()==0){    
                    $permisos =array(
                        'idUsuario' => $idUsuario,
                        'Permiso' => $keyS->Permiso,
                        'Estatus' => 0,
                        'Permisos' => 'O,O,O,O,O'
                    );
                    $this->control_usuarios_model->insert_permisos_nuevo($permisos);
                }
            endforeach;
    }
    
    
    
    
    
}

