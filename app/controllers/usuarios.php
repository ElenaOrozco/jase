<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuarios extends MY_Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['img_dir'] = base_url() . $this->config->item('img_dir');
        $data['meta'] = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => 'Sistema Administrativo en linea'),
            array('name' => 'keywords', 'content' => 'facturacion, control, cobranza, almacen, produccion , contabilidad'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $data['css'] = array(link_tag(base_url() . "css/principal.css"));
        $data['script'] = '<script type="text/javascript" src="' . $this->config->item('lib_jquery') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_ui') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('jquery_datatables') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('jquery_datatables_ex') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('jquery_datatables_ar') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_datepicker') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_maskedinput') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_maskmoney') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_extend') . '"></script>';

        // Validacion 
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate_ext') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate_es') . '"></script>';
        /////////////

        $data['script'].="
		<script language='JavaScript' type='text/javascript'>
		var oTable;
                var lastid = 0;
		$(document).ready(function() {
				// Bind para rezise
                                $('#menu_principal').load('" . site_url('/menu') . "');
				
				$(window).bind('resize', resizeWindow);
				//$('#menu').load('" . site_url("menu/index/3") . "');
				//$('.btn_nuevo').button({
				//	icons: {
				//		primary: 'ui-icon-plusthick'
				//	}
				//});
                                
				/////////
				// Tabla de datos
				
				oTable = $('#tabla_scroll').dataTable({				
                                'bProcessing': true,
				'sAjaxSource': '" . site_url("ajaxnullsource.txt") . "',
				'sScrollY': '400px' ,
				'bJQueryUI': true,
				'bPaginate': false,
				'bAutoWidth': true,
				'bScrollCollapse': false,
				'aoColumns': [ 
					{'sClass':'dt_left','sWidth': '20px'},
					{'sClass':'dt_left','sWidth': '200px'},
                                        {'sClass':'dt_left','sWidth': '200px'},
                                        {'sClass':'dt_left','sWidth': '20px'},
                                        {'sClass':'dt_left','sWidth': '20px'}
                                        ],
				'oLanguage': {
					'sProcessing':   'Procesando...',
					'sLengthMenu':   'Mostrar _MENU_ registros',
					'sZeroRecords':  'Obteniendo registros',
					'sInfo':         'Mostrando desde _START_ hasta _END_ de _TOTAL_ registros',
					'sInfoEmpty':    'Mostrando desde 0 hasta 0 de 0 registros',
					'sInfoFiltered': '(filtrado de _MAX_ registros en total)',
					'sInfoPostFix':  '',
					'sSearch':       'Buscar:',
					'sUrl':          '',
					'oPaginate': {
						'sFirst':    '&nbsp;Primero&nbsp;',
						'sPrevious': '&nbsp;Anterior&nbsp;',
						'sNext':     '&nbsp;Siguiente&nbsp;',
						'sLast':     '&nbsp;&Uacute;ltimo&nbsp;'
					}
				}
			});
			sUrl_source_ajax = '';
			oTable.fnReloadAjax('" . site_url('usuarios/listado_usuarios') . "');
                        
			resizeWindow();
                     
                        
                });         
                
                function reloadlist(registro){
                    var reg = '#reg'+parseInt(registro);
                    oTable.fnReloadAjax('" . site_url('usuarios/listado_usuarios') . "');
                    if (registro > 0){
                        oTable.parent().scrollTo(reg,800);
                    }
                }
		function resizeWindow( e ) {
			var originalheight = $('#tablaContenido').height();
			var busquedaheight = $('div.dataTables_filter').height();
			var sortheight = $('div.DataTables_sort_wrapper').height();	
			var infoheight = $('div.dataTables_info').height();	
			var snewheight = (originalheight - ((busquedaheight + sortheight+ infoheight)*1.65) ) + 'px';
			oTable.fnSettings().oScroll.sY = snewheight;
			$('div.dataTables_scrollBody').height( snewheight );
			oTable.fnAdjustColumnSizing();
		}
		                

                // Obras
                /////////////////////////
		function uf_nuevo(){
			var url = '" . site_url('usuarios/nuevo_usuario') . "';
                        lastid = 0;
			$('#ficha').empty();
			$('#ficha').load(url);
			$('#ficha').dialog({
					draggable: true,
					autoOpen: false,
					resizable: false,
					closeOnEscape: false,
					modal: true,
					minWidth: 900,
					minHeight: 540,
					title: 'Nuevo usuario',
					buttons: {
						'Aceptar': function() {
                                                        $('#formUsuario').submit();                                                        
							$('#ficha').dialog('close');                                                                                                               
						},
						'Cerrar': function(){
							$('#ficha').dialog('close'); 
						}
					}
					
			});
			$('#ficha').dialog('open');
			return false;
		}
                
                
                function uf_baja(id) {
                        var url = '" . site_url('usuarios/baja_usuario') . "';
                        var defaults = {
                                modal		: true,
                                resizable	: false,
                                buttons		: {
                                        'Aceptar': function() {
                                            $.post(url, {'id':id },function( data ) {
                                                if (data.retorno == '1'){
                                                    // refrescar listado
                                                    reloadlist(0);
                                                } else {
                                                    // Mandar error en baja
                                                    // refrescar listado
                                                    reloadlist(0);
                                                    alerta(data.error, {});
                                                }
                                            });
                                            $(this).dialog('close');
                                        },
                                        'Cancelar': function() {
                                                $(this).dialog('close');
                                        }
                                },
                                show		: 'fade',
                                hide		: 'fade',
                                minHeight	: 50,
                                minWidth	: 400,
                                title	        : 'Baja de Cliente ',
                                dialogClass	: 'modal-shadow'
                        }

                        confirmacion = $.getOrCreateDialog('confirmacion');
                        $('p', confirmacion).html('&iquest;Proceder a dar de baja de este registro?');
                        confirmacion.dialog($.extend({}, defaults, {}));
                }
               
		</script>
		<noscript>
		Se requiere Javascript activado
		</noscript>";
        // generar listado
        $data['botones'] = '<a href="#" class="btn_nuevo" onClick="uf_nuevo();">Nuevo usuario</a>';
        //$data['botones'] = '';
        $data['usuario'] = '<div align="right">Usuario: ' . $this->session->userdata('nombre') . '&nbsp;|&nbsp;<a href="' . site_url("sessions/logout") . '">Salir del Sistema</a></div>';
        $data['titulo'] = 'SECIP - Catalogo de usuarios';
        $data['subtitulo'] = 'Catalogo de usuarios';
        $data['encabezados'] = '
		  <th scope="col">Login</th>
		  <th scope="col">Nombre</th>
                  <th scope="col">Email</th>
                  <th scope="col">Super Usuario</th>
                  <th scope="col">Estatus</th>
		';
        $this->load->view('v_catalogos', $data);
    }
    
    public function listado_usuarios() {
        // salida del listado de obras via ajax
        $this->load->model("usuarios_model");
        $query = $this->usuarios_model->listado_usuarios();
        $output = array("aaData" => array());
        $aEstatus = $this->usuarios_model->addw_estatus();
        foreach ($query->result() as $rowdata) {

            $row = array();
            if ($rowdata->Estatus == 1)
                $row[] = '<a href="' . site_url('usuarios/cambios_usuario/' . $rowdata->id) . '" id="reg' . $rowdata->id . '" aria-disabled="false">' . $rowdata->Usuario . '</a>';
            else
                $row[] = '<a href="' . site_url('usuarios/activar_usuario/' . $rowdata->id) . '" id="reg' . $rowdata->id . '" aria-disabled="false">' . $rowdata->Usuario . '</a>';
            $row[] = $rowdata->Nombre;
            $row[] = $rowdata->Email;
            if ($rowdata->SuperUsuario == 0)
                $row[] = "No";
            else
                $row[] = "Si";
            $row[] = '<span style="text-color:"' . $aEstatus[$rowdata->Estatus]['color'] . '">' . $aEstatus[$rowdata->Estatus]['estatus'] . '</span>';
            $output['aaData'][] = $row;
        }
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($output, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function nuevo_usuario() {
        $this->load->model('usuarios_model');
        $this->load->helper('form');
        $this->load->library('table');
        $super = array("1" => "sí", "0" => "no");
        $niveles = array("1" => "Consulta", "2" => "Edicion");
        $menus = $this->usuarios_model->addw_menu();
//        print_r($menus);
        $attributes = array('id' => 'formUsuario', 'name' => 'formUsuario');
        echo '<div id="tabs">';
        echo '<ul>';
        echo '  <li><a href="#tabs-1">Datos Generales</a></li>';
        echo '</ul>';

        echo '<div id="tabs-1">';
        echo form_open(site_url('usuarios/nuevo_usuario_db'), $attributes);
        echo '
    <table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                  <td>Login:</td>
                  <td><input type="text" name="login" id="login" class="campoficha" required="required" title="Nombre de usuario requerido" /></td>
                </tr>
                <tr>
                <td class="forma_label">Password</td>
                <td><input name="password" type="password" id="password" required="required" title="password requerido" /></td>
        </tr>
        <tr>
        <td colspan="2"><hr width="100%"></td>
                <tr>
                  <td>Nombre:</td>
                  <td><input type="text" name="usuario" id="usuario" class="campoficha" required="required" title="Nombre del Usuario" /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" id="email" class="campoficha" /></td></tr>
<tr><td>Super Usuario</td><td>' . form_dropdown('SuperUsuario', $super, "0") . '</td></tr>
    <tr><td>Tipo de Usuario</td><td>' . form_dropdown('Nivel', $niveles) . '</td></tr>
</table>
</form>
    </div></div>';
        echo '<script language="JavaScript" type="text/javascript">';
        echo '        $(document).ready(function() {';
        echo '              $( "#tabs" ).tabs();';

        //echo '$("#formUsuario").validate();';
//        echo "        $('#formUsuario').submit(function(event) {
//                        var url = '" . site_url('usuarios/nuevo_usuario_db') . "';
//                        event.preventDefault();
//                        $.ajax({
//                            url:url,
//                            type:'post',
//                            data:$('#formUsuario').serialize(),
//                            dataType:'json',
//                            success:function(data){
//                                if (data.retorno == '1'){
//                                lastid = parseInt(data.registro);
//                                $(location).attr('href','" . site_url('usuarios/cambios_usuario') . "/'+lastid);
//                                } else { 
//                                alerta(data.error,{});
//                                lastid = 0;
//                                reloadlist(0);
//                                }
//                            }
//                        });
        echo "   $('#formUsuario').submit(function(event) {
                        var url = '" . site_url('usuarios/nuevo_usuario_db') . "';
                        event.preventDefault();
                        $.post(url, $('#formUsuario').serialize(),function( data ) {
                            if (data.retorno == '1'){
                                lastid = parseInt(data.registro);
                                reloadlist(data.registro);
                            } else { 
                                alerta(data.error,{});
                                lastid = 0;
                                reloadlist(0);
                            }
                        });
                        return false;
                    });";
        echo '});';
        echo '</script>';
    }

    public function nuevo_usuario_db() {
        // funcion para grabar un nuevo registro
        // llamar al modelo de datos
        $data = array(
            "Nombre" => $this->input->post('usuario'),
            "Usuario" => $this->input->post('login'),
            "Password" => sha1($this->input->post('password')),
            "email" => $this->input->post('email'),
            "SuperUsuario" => $this->input->post('SuperUsuario'),
            "Nivel" => $this->input->post('Nivel'),
            "Estatus" => 1
        );
        $menu = $this->input->post('Menu');
        $this->load->model("usuarios_model");
        $existe = $this->usuarios_model->usuarioRepetido($data['Usuario'], $data['Password']);
        if ($existe)
            $retorno = array("retorno" => "-1", "error" => "Ya Existe Usuario");
        else
            $retorno = $this->usuarios_model->datos_usuarios_insert($data, $menu);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($retorno, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function cambios_usuario($id = 0) {
        $this->load->model("usuarios_model");
        $this->load->model('supervisores_model');
        $query = $this->usuarios_model->get_usuario($id);
        $usuario = $query->row();
        //$this->load->helper('form');
        $this->load->library('table');
        $this->load->library('ferfunc');
        $data['img_dir'] = base_url() . $this->config->item('img_dir');
        $data['meta'] = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => 'Sistema Administrativo en linea'),
            array('name' => 'keywords', 'content' => 'facturacion, control, cobranza, almacen, produccion , contabilidad'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $data['css'] = array(link_tag(base_url() . "css/principal.css"));
        $data['css'][] = '<style>.ui-autocomplete {
                 max-height: 100px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
  }</style>';
        $data['titulo'] = "Edicion de Usuario";
        $data['subtitulo'] = $usuario->Nombre;
        $data['script'] = '<script type="text/javascript" src="' . $this->config->item('lib_jquery') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_ui') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_extend') . '"></script>';

        // Validacion 
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate_ext') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate_es') . '"></script>';
        /////////////

        $data['script'].='<script>';
        $data['script'].='        $(document).ready(function() {';
        $data['script'].='              $( "#tabs" ).tabs();';
