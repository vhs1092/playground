<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> </title>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>css/table.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>css/owl.carousel.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>css/style.css">
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/jquery.min.js"></script>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/bootstrap.js"></script>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/owl.carousel.min.js"></script>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/script.js"></script>


        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGDi8GXGHBBc397v54LQQT8UDq2T_ju7o">
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                var id = $(".theprice").attr("id");

                $(".theprice .op" + id).attr("selected", "selected");

                //Check that latitude is above -90 and below 90 and longitude is above -180 and below 180
                if ( > -90 && < 90 && > -180 && < 180) {
                    var isValid = true;
                } else {
                    var isValid = false;
                }

                if (isValid == false) {

                    var latlng = new google.maps.LatLng(40.7828687, -73.9675438);

                } else {

                    var latlng = new google.maps.LatLng('', '');

                }

                var map = new google.maps.Map(document.getElementById('myMap'), {
                    center: latlng,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: 'move and pin exact point of your property',
                    draggable: true
                });

                google.maps.event.addListener(marker, 'dragend', function(a) {
                    var sonuc1 = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4);
                    $('#latitude').val(a.latLng.lat().toFixed(4));
                    $('#longitude').val(a.latLng.lng().toFixed(4));

                    $('#loc').val(sonuc1);
                });

                function placeMarker(location) {


                    if (marker) {
                        marker.setPosition(location);
                    } else {
                        marker = new google.maps.Marker({
                            position: location,
                            map: map,
                            title: 'move and pin exact point of your property'
                        });
                    }
                }

                google.maps.event.addListener(map, 'click', function(event) {

                    placeMarker(event.latLng);
                    var sonuc2 = event.latLng.lat().toFixed(4) + ', ' + event.latLng.lng().toFixed(4);
                    $('#latitude').val(event.latLng.lat().toFixed(4));
                    $('#longitude').val(event.latLng.lng().toFixed(4));

                    $('#loc').val(sonuc2);
                });

            });


            $("#il").change(function() {
                var val = $('#il option:selected').val();
                var sonuc3 = (val);
                $('#sonucx').html(sonuc3);
                var mappos = document.getElementById("il").options[document.getElementById("il").selectedIndex].getAttribute('latLng');
                var latlngStr = mappos.split(',', 2);
                var lat = parseFloat(latlngStr[0]);
                var lng = parseFloat(latlngStr[1]);

                var latlng = new google.maps.LatLng(lat, lng);
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: latlng,
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: 'pin exact point of your property',
                    draggable: true
                });

                var sonuc4 = lat + "," + lng;
                $('#latitude').val(lat);
                $('#longitude').val(lng);

                google.maps.event.addListener(marker, 'dragend', function(a) {
                    var sonuc6 = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4);
                    $('#loc').val(sonuc6);
                });

                function placeMarker(location) {
                    if (marker) {
                        marker.setPosition(location);
                    } else {
                        marker = new google.maps.Marker({
                            position: location,
                            map: map,
                            title: 'move and pin exact point of your property'
                        });
                    }
                }

                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng);
                    var sonuc5 = event.latLng.lat().toFixed(4) + ', ' + event.latLng.lng().toFixed(4);
                    $('#loc').val(sonuc5);
                });



            });
        </script>

    </head>

    <body>
        <div class="container">
            <form class="form-horizontal" action="../updateEvent/" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 rowForm">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <h1>Edit Event</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <button class="btn btn-default">Set Target</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-default">Update</button>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="name" class="form-control customField" name="name" id="name" value="" placeholder="Event Name">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <select class="customField" name="event_type_id">
                                <option value="">
                                </option>

                                
                                <option value=""></option>
                                  
                            
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                            <textarea class="customField" name="description">   </textarea>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label>Event Start Date</label>
                            <input type="date" class="form-control customField" name="start_date" value="" placeholder="Event Name">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label>Event Start Time</label>
                            <input type="time" class="form-control customField" name="start_time" value="" id="name" placeholder="Event Name">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label>Event End Date</label>
                            <input type="date" class="form-control customField" id="name" value="" name="end_date" placeholder="Event Name">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label>Event End Time</label>
                            <input type="time" class="form-control customField" id="name" value="" name="end_time" placeholder="Event Name">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label>Event source</label>
                            <input type="text" class="form-control customField" id="name" value="" placeholder="Event Source" name="event_source">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Event Price Range</label>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                                <select name="price" class="theprice" id="">
                             

                              <option class="op1" value="1">$</option>
                              <option class="op2" value="2">$$</option>
                              <option class="op3" value="3">$$$</option>
                              <option class="op4" value="4">$$$$</option>
                              <option class="op5" value="5">$$$$$</option>

                            </select>

                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Recurrent</label>

                            <input type="checkbox" name="recurrent" value="1" checked="true">

                            <input type="checkbox" name="recurrent" value="1">


                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 rowForm">

                    <div id="maindiv">

                        <div id="formdiv">
                            <div class="owl-carousel owl-theme">
                                <img src="">
                                <video width="320" height="240" controls>
                          <source src="" >
                           Your browser does not support the video tag.
                        </video>

                            </div>

                            <div id="filediv"><input name="file[]" type="file" id="file" /></div>

                            <input type="button" id="add_more" class="upload" value="Add More Files" />
                            <br/>
                            <br/>
                            <!-------Including PHP Script here------>
                        </div>

                        <!-- Right side div -->

                    </div>

                    <div class="map">
                        <div id="myMap"></div><br/>

                        <input type="hidden" id="latitude" value="" name="latitude" placeholder="Latitude" />
                        <input type="hidden" id="longitude" value="" name="longitude" placeholder="Longitude" />


                    </div>
                </div>

            </form>

        </div>
    </body>

    </html>
    <script>
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            items: 1
        })
    </script>

    <style type="text/css">
        .customField {
            width: 100%;
            height: 6vh;
        }
        
        textarea.customField {
            height: 12vh;
        }
        
        .rowForm {
            margin: 2vh 0;
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
            width: 100%;
            -webkit-transform-style: preserve-3d;
            height: auto;
        }
        
        img#img {
            position: absolute;
            z-index: 5!important;
            right: 0;
            top: 0;
            width: 2vw;
            height: 2vw;
        }
    </style>