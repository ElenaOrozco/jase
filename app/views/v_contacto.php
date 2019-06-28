<?php $this->load->view('layouts/header'); ?>
<div class="container-fluid">
    <div class="container">
        <!--Section-->
        <section class="pb-4 pt-5">

            <!--Section heading-->
            <h2 class="h1-responsive font-weight-bold text-center my-4">Contacto</h2>
            <!--Section description-->
            <p class="text-center w-responsive mx-auto mb-5"><strong>¿Tiene usted alguna pregunta?</strong> Por favor no dude en contactarnos directamente. Nuestro equipo se contactará con usted para ayudarlo.</p>

            <?php if ($this->session->flashdata('email_sent')): ?>
                 <p class="h4 text-center w-responsive mx-auto mb-5"><?= $this->session->flashdata('email_sent')?></p>
                
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3733.2044599503256!2d-103.35777348568345!3d20.66125918619853!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b200e114b67d%3A0x5d1a08a539b7eb3f!2sNoble+%26+Jase+(NOBLE+%26+JASE+SISTEMAS+DE+ILUMINACION%2C+S.A.+DE+C.V.+)!5e0!3m2!1ses-419!2smx!4v1546404207576" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <!--Grid column-->
                <div class="col-md-6 mb-md-0 mb-5 px-3 py-5 bg-white  animated lightSpeedIn">
                    <form id="contact-form" name="contact-form" action="<?= base_url('contacto/enviar_mensaje')?>" method="POST">

                        

                        <!--Grid row-->
                        <div class="form-group">
                            <input type="text" id="nombre" name="nombre" class="line" placeholder="Ingresa tu Nombre">
                            <label for="nombre" class="">Nombre</label>
                               
                        </div>
                        <!--Grid row-->
                        <!--Grid row-->
                        <div class="form-group">
                            <input type="email" id="email" name="email" class="line" placeholder="Ingresa tu Email">
                            <label for="email" class="">Email</label>
                               
                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="form-group">

                            
                            <textarea type="text" id="message" name="message" rows="2" class="line" placeholder="Escribe tu Mensaje"></textarea>
                            <label for="message">Mensaje</label>
                              
                        </div>
                        <!--Grid row-->

                    </form>

                    <div class="text-center text-md-left">
                        <a class="btn btn-primary text-white" onclick="document.getElementById('contact-form').submit();">Enviar</a>
                    </div>
                    <div class="status"></div>
                </div>
                <!--Grid column-->
            </div>
            
            

        </section>
        <!--Section-->
    </div>
</div>

<section class="main-support bg-dark-blue">
    <div class="support">
        <div class="container">
            
            <div class="row text-center p-5 animated lightSpeedIn delay-1s">
                <div class="col-md-4 p-md-5">
                    <div>
                      <img src="<?= base_url('img/iconos/localizacion.png') ?>" alt="" style="width: 100; height: 100px">
                      <p class="text-white text-uppercase font-weight-bold monserrat">Av. Cristóbal Colón 1164-A</p>
                    </div>
                    <!-- <div>
                        <i class="fas fa-map-marker-alt m-4 fa-3x pb-md-2 text-blue-light"></i>
                        <p class="text-white text-uppercase font-weight-bold">Av. Cristóbal Colón 1164-A</p>

                    </div> -->
                </div>
                <div class="col-md-4 p-md-5">
                    <div>
                      <img src="<?= base_url('img/iconos/telefono.png') ?>" alt="" style="width: 100; height: 100px">
                      <p class="text-white text-uppercase font-weight-bold monserrat">(01 33) 3650 0807</p>
                    </div>
                    <!-- <div>
                        <i class="fas fa-phone m-4 fa-3x pb-md-2 text-blue-light"></i>
                        <p class="text-white font-weight-bold">(01 33) 3650 0807</p>
                    </div> -->
                </div>
                <div class="col-md-4 p-md-5">
                  <div>
                      <img src="<?= base_url('img/iconos/correo.png') ?>" alt="" style="width: 100; height: 100px">
                      <p class="text-white font-weight-bold monserrat">info@noble-jase.com</p>
                    </div>
                    <!-- <div>
                        <i class="fas fa-envelope m-4 fa-3x pb-md-2 text-blue-light"></i>
                        <p class="text-white font-weight-bold"> Info@noble-jase.com</p>
                    </div> -->
                </div>
                
            </div>
            
            
        </div>
        
    </div>
</section>

<section class="representantes p-5 text-sm bg-light">
    <div class="container">
        <h2 class="h1-responsive font-weight-bold text-center my-4">Nuestros Representantes</h2>
           <div class="row">
            <?php $ciudad_anterior = ""; ?>
            <?php foreach ($aDatos as $row): ?>
                
                
                  

                  

                  <?php foreach ($row['representantes']->result() as $representante): ?>
                    <div class="col-md-6 mb-4">
                      <?php if($ciudad_anterior != $row['ciudad']):?>
                   
                          <h4 class="col-md-12"><?= $row['ciudad'] ?></h4>
                      
                      <?php endif; ?>
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-4 justify-content-center  d-flex align-items-center">
                                      <img src="<?= base_url('img/representantes/').'/'. $representante->imagen ?>" alt="..." class="" style="width: 130px; height: auto;">
                                  </div>
                                  <div class="col-md-8">
                                      <dl class="row">
                                        <dt class="col-sm-4">Nombre:</dt>
                                        <dd class="col-sm-8"><?= $representante->Nombre ?></dd>

                                        <dt class="col-sm-4">Teléfono: </dt>
                                        <dd class="col-sm-8"><?= $representante->Telefono ?></dd>

                                        <dt class="col-sm-4">Correo:</dt>
                                        <dd class="col-sm-8"><?= $representante->Email ?></dd>

                                        <dt class="col-sm-4">Municipio</dt>
                                        <dd class="col-sm-8"><?= $representante->Municipio ?></dd>
                                      </dl>
                                      
                                  </div>
                              </div>
                              
                          </div>
                      </div> 
                    </div>
                  <?php endforeach; ?>

                  

                  <?php $ciudad_anterior = $row['ciudad']; ?>
               
            <?php endforeach; ?>
          </div>
            
            
        


    </div>
    

</section>

		
<?php $this->load->view('layouts/footer'); ?>