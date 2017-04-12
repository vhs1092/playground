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
            <form class="form-horizontal" action="Ctr_scrapings/ScrapUrl" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-12 ">
    
                    <select name="links" id="links">
                    <option value="">Select url</option>
                      <option value="http://www.brooklynbowl.com">(victor)-http://www.brooklynbowl.com</option>
                      <option value="http://www.thebellhouseny.com">(victor)-http://www.thebellhouseny.com</option>
                       <option value="http://www.musichallofwilliamsburg.com">(victor)-http://www.musichallofwilliamsburg.com</option>
                       <option value="http://www.slipperroom.com">(victor)-http://www.slipperroom.com</option>
                       <option value="http://www.nuyorican.org">(victor)-http://www.nuyorican.org</option>  
                       <option value="http://thepit-nyc.com">(Humberto)-http://thepit-nyc.com</option>  
                       <option value="http://www.jazz.org">(Humberto)-http://www.jazz.org</option>  
                       <option value="http://www.magnettheater.com">(Humberto)-http://www.magnettheater.com</option>  
                       <option value="http://www.beacontheatre.com">(Humberto)-http://www.beacontheatre.com</option>  


                    </select>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <input type="text" class="form-control customField" name="url" id="name" placeholder="Enter Url" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">

                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-default">Run</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
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
    <script type="text/javascript">
        
        $( document ).ready(function() {
    $( "#links" ).change(function() {
        var valor = $(this).val();
        $("#name").val("");
        $("#name").val(valor);
    });
});

    </script>
    </body>

    </html>


    