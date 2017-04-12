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
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>css/evento/editar.css">
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/jquery.min.js"></script>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/bootstrap.js"></script>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/owl.carousel.min.js"></script>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/script.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/picker.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/picker.time.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/picker.date.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGDi8GXGHBBc397v54LQQT8UDq2T_ju7o"></script>
        <script type="text/javascript">
                        $(document).ready(function() {
                var id = $(".theprice").attr("id");
                $(".theprice .op" + id).attr("selected", "selected");
                //Check that latitude is above -90 and below 90 and longitude is above -180 and below 180
                if (<?php echo $latitude;?> > -90 && <?php echo $latitude;?> < 90 && <?php echo $longitude;?> > -180 && <?php echo $longitude;?> < 180) {
                    var isValid = true;
                } else {
                    var isValid = false;
                }
                if (isValid == false) {
                    var latlng = new google.maps.LatLng(40.7828687, -73.9675438);
                } else {
                    var latlng = new google.maps.LatLng('<?php echo $latitude;?>', '<?php echo $longitude;?>');
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

        </script>
    </head>
    <body>
        <div class="container">
            <form class="form-horizontal" action="../updateEvent/<?php echo $event_id;?>" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 rowForm">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <h1>Edit Event</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            Set Target
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-default">Update</button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="name" class="form-control customField" name="name" id="name" value="<?php echo $name; ?>" placeholder="Event Name">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <select class="customField" name="event_type_id">
                                <?php foreach ($selEventType as $key => $value) {
                                    ?>
                                <?php if($value["event_type_id"] == $event_type_id) {?>
                                <option selected="selected" value="<?php echo $value['event_type_id'];?>"><?php echo $value['name'];?></option>
                                <?php }else{ ?>
                                <option  value="<?php echo $value['event_type_id'];?>"><?php echo $value['name'];?></option>
                                <?php 
                                    }
                                    } ?>  
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                            <textarea class="customField" name="description">   <?php echo $description; ?></textarea>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label>Event source</label>
                            <input type="text" class="form-control customField" id="name" value="<?php echo $event_source; ?>" placeholder="Event Source" name="event_source">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Event Price Range</label>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                                <select name="price" class="theprice" id="<?php echo $price;?>">
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
                            <?php if($recurrent == 1){  ?>
                            <input type="checkbox" name="recurrent" value="1" checked="true">
                            <?php }else{
                                ?>
                            <input type="checkbox" name="recurrent" value="1">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 rowForm">
                    <div id="maindiv">
                        <div id="formdiv">
                            <div class="owl-carousel owl-theme">
                                <?php
                                    foreach ($eventMedia as $key => $value) {
                                        if($value["type"] == "image"){
                                       ?><img src="<?php echo $this->config->base_url();?>uploads/<?php echo $value[" value "];?>">
                                <?php }else{
                                    ?> 
                                <video width="320" height="240" controls>
                                    <source src="<?php echo $this->config->base_url();?>uploads/<?php echo $value["value"];?>" >
                                    Your browser does not support the video tag.
                                </video>
                                <?php }
                                    }
                                    
                                     ?>
                            </div>
                            <div id="filediv"><input name="file[]" type="file" id="file" /></div>
                            <input type="button" id="add_more" class="upload" value="Add More Files" />
                            <br/>
                            <br/>
                        </div>
                        <!-- Right side div -->
                    </div>
                    <div class="map">
                        <div id="myMap"></div>
                        <br/>
                        <input type="hidden" id="latitude" value="<?php echo $latitude; ?>" name="latitude" placeholder="Latitude" />
                        <input type="hidden" id="longitude" value="<?php echo $longitude; ?>" name="longitude" placeholder="Longitude" />
                    </div>
                </div>
                <div class="container">
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Event scheduled</button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Event Scheduled</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="product">
                                        <?php 
                                            if(sizeof($evento_horarios) > 0){  
                                            foreach ($evento_horarios as $key => $value) {
                                            ?>
                                        <div id="inputs" class="col-lg-12">
                                            <div class="product-item float-clear col-lg-12" style="clear:both;">
                                                <div class="float-left col-lg-1">
                                                    <input type="checkbox" name="item_index[]" />
                                                </div>
                                                <div  class="col-lg-11">
                                                    <div class="float-left col-lg-3">
                                                        <input placeholder="start date" type="text" class="dates" name="fecha_inicio[]" value="<?php echo $value["fecha_inicio"]?>"/>
                                                    </div>
                                                    <div class="float-left col-lg-3">
                                                        <input placeholder="end date" type="text" class="dates" name="fecha_fin[]" value="<?php echo $value["fecha_fin"]?>"/>
                                                    </div>
                                                    <div class="float-left col-lg-3">
                                                        <input placeholder="start time" type="text" class="times" name="hora_inicio[]" value="<?php echo $value["hora_inicio"]?>"/>
                                                    </div>
                                                    <div class="float-left col-lg-3">
                                                        <input placeholder="end date" type="text" class="times" name="hora_fin[]" value="<?php echo $value["hora_fin"]?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                            }else{
                                            ?>
                                        <div id="inputs" class="col-lg-12">
                                            <div class="product-item float-clear col-lg-12" style="clear:both;">
                                                <div class="float-left col-lg-1"><input type="checkbox" name="item_index[]" /></div>
                                                <div  class="col-lg-11">
                                                    <div class="float-left col-lg-3"><input placeholder="start date" type="text" class="dates" name="fecha_inicio[]" /></div>
                                                    <div class="float-left col-lg-3"><input placeholder="end date" type="text" class="dates" name="fecha_fin[]" /></div>
                                                    <div class="float-left col-lg-3"><input placeholder="start time" type="text" class="times" name="hora_inicio[]" /></div>
                                                    <div class="float-left col-lg-3"><input placeholder="end date" type="text" class="times" name="hora_fin[]" /></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }
                                            ?>
                                    </div>
                                    <div class="btn-action float-clear">
                                        <input type="button" name="add_item" value="Add More" onClick="addMore();" />
                                        <input type="button" name="del_item" value="Delete" onClick="deleteRow();" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Acept</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script type='text/javascript' src="<?php echo $this->config->base_url();?>js/evento/editar.js"></script>
    </body>
</html>
<style type="text/css">
</style>