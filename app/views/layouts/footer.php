<!-- Footer -->
<footer class="page-footer font-small text-gris">

    <!-- Footer Links -->
    <div class="container-fluid text-center bg-medium-blue text-md-left  pt-4">
		<div class="container">
			<!-- Footer links -->
		    <div class="row text-center text-md-left mt-3 pb-3">

		        <!-- Grid column -->
		        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">NOBLE & JASE</h6>
		          <p>Here you can use rows and columns here to organize your footer content. Lorem ipsum dolor sit amet, consectetur
		            adipisicing elit.</p>
		        </div>
		        <!-- Grid column -->

		        <hr class="w-100 clearfix d-md-none">

		        <!-- Grid column -->
		        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">Productos</h6>
		          <p>
		            <a href="#!" class="text-gris">Balastros</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Drivers</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Luminarios</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Modulos LED</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Retrofit</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Tubos</a>
		          </p>
		        </div>
		        <!-- Grid column -->

		        <hr class="w-100 clearfix d-md-none">

		        <!-- Grid column -->
		        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">Empresa</h6>
		          <p>
		            <a href="#!" class="text-gris">Inicio</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Nosotros</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Productos</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Contacto</a>
		          </p>
		          <p>
		            <a href="#!" class="text-gris">Login</a>
		          </p>
		        </div>

		        <!-- Grid column -->
		        <hr class="w-100 clearfix d-md-none">

		        <!-- Grid column -->
		        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
		          <h6 class="text-uppercase mb-4 font-weight-bold">Contacto</h6>
		          <p>
		            <i class="fas fa-home mr-3"></i> Av. Cristóbal Colón 1164-A, Moderna, 44190 Guadalajara, Jal.</p>
		          <p>
		            <i class="fas fa-envelope mr-3"></i> info@gmail.com</p>
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
		          <p class="text-center text-md-left">© 2018 Copyright: <strong> NOBLE & JASE</strong>
		           
		          </p>

		        </div>
		        <!-- Grid column -->

		        <!-- Grid column -->
		        <div class="col-md-5 col-lg-4 ml-lg-0">

		          <!-- Social buttons -->
		          <div class="text-center text-md-right">
		            <ul class="list-unstyled list-inline">
		              <li class="list-inline-item">
		                <a class="btn-floating btn-sm rgba-white-slight mx-1">
		                  <i class="fab fa-facebook-f"></i>
		                </a>
		              </li>
		              <li class="list-inline-item">
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
		              </li>
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
   
    <script
	  src="https://code.jquery.com/jquery-3.3.1.min.js"
	  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<script type="text/javascript">


$(document).ready(function(){
	
	

	
	
	var menu = $('#products').offset().top/3;
	var marketing = $('.marcas').offset().top;
	
	
	
	

	$(window).on('scroll', function(){
		console.log($(window).scrollTop());
		if ( $(window).scrollTop() < 30){

			$("#nav-datos").fadeIn(1000, function() {
			    $(this).addClass("d-sm-block");
			    $("nav").removeClass('fixed-top')
			}); 
		}
		if ( $(window).scrollTop() > menu){

			$("#nav-datos").fadeIn(1000, function() {
			    $(this).removeClass("d-sm-block");
			    $("nav").addClass('fixed-top')
			}); 
		}
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

	
});


$("#btn-search").click(function() {
	$("#input-search").toggle()
	  	
		
	});

	
		$('.open-button').click(function(){
  $('.search').addClass('active');
  $('.overlay').removeClass('hidden');
  $('input').focus(); // If there are multiple inputs on the page you might want to use an ID
});

$('.overlay').click(function() {
  $('.search').removeClass('active');
  $(this).addClass('hidden');
});
	</script>

  </body>
</html>