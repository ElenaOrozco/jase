
		<?php $this->load->view('layouts/header'); ?>
		
		<?php $this->load->view('sections/slide'); ?>
		
		<?php //$this->load->view('sections/products'); ?>
		

		
		<?php $this->load->view('sections/slide_productos'); ?>
		
		<?php $this->load->view('sections/galerias'); ?>
		<?php $this->load->view('sections/support'); ?>
		<!-- <?php $this->load->view('sections/parallax'); ?> -->
		<?php $this->load->view('sections/marcas'); ?>

		<!-- <?php $this->load->view('sections/frase'); ?> -->
		
		<?php $this->load->view('layouts/footer'); ?>

		<script type="text/javascript">
			$(window).on('scroll', function(){
				var marketing = $('.marcas').offset().top;
				if ( $(window).scrollTop() >marketing){

					$("#f-1").fadeIn(30000, function() {
							
				    	$(this).addClass("animated fadeInDown");

					});
					$("#f-2").fadeIn(30000, function() {
						
				    	$(this).addClass("animated zoomIn");

					});
				}else{
					$("#f-1").fadeIn(30000, function() {
							
				    	$(this).removeClass("animated fadeInDown");

					});
					$("#f-2").fadeIn(30000, function() {
						
				    	$(this).removeClass("animated zoomIn");

					});

				}

					
			});
				
		</script>

		



    
