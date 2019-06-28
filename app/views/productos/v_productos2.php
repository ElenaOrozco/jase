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
				
				<div id="buscador" class="pb-3">
				    <span><?php echo validation_errors(); ?></span>
				    <?=form_open(base_url().'productos/validar')?>
				    
				    <div class="input-group">
				        
				        <input id="input_search" name="buscando" id="buscando" type="text" class="form-control form-control-lg border-blue-dark" id="inlineFormInputGroupUsername" placeholder="¿Qué estás buscando?">
				        <div class="input-group-prepend">
				          <div class="input-group-text border-blue-dark  bg-blue-dark text-white"><i class="fas fa-search"></i></div>
				        </div>
				    </div>
				    <?=form_close()?>
				</div>
				<?php if(isset($buscador) && $buscador != ""): ?>	
					<h5 class="font-weight-bolder text-blue pb-3">Productos que contengan '<?= $buscador ?> ' <br> <a href="<?= base_url('productos/ver_todos') ?>">  X Quitar Filtro</a></h5>
					
				<?php endif; ?>
				<?php if(isset($categoria['nombre'])): ?>
					<h5 class="font-weight-bolder text-blue pb-3"><?= $categoria['nombre'] ?></h5>
				<?php endif; ?>
				<div class="row">

					<?php if(!$results): ?>
						<div class="col-md-12">
							<h5 class="font-weight-bolder text-blue pb-3">No hay productos que mostrar</h5>
							
						</div>
					    
					<?php else : ?>
					    <?php foreach($results as $item): ?>
					    
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
										<div class="d-flex align-items-end justify-content-center">
												<a href="<?= base_url('productos/detalle/') .'/' . $item->id?>" class="btn-rounded bg-blue-dark mb-4 text-white" >Ver Más</a>
											</div>
									</div>
								</a>
							</div>

					    <?php endforeach; ?>
					    
					    
					    
					<?php endif; ?>	    
					
				</div>
				<div class="row d-flex justify-content-center">
		        	<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							 <?=$this->pagination->create_links()?>
							
						</ul>
					</nav> 
				</div>

			
			</div>
		</div>
	</div>
</section>



<?php $this->load->view('layouts/footer'); ?>

