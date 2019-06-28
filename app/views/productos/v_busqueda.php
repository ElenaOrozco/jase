<?php $this->load->view('layouts/header'); ?>


<section class="bg-light">
	<div class="container">
		
			<?php if($retorno->num_rows() > 0) : ?>
				<?php foreach ($retorno->result() as $row) : ?>
						<div class="row bg-white pt-5 pb-5">
							<div class="col-md-6 p-5">
								<?php if($row->imagen): ?>
						  			<img src="<?= base_url('uploads/') .'/' . $row->imagen ?>" class="card-img-top img-responsive" alt="..." height="230">
						  		<?php else:?>
						  			<img src="<?= base_url('uploads/nodisponible.png')  ?>" class="card-img-top img-responsive" alt="..." height="230">
						  		<?php endif; ?>
							</div>
							<div class="col-md-6 p-5">
								<h3><?= $row->nombre ?></h3>
								<p><?= $row->descripcion ?></p>
							</div>
						</div>
						<hr>
					
					
					

				<?php endforeach; ?>
			<?php else: ?>
				<div class="row bg-white pt-5 pb-5" style="height: 300px">
					<div class="col-md-6 p-5">
						<h3>No hay Resultados para <strong><?= $buscar ?></strong></h3>
					</div>
				</div>
			<?php endif; ?>
		
		
	</div>
</section>



<?php $this->load->view('layouts/footer'); ?>

