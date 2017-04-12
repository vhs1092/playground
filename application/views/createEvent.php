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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/evento/crear.css">
        <script type='text/javascript' src="<?php echo base_url();?>js/jquery.min.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/bootstrap.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/owl.carousel.min.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/script.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/picker.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/picker.time.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/picker.date.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type='text/javascript' src="<?php echo base_url();?>js/legacy.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGDi8GXGHBBc397v54LQQT8UDq2T_ju7o"></script>
        <script type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <form class="form-horizontal" action="saveEvent" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 rowForm">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <h1>New Event</h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            Set Target
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-default">Save</button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="name" class="form-control customField" name="name" id="name" placeholder="Event Name" >
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <select class="customField" name="event_type_id">
                                <option value="0">Event Type</option>
                                <?php foreach ($selEventType as $key => $value) {
                                    ?>
                                <option value="<?php echo $value['event_type_id'];?>"><?php echo $value['name'];?></option>
                                <?php } ?>  
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rowForm">
                            <textarea class="customField" name="description">   </textarea>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <input type="text" class="form-control customField" id="name" placeholder="Event Source" name="event_source">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Event Price Range</label>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                                <select name="price">
                                    <option value="1">$</option>
                                    <option value="2">$$</option>
                                    <option value="3">$$$</option>
                                    <option value="4">$$$$</option>
                                    <option value="5">$$$$$</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rowForm">
                            <label class="col-lg-6 col-md-6 col-sm-6 col-xs-12">Recurrent</label>
                            <input type="checkbox" name="recurrent" value="1">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 rowForm">
                    <div id="maindiv">
                        <div id="formdiv">
                            <div class="owl-carousel owl-theme">
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
                        <div id="myMap"></div>
                        <br/>
                        <input type="hidden" id="latitude" name="latitude" placeholder="Latitude" />
                        <input type="hidden" id="longitude" name="longitude" placeholder="Longitude" />
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
        <script type='text/javascript' src="<?php echo base_url();?>js/evento/crear.js"></script>
    </body>
</html>