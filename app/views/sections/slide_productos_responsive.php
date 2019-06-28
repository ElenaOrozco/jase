
<div class="slider-productos d-none d-sm-block">
	<ul>
		
		<?php foreach ($productos->result() as $item) : ?>
			
		
			<li>
				<a  href="<?= base_url('productos/detalle/') .'/' . $item->id ?>">
					<!-- <div class="text-center">	
						<a class="btn btn-outline-warning">Ver Más</a>
					</div> -->
					
					<div class="my-card">
						<div class="my-card-img">
							<?php if($item->imagen): ?>
					  			<img src="<?= base_url('uploads/') .'/' . $item->imagen ?>" class="card-img-top img-responsive" alt="...">
					  		<?php else:?>
					  			<img src="<?= base_url('uploads/nodisponible.png')  ?>" class="card-img-top img-responsive" alt="...">
					  		<?php endif; ?>
						</div>
					  		
					  		
					  	<div class="my-card-body mt-3">
						  	
						  	<hr class="hr-productos">
						  	<h6 class="text-blue-dark text-center text-sm pt-1"><strong><?= $item->nombre ?></strong></h6>
						    
						</div>
					</div>
				</a>
			</li>

		<?php endforeach ; ?>
		
		
	</ul>
</div>



<div class="slider d-block d-sm-none">
	<ul>

		<?php foreach ($productos->result() as $item) : ?>
			<li>
				<a href="<?= base_url('productos/detalle/') .'/' . $item->id ?>">
					<img src="<?= base_url('uploads/') .'/' . $item->imagen ?>" alt="">

					<h3 class="text-blue-dark font-weight-bolder"><strong><?= $item->nombre ?></strong></h3>
				</a>
			</li>
		<?php endforeach; ?>
		
		
	</ul>
</div>	