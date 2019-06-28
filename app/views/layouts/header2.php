<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!doctype html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="../../../../favicon.ico">

	    <title>Noble Jase</title>

	    <!-- Bootstrap core CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

	    <!-- Custom styles for this template -->
	    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat" rel="stylesheet">
	    <link rel="stylesheet" href="css/least.min.css">
	    <link rel="stylesheet" href="css/animate.css">
	    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	   
	    <link href="<?php echo base_url("css/style.css") ?>" rel="stylesheet">
	  </head>

	  
	<body>
    	<header style="margin-bottom: 128px">
    		
    	
			<nav class="navbar navbar-expand-lg navbar-light flex-column bg-white p-0 fixed-top border-bottom shadow-sm">
				<div class="data2 bg-white d-none d-sm-block monserrat w-100 shadow-lg" >
	    			<div class="data2 container d-flex justify-content-between align-items-center">
	    				<div class="data2-cl text-uppercase text-sm text-dark"><i class="fas fa-map-marker-alt"></i> Calle Francia 1751, Gdl, Jal.</div>
	    				<div class="data2-cl text-uppercase text-sm text-dark"> 
	    					<a class="navbar-brand text-center p-3" href="<?= base_url() ?>">
				    			<img src="<?= base_url("img/logo_corto.png")?>"  height="40" alt="">
						  	</a>

						</div>
	    				
	    				<div class="data2-redes d-flex align-items-center">
							
							<a href="<?= base_url('admin') ?>" class="text-uppercase text-dark mr-3 link-login" style="font-size: 1rem !important">Login</a>
							<a href="https://www.facebook.com/" target="_blank" class="text-uppercase  text-dark link-login"><i class="fab fa-facebook-square mr-2"></i></a>
							<a href="https://www.youtube.com/" target="_blank"  class="text-uppercase text-dark link-login"><i class="fab fa-youtube mr-2"></i></a>
							<a href="https://www.instagram.com" target="_blank"  class="text-uppercase text-dark link-login"><i class="fab fa-instagram"></i></a>
	    					
	    					
	    					
	    				</div>
	    			</div>

				</div>
				<!-- <div class="d-flex flex-column p-4 justify-content-center w-100">
    				<a class="navbar-brand text-center p-1" href="<?= base_url() ?>">
				    	<img src="<?= base_url("img/logo_corto.png")?>"  height="40" alt="">
				  	</a>
				  	
    				

					
					
				</div> -->

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					    <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse navigation bg-dark-blue text-white d-flex justify-content-center w-100" id="navbarSupportedContent">
					    <ul class="navbar-nav justify-content-center py-2">
					      <li class="nav-item active text-uppercase">
					        <a class="nav-link my-link2 px-3" href="<?= base_url() ?>">Inicio<span class="sr-only">(current)</span></a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link text-white text-uppercase my-link2 px-3" href="<?= base_url('nosotros') ?>">¿Quienes Somos?</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link text-uppercase my-link2 px-3" href="<?= base_url('productos') ?>">Productos</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link text-uppercase my-link2 px-3" href="<?= base_url('contacto') ?>">Contacto</a>
					      </li>
					      
					    </ul>
					    
					   
					    <form id="form-search" method="post" action="<?= base_url('productos/buscar') ?>" class="form-inline my-2 my-lg-0">
						    <div class="d-flex my-2 my-lg-0 px-3"">
						    	
									<input id="input_search" name="input_search" class="line mr-sm-2"  style="display: none" type="text" placeholder="Buscar" aria-label="Search">
									<i id="btn-search" class="btn fas fa-search"></i>
								
					
						    </div>
					    </form>
					
					</div>
				
				
			</nav>
		</header>