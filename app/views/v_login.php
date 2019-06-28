<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php if (isset($title)) echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <?php if (isset($meta)) echo meta($meta); ?>  

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat" rel="stylesheet">
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link href="<?php echo base_url("css/style.css") ?>" rel="stylesheet">

        <style>
                body
{
    margin: 0;
    padding: 0;
    background: url("<?= base_url('img/EMPRESA/Ventajas-de-la-iluminacion-LED-en-tu-empresa.jpg') ?>") no-repeat;
    background-size: cover;
    font-family: sans-serif;
}
.loginBox
{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    width: 350px;
    height: 520px;
    padding: 80px 40px;
    box-sizing: border-box;
    background: rgba(0,0,0,.5);
}

h2
{
    margin: 0;
    padding: 0 0 10px;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
}
h3{
    font-size: 1.3rem;
    margin: 0;
    padding: 10px;
    color: #fff;
    text-align: center;
}
.loginBox p
{
    margin: 0;
    padding: 0;
    font-weight: bold;
    color: #fff;
}
.loginBox input
{
    width: 100%;
    margin-bottom: 20px;
}
.loginBox input[type="text"],
.loginBox input[type="password"]
{
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
    padding: 10px;

}
::placeholder
{
    color: rgba(255,255,255,.5);
}
.loginBox input[type="submit"]
{
    border: none;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
    background: #2196f3;
    cursor: pointer;
    border-radius: 20px;
}
.loginBox input[type="submit"]:hover
{
    background: #3f51b5;
    color: #fff;
}
.loginBox a
{
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
}
            
        </style>

        

    </head>

    <body class="">

        <div class="loginBox">
            
            <a href="<?= base_url('') ?>"><h2 class="border-bottom">Noble && Jase</h2></a>
            <h3>Iniciar Sesión</h3>
            <form role="form" method="post" accept-charset="utf-8" action="<?php echo site_url("sessions/authenticate"); ?>">
                <p>Usuario</p>
                <input type="text"  id="usuario" name="usuario" autocomplete="off" placeholder="Usuario" required>
                <p>Contraseña</p>
                <input type="password" id="pass" name="pass" autocomplete="off" placeholder="Contraseña" required>
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
                <input type="submit" name="" value="Entrar">
             
            </form>
        </div>
   
<script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script type="text/javascript">
    </script>
</body>
</html>