//        $data['script'].='$("#permisos").load("' . site_url('usuarios/permisosUsuario/' . $id) . '");';
//        $data['script'].='$("#nvoPermiso").autocomplete({
//                source:"' . site_url('usuarios/listaPermisos/' . $id) . '",
//            });
//            ';
        $data['script'].="$('#mosPasswd').attr('checked', false);
                    $('#mosPasswd').click(function(){
                          value = $('#password').val();
                        if($(this).attr('checked'))
                            {
                                html = '<input type=\"text\" name=\"password\" value=\"'+value+'\" id=\"password\" />';
                                $('#password').after(html).remove();
                                }
                                else
                                {
                                 html = '<input type=\"password\" name=\"password\" value=\"'+value+'\" id=\"password\" />';
                                $('#password').after(html).remove();
                                 }
                            });
";
        $data['script'].='});';
        $data['script'].='function resetearPermiso()
            {
                $.ajax({
                    url:"' . site_url('usuarios/resetearPermisos/' . $id) . '",
                    success:function(data)
                    {
                        alert("Permisos Reseteados");
                    }
                });
            }';
        $data['script'].="function CambiarPassword()
            {
                $('#contra').show();
                $('cambioPass').val('1');
                $('#cmbPasswd').remove();
            }
            ";
        $data['script'].="function activarMenu(Nivel)
            {
                    if($('#Permiso'+Nivel).is(':checked'))
                    {
                      $.ajax({
                            url:'".site_url('usuarios/nvo_permisoUsuario')."/'+$('#Permiso'+Nivel).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
                                if(data.retorno==1)
                                    $('#divPermiso'+Nivel).show();
                            }
                     });
                   }
                   else
                   {
                        $.ajax({
                            url:'".site_url('usuarios/eliminarPermisos')."/'+$('#Permiso'+Nivel).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
                                if(data.retorno==1)
                                    $('#divPermiso'+Nivel).hide();
                            }
                     });
                  }
            }";
        $data['script'].="function activarPermiso(id)
            {
                    if($('#Submenu'+id).is(':checked'))
                    {
                      $.ajax({
                            url:'".site_url('usuarios/nvo_permisoUsuario')."/'+$('#Submenu'+id).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
//                                if(data.retorno==1)
//                                    $('#divPermiso'+id).show();
                            }
                     });
                   }
                   else
                   {
                        $.ajax({
                            url:'".site_url('usuarios/eliminarPermisos')."/'+$('#Submenu'+id).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
//                                if(data.retorno==1)
//                                    $('#divPermiso'+Nivel).hide();
                            }
                     });
                  }
            }";
        $data['script'].="</script>";
        $data['botones'] = '<a href="' . site_url('usuarios' . '/index/') . '" class="btn_nuevo" >Regresar</a>|<a href="' . site_url('usuarios/baja_usuario/' . $id) . '" class="btn_nuevo">Dar de Baja</a>';
        $super = array("1" => "sí", "0" => "no");
        $nivel = array("1" => "Consulta", "2" => "Edicion");
        $supervisores = $this->supervisores_model->addw_supervisores();
        $aJefeSupervisor=  $this->usuarios_model->addw_areas(FALSE);
        $data['supervisores'] = form_dropdown('supervisor', $supervisores, $usuario->idSupervisor);
        $data['jefeSup'] = form_dropdown('jefeSupervisor', $aJefeSupervisor, $usuario->idJefeSupervisor);
        $data['superUsuario'] = form_dropdown('SuperUsuario', $super, $usuario->SuperUsuario);
        $data['wms'] = form_dropdown('Wms', array("Sin Acceso","Consulta","Edicion"), $usuario->Wms);
        $data['usuarioActivo'] = '<div align="right"><span class="edicion"></span>Usuario: ' . $this->session->userdata('nombre') . '&nbsp;|&nbsp;<a href="' . site_url("sessions/logout") . '">Salir del Sistema</a></div>';
        $data['usuario'] = $usuario;
        $data['Nivel'] = form_dropdown('Nivel', $nivel, $usuario->Nivel);
        $qMenus = $this->usuarios_model->menus();
        $data['menus'] = '';
        $data['submenu'] = '';
        foreach($qMenus->result() as $rowdata){
            if($this->usuarios_model->tienepermiso($rowdata->Permiso, $id)){
              $data['menus'] .= form_checkbox('Permiso', $rowdata->Permiso, TRUE, 'id="Permiso' . $rowdata->Nivel . '" onclick="activarMenu(' . $rowdata->Nivel . ');"') . $rowdata->Modulo.'<br>';
              $qSubMenus = $this->usuarios_model->submenus($rowdata->Nivel);
              $data['submenu'] .= '<div id="divPermiso' . $rowdata->Nivel . '">'.$rowdata->Modulo."<br>";
            }else{
              $data['menus'] .= form_checkbox('Permiso', $rowdata->Permiso, FALSE, 'id="Permiso' . $rowdata->Nivel . '" onclick="activarMenu(' . $rowdata->Nivel . ');"') . $rowdata->Modulo.'<br>';
              $qSubMenus = $this->usuarios_model->submenus($rowdata->Nivel);
              $data['submenu'] .= '<div id="divPermiso' . $rowdata->Nivel . '" style="display:none">'.$rowdata->Modulo."<br>";
            }
            foreach ($qSubMenus->result() as $rowdata2){
                 if($this->usuarios_model->tienepermiso($rowdata2->Permiso, $id)){
                    $data['submenu'] .= form_checkbox('Permiso', $rowdata2->Permiso, TRUE, 'id="Submenu' . $rowdata2->id . '" onclick="activarPermiso(' . $rowdata2->id . ');"') . $rowdata2->Opcion . '<br>';
                 }else{
                     $data['submenu'] .= form_checkbox('Permiso', $rowdata2->Permiso, FALSE, 'id="Submenu' . $rowdata2->id . '" onclick="activarPermiso(' . $rowdata2->id . ');"') . $rowdata2->Opcion . '<br>';
                 }
              }
              $data['submenu'] .= '</div>';
            
        }
        $this->load->view('v_usuario_edicion1', $data);
    }
    public function perfil() {
        $id = $this->session->userdata("id");
        $this->load->model("usuarios_model");
        $this->load->model('supervisores_model');
        $query = $this->usuarios_model->get_usuario($id);
        $usuario = $query->row();
        //$this->load->helper('form');
        $this->load->library('table');
        $this->load->library('ferfunc');
        $data['img_dir'] = base_url() . $this->config->item('img_dir');
        $data['meta'] = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => 'Sistema Administrativo en linea'),
            array('name' => 'keywords', 'content' => 'facturacion, control, cobranza, almacen, produccion , contabilidad'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $data['css'] = array(link_tag(base_url() . "css/principal.css"));
        $data['css'][] = '<style>.ui-autocomplete {
                 max-height: 100px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
  }</style>';
        $data['titulo'] = "Edicion de Usuario";
        $data['subtitulo'] = $usuario->Nombre;
        $data['script'] = '<script type="text/javascript" src="' . $this->config->item('lib_jquery') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_ui') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_extend') . '"></script>';

        // Validacion 
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate_ext') . '"></script>';
        $data['script'].= '<script type="text/javascript" src="' . $this->config->item('lib_jquery_validate_es') . '"></script>';
        /////////////

        $data['script'].='<script>';
        $data['script'].='        $(document).ready(function() {';
        $data['script'].='              $( "#tabs" ).tabs();';
        $data['script'].="$('#mosPasswd').attr('checked', false);
                    $('#mosPasswd').click(function(){
                          value = $('#password').val();
                        if($(this).attr('checked'))
                            {
                                html = '<input type=\"text\" name=\"password\" value=\"'+value+'\" id=\"password\" />';
                                $('#password').after(html).remove();
                                }
                                else
                                {
                                 html = '<input type=\"password\" name=\"password\" value=\"'+value+'\" id=\"password\" />';
                                $('#password').after(html).remove();
                                 }
                            });
