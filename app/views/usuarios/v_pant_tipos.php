<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<?php $this->load->view('layouts/header') ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Usuarios
      <small>Tipos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Principal</a></li>
      <li><a href="#">Catalogos</a></li>
      <li class="active">Tipos Usuarios</li>
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
                    <a href="#modal-agregar-cat" class="btn btn-success" role="button" data-toggle="modal" ><span class="glyphicon glyphicon-plus"></span> Nuevo Tipo Usuario</a>
                </div>
                
                <div class="col-md-12 column">                    
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th class="col-md-1">
                                    Acción
                                </th>
                                
                                <th >
                                   Tipo
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($qTipos)) {
                                if ($qTipos->num_rows() > 0) {
                                    foreach ($qTipos->result() as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="#modal-editar-cat" onclick="uf_modificar_modalidad(<?= $row->id ?>)" class="btn btn-success btn-xs" role="button" data-toggle="modal">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                                <a class="btn btn-danger btn-xs"  title="Eliminar" onclick="eliminar(<?= $row->id ?>)"> <span class="glyphicon glyphicon-remove" ></span>
                                                </a>
                                            </td>
                                             
                                            <td>
                                                <?php echo $row->Tipo; ?>
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

          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col-xs-12 -->
    </div><!-- /.row -->
  </section><!-- /.content -->

  <!-- Dialogo Nuevo Tipo Usuario -->
  <div class="modal fade" id="modal-agregar-cat" role="dialog" aria-labelledby="modal-agregar-cat_myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      ×
                  </button>
                  <h4 class="modal-titlsamplee" id="modal-nuevo_documentomyModalLabel">Tipo Usuario - Nuevo</h4>
              </div>
              <form action="<?php echo site_url("tipos_usuarios/agregar"); ?>" method="post" name="forma1" target="_self" id="forma1" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      
                     
                      
                      <div class="form-group">
                          <label for="Nombre" class="col-sm-3 control-label">Tipo</label>   
                          <div class="col-sm-9"> 
                              <input type="text" name="Tipo" id="Tipo" required value="" class="form-control" >
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

  <!-- Dialogo Editar Tipo Usuario -->
  <div class="modal fade" id="modal-editar-cat" role="dialog" aria-labelledby="modal-agregar-cat_myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      ×
                  </button>
                  <h4 class="modal-titlsamplee" id="modal-nuevo_documentomyModalLabel">Tipo Usuario - Editar</h4>
              </div>
              <form action="<?php echo site_url("tipos_usuarios/editar") ?>" method="post" name="forma1" target="_self" id="forma1" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      
                     
                      
                      <div class="form-group">
                          <label for="Nombre" class="col-sm-3 control-label">Tipo</label>   
                          <div class="col-sm-9"> 
                              <input type="text" name="Tipo_mod" id="Tipo_mod" required value="" class="form-control" >
                          </div>
                                   
                      </div> 
                       
                      
                  </div>
                  <div class="modal-footer">
                      <input type="hidden" value="" id="idCatalogo" name="idCatalogo">
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


   <script>

    function alert(titulo, mensaje, tipo){
      swal(
        titulo,
        mensaje,
        tipo
      )
    }

    function uf_modificar_modalidad(id) {

          $("#idCatalogo").val(id);
         
          $.ajax({
              url: "<?php echo site_url('usuarios/datos_tipo') ?>/" + id,
              dataType: 'json',
              success: function (data, textStatus, jqXHR) {
                  $("#Tipo_mod").val(data['Tipo']);
                  
                  
              }
          });
    } 

    function eliminar(id){
      Swal({
        title: '¿Deseas eliminar el Registro?',
        //text: 'You will not be able to recover this imaginary file!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminarlo!',
        cancelButtonText: 'No'
      }).then((result) => {

          $.ajax({
              url: "<?php echo site_url('tipos_usuarios/eliminar_tipo') ?>/" + id,
              dataType: 'json',
              success: function (data, textStatus, jqXHR) {
                  console.log(data)
                  //if (result.value) { //Default
                  if (result.value) {
                    Swal(
                      'Eliminado!',
                      'El registro ha sido eliminado.',
                      'success'
                    )
                    location.reload();
                    // For more information about handling dismissals please visit
                    // https://sweetalert2.github.io/#handling-dismissals
                  } 
              }
          });

          
      })
    }
    
  </script>

<?php $this->load->view('layouts/footer') ?>
    
