<?php $this->load->view('admin/layouts/header') ?>
  <!-- Content Header (Page header) -->
  <section class="content-header bg-ligth">
    
    <!-- <ol class="breadcrumb">
      <li class="container active"><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Principal</a></li>
     
    </ol> -->
  </section>
  
  <section class="container mb-5">
    <h3 class="font-weigth-bolder mt-5 mb-1 text-blue">Categorias</h3>

    <div class="row">
      <!-- Button trigger modal -->
      

      <div class="col-md-12 mb-">
        
        <?php $correcto = $this->session->flashdata('correcto') ?>
        <?php if ($correcto) :?>
            <?= $correcto ?>
        <?php endif; ?>
      </div>
      <div class="col-md-12">
          <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus" aria-hidden="true"></i> Nueva Categoria
          </button>
      </div>

      <div class="col-md-12 mb-5">
        <table class="table table-bordered table-condense" id="myTable">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Imagen</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categorias->result() as $categoria)  : ?>
              <tr>
                <td><?= $categoria->nombre ?></td>
                <td><?= $categoria->descripcion ?></td>
                <td>
                  <?php if($categoria->imagen): ?>
                    <img height="50" src="<?= base_url('uploads/') .'/'. $categoria->imagen ?>" />
                  <?php else: ?>
                     <img height="50" src="<?= base_url('uploads/') .'/nodisponible.png' ?>" />
                  <?php endif; ?>
                </td>
                <td>
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" onclick="get_datos_categoria(<?=  $categoria->id ?>)">
                    <i class="fa fa-edit" aria-hidden="true"></i> 
                  </button>
                  <button onclick="eliminar_categoria( <?=  $categoria->id ?>)" class="btn btn-danger btn-sm" >
                    <i class="fa fa-trash" aria-hidden="true"></i> 
                  </button>
                </td>
              </tr>
            
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>      
  </section><!-- /.content -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo site_url("productos/agregar_categoria") ?>">
          <div class="modal-body">

            <div class="form-group">
              <label for="Nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
            </div>
          </div>
          <div class="form-group px-3 pb-3">
            <label for="exampleFormControlFile1">Imagen</label>
            <input type="file" class="form-control-file" id="userfile" name="userfile">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        
        
        

      </div>
    </div>
  </div>


  <!-- Modal Edit-->
  <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo site_url("productos/editar_categoria
        ") ?>">
          <div class="modal-body">

            <div class="form-group">
              <label for="Nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre_mod" id="nombre_mod" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" name="descripcion_mod" id="descripcion_mod" rows="3"></textarea>
            </div>
          </div>
          <div class="form-group px-3 pb-3">
            <label for="exampleFormControlFile1">Cambiar Imagen</label>
            <input type="file" class="form-control-file" id="userfile" name="userfile">
          </div>
          <div class="modal-footer">
            <input type="hidden" name="idCategoria_mod" id="idCategoria_mod">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        
        
        

      </div>
    </div>
  </div>

    <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar Categoria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo site_url("productos/editar_categoria
          ") ?>">
            <div class="modal-body">

              <div class="form-group">
                <label for="Nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre_mod" id="nombre_mod" placeholder="Nombre">
              </div>
              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion_mod" id="descripcion_mod" rows="3"></textarea>
              </div>
            </div>
            <div class="form-group px-3 pb-3">
              <label for="exampleFormControlFile1">Cambiar Imagen</label>
              <input type="file" class="form-control-file" id="userfile" name="userfile">
            </div>
            <div class="modal-footer">
              <input type="hidden" name="idCategoria" id="idCategoria">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
          
          
          

        </div>
      </div>
    </div>

<script type="text/javascript">
  function get_datos_categoria(idCategoria) {
    
    $.post( "<?= base_url('productos/datos_categoria')?>", { idCategoria: idCategoria }, function( data ) {
      $("#nombre_mod").val( data.nombre ); 
      $("#descripcion_mod").val( data.descripcion ); 
      $("#idCategoria_mod").val( data.id ); 
      console.log(data)
      
    }, "json");
  }

  function eliminar_categoria(idCategoria){
    swal({
      title: "Deseas Eliminar Categoria?",
      
      buttons: true,
      dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.post( "<?= base_url('productos/eliminar_categoria')?>", { idCategoria: idCategoria }, function( data ) {
            
            if(data){
              swal({
                title:"Categoria Eliminada!",
                text: "Categoria Eliminada con Exito",
                icon: "success",
                button: "Cerrar",
              });
              location.reload();
            }else{
              swal({
                title: "Error!",
                text: "No se ha podido eliminar la categoria!",
                icon: "danger",
                button: "Cerrar",
              });
            }

            
          });
          
        } 
      })


  }

</script>
  
  

<?php $this->load->view('admin/layouts/footer') ?>