<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<?php $this->load->view('layouts/header') ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Usuario
      <small>Edición</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Principal</a></li>
      <li><a href="<?php echo site_url(); ?>control_usuarios">Usuarios</a></li>
      <li class="active">Usuarios</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    
                    <div class="row">  

                      <!-- Columna Principal -->
                      <div class="column col-md-6 col-lg-7">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="panel-title">Permisos</h3>
                            
                          </div><!-- /.box-header -->
                          
                          <div class="box-body">
                          
                            <?php echo $menu;?>
                          </div>
                        </div>
                            

                        
                
        
                      </div>
                      <!-- Fin columna Principal -->


                      <!-- Columna chica -->
                      <div class="column col-md-6 col-lg-5">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="panel-title">Datos de Usuario</h3>
                            <div class="box-tools pull-right">
                              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-modificar-cat"><i class="fa fa-pencil"></i> Editar</button>
                            </div><!-- /.box-tools -->
                          </div><!-- /.box-header -->
                          <form class="form-horizontal">
                            <div class="box-body">
                              <dl class="row">
                                <dt class="col-sm-3 text-primary">Nombre</dt>
                                <dd class="col-sm-9 text-primary"><?= $qUsuario['Nombre'] ?></dd>

                                <dt class="col-sm-3 text-primary">Usuario</dt>
                                <dd class="col-sm-9 text-primary"><?= $qUsuario['Usuario'] ?></dd>

                                <dt class="col-sm-3 text-primary">Tipo</dt>
                                <dd class="col-sm-9 text-primary"><?= $addw_tipos[$qUsuario['idTipo']] ?></dd>

                                <?php if($qUsuario['admin']== 1): ?>

                                  <dt class="col-sm-3 text-primary">Administrador</dt>
                                  <dd class="col-sm-9 text-primary">Si</dd>
                                <?php endif; ?>

                               
                              </dl>
                              
                              
                            </div><!-- /.box-body -->
                          </form>
                        </div><!-- /.box -->
                      </div> <!-- /.Columna chica --> 
                    </div> <!-- row -->
                 

  </section><!-- /.content -->
  
    <!-- Dialogo Nuevo Usuario -->
        <div class="modal fade" id="modal-modificar-cat" role="dialog" aria-labelledby="modal-agregar-cat_myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-titlsamplee" id="modal-nuevo_documentomyModalLabel">Usuario - Editar</h4>
                    </div>
                    <form action="<?php echo site_url("control_usuarios/editar_cat") . '/' .$qUsuario['id']; ?>" method="post" name="forma1" target="_self" id="forma1" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" onSubmit="return valida_Datos_Usuario();">
                        <div class="modal-body">
                            
                           
                            
                            <div class="form-group">
                                        <label for="Nombre" class="col-sm-3 control-label">Nombre</label>   
                                         <div class="col-sm-9"> 
                                            <input type="text" name="Nombre" id="Nombre" required value="<?= $qUsuario['Nombre'] ?>" class="form-control" >
                                         </div>
                                         
                            </div> 
                            
                            <div class="form-group">
                                        <label for="Usuario" class="col-sm-3 control-label">Usuario</label> 
                                         <div class="col-sm-9"> 
                                            <input type="text" name="txtUsuario" id="txtUsuario" required value="<?= $qUsuario['Usuario'] ?>" class="form-control" >
                                         </div>
                                         
                            </div> 
                            
                             <div class="form-group">
                                <label for="Password" class="col-sm-3 control-label">Password</label>   
                                 <div class="col-sm-9"> 
                                    <input type="password" name="txtPassword" id="txtPassword" required value="-1" class="form-control" >
                                 </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Grupo</label>
                                <div class="col-sm-9"> 
                                    <select class="form-control select2" style="width: 100%;" id='idTipo' name="idTipo">
                                      
                                      <?php foreach ($qTipos->result() as $row) :?>
                                         <option value="<?= $row->id?>" <?php echo ( $qUsuario['idTipo'] == $row->id )? 'selected': '' ?>><?= $row->Tipo ?></option>
                                      <?php endforeach ; ?>
                                      
                                      
                                    </select>
                                </div>
                            </div><!-- /.form-group -->
                           
                            <div class="form-group">
                                <label for="Permisos" class="col-sm-3 control-label">Administrador</label>   
                                
                                
                                <div class="col-sm-9">
                                    <div class="col-sm-12">
                                        <label class="col-md-3 checkbox-inline">
                                            <input type="checkbox"   name="txtAdministrador" id="txtAdministrador"  value="<?php echo ( $qUsuario['admin'] == 1 )? '1': '0' ?>" onchange="alta_permiso(this)" <?php echo ( $qUsuario['admin'] == 1 )? 'checked': '' ?>>
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
  




<?php $this->load->view('layouts/footer') ?>
<script>
    (function() {
         $(".myFormulario").on('submit', function(evt){
          evt.preventDefault();  

          var form = $( this ).serialize();
          
      
          $.post( "<?php echo site_url('control_usuarios/guardar_permisos'); ?>/",
            form,
            function( data ) {
                console.log(data)
                Swal(
                      'Permisos Actualizados!',
                      '',
                      'success'
                    )
                
               
            });
        });

       

      })();
        

    
    
    function guardar(id){

      var form = $( "#form" + id ).serialize();
          
      
      $.post( "<?php echo site_url('control_usuarios/guardar_permisos'); ?>/",
        form,
        function( data ) {
            console.log(data)
            
           
        });
      

    }


    function marcar(obj, id){
          if ( obj.checked) {
            
            
            $(".radioTodo"+id).attr('checked', true)
            
          }else{
           
           
            $(".radioTodo"+id).attr('checked', false)
          }
          


    }


    function alta_permiso(element){
      if(element.checked){
        $("#txtAdministrador").val(1)
      }else{
        $("#txtAdministrador").val(0)
      }
    }

    
  </script>
    
