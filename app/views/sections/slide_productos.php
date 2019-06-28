<section class="section-productos">

	<div class="container py-5">

		 <!--Section heading-->
	    <h2 class="h1-responsive font-weight-bold text-center my-4 text-uppercase ">Productos Destacados</h2>
	    <!--Section description-->
	    <p class="text-center w-responsive mx-auto mb-3 lead">
	    Contamos con un extenso surtido de productos de iluminación <strong class="font-weight-bold">industrial, comercial y residencial.</strong></p>
	    
		<div class="slider-productos py-5">
			<?php $this->load->view('sections/slide_productos_responsive'); ?>
			
		</div>

		<div class="d-flex justify-content-center">
			<a href="<?= base_url('productos') ?>" class="btn-rounded bg-blue-dark text-white">Ver Más</a>
		</div>

	</div>
</section>
		
	
