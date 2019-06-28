<?php $this->load->view('layouts/header'); ?>
<section class="nosotros">
	
	
	<div class="container-fluid pl-0 pr-0">
		<img class="img-responsive pt-md-0" src="<?= base_url('img/general/urban-205986_1280.jpg')?>" alt="Nosotros">
		
	</div>
	<div class="container">
		<h3 class="pt-5 pb-1 animated bounce">¿Quiénes Somos?</h3>
		<div class="row pb-md-5">
			<div class="col-md-6 animated bounceInLeft text-justify">
				<p class="">
					Noble & Jase empresa mexicana con inicio de operaciones en al año 2002,
					oficinas y almacenes en la ciudad de Guadalajara, Jalisco, con clientes,
					representantes y distribuidores en las principales ciudades del país.
				</p>
				<p class="">
					Somos una empresa dedicada a la distribución y comercialización de productos del medio eléctrico, con marcas propias y representando las marcas líderes del mercado de iluminación, componentes leds, y equipos del ramo eléctrico, a través de nuestros representantes de marca atendemos a fabricantes de equipo de iluminación,
					especificadores, distribuidores de iluminación y clientes finales de segmentos, industrial, comercial, hospitalario y hotelero.
				</p>
				<p class="">
					Nuestros productos y marcas cumplen con los más altos estándares de calidad, diseño y funcionalidad.
				</p>
			</div>
			<div class="col-md-6">
				<img class="w-100 p-3" src="<?= base_url('img/EMPRESA/4-16.png') ?>" alt="">
			</div>	
			
		</div>
	</div>
	<div class="container-fluid pl-0 pr-0 container-nosotros">
	</div>


</section>
<?php $this->load->view('sections/parallax'); ?>
<section class="container categorias">
	<div class="row p-5">
		<div class="col-md-12 d-flex justify-content-center  pb-5">
			<a href="<?= base_url('productos') ?>" class="btn-rounded bg-blue-dark text-white">Nuestros Productos</a>
		</div>
		<?php foreach ($categorias->result() as $item): ?>
		<div class="col-md-4 mb-3">
			<a class="nav-link active text-dark py-1 px-0" href="<?= base_url('productos/listado_categoria') .'/' . $item->id ?>"><strong><?= $item->nombre ?></strong></a>
			<img class="p-1" src="<?= base_url('uploads') .'/' . $item->imagen ?>" alt="" width="100%">
		</div>
				    	
				  
		<?php endforeach; ?>
	</div>
</section>
<?php $this->load->view('layouts/footer'); ?>