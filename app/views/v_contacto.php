<?php $this->load->view('layouts/header'); ?>
<div class="container-fluid bg-light">
    <div class="container">
        <!--Section-->
    <section class="pb-4 pt-5">

        <!--Section heading-->
        <h2 class="h1-responsive font-weight-bold text-center my-4">Contacto</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
            a matter of hours to help you.</p>

        <div class="row animated lightSpeedIn delay-1s">
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3733.2044599503256!2d-103.35777348568345!3d20.66125918619853!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b200e114b67d%3A0x5d1a08a539b7eb3f!2sNoble+%26+Jase+(NOBLE+%26+JASE+SISTEMAS+DE+ILUMINACION%2C+S.A.+DE+C.V.+)!5e0!3m2!1ses-419!2smx!4v1546404207576" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <!--Grid column-->
            <div class="col-md-6 mb-md-0 mb-5 px-3 py-5 bg-white">
                <form id="contact-form" name="contact-form" action="mail.php" method="POST">

                    

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
        <div class="row text-center p-5 animated lightSpeedIn delay-1s">
            <div class="col-md-4 p-md-5">
                <div>
                    <i class="fas fa-map-marker-alt fa-2x pb-md-2"></i>
                    <p>Av. Cristóbal Colón 1164-A, Moderna, 44190 Guadalajara, Jal.</p>
                </div>
            </div>
            <div class="col-md-4 p-md-5">
                <div>
                    <i class="fas fa-phone mt-4 fa-2x pb-md-2"></i>
                    <p>01 33 3650 0807</p>
                </div>
            </div>
            <div class="col-md-4 p-md-5">
                <div>
                    <i class="fas fa-envelope mt-4 fa-2x pb-md-2"></i>
                    <p>contacto@miempresa.com</p>
                </div>
            </div>
            
        </div>
        

    </section>
    <!--Section-->
</div>
</div>

		
<?php $this->load->view('layouts/footer'); ?>