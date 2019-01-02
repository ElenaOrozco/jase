<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php if (isset($title)) echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <?php if (isset($meta)) echo meta($meta); ?>  

       <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
         <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>/plugins/iCheck/square/blue.css">
          
        <link href="<?php echo site_url(); ?>dist/css/style.css" rel="stylesheet">

        

        </style>

    </head>

    <body class="hold-transition login-page">
    <div class="login-box fondo brightness">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-logo card">
                <a href="<?php echo site_url(); ?>"><b>Admin</b>OP</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Iniciar Sessión</p>
                <form role="form" method="post" accept-charset="utf-8" action="<?php echo site_url("sessions/authenticate"); ?>">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" placeholder="Usuario" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" id="pass" name="pass" autocomplete="off" placeholder="Contraseña" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <?php if ($error == 1) { ?>
                        <br>
                        <div class="alert alert-dismissable alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>
                                Alerta!
                            </h4> <strong>Error de Acceso</strong> <?php echo $this->session->userdata("error_txt"); ?>
                        </div>
                        <br>
                    <?php } ?>
                  <div class="row">
                    <div class="col-xs-8">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox"> Recordarme
                        </label>
                      </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div><!-- /.col -->
                  </div>
                </form>


            </div><!-- /.login-box-body -->
        </div>
      
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo site_url(); ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url(); ?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo site_url(); ?>/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</body>
</html>

        
     
           <!--
            <div class="container fondo">
                <div class="container color">

                    <div class="row login">
                        <div class="col-md-4 col-sm-offset-4 box">
                            
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h3>
                                        LOGIN
                                    </h3>
                                </div>
                                <div class="col-md-10 col-md-offset-1">
                                    <form role="form" method="post" accept-charset="utf-8" action="<?php echo site_url("sessions/authenticate"); ?>" >
                                        <div class="form-group">
                                            <label for="usuario">Usuario:</label><input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pass">Contraseña:</label><input type="password" class="form-control" id="pass" name="pass" autocomplete="off" required>

                                        </div>
                                        <?php if ($error == 1) { ?>
                                            <br>
                                            <div class="alert alert-dismissable alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h4>
                                                    Alerta!
                                                </h4> <strong>Error de Acceso</strong> <?php echo $this->session->userdata("error_txt"); ?>
                                            </div>
                                            <br>
                                        <?php } ?>
                                        <button type="submit" class="btn btn-success">Acceso</button>
                                    </form>
                                </div>
                            </div>
                            

                            
                            
                        </div>
                    </div>

                    <!--
                    <div class="row clearfix">
                        
                        <div class="col-md-6 column">
                            <h3>
                                Acceso al sistema
                            </h3>

                            <form role="form" method="post" accept-charset="utf-8" action="<?php echo site_url("sessions/authenticate"); ?>" >
                                <div class="form-group">
                                    <label for="usuario">Usuario:</label><input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="pass">Contraseña:</label><input type="password" class="form-control" id="pass" name="pass" autocomplete="off" required>

                                </div>
                                <?php if ($error == 1) { ?>
                                    <br>
                                    <div class="alert alert-dismissable alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4>
                                            Alerta!
                                        </h4> <strong>Error de Acceso</strong> <?php echo $this->session->userdata("error_txt"); ?>
                                    </div>
                                    <br>
                                <?php } ?>
                                <button type="submit" class="btn btn-success">Acceso</button>
                            </form>

                        </div>
                    </div>
              
                </div>
            </div>
            --!>
            
       
        
    </body>
</html>