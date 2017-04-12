<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Iniciar Sesi&oacute;n - SNAG</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/favicon.png">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?php echo($this->config->base_url()); ?>includes/backend/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/backend/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/backend/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/backend/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?php echo($this->config->base_url()); ?>includes/backend/css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo($this->config->base_url()); ?>includes/backend/js/vendor/modernizr-3.3.1.min.js"></script>
        <script type="text/javascript">
            function encode (input) {
                var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                var output = "";
                var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                var i = 0;
             
                input = utf8_encode(input);
             
                while (i < input.length) {
             
                    chr1 = input.charCodeAt(i++);
                    chr2 = input.charCodeAt(i++);
                    chr3 = input.charCodeAt(i++); 
             
                    enc1 = chr1 >> 2;
                    enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                    enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                    enc4 = chr3 & 63;
             
                    if (isNaN(chr2)) {
                        enc3 = enc4 = 64;
                    } else if (isNaN(chr3)) {
                        enc4 = 64;
                    }
             
                    output = output +
                    _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
                    _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
                }
                return output;
            }

            function utf8_encode (string) {
                string = string.replace(/\r\n/g,"\n");
                var utftext = "";
             
                for (var n = 0; n < string.length; n++) {
             
                  var c = string.charCodeAt(n);
             
                  if (c < 128) {
                    utftext += String.fromCharCode(c);
                  }
                  else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                  }
                  else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                  }
             
                }
             
                return utftext;
            }

            function ver_mensaje(mensaje, tipo){
                var clase = '';
                var texto = '';
                switch (tipo){
                    case 'exito':
                        clase = 'success';
                        texto = 'Exito';
                        break;
                    case 'advertencia':
                        clase = 'warning';
                        texto = 'Advertencia';
                        break;
                    case 'error':
                        clase = 'danger';
                        texto = 'Error';
                        break;
                    default:
                        clase = 'danger';
                        texto = 'Error';
                        break;
                }
                var div_mensaje = '<div class="alert alert-'+clase+' alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
                                        '<strong>&#161;'+texto+'!</strong></br>'+mensaje+
                                    '</div>';
                return div_mensaje;
            }
            function AbrirAlerta(msg, alto, ancho) {
                jQuery.fancybox('<div class="content_msg">'+msg+'</div>', {
                   'height' : alto,
                   'width'  : ancho,
                   'autoSize' : false
                });
            }
            function cerrar_fancy(){
                $.fancybox.close(true);
            }
            function validateEmail(email) { 
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
            function validar_login(){
                var correo = jQuery('#txt_correo').val();
                var clave = jQuery('#txt_clave').val();
                var mensaje = '';
                var error = false;
                jQuery('#div_mensaje').html('');
                if(validateEmail(correo) == false || correo == ''){
                        error = true;
                        mensaje = mensaje + '<div>Ingrese un correo v&aacute;lido</div>';
                }
                if(clave == ''){
                    error = true;
                    mensaje = mensaje+'<div>Ingrese una Contrase&ntilde;a</div>';
                }
                if(error == true){
                    jQuery('#div_mensaje').html(ver_mensaje(mensaje,'advertencia'));
                }
                else{
                    correo = encode(correo);
                    clave = encode(clave);
                    jQuery.ajax({
                        url: "IngresarBackend",
                        type: 'post',
                        data: {
                            correo:correo,
                            clave:clave
                        },
                        dataType: 'json',
                        success: function(respuesta) {
                            switch(parseInt(respuesta.res)){
                                case 0:
                                    mensaje = 'La contrase&ntilde;a ingresada no coincide con el correo.';
                                    jQuery('#div_mensaje').html(ver_mensaje(mensaje,'error'));
                                    break;
                                case 1:
                                    window.location = '../ctr_ofertas/oferta';
                                    //window.location = 'index.php/ctr_diaz/inicio';
                                    break;
                                case 2:
                                    mensaje = 'El correo ingresado no existe, o usted no tiene permiso para acceder.';
                                    jQuery('#div_mensaje').html(ver_mensaje(mensaje,'advertencia'));
                                    break;
                            }
                        },
                    });
                }
            }   
        </script>
    </head>
    <body>
        <!-- Full Background -->
        <!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
        <img src="<?php echo($this->config->base_url()); ?>includes/backend/img/placeholders/layout/login2_full_bg.jpg" alt="Full Background" class="full-bg animation-pulseSlow">
        <!-- END Full Background -->

        <!-- Login Container -->
        <div id="login-container">
            <!-- Login Header -->
            <h1 class="h2 text-light text-center push-top-bottom animation-pullDown">
                <i class="fa fa-cube text-light-op"></i> <strong>SNAG</strong>
            </h1>
            <!-- END Login Header -->

            <!-- Login Block -->
            <div class="block animation-fadeInQuick">
                <!-- Login Title -->
                <div class="block-title">
                    <h2>Iniciar Sesi&oacute;n</h2>
                </div>
                <!-- END Login Title -->

                <!-- Login Form -->
                <div class="form-horizontal">
                    <div id="div_mensaje" style="color:red;">
                    </div>
                    <div class="form-group">
                        <label for="login-email" class="col-xs-12">Email</label>
                        <div class="col-xs-12">
                            <input type="text" id="txt_correo" name="login-email" class="form-control" placeholder="Tu Correo" value="wherrador.ios@gmail.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="col-xs-12">Contrase&ntilde;a</label>
                        <div class="col-xs-12">
                            <input type="password" id="txt_clave" name="login-password" class="form-control" placeholder="Tu Contrase&ntilde;a" value="1234">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-4 text-right">
                            <button type="submit" class="btn btn-effect-ripple btn-sm btn-success" style="width:130px;" onclick="validar_login();">Iniciar Sesi&oacute;n</button>
                        </div>
                    </div>
                </div>
                <!-- END Login Form -->
            </div>
            <!-- END Login Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="http://goo.gl/RcsdAh" target="_blank">Snag</a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="<?php echo($this->config->base_url()); ?>includes/backend/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="<?php echo($this->config->base_url()); ?>includes/backend/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo($this->config->base_url()); ?>includes/backend/js/plugins.js"></script>
        <script src="<?php echo($this->config->base_url()); ?>includes/backend/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?php echo($this->config->base_url()); ?>includes/backend/js/pages/readyLogin.js"></script>
        <script>$(function(){ ReadyLogin.init(); });</script>
    </body>
</html>