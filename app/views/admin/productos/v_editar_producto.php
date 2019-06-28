<?php $this->load->view('admin/layouts/header') ?>
  <!-- Content Header (Page header) -->
  <div class="container mt-3">
    <div class="card">
      <div class="card-header">
        Editar Producto
      </div>
      <div class="card-body">
        <div class="col-md-12 mb-3">
        
          <?php $correcto = $this->session->flashdata('correcto') ?>
          <?php if ($correcto) :?>
              <?= $correcto ?>
          <?php endif; ?>
        </div>
        <form role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo site_url("productos/editar_producto/0") ?>">
              
              <div class="modal-body row">
                <div class="col-offset-md-3 col-md-6">
                  
                  <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?= $producto['nombre'] ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="20" required><?= $producto['descripcion'] ?></textarea>
                  </div>
                  
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Categoria</label>
                    <select class="form-control" id="idCategoria" name="idCategoria" value="">
                      <option>Selecciona una opción</option>
                      <?php foreach ($categorias->result() as $item): ?>
                        <option value="<?= $item->id ?>" <?php echo ( $producto['idCategoria'] == $item->id)? 'selected': '' ?>><?= $item->nombre ?></option>
                       
                      <?php endforeach; ?>
                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="Nombre">Cambiar PDF</label>
                    <input type="file" class="form-control-file" id="pdf" name="pdf">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlFile1">Cambiar Imagen</label>
                    <input type="file" class="form-control-file" id="userfile" name="userfile">
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="disponible" id="disponible" <?= ( $producto['disponible'] == 1)? 'checked': '' ?>>
                    <label class="form-check-label" for="defaultCheck1">
                      Producto Disponible
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox"  value="" id="promocion" name="promocion" <?= ( $producto['promocion'] == 1)? 'checked': '' ?>>
                    <label class="form-check-label" for="defaultCheck2">
                      Producto en promoción
                    </label>
                  </div> 

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="visible" name="visible" <?= ( $producto['visible'] == 0)? 'checked': '' ?>>
                    <label class="form-check-label" for="defaultCheck2">
                      Ocultar
                    </label>
                  </div> 


                    
                </div>

                
              </div>
              
              <div class="modal-footer">
                <input type="hidden" id="idProducto" name="idProducto" value="<?= $producto['id'] ?>">
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
        </form>
      </div>
    </div>
  </div>
  
  
  
    




<?php $this->load->view('admin/layouts/footer') ?>