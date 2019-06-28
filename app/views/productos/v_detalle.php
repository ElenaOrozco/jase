<?php $this->load->view('layouts/header'); ?>
<section class="producto-detalle">
	<div class="container py-5">
		<div class="row">
			<div class="col-md-6 ">
				<figure class="px-md-3 card  rounded">
                    
                    <?php if($producto['imagen']): ?>
			  			<img src="<?= base_url('uploads/') .'/' . $producto['imagen'] ?>" class="img-responsive p-3" alt="...">
			  		<?php else:?>
			  			<img src="<?= base_url('uploads/nodisponible.png')  ?>" class="img-responsive p-3" alt="...">
			  		<?php endif; ?>
                               
                </figure>
				
			</div>
			<div class="col-md-6 bg-white">
				<div class="row">
					<div class="col-md-11 m-auto">
						<h3 class="font-weigth text-blue-light pt-3 pb-1"><strong><?= $producto['nombre'] ?></strong></h3>
						<div class="col-md-12 pt-3 m-auto text-right">
							<?php if($producto['disponible']): ?>
								<p class="animated zoomIn delay-3s text-blue-dark"><i class="text-blue-light fas fa-check mr-1"></i>Disponible</p>
							<?php endif; ?>
							<?php if($producto['promocion']): ?>
								<p class="animated zoomIn delay-3s text-blue-dark"><i class="text-blue-light fas fa-check mr-1"></i>Producto Rebajado</p>
							<?php endif; ?>
						</div>
						<h5 class="text-blue-dark py-2 font-weight-bold text-sm">Detalle</h5>
						<h5 class="text-blue-dark py-1 text-sm"><?= $producto['descripcion'] ?>
						<h5 class="text-blue-dark py-2 font-weight-bold text-sm">Categoria: <?= $producto['categoria'] ?>
						</h5>

						<?php if($producto['pdf']): ?>
							<div class="text-right">
								<a href="<?= base_url('uploads/pdf') . '/' . $producto['pdf'] ?>" class="btn btn-rounded bg-blue-dark text-white" download="<?= $producto['pdf'] ?>"><i class="text-white fas fa-download mr-1"></i>Descargar Ficha Técnica</a>
							</div>
							
						<?php endif; ?>
						
						
						
					</div>
					
				</div>
				
				
			</div>
		</div>
	</div>
	
</section>
<hr>
<section class="similares py-md-5">
	<div class="container">
		 <!--Section heading-->
	    <h2 class="h1-responsive font-weight-bold text-center my-4 text-uppercase ">Quizá pueda interesarte</h2>
		<?php $this->load->view('sections/slide_productos_responsive'); ?>
	</div>
</section>
<?php $this->load->view('layouts/footer'); ?>