";
        $data['script'].='});';
        $data['script'].='function resetearPermiso()
            {
                $.ajax({
                    url:"' . site_url('usuarios/resetearPermisos/' . $id) . '",
                    success:function(data)
                    {
                        alert("Permisos Reseteados");
                    }
                });
            }';
        $data['script'].="function CambiarPassword()
            {
                $('#contra').show();
                $('cambioPass').val('1');
                $('#cmbPasswd').remove();
            }
            ";
        $data['script'].="function activarMenu(Nivel)
            {
                    if($('#Permiso'+Nivel).is(':checked'))
                    {
                      $.ajax({
                            url:'".site_url('usuarios/nvo_permisoUsuario')."/'+$('#Permiso'+Nivel).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
                                if(data.retorno==1)
                                    $('#divPermiso'+Nivel).show();
                            }
                     });
                   }
                   else
                   {
                        $.ajax({
                            url:'".site_url('usuarios/eliminarPermisos')."/'+$('#Permiso'+Nivel).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
                                if(data.retorno==1)
                                    $('#divPermiso'+Nivel).hide();
                            }
                     });
                  }
            }";
        $data['script'].="function activarPermiso(id)
            {
                    if($('#Submenu'+id).is(':checked'))
                    {
                      $.ajax({
                            url:'".site_url('usuarios/nvo_permisoUsuario')."/'+$('#Submenu'+id).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
//                                if(data.retorno==1)
//                                    $('#divPermiso'+id).show();
                            }
                     });
                   }
                   else
                   {
                        $.ajax({
                            url:'".site_url('usuarios/eliminarPermisos')."/'+$('#Submenu'+id).val()+'/".$id."',
                            dataType:'json',
                            success:function(data)
                            {
//                                if(data.retorno==1)
//                                    $('#divPermiso'+Nivel).hide();
                            }
                     });
                  }
            }";
        $data['script'].="</script>";
        $data['botones'] = '<a href="' . site_url('usuarios' . '/index/') . '" class="btn_nuevo" >Regresar</a>|<a href="' . site_url('usuarios/baja_usuario/' . $id) . '" class="btn_nuevo">Dar de Baja</a>';
        $super = array("1" => "sí", "0" => "no");
        $nivel = array("1" => "Consulta", "2" => "Edicion");
        $supervisores = $this->supervisores_model->addw_supervisores();
        $aJefeSupervisor=  $this->usuarios_model->addw_areas(FALSE);
        $data['supervisores'] = form_dropdown('supervisor', $supervisores, $usuario->idSupervisor);
        $data['jefeSup'] = form_dropdown('jefeSupervisor', $aJefeSupervisor, $usuario->idJefeSupervisor);
        $data['superUsuario'] = form_dropdown('SuperUsuario', $super, $usuario->SuperUsuario);
        $data['wms'] = form_dropdown('Wms', array("Sin Acceso","Consulta","Edicion"), $usuario->Wms);
        $data['usuarioActivo'] = '<div align="right"><span class="edicion"></span>Usuario: ' . $this->session->userdata('nombre') . '&nbsp;|&nbsp;<a href="' . site_url("sessions/logout") . '">Salir del Sistema</a></div>';
        $data['usuario'] = $usuario;
        $data['Nivel'] = form_dropdown('Nivel', $nivel, $usuario->Nivel);
        $qMenus = $this->usuarios_model->menus();
        $data['menus'] = '';
        $data['submenu'] = '';
        foreach($qMenus->result() as $rowdata){
            if($this->usuarios_model->tienepermiso($rowdata->Permiso, $id)){
              $data['menus'] .= form_checkbox('Permiso', $rowdata->Permiso, TRUE, 'id="Permiso' . $rowdata->Nivel . '" onclick="activarMenu(' . $rowdata->Nivel . ');"') . $rowdata->Modulo.'<br>';
              $qSubMenus = $this->usuarios_model->submenus($rowdata->Nivel);
              $data['submenu'] .= '<div id="divPermiso' . $rowdata->Nivel . '">'.$rowdata->Modulo."<br>";
            }else{
              $data['menus'] .= form_checkbox('Permiso', $rowdata->Permiso, FALSE, 'id="Permiso' . $rowdata->Nivel . '" onclick="activarMenu(' . $rowdata->Nivel . ');"') . $rowdata->Modulo.'<br>';
              $qSubMenus = $this->usuarios_model->submenus($rowdata->Nivel);
              $data['submenu'] .= '<div id="divPermiso' . $rowdata->Nivel . '" style="display:none">'.$rowdata->Modulo."<br>";
            }
            foreach ($qSubMenus->result() as $rowdata2){
                 if($this->usuarios_model->tienepermiso($rowdata2->Permiso, $id)){
                    $data['submenu'] .= form_checkbox('Permiso', $rowdata2->Permiso, TRUE, 'id="Submenu' . $rowdata2->id . '" onclick="activarPermiso(' . $rowdata2->id . ');"') . $rowdata2->Opcion . '<br>';
                 }else{
                     $data['submenu'] .= form_checkbox('Permiso', $rowdata2->Permiso, FALSE, 'id="Submenu' . $rowdata2->id . '" onclick="activarPermiso(' . $rowdata2->id . ');"') . $rowdata2->Opcion . '<br>';
                 }
              }
              $data['submenu'] .= '</div>';
            
        }
        $this->load->view('v_perfil', $data);
    }

    public function actualiza_usuario_db() {
        $id = $this->input->post('idUsuario');
        // Funcion para guardar cambios en el registro
        $data = array(
            "Nombre" => $this->input->post('usuario'),
            "usuario" => $this->input->post('login'),
            "Email" => $this->input->post('email'),
            "SuperUsuario" => $this->input->post('SuperUsuario'),
            "Wms" => $this->input->post('Wms'),
            "Nivel" => $this->input->post('Nivel'),
            "Domicilio" => $this->input->post('direccion'),
            "RFC" => $this->input->post('rfc'),
            "Telefonos" => $this->input->post('telefono'),
            "idSupervisor" => $this->input->post('supervisor'),
            "idJefeSupervisor" => $this->input->post('jefeSupervisor')
        );
        $cambioPass = $this->input->post('password');
        if ($cambioPass != "")
            $data['Password'] = sha1($this->input->post('password'));
        $this->load->model("usuarios_model");
        $retorno = $this->usuarios_model->datos_usuarios_update($data, $this->input->post("idUsuario"));
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Location:' . site_url('usuarios/cambios_usuario/' . $id . '#tab-1'));
    }
    public function actualiza_perfil_db() {
        $id = $this->input->post('idUsuario');
        // Funcion para guardar cambios en el registro
        $data = array(
            
            "Domicilio" => $this->input->post('direccion'),
            "RFC" => $this->input->post('rfc'),
            "Telefonos" => $this->input->post('telefono'),
        );
        $cambioPass = $this->input->post('password');
        if ($cambioPass != "")
            $data['Password'] = sha1($this->input->post('password'));
        $this->load->model("usuarios_model");
        $retorno = $this->usuarios_model->datos_usuarios_update($data, $this->input->post("idUsuario"));
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Location:' . site_url('usuarios/perfil/'));
    }

    public function baja_usuario($id) {
        // funcion de validacion de no repetidos.m
        // salida json
        $this->load->model("usuarios_model");
        $retorno = $this->usuarios_model->baja_usuario($id);
        // refrescar pantalla
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 11 May 1972 05:00:00 GMT');
        header('Location:' . site_url('usuarios/index/'));
    }

    public function nvo_permisoUsuario($permiso,$idUsuario) {
        $this->load->model('usuarios_model');
            $data = array(
                'idUsuario' => $idUsuario,
                'Perfil' => $permiso
            );
            $retorno = $this->usuarios_model->setPermiso($data);
        echo json_encode($retorno);
    }

    public function listaPermisos($id) {
        $this->load->model('usuarios_model');
        $opciones = $this->usuarios_model->addw_permisos(FALSE);
        echo json_encode($opciones, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function permisosUsuario($id) {
        $this->load->model('usuarios_model');
        $this->load->library('table');
        $permisos = $this->usuarios_model->addw_permisos_usuario($id);
        $retorno = '<table width="100%" border="0" cellspacing="5" cellpadding="5">';
        //$this->table->set_template(array('table_open' => '<table width="100%" border="0" cellspacing="0" cellpadding="0">'));
        foreach ($permisos as $key => $perfil) {
            $retorno.='<tr>
                    <td>' . form_checkbox(array(
                        'value' => $perfil->id,
                        'name' => 'permisosUsuario[]',
                        'id' => 'permisoUsuario' . $key
                    )) . " " . $perfil->Perfil . '</td></tr>';
        }
        $retorno.='</table>';
        echo $retorno;
    }

    public function resetearPermisos($id) {
        $this->load->model('usuarios_model');
        $this->usuarios_model->restart_permisos($id);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Location:' . site_url('usuarios/cambios_usuario/' . $id . '#tab-2'));
    }

    public function eliminarPermisos($permiso,$idUsuario) {
        $this->load->model('usuarios_model');
            $data = array(
                'idUsuario' => $idUsuario,
                'Perfil' => $permiso
            );
            $retorno = $this->usuarios_model->unsetPermiso($data);
        echo json_encode($retorno);
    }

    public function activar_usuario($id) {
        $data = array(
            "Estatus" => 1
        );
        $this->load->model("usuarios_model");
        $retorno = $this->usuarios_model->datos_usuarios_update($data, $id);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Location:' . site_url('usuarios/cambios_usuario/' . $id . '#tab-1'));
    }

    

}

?>
