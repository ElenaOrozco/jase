<?php $this->load->view('layouts/header'); ?>
<div class="row bg-light">
	<aside class="col-md-3">
		<ul class="nav flex-column">
		  <li class="nav-item">
		    <a class="nav-link active" href="#">Active</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="#">Link</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="#">Link</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
		  </li>
		</ul>	
	</aside>
	<div class="col-md-9">
		<div class="row">
			

			<div class="col-md-4">
				<div class="card" style="width: 18rem;">
				  <img src="<?= base_url('img/empresa/cfl.jpg') ?>" class="card-img-top" alt="...">
				  <div class="card-body">
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				  </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card" style="width: 18rem;">
				  <img src="<?= base_url('img/empresa/cfl.jpg') ?>" class="card-img-top" alt="...">
				  <div class="card-body">
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				  </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card" style="width: 18rem;">
				  <img src="<?= base_url('img/empresa/cfl.jpg') ?>" class="card-img-top" alt="...">
				  <div class="card-body">
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				  </div>
				</div>
			</div>	
		</div>

	</div>
</div>
<?php $this->load->view('layouts/footer'); ?>