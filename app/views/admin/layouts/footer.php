<!-- Footer -->
<footer class="page-footer font-small text-gris">

   
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

		       

		    </div>
		    <!-- Grid row -->
	    </div>
	</div>

</footer>
<!-- Footer -->

	

	<script type="text/javascript" src="<?= base_url('js/SweetAlert/sweetalert.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/DataTables/jquery-3.3.1.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/DataTables/popper.min.js') ?>"></script> 
    <script type="text/javascript" src="<?= base_url('js/DataTables/bootstrap.min.js') ?>"></script> 
    <script type="text/javascript" src="<?= base_url('js/DataTables/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/DataTables/dataTables.bootstrap4.min.js') ?>"></script>

    
	<script src="<?= base_url('js/tinymce5/tinymce/js/tinymce/tinymce.min.js') ?>" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="<?php echo site_url(); ?>js/tinymce5/tinymce/js/tinymce/jquery.tinymce.min.js"></script>  -->
    
  
   
	<script type="text/javascript">


		$(document).ready(function(){

			// var menu = $('#products').offset().top/3;
			// var marketing = $('.marcas').offset().top;

			// tinymce.init({
   //              selector: 'textarea',
   //              language: 'es',
   //              plugins: "table code paste",
   //              menubar: "tools table format view edit pastetext"
   //          });  
   						 $(".add-campo").on("click",function(e){
                    var dato = $(this).data("info");
                    tinyMCE.activeEditor.execCommand('mceInsertContent', false, dato);
                    return false;                    
                });

                tinymce.init({
                    selector: 'textarea',
                    language: 'es',
                    plugins: "table code paste",
                    menubar: "tools table format view edit pastetext"
                }); 



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


		    $("#myTable").DataTable({
		      "language": {
		                        "url": "<?php echo base_url() . 'assets/dataTables.spanish.lang'; ?>"
		                    }, 
				     "buttons": [
				    'copy', 'excel', 'pdf'
				]
			});

			$("#myTableLg").DataTable({
				"scrollX": true,
		      	"language": {
		                        "url": "<?php echo base_url() . 'assets/dataTables.spanish.lang'; ?>"
		                    },

				     "buttons": [
				    'copy', 'excel', 'pdf'
				] 
			});


	        $('#example2').DataTable({
	          "paging": true,
	          "lengthChange": false,
	          "searching": false,
	          "ordering": false,
	          "info": true,
	          "autoWidth": false,
	          "buttons": [
			        'copy', 'excel', 'pdf'
			    ]
			});

			/*$('#myTable').DataTable();*/

      });


		


		$("#btn-search").click(function() {
			$("#input-search").toggle()
			  			
		});


	
	</script>

  </body>
</html>