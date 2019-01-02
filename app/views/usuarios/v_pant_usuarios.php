<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<?php $this->load->view('layouts/header') ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Usuarios
      <small>Listado</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Principal</a></li>
      <li><a href="#">Catalogos</a></li>
      <li class="active">Usuarios</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        

        <div class="box">
          <div class="box-header">
            <h3 class="box-title"></h3>
          </div><!-- /.box-header -->
          <div class="box-body">
                <div class="col-md-12" style="margin-bottom: 20px">
                    <a href="#modal-agregar-cat" class="btn btn-primary" role="button" data-toggle="modal" ><span class="glyphicon glyphicon-plus"></span> Nuevo Usuario</a>
                </div>
                
                <div class="col-md-12 column">                    
                    <table class="table table-striped table-bordered table-hover small" id="tabla_scroll">
                        <thead>
                            <tr>
                                <th class="col-md-1">
                                    Acción
                                </th>
                                <th >
                                   Nombre
                                </th>
                                <th >
                                   Usuario
                                </th>
                                <th >
                                   Tipo
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($qListado)) {
                                if ($qListado->num_rows() > 0) {
                                    foreach ($qListado->result() as $rSolicitud) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo site_url("control_usuarios/cambios/" . $rSolicitud->id); ?>" class="btn btn-success btn-xs" title=""  data-toggle="modal"  role="button" ><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;
                                                <a class="btn btn-danger btn-xs del_documento" href="<?php echo site_url("control_usuarios/eliminar_cat/" . $rSolicitud->id); ?>" title="Eliminar Solicitud" onclick="return confirm('¿Confirma eliminar Registro?');" target="_self"><span class="glyphicon glyphicon-remove" ></span></a>
                                            </td>
                                            <td>
                                                <?php echo $rSolicitud->Nombre; ?>
                                            </td>
                                            <td>
                                                <?php echo $rSolicitud->Usuario; ?>
                                            </td> 
                                            <td>
                                                <?php echo $rSolicitud->Tipo; ?>
                                            </td>  
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        
        
          <!-- Dialogo Nuevo Usuario -->
        <div class="modal fade" id="modal-agregar-cat" role="dialog" aria-labelledby="modal-agregar-cat_myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-titlsamplee" id="modal-nuevo_documentomyModalLabel">Usuario - Nuevo</h4>
                    </div>
                    <form action="<?php echo site_url("control_usuarios/agregar_cat"); ?>" method="post" name="forma1" target="_self" id="forma1" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" onSubmit="return valida_Datos_Usuario();">
                        <div class="modal-body">
                            
                           
                            
                            <div class="form-group">
                                        <label for="Nombre" class="col-sm-3 control-label">Nombre</label>   
                                         <div class="col-sm-9"> 
                                            <input type="text" name="Nombre" id="Nombre" required value="" class="form-control" >
                                         </div>
                                         
                            </div> 
                            
                            <div class="form-group">
                                        <label for="Usuario" class="col-sm-3 control-label">Usuario</label> 
                                         <div class="col-sm-9"> 
                                            <input type="text" name="txtUsuario" id="txtUsuario" required value="" class="form-control" >
                                         </div>
                                         
                            </div> 
                            
                             <div class="form-group">
                                <label for="Password" class="col-sm-3 control-label">Password</label>   
                                 <div class="col-sm-9"> 
                                    <input type="password" name="txtPassword" id="txtPassword" required value="" class="form-control" >
                                 </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Grupo</label>
                                <div class="col-sm-9"> 
                                    <select class="form-control select2" style="width: 100%;" id='idTipo' name="idTipo">
                                      
                                      <?php foreach ($qTipos->result() as $row) :?>
                                         <option value="<?= $row->id?>" <?php echo ($row->id ==1)? 'selected': '' ?>><?= $row->Tipo ?></option>
                                      <?php endforeach ; ?>
                                      
                                      
                                    </select>
                                </div>
                            </div><!-- /.form-group -->
                           
                            <div class="form-group">
                                <label for="Permisos" class="col-sm-3 control-label">Administrador</label>   
                                
                                
                                <div class="col-sm-9">
                                    <div class="col-sm-12">
                                        <label class="col-md-3 checkbox-inline">
                                            <input type="checkbox"   name="txtAdministrador" id="txtAdministrador"  value="1" onchange="alta_permiso(this)">
                                        </label>
                                        
                                    </div>
                                   
                                </div>
                                
                            </div>
                            
                            
                            
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                Guardar
                            </button>                       
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancelar
                            </button>   
                           
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
         
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->

<?php $this->load->view('layouts/footer') ?>
    
