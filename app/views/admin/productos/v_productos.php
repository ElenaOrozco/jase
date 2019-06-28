<?php $this->load->view('admin/layouts/header') ?>
  <!-- Content Header (Page header) -->
  
  
  <section class="container mb-5">
    <h3 class="font-weigth-bolder mt-5 mb-1 text-blue">Productos</h3>
  

    <div class="row">
      <!-- Button trigger modal -->
      

      <div class="col-md-12 mb-3">
        
        <?php $correcto = $this->session->flashdata('correcto') ?>
        <?php if ($correcto) :?>
            <?= $correcto ?>
        <?php endif; ?>
      </div>
      <div class="col-md-12">
          <!-- <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Producto
          </button> -->
          <a href="<?= base_url('productos/nuevo_producto')?>" class="btn btn-primary my-3">
            <i class="fa fa-plus" aria-hidden="true"></i> Nuevo Producto
          </a>
      </div>

      <div class="col-md-12  table-responsive mb-5">
        <table class="table table-bordered table-condensed"  id="myTableLg" width="100%">
        <thead>
          <tr>
            <th>Acciones</th>
            <th>Visible</th>
            <th>Disponible</th>
            <th>En Promoción</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoria</th>
            
            <th>PDF</th>
            
           
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos->result() as $producto)  : ?>
            <tr>
              
              <td>
                <a href="<?= base_url('productos/editar_producto') .'/' . $producto->id ?>" class="btn btn-success btn-sm">
                  <i class="fa fa-edit" aria-hidden="true"></i> 
                </a>
                
                <button onclick="eliminar_producto(<?= $producto->id ?>)" class="btn btn-danger btn-sm" >
                  <i class="fa fa-trash" aria-hidden="true"></i> 
                </button>
              </td>
              <td><?= ($producto->visible)? 'Si': 'No'?></td>
              <td><?= ($producto->disponible)? 'Si': 'No'?></td>
              <td><?= ($producto->promocion)? 'Si': 'No'?></td>
              <td>
                <?php if($producto->imagen): ?>
                  <img height="50" src="<?= base_url('uploads') .'/'. $producto->imagen ?>" />
                <?php else: ?>
                   <img height="50" src="<?= base_url('uploads/') .'/nodisponible.png' ?>" />
                <?php endif; ?>
              </td>
              <td><?= $producto->nombre ?></td>
              <td><?= $producto->categoria ?></td>
              
              <td><?= $producto->pdf ?></td>
              
            </tr>
          
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
      
      

      
       
          
        
      </div>
   

    
     

          
         
  </section><!-- /.content -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo site_url("productos/agregar_producto") ?>">
          <div class="modal-body row">
            <div class="col-md-6">
              
              <div class="form-group">
                <label for="Nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
              </div>
              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="2"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Categoria</label>
                <select class="form-control" id="idCategoria" name="idCategoria" value="">
                  <option>Selecciona una opción</option>
                  <?php foreach ($categorias->result() as $item): ?>
                    <option value="<?= $item->id ?>"><?= $item->nombre ?></option>
                   
                  <?php endforeach; ?>
                  
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">SubCategoria</label>
                <select class="form-control" id="idSubCategoria" name="idSubCategoria" value="">
                  <option>Selecciona una opción</option>
                  <?php foreach ($subcategorias->result() as $item): ?>
                    <option value="<?= $item->id ?>"><?= $item->nombre ?></option>
                   
                  <?php endforeach; ?>
                  
                </select>
              </div>
              <div class="form-group">
                <label for="Nombre">Potencia</label>
                <input type="text" class="form-control" name="potencia" id="potencia" placeholder="Nombre">
              </div>
              
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="Nombre">Voltaje Entrada</label>
                <input type="text" class="form-control" name="voltaje_entrada" id="voltaje_entrada" placeholder="Voltaje Entrada">
              </div>
              <div class="form-group">
                <label for="Nombre">Voltaje Salida</label>
                <input type="text" class="form-control" name="voltaje_salida" id="voltaje_salida" placeholder="Voltaje Salida">
              </div>
              <div class="form-group">
                <label for="Nombre">Corriente Salida</label>
                <input type="text" class="form-control" name="corriente_salida" id="corriente_salida" placeholder="Corriente Salida">
              </div>
              <div class="form-group">
                <label for="Nombre">Atenuación</label>
                <input type="text" class="form-control" name="atenuacion" id="atenuacion" placeholder="Atenuación">
              </div>
              <div class="form-group">
                <label for="Nombre">PDF</label>
                <input type="text" class="form-control" name="pdf" id="pdf" placeholder="PDF">
              </div>
              <div class="form-group">
                <label for="exampleFormControlFile1">Imagen</label>
                <input type="file" class="form-control-file" id="userfile" name="userfile" required>
              </div>
                
            </div>

            
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
              <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
            </div>
          </div>
          <div class="form-group px-3 pb-3">
            <label for="exampleFormControlFile1">Cambiar Imagen</label>
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
  <script type="text/javascript">
    function eliminar_producto(idProducto){
    swal({
      title: "Deseas Eliminar Producto?",
      
      buttons: true,
      dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.post( "<?= base_url('productos/eliminar_producto')?>", { idProducto: idProducto }, function( data ) {
            
            if(data){
              swal({
                title:"Producto Eliminado!",
                text: "Producto Eliminado con Exito",
                icon: "success",
                button: "Cerrar",
              });
              location.reload();
            }else{
              swal({
                title: "Error!",
                text: "No se ha podido eliminar el producto!",
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