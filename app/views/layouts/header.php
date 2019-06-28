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
	    <link rel="icon" href="<?= base_url('img/logo_favicon.png') ?>">

	    <title>Noble Jase</title>

	    
	    <!-- Bootstrap core CSS -->
	    <link rel="stylesheet" href="<?php echo site_url('css/DataTables/bootstrap.css'); ?>">
	  
		<!-- DataTables -->
    	<link rel="stylesheet" href="<?php echo site_url('css/DataTables/dataTables.bootstrap4.min.css'); ?>">

	    <!-- Custom styles for this template -->
	    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat" rel="stylesheet">
	    <link rel="stylesheet" href="css/least.min.css">
	    <link rel="stylesheet" href="css/animate.css">
	    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	   
	    <link href="<?php echo base_url("css/style.css") ?>" rel="stylesheet">
	  </head>

	  
	<body>
    	<header>
    		
    		<div class="data bg-dark-blue d-none d-sm-block monserrat" id="nav-datos">
    			<div class="data container d-flex justify-content-between align-items-center">
    				<div class="data-cl"><i class="fas fa-map-marker-alt mr-2"></i> Colón #1164-A Col. Moderna Gdl, Jal.</div>
    				<div class="data-cl"> <i class="fas fa-phone mr-2"></i> (01 33) 3650 0807</div>
    				
    				<div class="data-redes d-flex align-items-center">
						
						<a href="<?= base_url('admin') ?>" class="text-uppercase  mr-3 link-login" style="font-size: 1rem !important">Login</a>
						<a href="https://www.facebook.com/noblejaseamerica" target="_blank" class="link-login"><i class="fab fa-facebook-square mr-2"></i></a>
						<!-- <a href="https://www.youtube.com/" target="_blank"  class="text-uppercase text-gris link-login"><i class="fab fa-youtube mr-2"></i></a>
						<a href="https://www.instagram.com" target="_blank"  class="text-uppercase text-gris link-login"><i class="fab fa-instagram"></i></a> -->
    					
    					
    					
    				</div>
    			</div>
    			
    		</div>
    	
			<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm  px-md-4 ">
				<div class="container pt-1 pb-1">
    				<a class="navbar-brand p-1" href="<?= base_url() ?>">
				    	<img src="<?= base_url("img/logo_corto.png")?>"  height="40" alt="">
				  	</a>

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					    <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
					    <ul class="navbar-nav justify-content-end w-100">
					      <li class="nav-item active text-uppercase">
					        <a class="nav-link font-weight-bold my-link text-blue-dark px-3" href="<?= base_url() ?>">Inicio<span class="sr-only">(current)</span></a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link text-uppercase font-weight-bold my-link text-blue-dark px-3"" href="<?= base_url('nosotros') ?>">Nosotros</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link text-uppercase font-weight-bold my-link text-blue-dark px-3"" href="<?= base_url('productos') ?>">Productos</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link text-uppercase font-weight-bold my-link text-blue-dark px-3" href="<?= base_url('contacto') ?>">Contacto</a>
					      </li>
					      
					    </ul>
					    
					    
					    <form id="form-search" method="post" action="<?= base_url('productos/validar') ?>" class="form-inline my-2 my-lg-0">
						    <div class="d-flex my-2 my-lg-0 px-3"">
						    	
									<input id="input_search" name="buscando" class="line mr-sm-2"  style="display: none" type="text" placeholder="Buscar" aria-label="Search">
									<i id="btn-search" class="btn fas fa-search"></i>
								
					
						    </div>
					    </form>
					
					</div>
				</div>
			</nav>
		</header>