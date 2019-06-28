<!-- Footer -->
<footer class="page-footer font-small text-white">

    <!-- Footer Links -->
    <div class="container-fluid text-center bg-medium-blue text-md-left  pt-4">
		<div class="container">
			<!-- Footer links -->
		    <div class="row text-center text-md-left mt-3 pb-3">

		        <!-- Grid column -->
		        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">NOBLE & JASE</h6>
		          <p> Nuestro objetivo es apoyar a nuestros clientes con sus proyectos
					y entender sus necesidades.</p>
		        </div>
		        <!-- Grid column -->

		        <hr class="w-100 clearfix d-md-none">

		        <!-- Grid column -->
		        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">Productos</h6>
		          <p>
		            <a href="<?= base_url('productos/listado_categoria/1') ?>" class="text-gris">Balastros</a>
		          </p>
		          <p>
		            <a href="<?= base_url('productos/listado_categoria/2') ?>" class="text-gris">Drivers</a>
		          </p>
		          <p>
		            <a href="<?= base_url('productos/listado_categoria/3') ?>" class="text-gris">Luminarios</a>
		          </p>
		          <p>
		            <a href="<?= base_url('productos/listado_categoria/4') ?>" class="text-gris">Modulos LED</a>
		          </p>
		          <p>
		            <a href="<?= base_url('productos/listado_categoria/5') ?>" class="text-gris">Retrofit</a>
		          </p>
		          <p>
		            <a href="<?= base_url('/listar_categoria/6') ?>" class="text-gris">Tubos</a>
		          </p>
		        </div>
		        <!-- Grid column -->

		        <hr class="w-100 clearfix d-md-none">

		        <!-- Grid column -->
		        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">Empresa</h6>
		          <p>
		            <a href="<?= base_url('') ?>" class="text-gris">Inicio</a>
		          </p>
		          <p>
		            <a href="<?= base_url('/nosotros') ?>" class="text-gris">Nosotros</a>
		          </p>
		          <p>
		            <a href="<?= base_url('/productos') ?>" class="text-gris">Productos</a>
		          </p>
		          <p>
		            <a href="<?= base_url('/contacto') ?>" class="text-gris">Contacto</a>
		          </p>
		          <p>
		            <a href="<?= base_url('/admin') ?>" class="text-gris">Login</a>
		          </p>
		        </div>

		        <!-- Grid column -->
		        <hr class="w-100 clearfix d-md-none">

		        <!-- Grid column -->
		        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">Contacto</h6>
		          <p>
		            <i class="fas fa-home mr-3"></i> Colón #1164-A Col. Moderna C.P. 44190 Gdl, Jal.</p>
		          <p>
		            <i class="fas fa-envelope mr-3"></i> Info@noble-jase.com</p>
		          <p>
		            <i class="fas fa-phone mr-3"></i> 01 33 3650 0807</p>
		          
		        </div>
		        <!-- Grid column -->

		    </div>
		    <!-- Footer links -->
		</div>
		    

    	

	    

    </div>
    <!-- Footer Links -->

   
    <div class="container-fluid text-center  bg-dark-blue text-md-left  pt-4">

	    <div class="container">
	    	<!-- Grid row -->
		    <div class="row d-flex align-items-center bg-negro">

		        <!-- Grid column -->
		        <div class="col-md-7 col-lg-8">

		          <!--Copyright-->
		          <p class="text-center text-md-left">© <?= date('Y' ) ?> Copyright: <strong> NOBLE & JASE</strong>
		           
		          </p>

		        </div>
		        <!-- Grid column -->

		        <!-- Grid column -->
		        <div class="col-md-5 col-lg-4 ml-lg-0">

		          <!-- Social buttons -->
		          <div class="text-center text-md-right">
		            <ul class="list-unstyled list-inline">
		              <li class="list-inline-item">
		                <a href="https://www.facebook.com/noblejaseamerica" target="_blank" class="link-login mx-1">
		                  <i class="fab fa-facebook-square mr-2"></i>
		                </a>
		              </li>
		              <!-- <li class="list-inline-item">
		                <a class="btn-floating btn-sm rgba-white-slight mx-1">
		                  <i class="fab fa-twitter"></i>
		                </a>
		              </li>
		              <li class="list-inline-item">
		                <a class="btn-floating btn-sm rgba-white-slight mx-1">
		                  <i class="fab fa-google-plus-g"></i>
		                </a>
		              </li>
		              <li class="list-inline-item">
		                <a class="btn-floating btn-sm rgba-white-slight mx-1">
		                  <i class="fab fa-linkedin-in"></i>
		                </a>
		              </li> -->
		            </ul>
		          </div>

		        </div>
		        <!-- Grid column -->

		    </div>
		    <!-- Grid row -->
	    </div>
	</div>

</footer>
<!-- Footer -->

		


	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
 	<script src="<?= base_url('js/DataTables/jquery-3.3.1.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('js/DataTables/popper.min.js') ?>"></script>
	<script src="<?= base_url('js/DataTables/bootstrap4.min.js') ?>"></script> 

	<script type="text/javascript">


		$(document).ready(function(){

			$(window).on('scroll', function(){
				
				if ( $(window).scrollTop() < 100){

					$("#nav-datos").fadeIn(1000, function() {
					    $(this).addClass("d-sm-block");
					    $("header nav").removeClass('fixed-top')
					}); 
				}
				if ( $(window).scrollTop() > 100){

					$("#nav-datos").fadeIn(1000, function() {
					    $(this).removeClass("d-sm-block");
					    $("header nav").addClass('fixed-top')
					}); 
				}
				

					
			});


		});


		$("#btn-search").click(function() {
			$("#input_search").toggle()
			  			
		});

		// $("#form-search").submit(function() {
		// 	event.preventDefault();
		// 	search = $("#input-search").val()
		// 	alert(search)
			  			
		// });


	
		// $('.open-button').click(function(){
		//   $('.search').addClass('active');
		//   $('.overlay').removeClass('hidden');
		//   $('input').focus(); // If there are multiple inputs on the page you might want to use an ID
		// });

		// $('.overlay').click(function() {
		//   $('.search').removeClass('active');
		//   $(this).addClass('hidden');
		// });
	</script>

  </body>
</html>