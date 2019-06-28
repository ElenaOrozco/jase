<?php $this->load->view('layouts/header'); ?>
<section class="products-list">
	<div class="container">
		<div class="row">
			
		</div>
		<div class="row py-md-5">
		
			<aside class="col-md-3 p-3 bg-white h-100 ">
				<h3 class="h4 text-uppercase text-blue-dark">Categorías</h3>
				<hr class="mt-0">
				<ul class="nav flex-column">
				<?php foreach ($categorias->result() as $item): ?>
					<li class="nav-item">
				    	<a class="nav-link active py-1" href="<?= base_url('productos/listado_categoria') .'/' . $item->id ?>">
				    		<span class=""><?= $item->nombre ?></span>
				    	</a>
				  	</li>
				<?php endforeach; ?>
				  
				</ul>	
			</aside>
			<div class="col-md-9 pt-0 pb-3 pr-3">
				<form id="form-search" method="post" action="<?= base_url('productos/buscar_productos') ?>">
				  <div class="form-row align-items-center pb-3">
				    
				    <div class="col-sm-12 my-1">
				      <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
				      <div class="input-group">
				        
				        <input id="input_search" name="input_search" type="text" class="form-control form-control-lg border-blue-dark" id="inlineFormInputGroupUsername" placeholder="¿Qué estás buscando?">
				        <div class="input-group-prepend">
				          <div class="input-group-text border-blue-dark  bg-blue-dark text-white"><i class="fas fa-search"></i></div>
				        </div>
				      </div>
				    </div>
				    
				    
				  </div>
				</form>		
				<?php if(isset($categoria['nombre'])): ?>
				<h5 class="font-weight-bolder text-blue pb-3"><?= $categoria['nombre'] ?></h5>
				<?php endif; ?>
				<div class="row">
					<?php if(isset($results)): ?>
	                    <?php foreach ($results->result() as $item) { ?>
	                    	
	                        <div class="col-md-4 mb-5">
									<a href="<?= base_url('productos/detalle/') .'/' . $item->id ?>" class="text-decoration-none">
										<div class="card shadow-md rounded">
										  		<?php if($item->imagen): ?>
										  			<img src="<?= base_url('uploads/') .'/' . $item->imagen ?>" class="card-img-top img-responsive" alt="...">
										  		<?php else:?>
										  			<img src="<?= base_url('uploads/nodisponible.png')  ?>" class="card-img-top img-responsive" alt="...">
										  		<?php endif; ?>
										  		
										  	<div class="card-body text-center">
										  		<hr>
											  	<h6 class="text-blue-light font-weight-bolder text-uppercase title-producto"><strong><?= $item->nombre ?></strong></h6>
											    
											    
											</div>
											<div class="d-flex align-items-end">
												<a href="<?= base_url('productos/detalle/') .'/' . $item->id?>" class="btn-rounded bg-blue-dark mt-2 text-white" >Ver Más</a>
											</div>
										</div>
									</a>
								</div>
	                    <?php } ?>
	            <?php else: ?>
	            	<div class="col-md-12 d-flex justify-content-center">
	               		<p class="lead">No hay productos de esta Categoria</p>
	                </div>
                <?php endif; ?>
                </div>
                <div class="row d-flex justify-content-center">
      
			        <?php if (isset($links)) { ?>
			        	<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								 <?php echo $links ?>
								
							</ul>
						</nav> 

			           
			        <?php } ?>

				</div>
			
			</div>
		</div>
	</div>
</section>



<?php $this->load->view('layouts/footer'); ?>

