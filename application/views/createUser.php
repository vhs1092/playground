<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> </title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/table.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/owl.carousel.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
        <script type='text/javascript' src="<?php echo base_url();?>js/jquery.min.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/bootstrap.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/owl.carousel.min.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/script.js"></script>

    </head>

    <body>
        <div class="container">
            <form class="form-horizontal" action="UsuarioGuardar" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 rowForm">
                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <h1>New User</h1>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                            <input type="name" class="form-control customField" name="name" id="name" placeholder="User name" required>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                            <input type="password" class="form-control customField" name="password" id="password" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                            <input type="email" class="form-control customField" name="email" id="email" placeholder="Email" required>
                        </div>
                    </div>

                    <select name="roll_id">
              <option value="1">Super Admin</option>
              <option value="2">Admin</option>
                </select>


                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">

                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                            <a href="index"><button type="button" class="btn btn-default">Cancel</button></a>
                            <button type="submit" class="btn btn-default">Save</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </body>

    </html>


    <style type="text/css">
        .customField {
            width: 100%;
            height: 6vh;
        }
        
        textarea.customField {
            height: 12vh;
        }
        
        .rowForm {
            margin: 1vh 0;
        }
        
        .preview {
            position: relative;
            float: left;
        }
        
        #myMap {
            height: 350px;
            width: 350px;
        }
        
        .owl-carousel .owl-item img {
            display: block;
            width: 80%;
            -webkit-transform-style: preserve-3d;
            height: auto;
        }
        
        img#img {
            position: absolute;
            z-index: 5!important;
            right: 20%;
            top: 0;
            width: 2vw;
            height: 2vw;
        }
    </style>